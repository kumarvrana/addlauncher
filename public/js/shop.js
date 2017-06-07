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
        
        if(isNaN(cDuration)){
            cDuration = 1;
        }
        if(isNaN(cCost)){
            cCost = 1;
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

    $("#adl-cart-table").on("change", ".change-cart-newspaper", function() {
        $(".loader").show();
        $(".error").hide();

        var index = $(this).attr("data-index");
        var itemTD = $(this).attr("data-itemkey");
        var id = $(this).attr("id");
        var self = $("#adl-cart-table");
        var maxValue = Number($(this).val());
        switch(id){
            case 'quantity-'+index:
                var cCost = maxValue;
                var cWidth = Number($('#width-'+index+' option:selected').val());
                var cHeight = Number($('#height-'+index+' option:selected').val());
                var dbValue = $("#quantity-hidden-" + index).val();
                if (maxValue > dbValue) {
                    $(".quantity-error-" + index).show();
                    $(".loader").hide();
                    return;
                }
            break;
            case 'width-'+index:
                var cWidth = maxValue;
                var cCost = Number($('#quantity-'+index+' option:selected').val());
                var cHeight = Number($('#height-'+index+' option:selected').val());
               
            break;
            case 'height-'+index:
                var cHeight = maxValue;
                var cCost = Number($('#width-'+index+' option:selected').val());
                var cWidth = Number($('#height-'+index+' option:selected').val());
            break;



        }
        
        if(isNaN(cWidth) ||  isNaN(cHeight) || isNaN(cCost)){
            cHeight = 4;
            cWidth = 4;
            cCost = 1;
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
        if ($(this).scrollTop() > 190 && screen.width > 768) {
            $('.fixed-div').addClass("fix-nav");
            $(".toggle_menu").css("background-color", "#1d1d1d");
        } else {
            $('.fixed-div').removeClass("fix-nav");
            $(".toggle_menu").css("background-color", "#0AAEE4");
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
                var HTMLtext = '<span class="fa fa-star"></span> Add to Cart';
                self.html(HTMLtext);
            }
            if (status.status == "added") {
                var HTMLtext = '<span class="fa fa-minus-circle"></span> Remove From Cart';
                self.html(HTMLtext);
            }
        });
});


$(document).ready(
    function(){
        $("#div-filter-1").hide();
        $("#div-filter-2").hide();

        $("#option-filter-1").click(function () {
            $("#div-filter-1").show();
            $("#div-filter-2").hide();
        });
        $("#option-filter-2").click(function () {
            $("#div-filter-2").show();
            $("#div-filter-1").hide();
        });

    });



$(document).ready(function(){


    $(".toggle_menu").click(function(){

        $(".menusb").slideToggle( "slow", function() {
  
            });
    });
});

document.onreadystatechange = function () {
  var state = document.readyState
  if (state == 'complete') {
         document.getElementById('interactive');
         document.getElementById('loadpage').style.visibility="hidden";
  }
}

$('.menusb ul li:has(ul)').addClass('has-child');



// *************************************************************************************************************


jQuery(document).ready(function($){
    //open/close mega-navigation
    $('.cd-dropdown-trigger').on('click', function(event){
        event.preventDefault();
        toggleNav();
    });

    //close meganavigation
    $('.cd-dropdown .cd-close').on('click', function(event){
        event.preventDefault();
        toggleNav();
    });

    //on mobile - open submenu
    $('.has-children').children('a').on('hover', function(event){
        //prevent default clicking on direct children of .has-children 
        event.preventDefault();
        var selected = $(this);
        selected.next('ul').removeClass('is-hidden').end().parent('.has-children').parent('ul').addClass('move-out');
    });

    //on desktop - differentiate between a user trying to hover over a dropdown item vs trying to navigate into a submenu's contents
    var submenuDirection = ( !$('.cd-dropdown-wrapper').hasClass('open-to-left') ) ? 'right' : 'left';
    $('.cd-dropdown-content').menuAim({
        activate: function(row) {
            $(row).children().addClass('is-active').removeClass('fade-out');
            if( $('.cd-dropdown-content .fade-in').length == 0 ) $(row).children('ul').addClass('fade-in');
        },
        deactivate: function(row) {
            $(row).children().removeClass('is-active');
            if( $('li.has-children:hover').length == 0 || $('li.has-children:hover').is($(row)) ) {
                $('.cd-dropdown-content').find('.fade-in').removeClass('fade-in');
                $(row).children('ul').addClass('fade-out')
            }
        },
        exitMenu: function() {
            $('.cd-dropdown-content').find('.is-active').removeClass('is-active');
            return true;
        },
        submenuDirection: submenuDirection,
    });

    //submenu items - go back link
    $('.go-back').on('click', function(){
        var selected = $(this),
            visibleNav = $(this).parent('ul').parent('.has-children').parent('ul');
        selected.parent('ul').addClass('is-hidden').parent('.has-children').parent('ul').removeClass('move-out');
    }); 

    function toggleNav(){
        var navIsVisible = ( !$('.cd-dropdown').hasClass('dropdown-is-active') ) ? true : false;
        $('.cd-dropdown').toggleClass('dropdown-is-active', navIsVisible);
        $('.cd-dropdown-trigger').toggleClass('dropdown-is-active', navIsVisible);
        if( !navIsVisible ) {
            $('.cd-dropdown').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',function(){
                $('.has-children ul').addClass('is-hidden');
                $('.move-out').removeClass('move-out');
                $('.is-active').removeClass('is-active');
            }); 
        }
    }

    //IE9 placeholder fallback
    //credits http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
    if(!Modernizr.input.placeholder){
        $('[placeholder]').focus(function() {
            var input = $(this);
            if (input.val() == input.attr('placeholder')) {
                input.val('');
            }
        }).blur(function() {
            var input = $(this);
            if (input.val() == '' || input.val() == input.attr('placeholder')) {
                input.val(input.attr('placeholder'));
            }
        }).blur();
        $('[placeholder]').parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });
    }
});



$(document).ready(function(){

    $(".fa-times").click(function(){

        $(".sidebar_menu").removeClass("hide_menu");
        $(".toggle_menu").removeClass("opacity_one");
    });

    $(".toggle_menu").click(function(){

        $(".sidebar_menu").addClass("hide_menu");
        $(".toggle_menu").addClass("opacity_one");
    });
});