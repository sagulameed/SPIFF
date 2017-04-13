$( document ).ready(function() {
    var tags = [];

    $('#pricecheckbox').change(function(){
        $('.elements-edit-div').toggleClass('hidden')
    })


    $('.checkmark').change(function(){
        var checked = $(this).is(':checked');
        var input = $(this).data('inputhide')
        if ($('#'+input).hasClass('hidden')){
            $('#'+input).removeClass('hidden')
            $('#'+input).val('')
        }
        else{
            $('#'+input).addClass('hidden')
            $('#'+input).val('')
        }


    })


    if($('#inputTags').val() != ''){
        tags = JSON.parse($('#inputTags').val());
        console.log('tags initilized');
        console.log(tags)
    }
    $( "#newTags" ).on( "keydown", function(event) {
        if(event.which == 13) {
            var tagName = $(this).val().toLowerCase();
            tagName=tagName.replace(/\s+/g,"_");
            event.preventDefault();

            for (i in tags) {
                if(tags[i].name === tagName){
                    $('#message').text('You already added it').fadeOut(5000);
                    return;
                }
            }

            addTag(tagName)

            tag = {}
            tag['name']=tagName;
            tags.push(tag)

            $(this).val('')
            $(this).text = ''

            console.log(tags)
            $('#inputTags').val(JSON.stringify(tags))
        }

    });

    /*delegating event for new elements, event on bind this action*/
    $('#tagsVideo').on('click','a.close-tag',function(event){
        event.preventDefault()
        var tagName = $(this).data('tagname')
        console.log(tagName)
        $('#tag_'+tagName).remove()

        for (i in tags) {
            if(tags[i].name === tagName){
                tags.splice(i, 1);
            }
        }
        console.log(tags)
        $('#inputTags').val(JSON.stringify(tags))

    })

    function addTag(strTag){
        $('#tagsVideo').append('<div class="tagsinner" > <div class="tags" id="tag_'+strTag+'">'+strTag+'<a href="" class="close-tag tagclose" data-tagname="'+strTag+'"><span class="icon-close"></span></a></div></div>');
    }
});
