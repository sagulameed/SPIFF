$( document ).ready(function() {

    $(".rate").on('click',function(event){
        var data = new FormData();
        var _token  = $('input[name="_token"]').val();
        var rate    = $(this).data('valuerate')
        var videoId = $('#videoId').val()
        console.log('vsalue rate'+rate)
        data.append('_token',_token);
        data.append('rate',rate);
        data.append('videoId',videoId);

        jQuery.ajax({
            url: $('#ratePost').val(),
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                console.log(data)
                if(data.status === true){
                    console.log('success')
                    $('#alreadyVote').removeClass('hidden')
                }
                else{
                    $('#alreadyVote').removeClass('hidden').text(data.mess)
                }
            }
        });
    });

    var video = $('#videoReal')[0];

    video.addEventListener('playing', function(){
        $('#playbutton').fadeOut();
    })

    $('#playbutton').click(function(){
        $(this).fadeOut()
        $('video').css('z-index',10);
        document.getElementById("videoReal").play()
        counterCallAjax()
    })

    function counterCallAjax(){
        var data = new FormData();
        var _token  = $('input[name="_token"]').val();
        var videoId = $('#videoId').val()

        data.append('_token',_token);
        data.append('videoId',videoId);

        jQuery.ajax({
            url: $('#viewVideoPost').val(),
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                console.log(data)
                if(data.status === true){
                    console.log('success')
                    console.log('Great one vote more')
                }
                else{
                    console.log('Sorry no video more')
                }
            }
        });
    }
});