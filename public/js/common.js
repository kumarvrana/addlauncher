//var registerURL = "{{ route('user.postsignup') }}";
// var loginURL = "{{ route('user.postsignin') }}";


let $contactFormID = $('#contact-form');
$contactFormID.submit(function(event) {
    event.preventDefault();
    $('#submitButton').attr('disabled', 'disabled');
    $('.loader').css('display', 'block');
    var postData = {
        'email': $('#email').val(),
        'name': $('#first-name').val(),
        'phone': $('#phone').val(),
        'message': $('#description').val()
    }
    $.ajax({
        method: 'POST',
        url: contactFormURL,
        data: postData,
        success: function(response) {
            $('#email').val('');
            $('#first-name').val('');
            $('#phone').val('');
            $('#description').val('');
            errorsHtml = '<div class="alert alert-success">';
            errorsHtml += response.msg;
            errorsHtml += '</div>';
            $('#form-errors').html(errorsHtml);
            $('.loader').css('display', 'none');
            setTimeout(function() {
                $('#form-errors').fadeOut();
            }, 5000);
            $('#submitButton').removeAttr('disabled');
        },
        error: function(response) {
            //debugger;
            errorsHtml = '<div class="alert alert-danger"><ul>';
            if (response.status == 422) {
                $.each(response.responseJSON, function(key, value) {
                    errorsHtml += '<li>' + value[0] + '</li>';
                });
                errorsHtml += '</ul></div>';
                $('#form-errors').html(errorsHtml);
                $('.loader').css('display', 'none');
                setTimeout(function() {
                    $('#form-errors').fadeOut();
                }, 5000);
                $('#submitButton').removeAttr('disabled');
            }
        }
    });
});

var owl = $('.owl-carousel');
owl.owlCarousel({
    items: 1,
    loop: true,
    margin: 10,
    autoplay: true,
    autoplayTimeout: 4000,
    autoHeight: true,
    autoplayHoverPause: false
});

$(document).ready(function() {

    //Check to see if the window is top if not then display button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.scrollToTop').fadeIn(500);
        } else {
            $('.scrollToTop').fadeOut(500);
        }
    });

    //Click event to scroll to top
    $('.scrollToTop').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 800);
        return false;
    });


    $('input:radio[name=adl-payment]:nth(0)').attr('checked',true);

});

// step form checkout

$(document).ready(function() {
    $('.registration-form fieldset:first-child').fadeIn('slow');

    $('.registration-form input[type="text"]').on('focus', function() {
        $(this).removeClass('input-error');
    });

    // next step
    $('.registration-form .btn-next').on('click', function() {
        var parent_fieldset = $(this).parents('fieldset');
        var next_step = true;

        parent_fieldset.find('input[type="text"],input[type="email"]').each(function() {
            if ($(this).val() == "") {
                $(this).addClass('input-error');
                next_step = false;
            } else {
                $(this).removeClass('input-error');
            }
        });

        if (next_step) {
            parent_fieldset.fadeOut(400, function() {
                $(this).next().fadeIn();
            });
        }

    });

    // previous step
    $('.registration-form .btn-previous').on('click', function() {
        $(this).parents('fieldset').fadeOut(400, function() {
            $(this).prev().fadeIn();
        });
    });

    // submit
    $('.registration-form').on('submit', function(e) {

        $(this).find('input[type="text"],input[type="email"]').each(function() {
            if ($(this).val() == "") {
                e.preventDefault();
                $(this).addClass('input-error');
            } else {
                $(this).removeClass('input-error');
            }
        });

    });
    /*fancybox*/
	jQuery(".fancybox").fancybox({
		prevEffect: 'fade',
		nextEffect: 'fade',
		openEffect: 'fade',
		helpers : { 
		   overlay: {
			opacity: 1,
			css: {'background-color': "#f4f4f4"}
		   }
		  }
	});
});



$(document).ready(function(){
var wow = new WOW(
  {
    boxClass:     'wow',      // animated element css class (default is wow)
    animateClass: 'animated', // animation css class (default is animated)
    offset:       0,          // distance to the element when triggering the animation (default is 0)
    mobile:       true,       // trigger animations on mobile devices (default is true)
    live:         true,       // act on asynchronously loaded content (default is true)
    callback:     function(box) {
      // the callback is fired every time an animation is started
      // the argument that is passed in is the DOM node being animated
    },
    scrollContainer: null // optional scroll container selector, otherwise use window
  }
);
wow.init();

});