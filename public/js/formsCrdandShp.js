$( document ).ready(function() {
    Stripe.setPublishableKey('pk_test_SXuGb2QG1HAj6rjsaaJi3WKU');
    var newcreditcardform = $('#form-new-credit-card');


    newcreditcardform.submit(function(event){
        event.preventDefault()

        if($('#idC').val()){
            newcreditcardform.get(0).submit();
        }
        else{
            // console.log('fomr submited')

            Stripe.card.createToken({
                number: $('#card-number').val(),
                cvc: $('#card-cvc').val(),
                exp_month: $('#exp_month').val(),
                exp_year: $('#exp_year').val(),
                name : $('#customer-name').val(),
                address_line1 : $('#address_line1').val(),
                address_line2 : $('#address_line2').val(),
                address_city : $('#address_city').val(),
                address_country : $('#address_countryC').val(),
                address_state : $('#address_state').val(),
                address_zip : $('#address_zip').val()
            }, stripeResponseHandler);

            function stripeResponseHandler(status, response) {
                // console.log(response);
                // Grab the form:

                if (response.error) { // Problem!

                    // Show the errors on the form
                    newcreditcardform.find('.payment-errors').text(response.error.message);
                    newcreditcardform.find('button').prop('disabled', false); // Re-enable submission

                }
                else { // Token was created!
                    // console.log(response)
                    // Get the token ID:
                    var token = response.id;
                    var card = response.card;

                    // Insert the token into the form so it gets submitted to the server:
                    newcreditcardform.append($('<input type="hidden" name="stripeToken" />').val(token));
                    newcreditcardform.append($('<input type="hidden" name="cardjson" />').val(JSON.stringify(card)));

                    // Submit the form:
                    newcreditcardform.get(0).submit();
//
                }
            }
        }


    });


    $("#shippingAddresses").on('click','li.shipping-select',function(event){
        $(".btn-shipping-select").text('Shipping :'+  $(this).text());
        $(".btn-shipping-select").val($(this).text());
//                console.log($(this).data('jsoninfo'))
//         console.log($(this).attr('id'))

        var jsoninfo = $(this).data('jsoninfo')

        if($(this).attr('id') === 'newshipping'){
            $('#shipping-btn-submit').text('New Shipping')
        }
        else{
            $('#shipping-btn-submit').text('Edit Shipping')
        }

        //filling form with shipping data
        for(var name in jsoninfo){
//                    console.log(name+';'+jsoninfo[name])

            $('#'+name).val(jsoninfo[name]);
        }
    });


    $("#cardsList").on('click','li.cards-select',function(event){
        $(".btn-cards-select").text('Card :'+  $(this).text());
        $(".btn-cards-select").val($(this).text());
//                console.log($(this).data('jsoninfo'))
//         console.log($(this).attr('id'))

        var jsoninfo = $(this).data('jsoninfo')

        if($(this).attr('id') === 'newCard'){
            // console.log('NEW CARD')
            $('#card-btn-submit').text('New Card')
            $('#card-number').val('')
            $('#card-expiry-month').val('')
            $('#card-expiry-year').val('')
            $('#customerName').val('')
            $('#card-cvc').attr('disabled',false)
            $('#card-number').attr('disabled',false)
            $('#exp_month').attr('disabled',false)
            $('#exp_year').attr('disabled',false)
        }
        else{
            $('#card-btn-submit').text('Edit Card')
            $('#idC').val($(this).data('cardtok'))
            $('#card-cvc').attr('disabled',true)
            $('#card-number').attr('disabled',true)
            $('#exp_month').attr('disabled',true)
            $('#exp_year').attr('disabled',true)

        }
        //filling form with shipping data
        for(var name in jsoninfo){
//                    console.log(name+';'+jsoninfo[name])
            if(name === 'last4'){
                if ($(this).attr('id') === 'newCard'){
                    $('#card-number').val('')
                }
                else{
                    $('#card-number').val('***********'+jsoninfo[name])
                }

            }
            else if(name === 'name'){
                $('#customer-name').val(jsoninfo[name])
            }
            else if(name === 'address_country'){
                $('#address_countryC').val(jsoninfo[name])
            }
            else if(name === 'country'){
                $('#address_countryC').val(jsoninfo[name])
            }
            else {
                // console.log(jsoninfo[name])
                $('#'+name).val(jsoninfo[name]);
            }
        }


    });

});