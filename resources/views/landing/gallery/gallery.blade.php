@extends('landing.template.template')
@section('content')
    <style>
        .row-eq-height {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }
        .nolike{
            opacity: .3;
        }
    </style>
    <div class="container">
        <div class="col-md-12 mycreations">
            @foreach($shares as $share)
                <div class="col-sm-4 col-md-3">
                    <div class="thumbnail">
                        <a href="" data-toggle="modal" data-target="#bigModalGallery{{$share->id}}">
                            <img class="img-responsive" src="{{$share->design->layouts[0]->canvas_thumbnail}}" alt="..." style="object-fit: cover; width: 300px; height: auto">
                        </a>
                        @if(Auth::check())
                            <input type="hidden" id="user_thumbnail" value="{{Auth::user()->thumbnail}}">
                        @endif
                        <div class="caption text-center" style="background-color: grey; color: white">
                            <img src="{{$share->design->user->thumbnail}}" alt="..." class="img-circle pull-left" style="object-fit: cover; width: 70px; height: 70px" >
                            <h5>{{$share->design->user->email}}</h5>
                            <h5>{{strtoupper($share->design->name)}} {{$share->id}}</h5>
                            <div>
                                <img src="{{asset('img/minilike.png')}}" alt="" style=" margin-right: 5px;"><span class="numLikes{{$share->id}}">{{count($share->likesUsers)}}</span>
                                <img src="{{asset('img/minicoment.png')}}" alt="" style="margin-left: 20px; margin-right: 5px;"> {{count($share->commentsUsers)}}
                            </div>
                        </div>
                    </div>
                </div>
                @include('landing.modals.gallery',['share'=>$share])
            @endforeach
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        $( document ).ready(function() {
            console.log('ready')

            setInterval(function(){ console.log('image changed') }, 3000);

            $('.likeShares').click(function(e){
                e.preventDefault()
                var shareid = $(this).data('shareid')

                var data = new FormData();
                var _token = $('input[name="_token"]').val();
                console.log(_token)
                data.append('_token' , _token);
                data.append('shareId', shareid)
                jQuery.ajax({
                    url: $(this).data('urlform'),
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(data){
                        console.log(data);
                        if(data.status === true){
                            console.log('good beibe')
                            $('#imagelike'+shareid).css('opacity',1)
                            var numLikes = $('#numLikes'+shareid).text()
                            numLikes = parseInt(numLikes)
                            console.log('old Likes'+ numLikes)
                            numLikes = numLikes + 1;
                            console.log('new likes'+ numLikes)
                            $('#numLikes'+shareid).text(numLikes)
                        }
                        else{
                            $('#imagelike'+shareid).css('opacity',.3)
                            var numLikes = $('#numLikes'+shareid).text()
                            numLikes = parseInt(numLikes)
                            console.log('old Likes'+ numLikes)
                            numLikes = numLikes-1;
                            console.log('new likes'+ numLikes)
                            $('#numLikes'+shareid).text(numLikes)

                        }
                    }
                });

            });
            $(".commentInput").on('keydown',function(event){
                if(event.which == 13) {
                    event.preventDefault();
                    var data = new FormData();
                    var _token = $('input[name="_token"]').val();
                    var comment = $(this).val();
                    var shareid = $(this).data('shareid')

                    data.append('_token' , _token)
                    data.append('shareId', shareid)
                    data.append('comment', comment )

                    jQuery.ajax({
                        url: $(this).data('urlform'),
                        data: data,
                        cache: false,
                        contentType: false,
                        processData: false,
                        type: 'POST',
                        success: function(data){
                            console.log(data);
                            if(data.status === true){
                                $('#comments'+shareid).prepend(commentTemplate(comment,$('#user_thumbnail').val()));
                            }
                            else{

                            }
                        }
                    });
                    $(this).val('');
                }
            });

            function commentTemplate(strTxt,user_thumbnail){
                return '<div class="media"><div class="media-left"><a href="#"><img class="media-object image-circle" src="'+user_thumbnail+'" alt="..." style="object-fit: cover; width: 50px; height: 50px;    border-radius: 40px;"> </a></div><div class="media-body"><h5 class="media-heading">User name <small class="pull-right" style="font-size: 12px;">Now</small></h5> <p style="color: grey;">'+strTxt+'</p></div></div>';
            }


        });
    </script>
@endsection