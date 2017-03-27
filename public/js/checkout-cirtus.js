
//cirtus payment js
    citrus.setConfig({
        merchantAccessKey : 'NA14J5C8DJQQO3BA5GMY',
        vanityUrl : '25tt1ig74rZxzxz',
        env : 'prod'
    });

    function selectedPG(val){
				$(".pg").hide();
				$("#"+val).show();
				$("#citrusErrorMessage").html("");
			}
    
    $(function(){
         $('.form-horizontal').validate({ // initialize plugin
            ignore:":not(:visible)",			
                rules: {
                    name : "required"
                },
            });
        ///this method gives various payment options enabled for the merchant
        //like banks enabled for netbanking transactions, card schemes
        //like VISA etc for credit card, debit card payment modes. The card schemes supported for
        //debit card and credit card can be different. 
        citrus.cards.getPaymentDetails({
            vanityUrl: '25tt1ig74rZxzxz'
        }, function (err, pgSettingData) {
            if(err){
                console.log('got error while calling getPaymentDetails',err);
                return;
            }
            /*code block specific to netBanking starts.
            This code should be used to populate the banks supported*/
            pgSettingData.netBanking.forEach(function (bank) {
                $('#netbankingBanks').append($("<option />").val(bank.issuerCode).text(bank.bankName));
            });
            /*code block specific to netBanking ends*/
        });
    });
    

    //in case of errors found on the client side (configuration error etc.)
//this handler will be called, show the error and take the appropriate 
//action
citrus.registerHandlers("errorHandler", function (error) {
   console.log(error);
//assuming on start of payment the button was disabled
//to prevent multiple payment calls. So enabling it again.
   $('#cardPayButton').prop('disabled', false);
   $('#netbankingButton').prop('disabled', false);
});

//in case of any errors on the server, this handler will
//be called, show some error to the user and take the appropriate
//action
citrus.registerHandlers("serverErrorHandler", function (error){
   console.log("Error from server");
   console.log(JSON.stringify(error));
//assuming on start of payment the button was disabled
//to prevent multiple payment calls. So enabling it again.
   $('#cardPayButton').prop('disabled', false);
   $('#netbankingButton').prop('disabled', false);
});

//tell about the status of transaction
//check the status of transaction and take appropriate action
//check the resp (response), check the pgRespCode   property of resp object
//if it is anything other than 0, then it means the transaction has failed, for failure check like if (resp.pgRespCode != 0),show //some error to the user (the TxMsg property holds the transaction message and can be
//displayed as it is to the user )
citrus.registerHandlers("transactionHandler", function(resp){
   alert(JSON.stringify(resp));
//assuming on start of payment the button was disabled
//to prevent multiple payment calls. So enabling it again.
   $('#cardPayButton').prop('disabled', false);
   $('#netbankingButton').prop('disabled', false);
   console.log(JSON.stringify(resp));
});

//validation error handlers for hosted fields
//only required for hosted fields validation related error
// the hostedField contains the selector and fieldType property
//the cardValidationResult object contains three properties ‘isEmpty’,’isValid’ and
//txMsg. The txMsg is the validation message, isEmpty tells whether the field is empty or not
//isValid tells the status, whether the particular field is valid or not.
citrus.registerHandlers("validationHandler", function (hostedField,cardValidationResult) {
         if(cardValidationResult.isValid)
        console.log('field type '+hostedField.fieldType + ' is valid.');
        else 
        console.log('field type '+hostedField.fieldType + ' is invalid, message '+cardValidationResult.txMsg);
        });
function getPaymentData(){
     var data = {
                "merchantTxnId": $('#merchantTxnId').val(),
                "currency": "INR",
                "amount": $('#amount').val(),
                "userDetails": {
                    "email": $('#email').val(),//"sumittest@mailinator.com",
                    "firstName": $('#firstName').val(),//"nagama",
                    "lastName": $('#lastName').val(), //"inamdar",
                    "address": {
                        "street1": $('#street1').val(),//"City Garden",
                        //"street2": $('#street2').val(), //"Link Road",
                        "city": $('#city').val(), // "Pune",
                        "state": $('#state').val(), //"Maharashtra",
                        "country": $('#country').val(),//"India",
                        "zip": $('#zip').val() //"412345"
                    },
                    "mobileNo": $('#mobileNo').val()//"9876543210"
                },
                "returnUrl": $('#returnUrl').val(),
                "notifyUrl": $('#notifyUrl').val(),
                "requestSignature": $("#requestSignature").val(),
                "customParameters": {
                    "productName": "123"
                },
                "mode": 'dropOut'//either dropIn or dropOut
            };
     return data;
}
$(function(){
citrus.hostedFields.create({setupType : "card",hostedFields:[
        {
            fieldType:'cvv',
            selector:'#cvv',
           placeholder:'111'
        },
        {
            fieldType:'expiry',
            selector:'#expiry'
        },
        {
            fieldType:'number',
            selector:'#cardNumber'
        }
    ],style : {
               'input.valid': {
            color:'green'
        },
        'input.invalid':
        {
            color:'red'
        }
    }});
});
$(function(){
$("#cardPayButton").on("click", function (event) {
    //call the method described in step 4
    event.preventDefault();
    //validate here
    if($(".form-horizontal").valid()){
        var data = getPaymentData();
        data.paymentDetails = {
            paymentMode: "card",
            holder:$('#cardHolderName').val(),
            type:'credit'
        };
        citrus.payment.makePayment(data);
    }
});
});

citrus.registerHandlers("transactionHandler", function(resp){
        $('#cardPayButton').prop('disabled', false);
        $('#netbankingButton').prop('disabled', false);
        if(resp.pgRespCode !== 0){
            $('html, body').animate({
                scrollTop: $("#checkout-form").offset().top-105
            }, 2000);

            $('#charge-error-payment').addClass("alert alert-danger");
            $('#charge-error-payment').text(resp.pgRespCode+": "+resp.TxMsg);
            
        }
        if(resp.pgRespCode === 0){
            $("#checkout-form").submit();
        }   
    });
$(function(){
$("#netbankingButton").on("click", function () {
//disable the payment button to accidently sending
//multiple payment request for the same transaction.
        //$(this).prop('disabled', true);
        $("#cardPayButton").prop('disabled', true);
        //call the method described in step 4
        if($(".form-horizontal").valid()){	
            var data = getPaymentData();
        //fill bank related details in basic payment object.
            data.paymentDetails = {
                    "paymentMode" : "netBanking",
                    "bankCode" : $('#netbankingBanks').val()
                };
            citrus.payment.makePayment(data);
        }            
    });
});

    /*

    fetchPaymentOptions();
    
    function handleCitrusPaymentOptions(citrusPaymentOptions) {
        if (citrusPaymentOptions.netBanking != null)
            for (i = 0; i < citrusPaymentOptions.netBanking.length; i++) {
                var obj = document.getElementById("citrusAvailableOptions");
                if(obj){
                    var option = document.createElement("option");
                    option.text = citrusPaymentOptions.netBanking[i].bankName;
                    option.value = citrusPaymentOptions.netBanking[i].issuerCode;
                    obj.add(option);
                }
               
            }
    }

    function citrusServerErrorMsg(errorResponse) {
        alert(errorResponse);
        console.log(errorResponse);
    }
    function citrusClientErrMsg(errorResponse) {
        alert(errorResponse);
        console.log(errorResponse);
    }

    //Net Banking
    $('#citrusNetbankingButton').on("click", function () { makePayment("netbanking") });
    //Card Payment
    $("#citrusCardPayButton").on("click", function () {
         
         makePayment("card") });

    jQuery(document).ready(function() {	
	jQuery.support.cors = true; 
	
	// setup card inputs;	 	
	jQuery('#citrusExpiry').payment('formatCardExpiry');
	jQuery('#citrusCvv').payment('formatCardCVC');
	jQuery('#citrusNumber').keyup(function() {
		var cardNum = jQuery('#citrusNumber').val().replace(/\s+/g, '');		
			var type = jQuery.payment.cardType(cardNum);
			
			jQuery("#citrusNumber").css("background-image", "url(images/" + type + ".png)");						
			if(type!='amex')
            jQuery("#citrusCvv").attr("maxlength","3");
            else
            jQuery("#citrusCvv").attr("maxlength","4");						
			jQuery('#citrusNumber').payment('formatCardNumber');											
			jQuery("#citrusScheme").val(type);		
	});			 
});*/