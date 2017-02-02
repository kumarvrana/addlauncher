$(function(){
    /*$(".error-div").hide();
    $("#register").on('click', function(){
        var title = $(this).data('name');
        $('.modal-title').text(title);
        $("#register-model").modal();
       
    });
    $("#submit-register-form").on('click', function(e){
        e.preventDefault();
        var gemail = $("#cccemail").val();
        
        var firstName = $("#first_name").val();
        var lastName = $("#last_name").val();
        var rpassword = $("#password").val();
        var passwordConfirm = $("#password_confirmation").val();
        var token = $("input[name=_token]").val();
        $('.form').validate({ // initialize plugin
            ignore:":not(:visible)",			
            rules: {
                name : "required"
            },
        });
        $.ajax({
                method: 'POST',
                url: registerURL,
                data: {email: gemail, first_name: firstName, last_name: lastName, password: rpassword, password_confirmation: passwordConfirm, _token: token}
			}).done(function (msg){
                    $(".error-div").hide();
					$('.results').html(msg['response']);
           }).fail(function (error){
              
               var errors = $.parseJSON(error.responseText);
               $(".error-div").show();
                var htmlerror = '<div class="alert alert-danger error">';
                $.each(errors, function(index, value) {
             
                    htmlerror += '<p>'+value+'</p>'
                 });
                htmlerror += '</div>';
                $(".error-div").html(htmlerror);
           });
           
    });
    $("#login").on('click', function(){
        var title = $(this).data('name');
        $('.modal-title').text(title);
        $("#login-model").modal();
    });
     $("#submit-login-form").on('click', function(){

        var gemail = $("#gemail").val();
        var gpassword = $("#gpassword").val();
        var token = $("input[name=_token]").val();
         $('.form').validate({ // initialize plugin
            ignore:":not(:visible)",			
            rules: {
                name : "required"
            },
        });
        $.ajax({
                method: 'POST',
                url: loginURL,
                data: {email: gemail, password: gpassword,  _token: token}
			}).done(function (msg){
                $(".error-div").hide();
				$('.results').html(msg['response']);
                
            }).fail(function (error){
                    var errors = $.parseJSON(error.responseText);
                     $(".error-div").show();
                     var htmlerror = '<div class="alert alert-danger error">';
                    $.each(errors, function(index, value) {
                        htmlerror += '<p>'+value+'</p>'
                    });
                    htmlerror += '</div>';
                    $(".error-div").html(htmlerror);
                });
		
});*/
});