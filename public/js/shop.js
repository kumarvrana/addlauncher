
$(function(){
    /*$(".error-div").hide();
    $("#register").on('click', function(){
        var title = $(this).data('name');
        $('.modal-title').text(title);
        $("#register-model").modal();
       
    });*/
   $("#cart").on("change", ".change-cart", function(){
       $(".error").hide();
       var index = $(this).attr("data-index");
       var itemTD = $(this).attr("data-itemkey");
       var id = $(this).attr("id");
       var maxValue = Number($(this).val());
       if(id == 'quantity'){
           var dbValue = $("#quantity-hidden-"+index).val();
           if(maxValue <= dbValue){
             $.ajax({
					method: 'GET',
					url: updateCartUrl,
					data: {item: itemTD, count: maxValue}
				})
				.done(function (response){
                    var subtotalOutput = "<h4>Rs. "+response.subtotal+"</h4>";
                    $('.subtotal-'+index).html(subtotalOutput);
                    $('.cart-total').text(response.total);
				});
           }else{
               $(".quantity-error-"+index).show();
           }
       }
       /*if(id === 'duration'){
           var dbValue = $("#duration-hidden-"+index).val();
           if(maxValue <= dbValue){
                 
                //var subTotal = Number(subTotalTD.attr("data-subtotal"));
                //var subTotal = Number(subTotalTD.text());
                //var changeSubtotal =  maxValue * subTotal;
                //subTotalTD.attr("data-subtotal", changeSubtotal);
                //subTotalTD.text(changeSubtotal);
                $.ajax({
					method: 'GET',
					url: updateCartUrl,
					data: {item: itemTD, count: maxValue}
				})
				.done(function (msg){
					//$('.results').html(msg['response']);
				});
           }else{
                $(".duration-error-"+index).show();
           }
       }*/

   });

    $("#addClass").click(function () {
            $('#qnimate').addClass('popup-box-on');
                });
            
                $("#removeClass").click(function () {
            $('#qnimate').removeClass('popup-box-on');
    });
});

