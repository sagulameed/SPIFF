$( document ).ready(function() {

    $('#augmentedReality').click(function(){
        console.log('clicked')
        var data = new FormData();
        var _token = $('input[name="_token"]').val();
        console.log(_token)
        data.append('_token',_token);
        data.append('designId',$('#designId').val());
        console.log("design ID"+$('#designId').val());
        jQuery.ajax({
            url: $('#evaluateTarget').val(),
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                console.log(data);
                if(data.status){
                    var rank = data.rank;
                    console.log('Rank:'+rank)
                    $('#numHearts').empty()
                    $('#targetId').val(data.targetId)
                    $('.containerHearts').css('display','block')

                    if(rank>=4){
                        $('#paneaugmentedreality').addClass('active')
                    }
                    for (var i=0;i<+rank;i++){
                        console.log('adding heart')
                        $('#numHearts').append('<img src="http://spiff.inmersysapps.com/img/heartt.png" width="40px">');
                    }
                }
            }
        });
    })
    $('#augmentedRealityPanel').click(function(){
        $('#paneaugmentedreality').addClass('active')
    })

    $('#addTargetform').submit(function (event) {
        event.preventDefault();
        var data = new FormData();
        var _token = $('input[name="_token"]').val();
        data.append('_token',_token);
        data.append('designId',$('#designId').val());
        data.append('targetId',$('#targetId').val());
        jQuery.each(jQuery('#videoTarget')[0].files, function(i, file) {
            data.append('video', file);
        });
        jQuery.each(jQuery('#imagesTarget')[0].files, function(i, file) {
            data.append('images[]', file);
        });
        jQuery.ajax({
            url: $(this).attr('action'),
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                if(data.status){
                    console.log(data.mess)
                    $('#publicMarketBtn').hide();
                    $('#armessage').text('Great Marker uploaded');
                }
            }
        });
    })

    $('#videoTargetUpdate').change(function(){
       console.log('Video changed ')
        event.preventDefault();
        var videoId = $('#videoTId').val()
        var urlUpdate = $('#updateVideoT').val()
        var data = new FormData();

        var _token = $('input[name="_token"]').val();

        data.append('_token',_token);
        data.append('videoId',videoId);

        jQuery.each(jQuery('#videoTargetUpdate')[0].files, function(i, file) {
            data.append('video', file);
        });

        jQuery.ajax({
            url: urlUpdate,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                console.log(data)

               if (data.status){
                   $('#statusVideoUpdated').text(data.mess);
                   $('#videoSourceTarget').attr('src',data.url)
                   $("#videoLoaderDiv")[0].load();
               }
            }
        });
    });

    $('.removeImageGal').click(function(){
        event.preventDefault();
        var removeImgGalUrl = $('#removeImgGalUrl').val()

        var imgId = $(this).data('imgid');
        console.log('image id '+imgId)
        var data = new FormData();

        var _token = $('input[name="_token"]').val();

        data.append('_token',_token);
        data.append('imgId',imgId);

        jQuery.ajax({
            url: removeImgGalUrl,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                console.log(data)
                $('#galImgContainer'+imgId).remove()
                $('#statusGalleryMess').text(data.mess);
            }
        });

    });

    $('#addGalleryElements').click(function(){
        event.preventDefault();
        var newImagesGal = $('#newImagesGal').val()

        var data = new FormData();

        var _token = $('input[name="_token"]').val();

        data.append('_token',_token);
        data.append('targetId',$('#targetId').val());

        jQuery.each(jQuery('#imagesTargetNew')[0].files, function(i, file) {
            data.append('images[]', file);
        });

        jQuery.ajax({
            url: newImagesGal,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                console.log(data)
                $('#statusGalleryMess').text(data.mess);
            }
        });
    })


});