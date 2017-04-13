$( document ).ready(function() {
    var tags = [];
    $(".file-upload-wrapper:has(#videos)").css('display','block')

    $('#file-input').change(function(){
        $('#previewImage').attr('href')
        readURL(this)
        $('#previewImage').css({'display':'block'});
    })
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
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

    $(".dropdown-menu li a").click(function(){
        $(".btn:first-child").text($(this).text());
        $(".btn:first-child").val($(this).text());
        $('#category').val($(this).data('category'))
    });
    //for new appended delegate event binding
    $("#categoryList").on('click','li.category-select',function(event){
        $(".btn:first-child").text($(this).text());
        $(".btn:first-child").val($(this).text());
        $('#category').val($(event.target).data('category'))
    });
    $('.dropdown-submenu a.test').on("click", function(e){
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });
    $("#newCategory").on('keydown',function(event){
        if(event.which == 13) {
            event.preventDefault();
            var data = new FormData();
            var _token = $('input[name="_token"]').val();
            console.log(_token)
            data.append('_token',_token);
            data.append('categoryName',$('#newCategory').val())
            jQuery.ajax({
                url: $('#categoryPost').val(),
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(data){
                    console.log(data);
                    if(data.status === true){
                        $('#newCategory').val('')
                        $('#helper-text').text(data.mess).css('color','green')
                        $('#categoryList').prepend("<li class='category-select text-center' id='"+data.id+"'><a href='#' style='color:white' data-category='"+data.id+"'>"+data.catname+"</a> </li>");
                    }
                    else{
                        $('#helper-text').text(data.mess).css('color','red')
                    }
                }
            });
        }
    });
});