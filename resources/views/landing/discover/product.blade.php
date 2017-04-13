@extends('landing.template.template')
@section('styles')
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.css" />
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials-theme-flat.css" />

    {{-- http://js-socials.com/ --}}
@endsection
@section('content')
    <style>

        body{
            background-color: white;
        }

          .row-eq-height {

            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }
        .firstrow{
            margin-top: 70px;
        }
        h4 {
            color: grey;
            font-weight: bold;
        }
        .rose{
            font-weight: bold;
            color: #9E005C;
        }
        .panel-heading{
            background-color: white !important;
            /*border-color: white !important;*/
        }
        .panel-default{
            border-color: white;
        }
        .panel-body{
            border-color: white !important;
        }
        ::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 10px;
        }
        ::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background-color: rgba(45,45,45,.5);
            -webkit-box-shadow: 0 0 1px rgba(255,255,255,.5);
        }
        .img-overlay {
            position: relative;
            max-width: 500px;
        }
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 70%;
            height: 70%;
            margin-left: 15%;
            margin-top: 15%;

        }
        .collapsed { background: #fbb; }
        h5 {
            color: #b0b0b0;
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
        .jssocials-share {
             margin:0;
        }
        .jssocials-shares {
             margin: 0;
        }
       /* #socialnetworks>li{
            background-color: #f9dadf;

        }
        #socialnetworks>li>a{
            color: white;
        }*/
    </style>

    <div class="container">
        <div class="row firstrow">
            <div class="col-md-5">
                <h5>BY : SPIFF</h5>
                <h2 class="rose text-uppercase" style="border-bottom: 3px solid #9E005C;">{{$product->product_name}}</h2>
            </div>
            <div class="col-md-5">
                <h2></h2>
                <p class="text-uppercase pull-right">TOTAL VIEWS : {{$product->numViews}}</p>
            </div>
            <div class="col-md-2">

            </div>

        </div>
        <div class="row  row-eq-height">
            <div class="col-md-5">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false" style="margin-top: 30px;">
                    @foreach($product->features as $feature)
                        <div class="panel panel-default">
                            <div class="panel-heading text-capitalize" role="tab" id="heading{{$feature->id}}">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$feature->id}}" aria-expanded="false" aria-controls="collapse{{$feature->id}}">
                                        <h3 style="margin-bottom: 0px;"><img src="{{asset('img/mas.png')}}" width="20px" alt=""> {{$feature->name}}</h3>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapse{{$feature->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$feature->id}}">
                                <div class="panel-body">
                                    <p class="text-justify">
                                        {{$feature->description}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="col-md-5">
                <div class="row">
                    <img class="img-responsive" id="previewResource" src="{{$product->product_image}}" alt="" style="object-fit: contain; width: 100%; height: 300px;">
                    @if(!empty($product->video))
                        <video id="productVideo" width="100%" height="300" controls class="hidden">
                            <source src="{{$product->video}}" tyzpe="video/mp4">
                        </video>
                    @endif

                </div>
                <div class="row" style="margin-top: 50px">
                    <div class="col-md-7">
                        <h3 style=" border-top: 3px solid black; "><a href="{{url("productdetails/products/$product->id")}}" style="color: #9E005C;">CREATE </a> THIS BOX </h3>
                    </div>
                    <div class="col-md-5 pull-right">
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
            <div class=" col-md-2" style="height: 400px;overflow: scroll;">
                @foreach($product->thumbnails as $thumb)
                    <a href="#" class="thumbnail">
                        <img class="sideresource" src="{{$thumb->image}}" alt="..." style="object-fit: contain; width: 100%; height: 100px;">
                    </a>
                @endforeach
                @if(!empty($product->video))
                    <div class=" img-overlay">
                        <img class="img-responsive videosource"  src="{{$product->product_image}}" alt="...">
                        <img class="img-responsive image-overlay videosource" src="{{asset('img/playVid.png')}}" alt="">
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-6">

            </div>
            <div class="col-md-2">


            </div>

        </div>
    </div>
@endsection
@section('javascript')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>
    <script>
        $('.sideresource').click(function(){
            var source = $(this).attr('src')
            console.log(source);
            $('#productVideo').addClass('hidden')
            $('#previewResource').removeClass('hidden')
            $('#previewResource').attr('src',source)
        })
        $('.videosource').click(function(){
            var source = $(this).data('videoproduct')
            console.log(source);
            $('#productVideo').removeClass('hidden')
            $('#previewResource').addClass('hidden')

        })

        jQuery('.panel-heading a').click(function() {
            $('.panel-heading').css('opacity',.3).css('border-bottom','0px');
            $(this).parents('.panel-heading').css('opacity',1).css('border-bottom','3px solid black');
        });

        jsSocials.setDefaults("twitter", {
            hashtags: "spiff,product,amazing"
        });
        $("#twitter-share").jsSocials({
            shares: ["twitter"],
            url: window.location.href,
            text: "This is amazing product of SPIFF ",
            hashtags: "spiff,product,amazing",
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



    </script>

@endsection
