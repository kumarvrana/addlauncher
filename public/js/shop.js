
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
                    var grandTotal = "Rs. "+response.total;
                    $('.subtotal-'+index).html(subtotalOutput);
                    $('.cart-total').text(grandTotal);
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

  
      $(document).ready(function() {
        $('#showmenu').click(function() {
                $('.nav-cat-menu').toggle("slide");
        });
    });



$(document).ready(function(){

 
    
  $(window).scroll(function () {
    if ($(this).scrollTop() > 165) {
    $('.fixed-div').addClass("fix-nav");
    } else {
    $('.fixed-div').removeClass("fix-nav");
    }
  });
  $(function dropDown()
  {
    elementClick = '.top-currency .btn-link,.top-language .btn-link,.top-account .dropdown-toggle,.quick-access .btn-inverse';
    elementSlide =  '.dropdown-menu';
    activeClass = 'active';

    $(elementClick).on('click', function(e){
    e.stopPropagation();
    var subUl = $(this).next(elementSlide);
    if(subUl.is(':hidden'))
    {
    subUl.slideDown();
    $(this).addClass(activeClass);
    }
    else
    {
    subUl.slideUp();
    $(this).removeClass(activeClass);
    }
    $(elementClick).not(this).next(elementSlide).slideUp();
    $(elementClick).not(this).removeClass(activeClass);
    e.preventDefault();
    });

    $(elementSlide).on('click', function(e){
    e.stopPropagation();
    });

    $(document).on('click', function(e){
    e.stopPropagation();
    var elementHide = $(elementClick).next(elementSlide);
    $(elementHide).slideUp();
    $(elementClick).removeClass('active');
    });
  });
});

 //Parallax
    
    $('.parallax-home').parallax("50%", 0.4);
    $('.parallax-1').parallax("50%", 0.4);

$("#table-results").on('click', '.add-cartButton', function(event){
    event.preventDefault();
    var self = $(this);
    var addCartURL = self.attr('data-href');
    
    $.ajax({
			method: 'GET',
			url: addCartURL,
			
		})
		.done(function (status){
            $('.cartQuantity').text(status.quatity);
            $('.cartTotal').text(status.total);
            if(status.status == "removed"){
               self.text('Add to Cart');
            }
            if(status.status == "added"){
               self.text('Remove From Cart');
            }
		});
});
