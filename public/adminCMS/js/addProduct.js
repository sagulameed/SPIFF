$(document).ready(function () {
    var tags = [];
    var thumbsdel = [];
    var illusdel = [];
    var panesdel = [];
    var fromtoArr = [1];
    var counter = ($('#lastCounter').val())?Number($('#lastCounter').val())-1:1;
    var isPriced = false;
    var priceMess = $('#wrongPrice')


    $('#addFeature').click(function () {
        var lastChild = $('.boxlist li').last();
        var input = $(lastChild).find('.box-list-head input');
        var textarea = $(lastChild).find('textarea');

        if (input.val() !== '' && textarea.val() !== ''){
            $('.boxlist').append('<li><div class="box-list-head" ><input class="btn-block" name="names[]" type="text" placeholder="Name of Feature"></div><textarea class="form-control" rows="3" name="descriptions[]" placeholder="Brrief description of the feature"></textarea><button type="button" class="btn btn-primary pull-right removefeature" >Remove</button></li>');
            $('#dangerEmpty').hide('slow');
        }
        else{
            $('#dangerEmpty').show('slow');

            console.log('sorry you can not add more fearures')
        }
    });

    $(document).on('click','.removefeature',function(){
        $(this).closest('li').remove();
    })
    $('.removefeaturestored').click(function(){
        var featureEle = $(this);
        var data = new FormData();
        var _token = $('input[name="_token"]').val();
        var featureId = $(this).data('featureid');
        console.log(_token)
        data.append('_token',_token);
        data.append('featureId',featureId);
        jQuery.ajax({
            url: $('#removeFeature').val(),
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                if(data.status){
                    featureEle.closest('li').remove();
                }
            }
        });

    });
    $('#addPriceRank').click(function () {
        $('#rankPrices').append('<tr><td> <input type="number" min="0" step="1" name="from[]" required class="form-control unitbox fromto" id="'+(counter+1)+'" placeholder="From"> </td><td><span class="ndash"></span></td> <td><input type="number" min="0" step="1" name="to[]" required class="form-control unitbox fromto" id="'+(counter+2)+'" placeholder="To"> </td><td> <input type="number" min="0" step="any" name="price[]" class="form-control unitbox" required placeholder="$"> </td></tr>');
        counter +=2;
        console.log('counter::'+counter)
    });

    $(document).on('focusout','.fromto',function(e){

        e.preventDefault();
        var val = Number($(this).val());
        var id = Number($(this).attr('id'));
        console.log("val"+val);
        console.log("id"+id);

        if(val !== '' && fromtoArr[id] !== val){ //first
            if (id==0){
                isPriced = checkNext(id, val, $(this))
                console.log("isPriced:"+isPriced)
            }
            else if(id==fromtoArr.length-1){ //lastes
                isPriced = checkLast(id, val, $(this))
                console.log("isPriced:"+isPriced)
            }
            else{
                // isPriced = checkNext(id, val, $(this)) && checkLast(id, val, $(this))
                if (id%2===0){
                    console.log('checking consecute')
                    isPriced = checkConsecutive(id, val, $(this))
                }
                else{
                    console.log('checking last position')
                    isPriced = checkNext(id, val, $(this)) && checkLast(id, val, $(this))
                }

                console.log("isPriced:"+isPriced)
            }
            isPriced?$('#addPriceRank').removeClass('disabled'):$('#addPriceRank').addClass('disabled');
            isPriced?'':cleanFields(id);
            isPriced?$('#uploadProductBtn').show():$('#uploadProductBtn').hide();

            fromtoArr[id]= val;
        }
        console.log(fromtoArr)
    });

    function checkNext(currentPosition , val, element){

        if(val >= fromtoArr[currentPosition+1]){
            element.focus()
            console.log('shoud be smaller' + val +'---'+ fromtoArr[currentPosition+1])
            priceMess.text('Should be smaller than:'+ fromtoArr[currentPosition+1]).show()
            return false;
        }
        else{

            priceMess.hide()
            return true
        }
    }
    function checkLast(currentPosition , val , element){

        if(val <= fromtoArr[currentPosition-1]){
            element.focus()
            console.log('shoud be greater' + val +'---'+ fromtoArr[currentPosition-1])
            priceMess.text('Should be greater than:'+ fromtoArr[currentPosition-1]).show()

            return false;
        }
        else{

            priceMess.hide()
            return true
        }
    }

    function checkConsecutive(currentPosition, val,element){
        if(val != fromtoArr[currentPosition-1]+1){ //
            element.focus()
            console.log('shoud be consecutive' + val +'---'+ fromtoArr[currentPosition-1])
            priceMess.text('Should be consecutive of:'+ fromtoArr[currentPosition-1]).show()
            return false;
        }
        else{

            priceMess.hide()
            return true
        }
    }

    function cleanFields(currentPosition){
        console.log('cleaningStuff');

        for (var i=currentPosition ; i< fromtoArr.length ; i++){
            $('#'+i).val('')
        }
        fromtoArr = fromtoArr.splice(0,currentPosition);
        console.log(fromtoArr)
    }
    if ($('#inputTags').val() != '') {
        tags = JSON.parse($('#inputTags').val());
        console.log('tags initilized');
        console.log(tags)
    }
    if ($('#pricingJson').val() != '') {
        fromtoArr = new Array();
        console.log('triying')
        var pricing = JSON.parse($('#pricingJson').val());
        $.each(pricing, function(i, item){
            fromtoArr.push(Number(pricing[i].from))
            fromtoArr.push(Number(pricing[i].to))

        })
        console.log(fromtoArr)
    }
    $("#newTags").on("keydown", function (event) {
        if (event.which == 13) {
            var tagName = $(this).val().toLowerCase();
            tagName = tagName.replace(/\s+/g, "_");
            event.preventDefault();

            for (i in tags) {
                if (tags[i].name === tagName) {
                    $('#message').text('You already added it').fadeOut(5000);
                    return;
                }
            }

            addTag(tagName)

            tag = {}
            tag['name'] = tagName;
            tags.push(tag)

            $(this).val('')
            $(this).text = ''

            console.log(tags)
            $('#inputTags').val(JSON.stringify(tags))
        }

    });
    /*delegating event for new elements, event on bind this action*/
    $('#tagsVideo').on('click', 'a.close-tag', function (event) {
        event.preventDefault()
        var tagName = $(this).data('tagname')
        console.log(tagName)
        $('#tag_' + tagName).remove()

        for (i in tags) {
            if (tags[i].name === tagName) {
                tags.splice(i, 1);
            }
        }
        console.log(tags)
        $('#inputTags').val(JSON.stringify(tags))

    })
    function addTag(strTag) {
        $('#tagsVideo').append('<div class="tagsinner" > <div class="tags" id="tag_' + strTag + '">' + strTag + '<a href="" class="close-tag tagclose" data-tagname="' + strTag + '"><span class="icon-close"></span></a></div></div>');
    }


    $('.mygallclose').click(function(e){
        e.preventDefault();
        var thumbid = $(this).data('thumbid')

        thumbsdel.push(thumbid);
        $('#thumsdel').val(JSON.stringify(thumbsdel));
        $('#thumb_'+thumbid).remove();

    });
    $('.myillusclose').click(function(e){
        e.preventDefault();
        var illuid = $(this).data('illusid')
        console.log(illuid)
        illusdel.push(illuid);
        $('#illusdel').val(JSON.stringify(illusdel));
        console.log(illusdel)
        $('#illus_'+illuid).remove();

    });

    $('.paneclose').click(function(e){
        e.preventDefault();
        var paneid = $(this).data('paneid')
        console.log(paneid)
        panesdel.push(paneid);
        $('#paneldel').val(JSON.stringify(panesdel));
        console.log(panesdel)
        $('#pane_'+paneid).remove();

    });
});