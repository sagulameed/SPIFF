$( document ).ready(function() {

    $('#publishSpiff').click(function(event){
        // console.log('clicked')
        event.preventDefault()

        var data = new FormData();
        var _token = $('input[name="_token"]').val();

        data.append('_token',_token);
        data.append('designId',$('#designId').val());

        jQuery.ajax({
            url: $('#formPublishSpiff').attr('action'),
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: function(data){
                console.log(data)
                $('#messPublishDesign').text(data.mess).show();
            }
        });


    })
});