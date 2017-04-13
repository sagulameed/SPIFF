$( document ).ready(function() {

        var prices = $.parseJSON($('#priceJson').val())
        var  elementsPurchased = JSON.parse($('#elementsPurchased').val())
        console.log(elementsPurchased)

        $('#numPieces').keyup(function(){
            var numUnits = $(this).val()
            var pricePerWeigh   =   Number( $('#pricePerWeigh').val())
            var weightUnit      =   Number( $('#weightUnit').val())


            /*search the num pieces in the interval of product prices*/
            var pricePieces = Number(searchIntervalPrice (numUnits));
            var totalPricePieces = pricePieces*numUnits
            setPrice(totalPricePieces.toFixed(2),$('.pricePieces') )
            setPrice(totalPricePieces.toFixed(2),$('#txtPricePieces') )
            console.log('weightUnit:'+weightUnit)
            console.log('pricePerWeigh:'+pricePerWeigh)
            console.log('numUnits:'+numUnits)
            /*cal delivery charge per number of pieces*/
            var totalCharge = weightUnit * pricePerWeigh * numUnits

            setPrice(totalCharge.toFixed(2), $('#txtDeliveryCharge') )

            /*calculatin total billin*/
            var totalBilling = totalPricePieces + totalCharge
            setPrice(totalBilling.toFixed(2),$('#totalBilling'))


            calcTotalBilling()

        })
        /*If element in carrusel is clicked show details of that element*/
        $('.elementsCanvas').click(function(){
           if($(this).data('isfree') == 1 || $(this).data('ispurchased') == 1){
               $('#previewElementPrices').hide('slide',{direction:'left'},400)
           }
           else{
               /*hiden divs od kind prices and whowing prices in accurate section*/
               $('#previewElementPrices').show('slide',{direction:'left'},400)

               $('#elementIdPrev').text($(this).data('elementid'))


               if ($(this).data('singlep')){
                   $('.singleDiv').show('slide',{direction:'left'},400)
                   // console.log($(this).data('singlep'))
                   $('#singlePricePrev').text('$ '+ $(this).data('singlep')+' usd')
                   setDataButton($('#btnSingleLicense'), $(this) , $(this).data('singlep'))
               }else{
                   $('.singleDiv').hide('slide',{direction:'left'},400)
               }
               if ($(this).data('multiplep')){
                   $('.multipleDiv').show('slide',{direction:'left'},400)
                   // console.log($(this).data('multiplep'))
                   $('#multiplePricePrev').text('$ '+ $(this).data('multiplep')+' usd')
                   setDataButton($('#btnMultipleLicense'), $(this) , $(this).data('multiplep'))

               }
               else{
                   $('.multipleDiv').hide('slide',{direction:'left'},400)
               }
               if ($(this).data('rightp')){
                   $('.rightDiv').show('slide',{direction:'left'},400)
                   // console.log($(this).data('rightp'))
                   $('#rightPricePrev').text('$ '+ $(this).data('rightp')+' usd')
                   setDataButton($('#btnRightLicense'), $(this) , $(this).data('rightp'))

               }
               else{
                   $('.rightDiv').hide('slide',{direction:'left'},400)
               }
           }
        });

        $('.licenseBtn').click(function(){
            var elementId = 'elementList'+$(this).attr('data-elementid')+$(this).attr('data-elementtype')+'';

            // console.log(elementId)

            if($('#'+elementId).length){
                console.log('exists element list')
                $('#'+elementId+' td:first-child').text($(this).attr('data-elementtype').substring(0,4)+'_'+$(this).attr('data-elementid'));
                $('#'+elementId+' td:last-child').text('$ '+$(this).attr('data-price')+' usd');

            }
            else{
                console.log('New element')
                $('<tr id="elementList'+$(this).attr('data-elementid')+$(this).attr('data-elementtype')+'"><td>'+$(this).attr('data-elementtype').substring(0,4)+'_'+$(this).attr('data-elementid')+'</td><td>$ '+$(this).attr('data-price')+' usd</td></tr>').insertBefore($('#rowTotalListElements'));

            }

            for (var i in elementsPurchased) {

                if (elementsPurchased[i].elementId === $(this).attr('data-elementid') && elementsPurchased[i].elementType === $(this).attr('data-elementtype')){
                    console.log('I found')
                    elementsPurchased[i].license = $(this).attr('data-licenseele')
                    console.log('license set : '+$(this).attr('data-licenseele'))
                    break;
                }
            }
            $('#elementsPurchased').val(JSON.stringify(elementsPurchased));


            console.log(elementsPurchased)

            calcListElements()
        });

        function calcListElements(){
            var total = 0
            $('#listElements > tr td:last-child').each(function(){

                var text  = $(this).text()
                var number = Number(text.replace(/\$|usd/g,''))

                if ($(this).attr('id') !== 'totalElementList')
                if(!isNaN(number)){
                    total += number;
                }


            });

            $('#totalElementList').text('$ '+ total.toFixed(2) + ' usd')
            setPrice(total.toFixed(2), $('#txtElementCharge'))
            calcTotalBilling()
        }


        function setDataButton(elementGetter , elementSeter , price=null){
            elementGetter.attr('data-price'       , price)
            elementGetter.attr('data-elementid'     , elementSeter.data('elementid'))
            elementGetter.attr('data-elementtype'   , elementSeter.data('elementtype'))
        }


        /*
        * Sum total ordered , delivery and elements price
        * */
        var calcTotalBilling = function(){
            var price = Number($('#txtPricePieces').attr('data-totalprice'))
            var delivery = Number($('#txtDeliveryCharge').attr('data-totalprice'))
            var element =Number($('#txtElementCharge').attr('data-totalprice'))
            console.log(price)
            console.log(delivery)
            console.log(element)


            var total =  price+delivery  + element;
            console.log("total:"+total)
            setPrice(total.toFixed(2), $('#totalBilling'))

        }
        /*
        * set price in htmlelement with data price
        * */
        var setPrice = function (price , element){
            element.text('$ '+price+' usd')
            element.attr("data-totalprice",price)
        }


        var searchIntervalPrice = function (numUnits) {
            var numUnits = Number(numUnits)
            // console.log('Gotten:'+ numUnits)
            var result = 0;
            if (numUnits>prices[prices.length -1].to){ //if number piueces more than the ultimate price take last price

                console.log('bigger than all'+prices[prices.length -1].price)
                result = prices[prices.length -1].price
            }

            $.each(prices, function(i, row){

                if  (numUnits >= Number(row.from) && numUnits <= Number(row.to)){
                    // console.log('Price eacher:'+row.price)

                    result = row.price
                }

            })

            return result
        }




});
