$(function() {
    $('[data-toggle="tooltip"]').tooltip();
    /*$(".error-div").hide();
    $("#register").on('click', function(){
        var title = $(this).data('name');
        $('.modal-title').text(title);
        $("#register-model").modal();

    });*/

    $("#adl-cart-table").on("change", ".change-cart", function() {
        $(".loader").show();

        $(".error").hide();

        var index = $(this).attr("data-index");
        var itemTD = $(this).attr("data-itemkey");
        var id = $(this).attr("id");
        var self = $("#adl-cart-table");
        var maxValue = Number($(this).val());
        switch(id){
            case 'quantity-'+index:
                var length = 'quantity';
                var cCost = maxValue;
                var cDuration = Number($('#duration-'+index+' option:selected').val());
                var dbValue = $("#quantity-hidden-" + index).val();
                if (maxValue > dbValue) {
                    $(".quantity-error-" + index).show();
                    $(".loader").hide();
                    return;
                    

                }
            break;
            case 'length-'+index:
                var length = 'length';
                var cCost = maxValue;
                var cDuration = Number($('#duration-'+index+' option:selected').val());
               
            break;
            case 'duration-'+index:
                var selectID1 = $(this).closest('td').prev('td');
	            var prevSelectName = selectID1.find( ".change-cart" ).attr( "name" );
                if(prevSelectName == 'length'){
                    var cCost = Number($('#length-'+index).val());
                }else{
                    var cCost = Number($('#quantity-'+index).val());
                }
                var cDuration = maxValue;
              
            break;



        }
       let working = false;
            if (working) {
                    xhr.abort();
                }
                working = true;

                xhr= $.ajax({
                method: 'GET',
                url: updateCartUrl,
                data: {
                    item: itemTD,
                    count: cCost,
                    duration: cDuration,
                }
            })
            .done(function(response) {
                var subtotalOutput = "<h4>Rs. " + response.subtotal + "</h4>";
                var grandTotal = "Rs. " + response.total;
                $('.subtotal-' + index).html(subtotalOutput);
                $('.cart-total').text(grandTotal);
                $(".loader").hide();
                working = false;

            });

        
    });

    $("#addClass").click(function() {
        $('#qnimate').addClass('popup-box-on');
    });

    $("#removeClass").click(function() {
        $('#qnimate').removeClass('popup-box-on');
    });
});

$(document).ready(function() {
    $('#showmenu').click(function() {
        $('.nav-cat-menu').toggle("slide");
    });
});

$(document).ready(function() {

    $(window).scroll(function() {
        if ($(this).scrollTop() > 190) {
            $('.fixed-div').addClass("fix-nav");
        } else {
            $('.fixed-div').removeClass("fix-nav");
        }
    });
    $(function dropDown() {
        elementClick = '.top-currency .btn-link,.top-language .btn-link,.top-account .dropdown-toggle,.quick-access .btn-inverse';
        elementSlide = '.dropdown-menu';
        activeClass = 'active';

        $(elementClick).on('click', function(e) {
            e.stopPropagation();
            var subUl = $(this).next(elementSlide);
            if (subUl.is(':hidden')) {
                subUl.slideDown();
                $(this).addClass(activeClass);
            } else {
                subUl.slideUp();
                $(this).removeClass(activeClass);
            }
            $(elementClick).not(this).next(elementSlide).slideUp();
            $(elementClick).not(this).removeClass(activeClass);
            e.preventDefault();
        });

        $(elementSlide).on('click', function(e) {
            e.stopPropagation();
        });

        $(document).on('click', function(e) {
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

$("#table-results").on('click', '.add-cartButton', function(event) {
    event.preventDefault();
    var self = $(this);
    var addCartURL = self.attr('data-href');

    $.ajax({
            method: 'GET',
            url: addCartURL,

        })
        .done(function(status) {
            $('.cartQuantity').text(status.quatity);
            $('.cartTotal').text(status.total);
            if (status.status == "removed") {
                self.text('Add to Cart');
            }
            if (status.status == "added") {
                self.text('Remove From Cart');
            }
        });
});