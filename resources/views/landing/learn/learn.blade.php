@extends('landing.template.template')
@section('content')

    <style>
        .carousel-control {
            padding-top:10%;

        }
        .arrowleft{
            width: 50px;
            height: 50px;
            position: absolute;
            top: 50%;
            z-index: 5;
            display: inline-block;
            margin-top: -15px;
            right: 50%;
        }
        .arrowright{
            width: 50px;
            height: 50px;
            position: absolute;
            top: 50%;
            z-index: 5;
            display: inline-block;
            margin-top: -15px;
            left: 50%;
        }
        ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
            color: #fff;
        }
        :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
            color: #fff;
            opacity:  1;
        }
        ::-moz-placeholder { /* Mozilla Firefox 19+ */
            color: #fff;
            opacity:  1;
        }
        :-ms-input-placeholder { /* Internet Explorer 10-11 */
            color: #fff;
        }
    </style>
    <div class="container-fluid bg-clr">
        <div class="container">
            <div class="row">
                <div class="col-md-12 create-tab">
                    <h4 for="" style="color: white">Press Enter</h4>
                    <form action="{{url('learn/search')}}" method="GET">
                        <input type="text" name="criteria" class="input-lg col-lg-6" placeholder="I WANT TO LEARN ABOUT ..." style="background-color: transparent;border-color: transparent; font-size: 33px; color: white; border-bottom-color: white;">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="col-md-12 mycreations">
            @foreach($categories as $category)
                @if(count($category->videos->toArray())>0)
                    <?php
                        $newVideos = $category->videos->toArray();
                        $newVideos = array_chunk($newVideos,4);
                        $count = 0;
                    ?>
                    <div id="myCarousel{{$category->id}}" class="carousel slide">
                        <h2 class="text-uppercase">{{$category->name}}</h2>
                        <div class="carousel-inner">
                            @foreach($newVideos as $rowVideos)
                                <div class="item {{($count==0)?'active':''}}">
                                    <div class="row">
                                        @foreach($rowVideos as $video)
                                            <div class="col-sm-3">
                                                <a href="{{url("learn/videos/".$video['id'])}}">
                                                    <img src="{{$video['thumbnail']}}" alt="Image" class="img-responsive" style="object-fit: cover; width: 100%; height: 200px;">
                                                </a>
                                                <h4 style="margin-top: 15px">{{$video['title']}}</h4>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <?php $count++;?>
                            @endforeach
                        </div>

                        <a class="left carousel-control" href="#myCarousel{{$category->id}}" data-slide="prev">
                            {{-- <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>--}}
                            <img class="arrowleft" src="{{asset('img/leftArrow.png')}}" alt="">
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#myCarousel{{$category->id}}" data-slide="next">
                            {{--<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>--}}
                            <img class="arrowright" src="{{asset('img/rightArrow.png')}}" alt="">
                            <span class="sr-only">Previous</span>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <script>

    </script>
@endsection