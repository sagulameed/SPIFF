<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="bigModalGallery{{$share->id}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content " style="margin-top: 25%;">
            <div class="row row-eq-height">
                <div class="col-md-7 col-xs-12" style=" padding-right: 0px; ">
                    <img class="img-responsive center-block" src="{{$share->design->layouts[0]->canvas_thumbnail}}" alt="..." style="object-fit: cover; width: 100%; ">
                </div>
                <div class="col-md-5 col-xs-12" style="background-color: white;">

                    <div class="infodata" style="margin-top: 30px">
                        <img src="{{$share->design->user->thumbnail}}" alt="..." class="img-circle pull-left" style="object-fit: cover; width: 70px; height: 70px" >
                        <h5 class="text-center"> {{$share->design->user->email}}</h5>
                        <h4 class="text-center" style="color: #be2b9f">{{strtoupper($share->design->name)}}</h4>

                        <div class="text-center">
                            @if(Auth::check()&& Auth::user()->isUser())
                                <a href="#" class="likeShares" data-shareid="{{$share->id}}" data-urlform="{{url('gallery/like')}}" style=" margin-right: 15px;">
                                    <img id="imagelike{{$share->id}}" class="{{(Auth::user()->isShareLiked($share->id))?'':'nolike'}}" src="{{asset('img/minilikecolor.png')}}" >
                                    <span style="color: #be2b9f" id="numLikes{{$share->id}}" class="numLikes">{{count($share->likesUsers)}}</span>
                                </a>
                            @else
                                <img id="imagelike{{$share->id}}" src="{{asset('img/minilikecolor.png')}}" >
                                <span style="color: #be2b9f">{{count($share->likesUsers)}}</span>
                            @endif
                            <img src="{{asset('img/minicomentcolor.png')}}" alt="" style=" margin-right: 5px;">
                            <span style="color: #be2b9f">{{count($share->commentsUsers)}}</span>
                        </div>
                    </div>
                    <hr style="border-top: 3px solid #b52942;">

                    @if(Auth::check() && Auth::user()->isUser())
                        {{ csrf_field() }}
                        <input type="text" id="comment" name="comment" data-urlform="{{url('gallery/comment')}}" data-shareid="{{$share->id}}" class="form-control commentInput" placeholder="type a comment">
                    @endif

                    <div class="comments" id="comments{{$share->id}}" style="margin-top: 30px; margin-bottom: 30px; overflow: scroll; height: 200px">
                        @foreach($share->commentsUsers()->orderBy('share_comment.created_at', 'desc')->get() as $comment)
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object image-circle" src="{{$comment->thumbnail}}" alt="..." style="object-fit: cover; width: 50px; height: 50px;    border-radius: 40px;">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h5 class="media-heading">{{substr($comment->email,0,10)}} <small class="pull-right" style="font-size: 12px;">{{\Carbon\Carbon::now()->diffForHumans(\Carbon\Carbon::parse($comment->pivot->created_at))}}</small></h5>
                                    <p style="color: grey;">{{$comment->pivot->comment}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
