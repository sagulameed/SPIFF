@extends('landing.template.template')

@section('styles')
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />
    <style>
        ::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 10px;
        }
        ::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background-color: rgba(45,45,45,.5);
            -webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);
        }
        .caption{
            color: white !important;
            background-color: #aaaaaa;
        }
        .myicons{
            width: 40px;
        }
        .spiff-color{
            color: #cf1a59;
        }
        #videoContainer{
            /*background-color: black;*/

        }
        .panel-heading{
            opacity: .3;
        }
        #socialnetworks{
            background-color: transparent;
            webkit-box-shadow:none;
            box-shadow:none;
            border: none;
            top: -30%;
            left: 95%;
            min-width: 60px;
        }
        .text-icons{
            font-size: 10px;
        }
        .jssocials-share {
            margin:0;
        }
        .jssocials-shares {
            margin: 0;
        }

        #videoContainer {
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#000000+0,000000+50,207cca+51,207cca+51,000000+51,000000+100&1+37,0.1+51,1+66 */
            background: -moz-linear-gradient(left, rgba(0,0,0,1) 0%, rgba(0,0,0,1) 37%, rgba(0,0,0,0.16) 50%, rgba(0,0,0,0.1) 51%, rgba(0,0,0,1) 66%, rgba(0,0,0,1) 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(left, rgba(0,0,0,1) 0%,rgba(0,0,0,1) 37%,rgba(0,0,0,0.16) 50%,rgba(0,0,0,0.1) 51%,rgba(0,0,0,1) 66%,rgba(0,0,0,1) 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to right, rgba(0,0,0,1) 0%,rgba(0,0,0,1) 37%,rgba(0,0,0,0.16) 50%,rgba(0,0,0,0.1) 51%,rgba(0,0,0,1) 66%,rgba(0,0,0,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#000000',GradientType=1 ); /* IE6-9 */
        }
        video{
            position: relative;
            z-index: -1;
        }
    </style>
@endsection

@section('content')

    <div id="videoContainer" class="container-fluid grad" {{--style="background-color: black"--}}>
        <div class="container">
            <div class="row text-center " style="position:relative; ">
                <video id="videoReal" width="50%" height="auto" >
                    <source src="{{$video->video}}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <img id="playbutton" class="" src="{{asset('img/playVid.png')}}" alt="" width="140px"  style="position: absolute; left: 43%; top: 23%; z-index: 3000" >
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row col-lg-offset-2" style="margin-top: 20px">
            <div class="col-md-3">
                <h4 class="center-block" style="margin-top: 10%;">TOTAL VIEWS: {{number_format($video->numViews)}}</h4>
            </div>
            <div class="col-md-3 text-center">
                <input type="hidden" id="ratePost" value="{{url('learn/vote')}}">
                <input type="hidden" id="viewVideoPost" value="{{url('learn/viewVideo')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="videoId" id="videoId" value="{{ $video->id }}">
                <h3>
                    <small class="spiff-color text-icons">RATE THIS VIDEO</small> {{--{{round($video->rate)}}--}} <br>
                    <div class="hearths">
                      @if (Auth::check() && Auth::user()->isUser())
                        @for ($i = 1; $i <= round($video->rate); $i++)
                            <img id="star_{{$i}}" data-valuerate="{{$i}}" class="rate" src="{{asset('img/ratt.png')}}" alt="" width="30px">
                        @endfor
                        @for ($i = round($video->rate); $i < 5; $i++)
                            <img id="star_{{$i+1}}" data-valuerate="{{$i+1}}" class="rate" src="{{asset('img/ratt.png')}}" alt="" width="30px" style="opacity: .3">
                        @endfor
                      @else
                        @for ($i = round($video->rate); $i < 5; $i++)
                            <img src="{{asset('img/ratt.png')}}" alt="" width="30px" style="opacity: .3">
                        @endfor
                      @endif
                    </div>
                    <br>
                    <small style="color: #cf1a59" class="hidden" id="alreadyVote">You already vote <img src="{{asset('img/check.png')}}" alt="" width="20px"></small>
                </h3>

            </div>
            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="col-md-3 col-xs-6 col-sm-6 text-center">
                    <span class="spiff-color text-icons">DOWNLOAD</span>
                    <a href="{{$video->video}}" DOWNLOAD>
                        <img class="myicons" src="{{asset('img/dwl.png')}}" alt="">
                    </a>
                </div>
                <div class="col-md-2 col-xs-6 col-sm-6 text-center">
                    <span class="spiff-color text-icons">SHARE</span>
                    <div class="btn-group pull-right">
                        {{--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                        <img class="pull-right dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" src="{{asset('img/share.png')}}" alt="" width="40px">
                        {{--</button>--}}
                        <ul id="socialnetworks" class="dropdown-menu ">
                            <li id="facebook-share" class="text-center"><a href="#">Facebook</a></li>
                            <li id="twitter-share" class="text-center"><a href="#">Twitter</a></li>
                        </ul>
                    </div>
                </div>


            </div>
        </div>

        <div class="row ">
            <div class="col-md-7 col-xs-12 col-sm-12">
                <h3 class="text-uppercase " style="border-bottom-style: solid;">{{$video->title}}</h3>
                <h3 class="text-uppercase">{{$video->subtitle}}</h3>
                <p class="text-justify" style="padding-top: 15px;">  {{$video->description}} </p>
            </div>
            <div class="col-md-4 col-xs-12 col-sm-12 col-lg-offset-1">
                <h3 style="border-bottom-style: solid;" class="text-center">RELATED TALKS</h3>
                <div style="height: 400px; overflow-y: scroll;">
                    @foreach($videosRelated as $videoRel)
                        <div class="thumbnail" style="margin-right: 20px">
                            <a href="{{url("learn/videos/".$videoRel['id'])}}">
                                <img src="{{$videoRel['thumbnail']}}" alt="..." style="object-fit: cover; width: 100%; height: 200px;">
                                <div class="caption">
                                    <h3>{{$videoRel['title']}}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascript')
    <script src="{{asset('js/socialVideos.js')}}"> </script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>
    <script>
        jsSocials.setDefaults("twitter", {
            hashtags: "spiff,product,amazing"
        });
        $("#twitter-share").jsSocials({
            shares: ["twitter"],
            url: window.location.href,
            text: "This is amazing product of SPIFF ",
            hashtags: "spiff,videos,amazing",
            shareIn: "popup",
            showLabel: false,
            showCount: false,
        });

        $("#facebook-share").jsSocials({
            shares: ["facebook"],
            url: window.location.href,
            text: "This is amazing product of SPIFF ",
            shareIn: "popup",
            showLabel: false,
            showCount: false,
        });
        $('#videoReal').hover(function toggleControls() {
            if (this.hasAttribute("controls")) {
                this.removeAttribute("controls")
            } else {
                this.setAttribute("controls", "controls")
            }
        })
    </script>
@endsection
