@extends('landing.template.template')

<style>
    .black-text{
        color: black;
    }
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
    .carrusel-title{
        color: black !important;
    }
    .mycreations h2{
        margin-left: 4%;
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
    .row-eq-height {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    }
    .carousel{

    }
    .carousel-inner {
        margin: 0 auto;
        /*width: 70% !important;*/
        margin-left: 0px;
    }
    .col-md-5, .col-md-7{
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
    video::-internal-media-controls-download-button {
        display:none;
    }

    video::-webkit-media-controls-enclosure {
        overflow:hidden;
    }

    video::-webkit-media-controls-panel {
        width: calc(100% + 30px); /* Adjust as needed */
    }

</style>

@section('content')
    <div class="container-fluid bg-clr">
        {{--<div class="container">--}}
        <div class="container">
            <h4 style="color: white"><span class="text-uppercase">Every wish you had the access to expertise and technology to build your business like the big companies do?</span></h4>

        </div>

            <div class="row row-eq-height">
                @if(count($products)>3)
                  <div class="col-md-4 col-md-offset-1">

                    <div id="carousel-products" class="carousel slide" data-ride="carousel" data-interval="false">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-products" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-products" data-slide-to="1"></li>
                            <li data-target="#carousel-products" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox" style="margin-right: 0px;">

                            @for($i=0; $i<4 ; $i ++)
                                <div class="item {{($i==0)?'active':''}}">
                                    <img src="{{$products[$i]->product_image}}" alt="..." style="object-fit: cover; width: 100%; height: auto">
                                </div>
                            @endfor

                        </div>
                    </div>

                </div>
                @endif
                @if(count($videos)>3)
                  <div class="col-md-6">
                    <div id="carousel-learn" class="carousel slide" data-ride="carousel" data-interval="false">
                        <!-- Indicators -->
                        {{--<ol class="carousel-indicators">
                            <li data-target="#carousel-learn" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-learn" data-slide-to="1"></li>
                            <li data-target="#carousel-learn" data-slide-to="2"></li>
                        </ol>--}}

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox" style="margin-left: 0px;">

                            @for($i=0; $i<4 ; $i ++)
                                <div class="item {{($i==0)?'active':''}}">
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video  controls>
                                            <source src="{{$videos[$i]->video}}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        {{--<iframe class="embed-responsive-item" src="{{asset('dummy/small.mp4')}}" autoplay="false"></iframe>--}}
                                    </div>
                                    <div class="carousel-caption">
                                        <h3>{{$videos[$i]->title}}</h3>
                                        <p>{{$videos[$i]->subtitle}}</p>
                                    </div>
                                </div>
                            @endfor
                        </div>


                        <a class="left carousel-control" href="#carousel-learn" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-learn" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>

                    </div>
                </div>
                @endif
                <div class="col-md-1"></div>

            </div>
        {{--</div>--}}
    </div>
    @if(count($videos->toArray())>0)
    <div class="container">
        <div class="col-md-12 mycreations">
            <div id="myCarouselTrending" class="carousel slide">
                <h4 class="text-uppercase carrusel-title">Trending</h4>

                <div class="carousel-inner">

                <?php
                    $newVideos = $videos->toArray();
                    $newVideos = array_chunk($newVideos,4);

                    $count = 0;
                    ?>
                    @foreach($newVideos as $rowVideos)
                        <div class="item {{($count==0)?'active':''}}">
                            <div class="row">
                                @foreach($rowVideos as $video)
                                    <div class="col-sm-3">
                                        <a href="{{url("learn/videos/".$video['id'])}}">
                                            <img src="{{$video['thumbnail']}}" alt="Image" class="img-responsive" style="object-fit: cover; width: 100%; height: 200px;">
                                        </a>
                                        <p style="margin-top: 15px">{{$video['title']}}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <?php $count++;?>
                    @endforeach
                </div>
                <a class="left carousel-control" href="#myCarouselTrending" data-slide="prev">
                    {{-- <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>--}}
                    <img class="arrowleft" src="{{asset('img/leftArrow.png')}}" alt="">
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarouselTrending" data-slide="next">
                    {{--<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>--}}
                    <img class="arrowright" src="{{asset('img/rightArrow.png')}}" alt="">
                    <span class="sr-only">Previous</span>
                </a>
            </div>
        </div>
    </div>
    @endif
    @if(count($products->toArray())>0)
    <div class="container">
        <div class="col-md-12 mycreations">
            <div id="myCarouselDiscover" class="carousel slide">
                <h4 class="text-uppercase carrusel-title">Discover Products</h4>

                <div class="carousel-inner">

                <?php
                    $newProducts = $products->toArray();
                    $newProducts = array_chunk($newProducts,4);

                    $count = 0;
                    ?>
                    @foreach($newProducts as $rowProducts)
                        <div class="item {{($count==0)?'active':''}}">
                            <div class="row">
                                @foreach($rowProducts as $product)
                                    <div class="col-sm-3">
                                        <a href="{{url("discover/".$product['id'])}}">
                                            <img src="{{$product['product_image']}}" alt="Image" class="img-responsive" style="object-fit: cover; width: 100%; height: 200px;">
                                        </a>
                                        <p style="margin-top: 15px">{{$product['product_name']}}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <?php $count++;?>
                    @endforeach
                </div>
                <a class="left carousel-control" href="#myCarouselDiscover" data-slide="prev">
                    {{-- <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>--}}
                    <img class="arrowleft" src="{{asset('img/leftArrow.png')}}" alt="">
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarouselDiscover" data-slide="next">
                    {{--<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>--}}
                    <img class="arrowright" src="{{asset('img/rightArrow.png')}}" alt="">
                    <span class="sr-only">Previous</span>
                </a>
            </div>
        </div>
    </div>
    @endif
    @if(count($gallery->toArray())>0)
    <div class="container">
        <div class="col-md-12 mycreations">
            <div id="myCarouselGallerydesigns" class="carousel slide">
                <h4 class="text-uppercase carrusel-title">Users Gallery</h4>

                <div class="carousel-inner">

                <?php
                    $newGallery = $gallery->toArray();
                    $newGallery = array_chunk($newGallery,4);

                    $count = 0;
                    ?>
                    @foreach($newGallery as $rowGallery)
                        <div class="item {{($count==0)?'active':''}}">
                            <div class="row">
                                @foreach($rowGallery as $design)
                                    <div class="col-sm-3">
                                        <a href="{{url("learn/videos/".$design->designId)}}">
                                            <img src="{{$design->canvas_thumbnail}}" alt="Image" class="img-responsive" style="object-fit: cover; width: 100%; height: 200px;">
                                        </a>
                                        <p style="margin-top: 15px">{{$design->designName}}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <?php $count++;?>
                    @endforeach
                </div>
                <a class="left carousel-control" href="#myCarouselGallerydesigns" data-slide="prev">
                    {{-- <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>--}}
                    <img class="arrowleft" src="{{asset('img/leftArrow.png')}}" alt="">
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarouselGallerydesigns" data-slide="next">
                    {{--<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>--}}
                    <img class="arrowright" src="{{asset('img/rightArrow.png')}}" alt="">
                    <span class="sr-only">Previous</span>
                </a>
            </div>
        </div>
    </div>
    @endif

    </div>
@endsection
