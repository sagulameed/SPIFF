<html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta name="_token" content="{!! csrf_token() !!}" />
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spiff Editor</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{asset('css/jquery-ui.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/jquery.colorpicker.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/bootstrap-slider.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/jq-colorpicker.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('plugins/slider/thumbnail-slider.css')}}" rel="stylesheet" />
    <link href="{{asset('css/cropper.min.css')}}" type="text/css" rel="stylesheet">

    <!--font style css-->
    <style type="text/css">
      @if( ! empty($fonts))
      @foreach ($fonts as $font)
        @font-face {
          font-family:"<?php echo preg_replace('/\\.[^.\\s]{3,4}$/', '', $font->font_name);?>";
          src: url("{{asset('adminCMS/uploads/fonts')}}/{{$font->font_name}}");
          font-style: normal;
          font-weight: 400;
        }
      @endforeach
      @endif
    </style>

    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

</head>
<style type="text/css">
    .image-upload > input {
        display: none;
    }
    #imagetocrop {
     max-width: 75%;
    }
    .toolbar-text, .toolbar-image, .toolbar-svg {
      position: absolute;
    }
    .fileButtonM{
        cursor: pointer;
        /*display: inline-block;*/
        color: #801C6B;
        font-size: 12px;
        text-transform: uppercase;
        padding: 10px 20px;
        border: none;
        margin-left: -1px;
        background-color: #fff;
        border: 1px solid #801C6B;
        border-radius: 11px;
        float: left;
    }
    .ytplayer {
      pointer-events: none;
      position: absolute;
    }
    .clearable-input {
      width: 100%;
      position: relative;
      display: inline-block;
    }
    .clearable-input > input {
      padding-right: 1.4em;
    }
    .clearable-input >[data-clear-input] {
      display: none;
      position: absolute;
      top: 0;
      right: 0;
      font-weight: bold;
      font-size: 1.4em;
      padding: 0 0.2em;
      line-height: 1em;
      cursor: pointer;
    }
    .clearable-input > input::-ms-clear {
      display: none;
    }
    .morecontent span {
      display: none;
    }
    .morelink {
      display: block;
    }
</style>

<body>
    <ul class='custom-menu'>
        <li data-action="selectall">Select All</li>
        <li data-action="cut">Cut</li>
        <li data-action="copy">Copy</li>
        <li data-action="paste">Paste</li>
    </ul>
    <!-- <div id="loadingpage" class="modal" data-backdrop="static" data-keyboard="false" style="background:#2bbfbf; opacity:1; display:block;"><i class="fa fa-cog fa-spin" style="position: absolute; top: 50%; left: 50%; margin-top: -75px; margin-left: -75px; font-size: 150px; color:#fff;"></i></div> -->
    <div class="container" id="page-container">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid no-padding">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header col-md-3">
                             <div class="navbar-header">
                      <a href="{{url('home')}}" class="logo-text"><img src="{{asset('img/logo.jpg')}}" alt="" ></a>
                    </div>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav text-center">
                    <li>
                      @if (Auth::user()->isAdmin())
                        <a href="{{asset('adminCMS/productlayouts')}}" ><img src="{{asset('img/create.png')}}" width="30" alt="">Back to Designs</a>
                      @else
                        <a href="{{url('create')}}"><img src="{{asset('img/create.png')}}" width="30" alt="">Go to Create</a>
                      @endif

                    </li>
                    @if (Auth::user()->isUser())
                    <li><a href="#e" data-toggle="tab" onclick="showProdTab();"><img src="{{asset('img/products.png')}}" width="30" alt="">Products</a></li>
                    @endif
                    <li><a href="#d" data-toggle="tab" onclick="hideProdTab();"><img src="{{asset('img/backgrounds.png')}}" width="30" alt="">Backgrounds</a></li>
                    @if (Auth::user()->isUser())
                    <li><a href="#f" data-toggle="tab" onclick="hideProdTab();"><img src="{{asset('img/layouts.png')}}" width="30" alt="">Layouts</a></li>
                    @endif
                    <li class="active"><a href="#b" data-toggle="tab" onclick="hideProdTab();"><img src="{{asset('img/text.png')}}" width="30" alt="">Text</a></a></li>
                    <li><a href="#c" data-toggle="tab" onclick="hideProdTab();"><img src="{{asset('img/elements.png')}}" width="30" alt="">Elements</a></li>
                    @if (Auth::user()->isUser())
                    <li><a href="#h" data-toggle="tab" onclick="hideProdTab();"><img src="{{asset('img/uploads.png')}}" width="30" alt="">Uploads</a></li>
                    @endif
                </ul>
                <ul class="nav navbar-nav land-nav navbar-right ">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        {{--<li><a href="{{ url('/register') }}">Register</a></li>--}}
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{url('me/profile')}}">
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('me/paymentConf')}}">
                                        Billing Conf
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('/logout') }}"
                                       onclick="event.preventDefault();
                                       document.getElementById('logout-form').submit();">
                                       Logout
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
          </div>
            <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
    </nav>
    <!-- /row -->
    <!-- /row -->
    <div class="row">
        <div id="leftsection" class="col-xs-6 col-md-4" style="padding-right: 0px; padding-left: 0px; position:fixed;z-index:1000;">
            <div class="tabs-left">

                <!-- Search starts -->
                <div class="search-sec">
                  <p class="hidevideo" style='z-index: 2000;'>Click here to hide the video</p>
                  <div style="position: relative;z-index: 2;">
                    <div class="clearable-input">
                      <input type="text" id="searchelements" placeholder="Search images, elements, background..."/>
                      <span data-clear-input style="color:white;">&times;</span>
                    </div>
                    <p>Press enter</p>
                  </div>
                  <div id="video" style="position: absolute;left: 0;top:36px;opacity: 0.5;z-index: 1;">
                      @if (Auth::user()->isAdmin())
                      <iframe width="340" height="200" src="" id="videoplayer" frameborder="0" showinfo="1" controls="1" allowfullscreen></iframe>
                      @else
                      <iframe width="340" height="200" class="ytplayer" id='videoplayer' type="text/html" src="https://www.youtube.com/embed/PCwL3-hkKrg?modestbranding=1&version=3&autoplay=1&loop=1&playlist=PCwL3-hkKrg&showinfo=0&controls=0&autohid=0&rel=0&enablejsapi=1"></iframe>
                      @endif
                  </div>
                </div>
                <!-- Search ends -->

                <div class="tab-content" style="position:absolute;">

                    <!-- Go to Create Starts -->
                    <div class="tab-pane" id="a">
                      <h4 class="text-center">Go to create Content Goes Here</h4>
                    </div>
                    <!-- Go to Create Ends -->

                    <!-- Text Tab Starts -->
                     <div class="tab-pane active" id="b">
                        <div id="addtextoptions" class="col-lg-12" style="text-align:center;">
                          <p class="dragtext">Click or Drag and Drop for insert text</p>
                          <div id="addheading" style="font-size:35px;"><a href="javascript:void(0);" onClick="javascript:addheadingText();"><img class="textImage" texttype="H1" src="{{asset('img/H1.png')}}"/></a></div>
                          <div id="addsubheading" style="font-size:25px; font-weight:bold;"><a href="javascript:void(0);" onClick="javascript:addsubheadingText();"><img class="textImage" texttype="H2" src="{{asset('img/H2.png')}}"/></a></div>
                          <div id="addsometext" style="font-size:18px; margin:5px 0 10px 0;"><a href="javascript:void(0);" onClick="javascript:addText();"><img class="textImage" texttype="H3" src="{{asset('img/H3.png')}}"/></a></div>
                        </div>
                     </div>
                     <!-- Text Tab Ends -->

                    <!-- Element Tab Starts -->
                     <div class="tab-pane" id="c">
                        <div class="col-lg-12 col-xs-12">
                          <p class="select-ele">Click to Select Elements</p>

                          <div id="tabs4">
                            <ul class="list-inline menu-tabs layout-frame">
                                <li>
                                  <a href="#tabs4-1">
                                    <img src="{{asset('img/pictures.png')}}" alt="" width="80">
                                    <span>Pictures</span>
                                  </a>
                                </li>
                                <li>
                                  <a href="#tabs4-2">
                                    <img src="{{asset('img/illustrations.png')}}" alt="" width="80">
                                    <span>Illustrations</span>
                                  </a>
                                </li>
                                <li>
                                  <a href="#tabs4-3">
                                    <img src="{{asset('img/grids.png')}}" alt="" width="80">
                                    <span>Grids</span>
                                  </a>
                                </li>
                                <li class="read-more-tab">
                                  <a href="#tabs4-4">
                                    <img src="{{asset('img/lines.png')}}" alt="" width="80">
                                    <span>Lines</span>
                                  </a>
                                </li>
                                <li class="read-more-tab">
                                  <a href="#tabs4-5">
                                    <img src="{{asset('img/frames.png')}}" alt="" width="80">
                                    <span>Frames</span>
                                  </a>
                                </li>
                              </ul>
                              <p id="show-tab" class="text-center"><a href="#"><i class="fa fa-chevron-down"></i></a></p>
                            <div id="tabs4-1">
                              <p class="select-ele">Pictures</p>
                              <span class="select-ele2">Click or drag and drop to insert elements</span>
                              <ul class="list-inline layout-frame pictures-container">

                                @include('getPictures', ['pictures' => $pictures])

                              </ul> 
                            </div> 
                            <div id="tabs4-2">
                            <p class="select-ele">Illustrations</p>
                              <span class="select-ele2">Click or drag and drop to insert elements</span>
                                <div id="tabs5">
                                  <ul class="list-inline menu-tabs">
                                    <li><a href="#tabs5-1">SPIFF ILLUSTRATIONS</a></li>
                                    <li><a href="#tabs5-2">RECOMMENDED</a></li>
                                  </ul>
                                  <div id="tabs5-1">
                                    <ul class="list-inline layout-frame illustrations-container">
                                      @include('getIllustrations', ['illustrations' => $illustrations])
                                    </ul>
                                  </div>
                                  <div id="tabs5-2">
                                    <ul class="list-inline layout-frame recillustrations-container">
                                      @include('getIllustrations', ['illustrations' => $recillustrations])
                                    </ul>
                                  </div>
                                </div>
                            </div>
                            <div id="tabs4-3">
                            <p class="select-ele">Grids</p>
                              <span class="select-ele2">Click or drag and drop to insert elements</span>
                              <ul class="list-inline pad-tb-5 layout-frame grids-container">

                                @include('getGrids', ['grids' => $grids])

                              </ul>
                            </div>
                            <div id="tabs4-4">
                            <p class="select-ele">Lines</p>
                              <span class="select-ele2">Click or drag and drop to insert elements</span>
                              <ul class="list-inline layout-frame lines-container">

                                @include('getLines', ['lines' => $lines])

                              </ul>
                            </div>
                            <div id="tabs4-5">
                            <p class="select-ele">Frames</p>
                              <span class="select-ele2">Click or drag and drop to insert elements</span>
                              <ul class="list-inline layout-frame frames-container">

                                @include('getFrames', ['frames' => $frames])

                              </ul>
                            </div>
                          </div>                            
                          <ul id="elementdetails" class="keywords no-padding" style="display: none;">
                            <li>
                              <h4><span id='typedet'></span><br><span class="small-txt">By SPIFF</span><span class="pull-right"><a href="javascript:hideElementDetails();"><i class="fa fa-close"></i></a></span></h4>
                            </li>
                            <li>
                              <span class="big-txt brd-btm clr-grey">BUY</span>
                              <span class="med-txt" id='singlepricedet'></span>
                              <span class="med-txt" id='multiplepricedet'></span>
                              <span class="med-txt" id='rightspricedet'></span>
                            </li>
                            <li>
                              <span class="big-txt brd-btm clr-grey">ID</span>
                              <span class="clr-pink" id='iddet'></span>
                            </li>
                            <li>
                              <span class="big-txt brd-btm clr-grey">KEYWORDS</span>
                              <span class="med-txt" id='keywordsdet'></span>
                            </li>
                          </ul>
                        </div>
                     </div>
                     <!-- Element Tab Ends -->

                    <!-- Background Tab Starts -->
                     <div class="tab-pane" id="d">
                        <p class="dragtext">Background Staff</p>
                        <!--<button class="custom-icon-plus"><i class="fa fa-plus"></i></button>-->
                        <div>
                          <div id="bgcololrpicker" style="overflow: scroll;" class="bgcolorselect"></div>
                        </div>
                        <p class="dragtext"></p>
                        <!--<div class="col-lg-12" style="padding-bottom: 10px;">
                           <button class="btn btn-default" type="button" id="bgcolorselect"></button>
                        </div>-->
                        <div class="col-lg-12 col-xs-12" id="backgrounds-container">
                          <ul class="list-inline layout-frame backgrounds-container">

                              @include('getBackgrounds', ['backgrounds' => $backgrounds])

                          </ul>
                          <div>
                            <ul id="bgelementdetails" class="keywords no-padding" style="display:none ;">
                              <li>
                                <h4><span id='bgtypedet'></span><br><span class="small-txt">By SPIFF</span><span class="pull-right"><a href="javascript:hideBGElementDetails();"><i class="fa fa-close"></i></a></span></h4>
                              </li>
                              <li>
                                <span class="big-txt brd-btm clr-grey">BUY</span>
                                <span class="med-txt" id='bgsinglepricedet'></span>
                                <span class="med-txt" id='bgmultiplepricedet'></span>
                                <span class="med-txt" id='bgrightspricedet'></span>
                              </li>
                              <li>
                                <span class="big-txt brd-btm clr-grey">ID</span>
                                <span class="clr-pink" id='bgiddet'></span>
                              </li>
                              <li>
                                <span class="big-txt brd-btm clr-grey">KEYWORDS</span>
                                <span class="med-txt" id='bgkeywordsdet'></span>
                              </li>
                            </ul>
                          </div>
                        </div>      
                     </div>

                  <!-- Layout Tab Starts -->
                  <div class="tab-pane" id="f">
                    <div id="layout-section">
                        <div class="col-md-12">
                          <p class="dragtext">Select a Layout To Customize</p>
                          <div id="tabs1">
                            <ul class="list-inline menu-tabs">
                              <li><a href="#tabs1-1">Spiff Designs</a></li>
                              @if (Auth::user()->isUser())
                              <li><a href="#tabs2-2">My Designs</a></li>
                              @endif
                            </ul>
                            <div id="tabs1-1">

                              <ul class="list-inline pad-tb-10 spiff-layouts-container">
                                  @include('getLayouts', ['spiffdesigns' => $admindesigns])
                              </ul>

                            </div>
                            <div id="tabs2-2">

                              @if (Auth::user()->isUser())
                              <ul class="list-inline pad-tb-10 layouts-container">
                                    @include('getLayouts', ['userdesigns' => $designs])
                              </ul>
                              @endif

                            </div>
                          </div>
                          <ul class="list-inline pad-tb-10">
                          </ul>
                          <ul class="keywords no-padding">
                            <li>
                              <h4>PULL &amp; POP UP CARD<br/><span class="small-txt">By SPIFF</span><span class="pull-right"><a href="#"><i class="fa fa-close"></i></a></span></h4>
                            </li>
                            <li>
                              <span class="big-txt brd-btm clr-grey">BUY</span>
                              <span class="med-txt">Free / Price</span>
                            </li>
                            <li>
                              <span class="big-txt brd-btm clr-grey">ID</span>
                              <span class="clr-pink">541324fdss</span>
                            </li>
                            <li>
                              <span class="big-txt brd-btm clr-grey">KEYWORDS</span>
                              <span class="med-txt">Pull and pop, gift card, circus, vintage...</span>
                            </li>
                          </ul>
                        </div>
                      </div>
                  </div>
                  <!-- Layout Tab Ends -->

                  <!-- Uploads Tab Starts -->
                   <div class="tab-pane" id="h">
                      <div class="col-lg-12">
                        <p class="select-ele">Your Uploads</p>

                        <!--<p>
                        <span class="select-ele2">Click to pick the file from other Social Media.</span>
                        <div align='center'>
                        <input type="filepicker" data-fp-apikey="AP0JVXMQMQjOqO8emYcB4z" onchange="filepickerimageToCanvas(event.fpfile.url)">
                        </div>
                        </p>-->

                        <span class="select-ele2">Click or drag and drop to insert elements</span>
                        <form name="uploadform" id="uploadform" method="post" action="">
                        <label class="filebutton">
                        <span><input type="file" id="importfile" name="importfile"></span>
                        </label>
                        </form>
                          <div id="tabs3">
                            <div style="position: relative;">
                              <ul class="list-inline menu-tabs">
                                <li><a href="#tabs3-1">Your Files</a></li>
                                <li><a href="#tabs3-2">Your Purchase</a></li>
                              </ul>
                              <span class="social-icons">
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-facebook-square"></i></a>
                              </span>
                            </div>
                            <div id="tabs3-1">
                              @if (Auth::user()->isUser())
                              <ul class="list-inline upload-gallery spiff-userimages-container">
                                @include('getUserImages', ['userimages' => $userimages])
                              </ul>
                              @endif
                            </div>
                            <div id="tabs3-2">
                              <ul class="list-inline upload-gallery">
                                <li>
                                  <button><i class="fa fa-close"></i></button>
                                  <img src="{{asset('img/upload3.jpg')}}" alt="">
                                </li>
                                <li>
                                  <button><i class="fa fa-close"></i></button>
                                  <img src="{{asset('img/upload2.jpg')}}" alt="">
                                </li>
                                <li>
                                  <button><i class="fa fa-close"></i></button>
                                  <img src="{{asset('img/upload3.jpg')}}" alt="">
                                </li>
                                <li>
                                  <button><i class="fa fa-close"></i></button>
                                  <img src="{{asset('img/upload1.jpg')}}" alt="">
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                    </div>
                <!-- /tab-content -->
                    <div class="tab-pane" id="paneaugmentedreality">
                        <div class="col-md-12">
                            <p class="dragtext">Select media fils to be contained in your marker</p>
                            {{--Form to add New Marker--}}
                            @if(empty($theDesign->target))
                                @if(empty($theDesign->target->resources))
                                    <form id="addTargetform" action="{{url('targets/store')}}" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="targetId" id="targetId" value="{{(isset($theDesign->target_id))?$theDesign->target_id:''}}">
                                    <div id="tabs6">
                                        <ul class="list-inline menu-tabs">
                                            <li><a href="#tabs6-1">Video</a></li>
                                            <li><a href="#tabs6-2">Gallery</a></li>
                                            <div id="tabs6-1">
                                                <div class="image-upload text-center" style="margin-top: 30px">
                                                    <label for="videoTarget">
                                                        <img  src="{{asset('img/addVideoar.png')}}" style=" width: 100%;">
                                                    </label>
                                                    <input id="videoTarget" type="file" name="video" accept="video/*">
                                                    <p id="videoNamePreview"></p>
                                                </div>
                                            </div>
                                            <div id="tabs6-2">
                                                <div class="col-md-4" style="margin-top: 10px">
                                                    <div class="image-upload text-center">
                                                        <label for="imagesTarget">
                                                            <img  class="center-block" src="{{asset('img/galleryar.png')}}" style=" width: 100%; height: 70px">
                                                        </label>
                                                        <input id="imagesTarget" type="file" name="images[]" multiple="multiple" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="imagesadded" style="">


                                                </div>
                                            </div>
                                        </ul>
                                    </div>

                                    <div class="col-md-12 text-center">
                                        <button id="publicMarketBtn" class="btn btn-default purple-button" type="submit" style="margin-top: 50px;width: 150px;">
                                            PUBLISH YOUR MARKER
                                        </button>
                                        <h5 id="armessage" class="text-center" style="color: #9E005C;"></h5>

                                    </div>
                                </form>
                                @endif
                            @endif
                                {{--End Form to add new targe--}}
                            @if(!empty($theDesign->target))
                                @if(!empty($theDesign->target->resources))
                                    <form id="updateTargetForm" action="{{url('targets/update')}}" method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="targetId" id="targetId" value="{{$theDesign->target_id}}">
                                        <div id="tabs6">
                                            <ul class="list-inline menu-tabs">
                                                <li><a href="#tabs6-1">Video</a></li>
                                                <li><a href="#tabs6-2">Gallery</a></li>
                                                <div id="tabs6-1">
                                                    <div class="image-upload text-center" style="margin-top: 30px">
                                                        <input type="hidden" id="videoTId" value="{{(! empty($theDesign->target->resources()->where('type','video')->first()))?$theDesign->target->resources()->where('type','video')->first()->id:''}}">
                                                        <input type="hidden" id="updateVideoT" value="{{url('targets/video')}}">

                                                        <div class="row">
                                                            <span id="videoNamePreview">
                                                            @if(isset($theDesign->target->resources()->where('type','video')->first()->resource))
                                                                    <video width="300" height="222" controls id="videoLoaderDiv">
                                                                  <source id="videoSourceTarget" src="{{$theDesign->target->resources()->where('type','video')->first()->resource}}" type="video/mp4">
                                                                  {{--<source id="videoSourceTarget" src="{{asset('uploads/targets/export-x264.mp4')}}" type="video/mp4">--}}
                                                                Your browser does not support the video tag.
                                                                </video>
                                                                @endif
                                                            </span>
                                                        </div>


                                                        <div class="row">
                                                            <div class="text-center">
                                                                <label for="videoTargetUpdate" class="fileButtonM">
                                                                    @if(count($theDesign->target->resources)==0)
                                                                        Upload Video
                                                                    @else
                                                                        Replace Video
                                                                    @endif

                                                                    {{--<button type="button" class="btn btn-primary">Replace Video</button>--}}
                                                                </label>
                                                                <input id="videoTargetUpdate" name="videoTargetUpdate" type="file" style="display:none;" accept="video/mp4"/>
                                                            </div>
                                                        </div>


                                                        <p id="statusVideoUpdated" style="color: #9E005C;"></p>


                                                    </div>
                                                </div>
                                                <div id="tabs6-2">
                                                    <div class="col-md-4" style="margin-top: 12px">
                                                        <input type="hidden" id="newImagesGal" value="{{url('targets/images')}}">
                                                        <div class="image-upload text-center">
                                                            <label for="imagesTargetNew" style="display: inline-block;cursor: pointer;
    ">
                                                                <img  class="center-block" src="{{asset('img/galleryar.png')}}" style=" width: 100%; height: 72px">
                                                            </label>
                                                            <input id="imagesTargetNew" type="file" name="newImages[]" multiple="multiple" accept="image/*" >
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="removeImgGalUrl" value="{{url('targets/imageRemove')}}">
                                                    <div>
                                                        @foreach($theDesign->target->resources()->where('type','image')->get() as $image)
                                                            <div class="col-md-4" style="margin-top: 12px" id="galImgContainer{{$image->id}}">
                                                                <div class="image-upload text-center">
                                                                    <div class="containerimage" style="position:relative">
                                                                        <img  class="center-block" src="{{$image->thumbnail}}" style="position:relative;object-fit: fill; width: 100%; height: 72px;">
                                                                        <img class="removeImageGal" data-imgid="{{$image->id}}" src="{{asset('img/close.png')}}" style="position:absolute;top: 5%;left: 66%;" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    <div class="imagesadded" style="">


                                                    </div>

                                                    <div class="col-md-12 text-center">
                                                        <button class="btn btn-primary" id="addGalleryElements" style="margin-top: 20px;width: 133px;">
                                                            Add Gallery Elements
                                                        </button>
                                                        <h5 id="statusGalleryMess" style="color: #9E005C;"></h5>
                                                    </div>

                                                </div>
                                            </ul>
                                        </div>

                                        <div class="col-md-12">
                                            {{--<button class="btn-primary purple-button center-block" type="submit" style="margin-top: 50px">
                                                UPDATE MEDIA
                                            </button>--}}
                                        </div>
                                    </form>
                                @endif
                            @endif
                            {{--Form to update elements in target--}}
                        </div>
                    </div>
                    <ul class="list-unstyled hidden-xs" id="sidebar-footer">
                      <li>
                          <i class="fa fa-plus-circle fa-lg" id="btnZoomIn" style="cursor:pointer;"></i></br><span id="zoomperc">100%</span></br><i class="fa fa-minus-circle fa-lg" id="btnZoomOut" style="cursor:pointer;"></i>
                      </li>
                    </ul>
            </div>
            <!-- /tabbable -->
        </div>
        </div>
        <div class="" style="margin-top:100px; margin-left:220px;" id='rightsection' align="center">

          <div class="tab-content" id='canvasbox-tab' style='margin-top:70px; text-align: -webkit-center; display: inline-block;' align="center">
              <div class="containerHearts" style="position: relative;z-index: 1000; display: none">
                  <p style="color: #ee536e">RANK MARKER</p>
                  <div id="numHearts">
                  </div>
              </div>
              <div id='canvaspages' tabindex="0" style='outline:none;'>
              </div>
              <div style="display:none;">
                  <canvas id="outputcanvas" width="750" height="600" class="canvas"></canvas>
              </div>
              <div style="display:none;">
                  <canvas id="tempcanvas" width="100" height="100" class="canvas"></canvas>
              </div>
          </div>
        <!-- /tab-content -->
        </div>
    </div>
    <!-- /.row -->
    </div>
    <div class="sub-menu" style="height: 80px;background-color: #fff;width: 100%;position:fixed;z-index: 101;">
      <div class="col-md-9 col-md-offset-3 clearfix">
        <ul class="list-inline leftmenu" style="float: left;margin-left:50px;">
          <li><a href="#" id="savelayout"><img src="{{asset('img/save.png')}}" width="30" alt="">Save</a></li>
          <li><a href="#" id="undo"><img src="{{asset('img/undo.png')}}" width="30" alt="">Undo</a></li>
          <li><a href="#" id="redo"><img src="{{asset('img/redo.png')}}" width="30" alt="">Redo</a></li>
        </ul>
        <ul class="list-inline rightmenu" style="visibility:hidden;">
          <li>
            <span class="textelebtns">
          
            <div class="toolbar-text" style="visibility:hidden;">
              <div class="btn-group">
                <a title="Select Font" id="font-selected" class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#" style="border: 0;padding: 0;">
                 <span><span style="font-size: 10px; padding-right: 5px;">FONT SELECT</span><span class="fa fa-unsorted"></span></span>
                </a>
                <ul class="dropdown-menu fonts-dropdown" id="fonts-dropdown">
                  @if( ! empty($fonts))
                  @foreach ($fonts as $font)
                    <?php $fontname = preg_replace('/\\.[^.\\s]{3,4}$/', '', $font->font_name);?>
                   <li><a href="javascript:void(0);"><font face="<?=$fontname;?>" size="4"><?=$fontname;?></font></a></li>
                  @endforeach
                  @endif
                </ul>
              </div>
              <span class="single-brd"></span>
              <div class="btn-group">
                <a title="Select Font" id="fontsize" class="btn btn-default dropdown-toggle" data-toggle="dropdown" href="#" style="border: 0;padding: 0;">
                 <span><span style="font-size: 14px; padding-right: 5px;" id='fontsizeval'>12</span><span class="fa fa-unsorted"></span></span>
                </a>
                <ul class="dropdown-menu font-size-dropdown" id="font-size-dropdown">
                  <li><a href="javascript:void(0);">6</a></li>
                  <li><a href="javascript:void(0);">8</a></li>
                  <li><a href="javascript:void(0);">10</a></li>
                  <li><a href="javascript:void(0);">12</a></li>
                  <li><a href="javascript:void(0);">14</a></li>
                  <li><a href="javascript:void(0);">16</a></li>
                  <li><a href="javascript:void(0);">18</a></li>
                  <li><a href="javascript:void(0);">20</a></li>
                  <li><a href="javascript:void(0);">22</a></li>
                  <li><a href="javascript:void(0);">24</a></li>
                  <li><a href="javascript:void(0);">26</a></li>
                  <li><a href="javascript:void(0);">28</a></li>
                  <li><a href="javascript:void(0);">30</a></li>
                  <li><a href="javascript:void(0);">36</a></li>
                  <li><a href="javascript:void(0);">48</a></li>
                  <li><a href="javascript:void(0);">60</a></li>
                  <li><a href="javascript:void(0);">72</a></li>
                  <li><a href="javascript:void(0);">96</a></li>
                  <li><a href="javascript:void(0);">120</a></li>
                  <li><a href="javascript:void(0);">144</a></li>
                </ul>
              </div>
              <span class="single-brd"></span>
              <div id="textoptions" class="btn-group">
                <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;"  title="Bold"><a href="javascript:void(0);" id="fontbold" class="btn btn-default" style="border: 0;padding: 0;">
                <i class="fa fa-bold"></i></a>
                </button>
                <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;"  title="Itaic"><a href="javascript:void(0);" id="fontitalic" class="btn btn-default" style="border: 0;padding: 0;">
                <i class="fa fa-italic"></i></a>
                </button>
                <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;"  title="UnderLine"><a href="javascript:void(0);" id="fontunderline" class="btn btn-default" style="border: 0;padding: 0;">
                <i class="fa fa-underline"></i></a>
                </button>
              </div>
              <span class="single-brd"></span>

              <div id="showmoreoptionstxtali" class="btn-group" style="display:inline-block;">
                  <a href="javascript:void(0);" id="showmore" data-toggle="dropdown" title="Show More Tools" class="tools-top btn btn-default dropdown-toggle"><i class="fa fa-align-left"></i></a>
                  <ul class="dropdown-menu">
                      <li style="display: inline-flex;margin-top: 10px;">
                        <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Align Left"><a href="javascript:void(0);" id="objectalignleft" class="btn btn-default" style="border: 0;padding: 0;">
                        <i class="fa fa-align-left"></i></a>
                        </button>
                        <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Align center"><a href="javascript:void(0);" id="objectaligncenter" class="btn btn-default" style="border: 0;padding: 0;">
                        <i class="fa fa-align-center"></i></a>
                        </button>
                        <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Align Right"><a href="javascript:void(0);" id="objectalignright" class="btn btn-default" style="border: 0;padding: 0;">
                        <i class="fa fa-align-right"></i></a>
                        </button>
                        <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Align Justify"><a href="javascript:void(0);" id="objectalignjustify" class="btn btn-default" style="border: 0;padding: 0;">
                        <i class="fa fa-align-justify"></i></a>
                        </button>                        
                      </li>
                  </ul>
              </div>              

              <span class="single-brd"></span>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Send Back"><a href="javascript:void(0);" class="sendbackward" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/send-backward.svg')}}" height="16" width="16" /></a>
              </button>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Bring Front"><a href="javascript:void(0);" class="bringforward" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/bring-forward.svg')}}" height="16" width="16" /></a>
              </button>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default objectfliphorizontal" style="border: 0;" title="Flip Horizontal" ><a href="javascript:void(0);" id="" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/fliphorizontally.png')}}" width="14"></a>
              </button>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default objectflipvertical" style="border: 0;" title="Flip Vertical"><a href="javascript:void(0);" id="" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/flipvertically.png')}}" width="14"></a>
              </button>
              <!--<button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Lock Object"><a href="javascript:void(0);" class="objectlock" class="btn btn-default" style="border: 0;padding: 0;">
              <i class="fa fa-lock" style="font-size: 16px;"></i></a>
              </button>-->
              <span class="group-one">
              <span class="single-brd"></span>
              <input type="hidden" id="textbgcolor-input" value="#abc123"/>
              <button id="textbgcolor" title="Text Background Color" class="btn" style="padding: 0;background-color: transparent;">
                <i class="fa fa-circle-up" style="border: 1px solid rgb(204, 204, 204); height: 0.9em; border-radius: 3px; width: 1em;background-color: orange;"></i>
              </button>
              </span>       
              <span class="single-brd"></span>

              <div id="showmoreoptionstxtopa" class="btn-group" style="display:inline-block;">
                  <a href="javascript:void(0);" id="showmore" data-toggle="dropdown" title="Show More Tools" class="tools-top btn btn-default dropdown-toggle"><img style="width: 16px;" src="{{asset('img/opacity.svg')}}"/></a>
                  <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" id="" title="Opacity" class="tools-top more noclose"><img src="{{asset('img/opacity.svg')}}" width="13">&nbsp; Opacity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id='txtopacityval'>1</span></a></li>
                      <input id="changeopacitytx" data-slider-id='opacitySlidertx' type="text" data-slider-tooltip="hide" data-slider-min="0.1" data-slider-max="1" data-slider-step=".01" data-slider-value="1" />
                  </ul>
              </div>

              <div id="showmoreoptionstxt" class="btn-group" style="display:inline-block;">
                  <a href="javascript:void(0);" id="showmore" data-toggle="dropdown" title="Show More Tools" class="tools-top btn btn-default dropdown-toggle"><img style="width: 16px;" src="{{asset('img/lineheight.svg')}}"/></a>
                  <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" id="" title="Line Height" class="tools-top more textelebtns noclose" ><img src="{{asset('img/lineheight.svg')}}" width="14">&nbsp; Line Height&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id='lineheightval'>1.2</span></a></li>
                      <input id="changelineheight" data-slider-id='lineheightSlider' type="text" data-slider-tooltip="hide" data-slider-min="0.5" data-slider-max="5" data-slider-step="0.1" data-slider-value="1.3"/>
                      <li><a href="javascript:void(0);" id="" title="Letter Spacing" class="tools-top more textelebtns noclose" ><img src="{{asset('img/lineheight.svg')}}" width="14">&nbsp; Letter Spacing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id='letterspaceval'>100</span></a></li>
                      <input id="changecharspacing" data-slider-id='charspacingSlider' type="text" data-slider-tooltip="hide" data-slider-min="-200" data-slider-max="800" data-slider-step="10" data-slider-value="200"/>
                  </ul>
              </div>

              <span class="single-brd"></span>
                <a href="javascript:void(0);" class="clone" title="Clone Object"><i class="fa fa-files-o" style="font-size: 14px;"></i></a>
              <span class="single-brd"></span>
                <a href="javascript:void(0);" class="deleteitem" title="Delete Selected Item"><i class="fa fa-trash-o" style="color: #000; font-size: 14px;"></i></a> 
            </div>
            
            <div class="toolbar-image" style="visibility:hidden;margin-left:0px;">
              <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Send Backward"><a href="javascript:void(0);" class="sendbackward" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/send-backward.svg')}}" height="16" width="16" /></a>
              </button>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Bring Forward"><a href="javascript:void(0);" class="bringforward" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/bring-forward.svg')}}" height="16" width="16" /></a>
              </button>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default objectfliphorizontal" style="border: 0;" title="Flip Horizontal" ><a href="javascript:void(0);" id="" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/fliphorizontally.png')}}" width="14"></a>
              </button>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default objectflipvertical" style="border: 0;" title="Flip Vertical"><a href="javascript:void(0);" id="" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/flipvertically.png')}}" width="14"></a>
              </button>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Lock Object"><a href="javascript:void(0);" class="objectlock" class="btn btn-default" style="border: 0;padding: 0;">
              <i class="fa fa-lock" style="font-size: 16px;"></i></a>
              </button>
              <span class="single-brd"></span>
              <a href="javascript:void(0);" id="cropimage" title="Crop Selected Image" class="btn btn-default"  style="border: 0;padding: 0;"><i class="fa fa-crop" ></i></a>
              <span class="single-brd"></span>
              <a href="javascript:void(0);" class="clone" title="Clone Object"><i class="fa fa-files-o" style="font-size: 14px;"></i></a>
              <span class="single-brd"></span>

              <div id="showmoreoptionsimg" class="btn-group" style="display:inline-block;">
                  <a href="javascript:void(0);" id="showmore" data-toggle="dropdown" title="Show More Tools" class="tools-top btn btn-default dropdown-toggle"><img style="width: 16px;" src="{{asset('img/opacity.svg')}}"/></a>
                  <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" id="" title="Opacity" class="tools-top more noclose"><img src="{{asset('img/opacity.svg')}}" width="13">&nbsp; Opacity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id='imgopacityval'>1</span></a></li>
                      <input id="changeopacityimg" data-slider-id='opacitySliderimg' type="text" data-slider-tooltip="hide" data-slider-min="0.1" data-slider-max="1" data-slider-step=".01" data-slider-value="1" />
                  </ul>
              </div>

              <span class="single-brd"></span>
                <a href="#" id="openimgfiltersModallink" class="close1" style="font-size: 10px;">FILTER</a>
                <div id="openimgfiltersModal" class="modalDialog">
                    <div>
                      <a href="#close" id="closeimgfiltersModal" title="Close" class="close closebtn">X</a>
                      <ul id='imagefilterspreset' class="list-inline filter-slider text-center">
                      </ul>
                      <div class="bright-sec">
                        <div class="clearfix">
                          <span>Brightness</span>
                          <input type="range" id="imgbrightness" name="imgbrightness" min="-100" max="100" value="0" > 
                          <p style="font-size:11px;" id="imgbrightness-value">0</p>
                        </div>
                        <div class="clearfix">
                          <span>Contrast</span>
                          <input type="range" id="imgcontrast" name="imgcontrast" min="-100" max="100" value="0">
                          <p style="font-size:11px;" id="imgcontrast-value">0</p>
                        </div> 
                        <div class="clearfix">
                          <span>Saturate</span>
                          <input type="range" id="imgsaturate" name="imgsaturate" min="-100" max="100" value="0">
                          <p style="font-size:11px;" id="imgsaturate-value">0</p>
                        </div>                                           
                      </div>
                    </div>
                </div>
                <span class="single-brd"></span>
                <a href="javascript:void(0);" class="deleteitem" title="Delete Selected Item"><i class="fa fa-trash-o" style="color: #000; font-size: 14px;"></i></a> 
            </div>

            <div class="toolbar-pattern" style="visibility:hidden;margin-left:0px;">            
              <button onClick="javascript:okPattern();" class="btn btn-default" style="border: 0;" title="Apply Pattern">
                <a href="javascript:okPattern();" id="" class="btn btn-default" style="border: 0;padding: 0;">
                  <i class="fa fa-check" style="font-size: 16px;"></i>
                </a>
              </button>         
              <button onClick="javascript:cancelPattern();" class="btn btn-default" style="border: 0;" title="Cancel Pattern">
                <a href="javascript:cancelPattern();" id="" class="btn btn-default" style="border: 0;padding: 0;">
                  <i class="fa fa-times" style="font-size: 16px;"></i>
                </a>
              </button>
              <button onClick="javascript:cropPattern();" class="btn btn-default" style="border: 0;" title="Crop Pattern">
                <a href="javascript:cropPattern();" id="" class="btn btn-default" style="border: 0;padding: 0;">
                  <i class="fa fa-crop" style="font-size: 16px;"></i>
                </a>
              </button>
            </div>

            <div class="toolbar-svg" style="visibility:hidden;margin-top:-20px;">              
              <span id='dynamiccolorpickers'>
              </span>
              
              <span id='editgridframeicon'>              
                <button onClick="javascript:showGridFrameCanvas();" class="btn btn-default editgrid" style="border: 0;" title="Edit Grid / Frames">
                  <a href="javascript:showGridFrameCanvas();" id="" class="btn btn-default" style="border: 0;padding: 0;">
                    <i class="fa fa-edit" style="font-size: 16px;"></i>
                  </a>
                </button>
                <span class="single-brd"></span>
              </span>

              <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Send Backward"><a href="javascript:void(0);" class="sendbackward" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/send-backward.svg')}}" height="16" width="16" /></a>
              </button>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Bring Forward"><a href="javascript:void(0);" class="bringforward" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/bring-forward.svg')}}" height="16" width="16" /></a>
              </button>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default objectfliphorizontal" style="border: 0;" title="Flip Horizontal" ><a href="javascript:void(0);" id="" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/fliphorizontally.png')}}" width="14"></a>
              </button>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default objectflipvertical" style="border: 0;" title="Flip Vertical"><a href="javascript:void(0);" id="" class="btn btn-default" style="border: 0;padding: 0;">
              <img src="{{asset('img/flipvertically.png')}}" width="14"></a>
              </button>
              <button href="javascript:void(0);" id="showmore" class="btn btn-default" style="border: 0;" title="Lock Object"><a href="javascript:void(0);" class="objectlock" class="btn btn-default" style="border: 0;padding: 0;">
              <i class="fa fa-lock" style="font-size: 16px;"></i></a>
              </button>
              <span class="single-brd"></span>

              <div id="showmoreoptionssvg" class="btn-group" style="display:inline-block;">
                  <a href="javascript:void(0);" data-toggle="dropdown" title="Show More Tools" class="tools-top btn btn-default dropdown-toggle"><img style="width: 16px;" src="{{asset('img/opacity.svg')}}"/></a>
                  <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" id="" title="Opacity" class="tools-top more noclose"><img src="{{asset('img/opacity.svg')}}" width="13">&nbsp; Opacity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span id='svgopacityval'>1</span></a></li>
                      <input id="changeopacitysvg" data-slider-id='opacitySlidersvg' type="text" data-slider-tooltip="hide" data-slider-min="0.1" data-slider-max="1" data-slider-step=".01" data-slider-value="1" />
                  </ul>
              </div>

              <span class="single-brd"></span>
                <a href="javascript:void(0);" class="clone" title="Clone Object"><i class="fa fa-files-o" style="font-size: 14px;"></i></a>
              <span class="single-brd"></span>
                <a href="javascript:void(0);" class="deleteitem" title="Delete Selected Item"><i class="fa fa-trash-o" style="color: #000; font-size: 14px;"></i></a> 
            </div>
            
          </span>

          </li>
        </ul>
      </div>
      </div>
        <div class="slider">
          <div style="text-align: center">
              <div style="width: 50%; margin: 0 auto; text-align: left">Hello</div>
          </div>
          <div id="thumbnail-slider" style="width:66%;margin-left:125%;background-color:white;visibility: hidden;">
            <div class="inner">
              <ul>

                @if( ! empty($products))
                     @foreach ($products as $product)

                        @if (Auth::user()->isAdmin())
                        <li onClick="window.location.href='{{ url('/adminCMS/admineditor') }}?product_id={{$product->id}}';">
                        @else
                        <li onClick="window.location.href='{{ url('/productdetails') }}/products/{{$product->id}}';">
                        @endif
                          <figure>
                            <a class="thumb" href="{{$product->product_image}}">
                            </a>
                            <figcaption style="color:#801C6B; font-weight:bold;">{{$product->product_name}}
                            </figcaption>
                          </figure>
                        </li>

                    @endforeach
                @endif

              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="right-content">
      <ul>
        <li class="nopadd"><h4>PULL &amp; POP <br/> UP <br/> SIDES</h4></li>
        <li class="nopadd"><hr></li>

        <span id='layoutsrc-container'>
            @include('getLayoutsrc', ['adminlayouts' => $adminlayouts])
        </span>

        <li class="nopadd"><hr></li>

        @if (Auth::user()->isUser())
            @if(!empty($theDesign->id))
              <li>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" id="evaluateTarget" value="{{url('targets/evaluate')}}">
                  <input type="hidden" name="designId" id="designId" value="{{$theDesign->id}}">
                  @if(!empty($theDesign->product->panels()->where('isTarget',1)->first()))
                      @if(empty($theDesign->target_id) || $theDesign->target->rank < 4)
                        <a href="#" id="augmentedReality"><img src="{{asset('img/AR.png')}}" class="img-responsive center-block" alt="">
                          Augmented <br/>reality</a>
                      @else
                          <a href="#" id="augmentedRealityPanel"><img src="{{asset('img/AR.png')}}" class="img-responsive center-block" alt="">
                              Augmented <br/>reality</a>
                      @endif
                  @endif
              </li>

               @if(empty($theDesign->order))
                  <li>
                      <a href="{{url("orders/$theDesign->id")}}"><img src="{{asset('img/orderBuy.png')}}" class="img-responsive center-block" alt="">
                          Order &amp; Buy</a>
                  </li>
                  <li>
                      <form action="{{url('publish/spiff')}}" method="POST" id="formPublishSpiff">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="designId" id="designId" value="{{$theDesign->id}}">
                          <a href="#" id="publishSpiff">
                              <img src="{{asset('img/publish.png')}}" class="img-responsive center-block" alt="">
                              Publish
                          </a>
                      </form>
                  </li>
                  <li>
                    <p id="messPublishDesign"></p>
                  </li>
                @endif
            @endif

          <!--<li>
            <a href="#" style="color:#9E005C;">
            <img src="{{asset('img/uploads.png')}}" class="img-responsive center-block" alt="" style="background-color: #9E005C;">
            UPLOAD <br> DESIGN
            </a>
          </li> -->
        @endif
      </ul>
    </div>
    <!-- Success Modal HTML -->
    <div id="successModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-300">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="{{asset('img/close.png')}}"></button>
                    <h4 class="modal-title">Success</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span id="successMessage"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Alert Modal HTML -->
    <div id="alertModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-300">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="{{asset('img/close.png')}}"></button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <span id="responceMessage"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>

      <!-- Save as Template Modal HTML -->
      <div id="savelayout_modal" class="modal fade">
         <div class="modal-dialog">
            <div class="modal-content modal-content-500">
<!--                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                  <h4 class="modal-title">Save Design</h4>
               </div>
 -->               <form role="form" name="savelayoutform" id="savelayoutform">
                 <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                       <img src="{{asset('img/logo-modal.png')}}" class="modal-logo">
                       <img src="{{asset('img/tick-modal.png')}}" class="modal-logo center-block" >
                       <span><!-- <label for="layoutname">Design Name :</label> -->
                       <input type="text" name="layoutname" id="layoutname" class="form-control" placeholder="TYPE A NAME FOR YOUR DESIGN"></span>
                    </div>
                 </div>
                  <div class="modal-footer clearfix">
                     <button type="submit" class="btn btn-default pull-left" >Continue</button>
                     <button type="button" class="btn btn-default pull-right" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;">Cancel</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
    <div id="spinnerModal" style="display: none;" data-keyboard="false"><i class="fa fa-cog fa-spin" style="position: absolute; top: 50%; left: 50%; margin-top: -75px; margin-left: -75px; font-size: 150px;"></i></div>
    <!-- Imgae Alert Modal HTML -->
    <div id="imagealertModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-400">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="{{asset('img/close.png')}}"></button>
                    <h4 class="modal-title">IMAGE FILE FORMAT / SIZE MISMATCH.</h4>
                </div>
                <div class="modal-body" style="margin-top:-30px; ">
                    <div class="body">
                        <label>Please upload your image format in JPG/PNG/GIF. Each file size is limited to 1000 KB.</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Element Modal HTML -->
    <div id="AddelementModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content modal-content-500">
                <div class="jumbotron modal-header" style="border-radius:5px 5px 0px 0px; ">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="opacity:1.0;"><img src="{{asset('img/close.png')}}"></button>
                    <h4 class="modal-title">Add Element</h4>
                </div>
                <form role="form" name="addelementform" id="addelementform">
                    <div class="modal-body" style="margin-top:-30px; ">
                        <div class="row">
                            <div class="form-group col-lg-12">
                               <label for="element_category">Category</label>
                               <select class="form-control" name="element_category" id="element_category" >
                                  <option value="">Select Category</option>
                               </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="element_name">Element Name</label>
                                <input type="text" name="element_name" id="element_name" class="form-control" placeholder="Enter Element">
                            </div>
                            <div class="form-group col-lg-12">
                                <label name="element">Element</label>
                            </div>
                            <div class="form-group element-upload col-lg-3">
                                <label for="element_img" class="btn btn-default btn-block"><i class="fa fa-cloud-upload"></i> Upload</label>
                                <input id="element_img" type="file" onchange="readIMG(this);" name="element_img" />
                            </div>
                            <img id="previewImage" src="#" alt="Your image" style="display:none;" />
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="reset" class="btn btn-default btn-small" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-default btn-small">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <!-- Crop Image Modal -->
        <div class="modal fade" id="crop_imagepopup" aria-labelledby="modalLabel" role="dialog" tabindex="-1">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <!--<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modalLabel">Crop the image</h4>
              </div>-->
              <div class="modal-body" style="text-align: center;">
                <button type="button" style="margin-right: -20px; margin-top: -10px;" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div>
                  <img id="imagetocrop" src="" alt="Picture">
                </div>

               <div class="btn-group">
                <!--
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move" onClick='javascript:setDragMode("move");'>
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;move&quot;)">
                    <span class="fa fa-arrows"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop" onClick='javascript:setDragMode("crop");'>
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
                    <span class="fa fa-crop"></span>
                  </span>
                </button>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In" onClick='javascript:zoom(0.1);'>
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
                    <span class="fa fa-search-plus"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out" onClick="javascript:zoom(-0.1);">
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
                    <span class="fa fa-search-minus"></span>
                  </span>
                </button>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left" onClick="javascript:move(-10,0);">
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
                    <span class="fa fa-arrow-left"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right" onClick="javascript:move(10,0);">
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
                    <span class="fa fa-arrow-right"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up" onClick='javascript:move(0,-10);'>
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
                    <span class="fa fa-arrow-up"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down" onClick='javascript:move(0,10);'>
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
                    <span class="fa fa-arrow-down"></span>
                  </span>
                </button>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left" onClick="javascript:rotate(-45);">
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
                    <span class="fa fa-rotate-left"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right" onClick="javascript:rotate(45);">
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
                    <span class="fa fa-rotate-right"></span>
                  </span>
                </button>
              </div>
              <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal" onClick="javascript:scaleX(-1);">
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
                    <span class="fa fa-arrows-h"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical" onClick="javascript:scaleY(-1);">
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
                    <span class="fa fa-arrows-v"></span>
                  </span>
                </button>
              </div>

              <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="disable" title="Disable" onClick="javascript:disable();">
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.disable()">
                    <span class="fa fa-lock"></span>
                  </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="enable" title="Enable" onClick="javascript:enable();">
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.enable()">
                    <span class="fa fa-unlock"></span>
                  </span>
                </button>
              </div>

              <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="reset" title="Reset" onClick="javascript:reset();">
                  <span class="docs-tooltip" data-toggle="tooltip" title="cropper.reset()">
                    <span class="fa fa-refresh"></span>
                  </span>
                </button>

              </div>-->
               <span><button type="button" class="btn btn-success" title="Save Crop" data-method="getCroppedCanvas" id="getCroppedCanvas" name='getCroppedCanvas'>Crop</button></span>
              </div>
              <!--<div class="modal-footer">
               <span><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></span>
              </div>-->
            </div>
          </div>
      </div>
    </div>

    <!-- Grids Frames Modal HTML -->
    <div id="gridsframesdiv" style="z-index: 100; display: none;position: absolute;">
        <div class="bright-sec">
          <canvas id="gridframecanvas" width="1200" height="2000" style="border:0px solid #ccc;background:transparent;"></canvas>
        </div>
    </div>
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="{{asset('js/fabric1.7.2.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-slider.js')}}"></script>
<script type="text/javascript" src="{{asset('js/aligning_guidelines.js')}}"></script>
<script type="text/javascript" src="{{asset('js/centering_guidelines.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/validation-methods.js')}}"></script>
<script src="{{asset('js/augmentedReality.js')}}"></script>
<script src="{{asset('js/publishShare.js')}}"></script>
<script src="{{asset('plugins/slider/thumbnail-slider.js')}}" type="text/javascript"></script>
<script src="{{asset('js/cropper.min.js')}}"></script>
<script src="{{asset('js/jquery.colorpicker.js')}}"></script>
<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/camanjs/4.0.0/caman.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
<script type="text/javascript" src="//api.filestackapi.com/filestack.js"></script>

<script type="text/javascript">

  $("#spinnerModal").modal('show');

  $(document).ready(function() {
    $('#myCarousel').carousel({
      interval: 10000
    })
    //preview images for augmented reallity gallery
    var imagesPreview = function(input, placeToInsertImagePreview) {
        console.log('adding images')
        if (input.files) {
            var filesAmount = input.files.length;
            $(placeToInsertImagePreview).empty();
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $(placeToInsertImagePreview).append('<div class="col-md-4" style="margin-top: 10px"><div class="image-upload text-center"><img  class="center-block" src="'+event.target.result+'" style="object-fit: fill; width: 100%; height: 72px;"> </div></div>');
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    };

    $('#imagesTarget').on('change', function() {
        console.log('input changed')
        imagesPreview(this, '.imagesadded');
    });
    $('#imagesTargetNew').on('change', function() {
        console.log('input changed')
        imagesPreview(this, '.imagesadded');
    });
    $('#videoTarget').on('change', function() {
        console.log('Video File change')
        $('#videoNamePreview').append('<p style="color:#9E005C">Video Added <img src="{{asset('img/check.png')}}" width="20px"></p> ')
    });
});
</script>
<script>
  $( function() {
    $( "#tabs1" ).tabs();
    $( "#tabs2" ).tabs();
    $( "#tabs3" ).tabs();
    $( "#tabs4" ).tabs();
    $( "#tabs5" ).tabs();
    $( "#tabs6" ).tabs(); //marker augmented reality
  } );

  $("#tabs4").children(".menu-tabs").mouseenter(function(){
    $('.read-more-tab').show("slow");
  });

  $("#tabs4").children(".menu-tabs").mouseleave(function(){
    $('.read-more-tab').hide();
  });

//Show/hide dropdown submenu
$(document).ready(function() {
    $(".dropdown-submenu").click(function(event) {
        // stop bootstrap.js to hide the parents
        event.stopPropagation();
        // hide the open children
        $(this).find(".dropdown-submenu").removeClass('open');
        // add 'open' class to all parents with class 'dropdown-submenu'
        $(this).parents(".dropdown-submenu").addClass('open');
        // this is also open (or was)
        $(this).toggleClass('open');
    });
});
var tempIdToDel = '';
$(document).on("click", ".deleteTemp", function() {
    tempIdToDel = $(this).attr('id');
    $("#Del_tempModal").modal('show');
});
/*$("#saveTemplate").click(function() {
    $("#templateSaveModal").modal('show');
});*/

$("#publishTemplate").click(function() {
    $("#publishModal").modal('show');
});

/*$("#colorStrokeSelector").spectrum({
    showAlpha: false,
    showPalette: true,
    //maxSelectionSize: 2,
    preferredFormat: "hex",
    hideAfterPaletteSelect: true,
    showInput: true,
    allowEmpty: true,
    move: function(color) {
        var colorVal = color.toHexString(); // #ff0000
        changeStrokeColor(colorVal);
        $('#colorStrokeSelector').css('backgroundColor', colorVal);
    },
});*/


//hide tab pane by clicking again
$(document).off('click.tab.data-api');
$(document).on('click.tab.data-api', '[data-toggle="tab"]', function(e) {
    e.preventDefault();
    var tab = $($(this).attr('href'));
    var activate = !tab.hasClass('active');
    $('div.tab-content>div.tab-pane.active').removeClass('active');
    $('ul.nav.nav-tabs>li.active').removeClass('active');
    if (activate) {
        $(this).tab('show')
    }
});

// Hide the extra content initially, using JS so that if JS is disabled, no problemo.
$('.read-more-content').addClass('hide');

// Set up the toggle.
$('.read-more-toggle').on('click', function() {
  $(this).next('.read-more-content').toggleClass('hide');
});


$(".read-more-tab").hide();

$("#show-tab").click(function(){
    $(".read-more-tab").toggle();
});

</script>
<script type="text/javascript">
    var tempcanvas = new fabric.Canvas(document.getElementById('tempcanvas'));
    var canvas = new fabric.Canvas(document.getElementById('canvas0'), {renderOnAddRemove: false, stateful: false});
    canvas.rotationCursor = 'url("{{asset('img/rotatecursor2.png')}}") 10 10, crosshair';
    canvas.backgroundColor = '#ffffff';
    var selectedFont = 'Antonio';
    var fillColor = '#666666';
    var  isAdmin = false;
    @if (Auth::user()->isAdmin())
        isAdmin = true;
    @endif

    var app_base_url = window.location.origin;

    if(isAdmin) {
        app_base_url += "/adminCMS";
    }

    var user_id = "";
    @if (Auth::user()->isUser())
    user_id = {{Auth::user()->id}};
    @endif

    var product_id = "";

    <?php
      if(isset($product_id)) {
    ?>
      product_id = {{$product_id}};
    <?php
      }
    ?>

    var loadeddesignid = 0;
    var pageindex = '{{$panel->id}}';
    var bgpanel = '{{$panel->image}}';
    var panelisTarget = {{$panel->isTarget}};
    var panelname = '{{$panel->name}}';
</script>
<!-- our site js -->
<script src="{{asset('js/functions.js')}}" type="text/javascript"></script>
<script src="{{asset('js/canvasevents.js')}}" type="text/javascript"></script>
<script>
// Wait for window load
$(window).load(function() {

    $(document).mousemove(function(e) {
      checkcollision(e);
    });

    <?php
      if(isset($theDesign->id)) {
    ?>
      loadeddesignid = {{$theDesign->id}};
      loadDesign(loadeddesignid);
    <?php
      } else if(isset($adminDesign_id) && $adminDesign_id != '') {
    ?>
      bgpanel = "";
      loadAdminDesign({{$adminDesign_id}});
    <?php
      } else {
    ?>
      bgpanel = "";
      @if(!empty($panels))
        @foreach ($panels as $panel)
            showPanel({{$panel->id}}, '{{$panel->image}}', {{$panel->isTarget}}, '{{$panel->name}}');
        @endforeach
      @endif
      //addNewCanvasPage();
      //setCanvasSize();
    <?php
      }
    ?>

    $('.deletecanvas').css('display', 'none');
});

var Istempselected = false;
var Iscatselected = false;
var IsBgselected = false;
var IsTextselected = false;

$(document).ready(function() {

    initDraggable();

    $(document).on("click", ".catImage", function() {
        setdragdata(this);
        addImage(dragdatasrc);
        return false;
    });

    $(document).on("click", ".catSVGImage", function() {
        setdragdata(this);
        addSVGToCanvas(dragdatasrc);
        return false;
    });

    $(document).on("click", ".gridImage", function() {
        setdragdata(this);
        var options = {};
        options.grid = true;
        addSVGToCanvas(dragdatasrc, options);
        return false;
    });

    $(document).on("click", ".addImage", function() {
        setdragdata(this);
        addImage(dragdatasrc);
        return false;
    });

    var uploadIdToDel = '';
    $(document).on("click", ".deleteUploadImg", function() {
        uploadIdToDel = $(this).attr('id');
        proceed_uploadimgDelete();
    });

    function proceed_uploadimgDelete() {
        var selectedimg = uploadIdToDel;
        if (selectedimg != '') {
            $.post("actions/deleteimg.php", {
                "imgid": selectedimg
            }, function(data) {
                $('#image_container').empty();
                getuploadimages();
            });
        } else {
        }
    }

    $(document).on("click", ".bgImage", function() {
        var imagepath = $(this).attr('src');
        
        setCanvasBg(canvas, imagepath);

        setdragdata(this);

        return false;
    });

    $('#textcat-select').on('change', function() {
        Istextselected = true;
        $('#text_container').empty();
        getTexts($(this).val());
    });

});

//Do not close dropdown with checkbox
$('.noclose').on('click', function(e) {
    e.stopPropagation();
});
//Show/hide dropdown submenu
$(document).ready(function() {
    $(".dropdown-submenu").click(function(event) {
        // stop bootstrap.js to hide the parents
        event.stopPropagation();
        // hide the open children
        $(this).find(".dropdown-submenu").removeClass('open');
        // add 'open' class to all parents with class 'dropdown-submenu'
        $(this).parents(".dropdown-submenu").addClass('open');
        // this is also open (or was)
        $(this).toggleClass('open');
    });
});

var tempIdToDel = '';
$(document).on("click", ".deleteTemp", function() {
    tempIdToDel = $(this).attr('id');
    $("#Del_tempModal").modal('show');
});

$("#publishTemplate").click(function() {
    $("#publishModal").modal('show');
});

/*$("#objectopacitytx").click(function() {
    $("#opacitySlidertx").toggle();
    $("#showmoreoptionstxt ul li a").each(function() {
        if ($(this).css("display") == "block") {
            $(this).not("#objectopacitytx").addClass('temphide');
        }
    });
});

$("#objectopacityimg").click(function() {
    $("#opacitySliderimg").toggle();
    $("#showmoreoptionsimg ul li a").each(function() {
        if ($(this).css("display") == "block") {
            $(this).not("#objectopacityimg").addClass('temphide');
        }
    });
});

$("#objectopacitysvg").click(function() {
    $("#opacitySlidersvg").toggle();
    $("#showmoreoptionssvg ul li a").each(function() {
        if ($(this).css("display") == "block") {
            $(this).not("#objectopacitysvg").addClass('temphide');
        }
    });
});
$("#lineheight").click(function() {
    $("#lineheightSlider").toggle();
    $("#showmoreoptionstxt ul li a").each(function() {
        if ($(this).css("display") == "block") {
            $(this).not("#lineheight").addClass('temphide');
        }
    });
});
$("#charspacing").click(function() {
    $("#charspacingSlider").toggle();
    $("#showmoreoptionstxt ul li a").each(function() {
        if ($(this).css("display") == "block") {
            $(this).not("#charspacing").addClass('temphide');
        }
    });
});*/


$("#showmoreoptionstxt").click(function() {
    //$("#opacitySlidertx").hide();
    //$("#lineheightSlider").hide();
    //$("#charspacingSlider").hide();
    $('#showmoreoptionstxt ul li a').removeClass('temphide');
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        if (activeObject.lockMovementY == true) {
            $('#objectlock').html("<i class='fa fa-unlock'></i>");
        } else {
            $('#objectlock').html("<i class='fa fa-lock' style='font-size:14px;'></i>");
        }
        var objectopacity = activeObject.getOpacity();
        changeopacitytxslider.setValue(objectopacity);
        var lineheight = activeObject.getLineHeight();
        changelineheightslider.setValue(lineheight);
        var charspacing = activeObject.charSpacing;
        changecharspacingslider.setValue(charspacing);

        $("#txtopacityval").html(changeopacitytxslider.getValue());
        $("#lineheightval").html(changelineheightslider.getValue());
        $("#letterspaceval").html(changecharspacingslider.getValue());
    }
});

$("#showmoreoptionsimg").click(function() {
    //$("#opacitySliderimg").hide();
    $('#showmoreoptionsimg ul li a').removeClass('temphide');
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        if (activeObject.lockMovementY == true) {
            $('#objectlock').html("<i class='fa fa-unlock'></i>");
        } else {
            $('#objectlock').html("<i class='fa fa-lock' style='font-size:14px;'></i>");
        }
        var objectopacity = activeObject.getOpacity();
        changeopacityimgslider.setValue(objectopacity);

        $("#imgopacityval").html(changeopacityimgslider.getValue());
    }
});

$("#showmoreoptionssvg").click(function() {
    //$("#opacitySlidersvg").hide();
    $('#showmoreoptionssvg ul li a').removeClass('temphide');
    var activeObject = canvas.getActiveObject();
    if (activeObject) {
        if (activeObject.lockMovementY == true) {
            $('#objectlock').html("<i class='fa fa-unlock'></i>");
        } else {
            $('#objectlock').html("<i class='fa fa-lock' style='font-size:14px;'></i>");
        }
        var objectopacity = activeObject.getOpacity();
        changeopacitysvgslider.setValue(objectopacity);

        $("#svgopacityval").html(changeopacityimgslider.getValue());
    }
});

function handleContextmenu(e) {
    // prevents the usual context from popping up
    e.preventDefault();
    // Show contextmenu
    $(".custom-menu").finish().toggle(100).
        // In the right position (the mouse)
    css({
        top: e.pageY + "px",
        left: e.pageX + "px"
    });
}
//Disable context menu
$("#canvasbox-tab").bind('contextmenu', function(e) {
    handleContextmenu(e);
    return false;
});
// If the menu element is clicked
$(".custom-menu li").click(function() {
    // This is the triggered action name
    switch ($(this).attr("data-action")) {
        // A case for each action. Your actions here
        case "selectall":
            selectallobjs();
            break;
        case "copy":
            copyobjs();
            break;
        case "cut":
            cutobjs();
            break;
        case "paste":
            pasteobjs();
            break;
    }
    // Hide it AFTER the action was triggered
    $(".custom-menu").hide(100);
});

//hide tab pane by clicking again
$(document).off('click.tab.data-api');
$(document).on('click.tab.data-api', '[data-toggle="tab"]', function(e) {
    e.preventDefault();
    var tab = $($(this).attr('href'));
    var activate = !tab.hasClass('active');
    $('div.tab-content>div.tab-pane.active').removeClass('active');
    $('ul.nav.nav-tabs>li.active').removeClass('active');
    if (activate) {
        $(this).tab('show')
    }
});

// Prevent the backspace key from navigating back.
$(document).unbind('keydown').bind('keydown', function(event) {
    var doPrevent = false;
    if (event.keyCode === 8) {
        var d = event.srcElement || event.target;
        if ((d.tagName.toUpperCase() === 'INPUT' &&
                (
                    d.type.toUpperCase() === 'TEXT' ||
                    d.type.toUpperCase() === 'PASSWORD' ||
                    d.type.toUpperCase() === 'FILE' ||
                    d.type.toUpperCase() === 'SEARCH' ||
                    d.type.toUpperCase() === 'EMAIL' ||
                    d.type.toUpperCase() === 'NUMBER' ||
                    d.type.toUpperCase() === 'DATE')
            ) ||
            d.tagName.toUpperCase() === 'TEXTAREA') {
            doPrevent = d.readOnly || d.disabled;
        } else {
            doPrevent = true;
        }
    }
    if (doPrevent) {
        event.preventDefault();
    }
});

$(document).ready(function() {
    $('#rightside').css('margin-left', $(".tabs-left").width() - 25);
});
$(function () {
  var $image = $('#imagetocrop');
  var cropBoxData;
  var canvasData;
  $('#crop_imagepopup').on('shown.bs.modal', function () {
    $image.cropper({
      autoCropArea: 0.5,
      built: function () {
        //$image.cropper('setCanvasData', canvasData);
        //$image.cropper('setCropBoxData', cropBoxData);
      }
    });
  }).on('hidden.bs.modal', function () {
    cropBoxData = $image.cropper('getCropBoxData');
    canvasData = $image.cropper('getCanvasData');
    $image.cropper('destroy');
  });
});
function getuploadimages() {

    var $grid = $('#image_container');
    $grid.empty();

    $grid.isotope({
        itemSelector: '.thumb',
        masonry: {
            columnWidth: '.thumb'
        }
    });

    $.ajax({
        type: 'GET',
        url: 'get_uploadimages.php',
        success: function(data) {
            if (data != '') {
                var data = $(data);

                $grid.isotope()
                    .append(data)
                    .isotope('appended', data)
                    .isotope('layout');

                $grid.imagesLoaded().progress(function() {
                    $grid.isotope('layout');
                    $grid.isotope('reloadItems');
                });
            }
        }
    });
}

function addImage(imgpath, options) {
    
    if(imgpath.trim().length == 0) return;

    var actObj = canvas.getActiveObject();
    if (isReplaceImage && actObj && actObj.type == 'image') {
        //replace image
        var img = new Image();
        img.onload = function() {

            w = actObj.width * actObj.scaleX;
            h = actObj.height * actObj.scaleY;

            actObj.setElement(img);
            actObj.src = imgpath;
            actObj.orgSrc = imgpath;

            actObj.cw = w;
            actObj.ch = h;

            actObj.scaleX = w/actObj.width;
            actObj.scaleY = h/actObj.height;

            var ih = img.naturalHeight;
            var iw = img.naturalWidth;

            //find the width/height for the aspect ratio.
            var fw, fh;

            var width_ratio  = w  / iw;
            var height_ratio = h / ih;
            if (width_ratio > height_ratio) {
                fw = iw * width_ratio;
                fh = ih*fw/iw;
            } else {
                fh = ih * height_ratio;
                fw = iw*fh/ih;
            }

            if (width_ratio > height_ratio) {
                actObj.cw = w / width_ratio;
                actObj.ch = h / width_ratio;
            } else {
                actObj.cw = w / height_ratio;
                actObj.ch = h / height_ratio;
            }

            actObj.cx = 0;
            actObj.cy = 0;

            actObj.zoomBy(0, 0, 0, function() {

                actObj.setCoords();
                canvas.renderAll();

                $("#spinnerModal").modal('hide');
                $("#AdduploadimageModal").modal('hide');
            });
        }
        img.src = imgpath;
        isReplaceImage = false;
    } else {
        fabric.util.loadImage(imgpath, function(img) {
            var object = new fabric.Image(img, {
                //scaleX: cavasScale / 2,
            });
            object.orgSrc = imgpath;
            object.src = imgpath;
            canvas.add(object);

            object.scaleToWidth(200);

            if(options) {
              object.left = options.left - (object.width*object.scaleX)/2;
              object.top = options.top - (object.height*object.scaleY)/2;
            } else {
              object.center();
            }
            object.setCoords();

            setElementProps(object);

            object.globalCompositeOperation = 'source-atop';

            $("#spinnerModal").modal('hide');
            $("#AdduploadimageModal").modal('hide');

            canvas.renderAll();
            saveState();
        }, {
            crossOrigin: ''
        });
    }
}

function copyElementProps(srcobj, dstobj) {

    dstobj.elementId = srcobj.elementId;
    dstobj.elementType = srcobj.elementType;
    dstobj.elementPrice = srcobj.elementPrice;
    dstobj.elementLicense = srcobj.elementLicense;
}

function setElementProps(object) {

    object.elementId = dragdataid;
    object.elementType = dragdatatype;

    object.elementPrice = 0;
    object.elementLicense = "free";

    if(object.elementPrice < dragdatasingle) {
      object.elementPrice = dragdatasingle;
      object.elementLicense = "single";
    }
    if(object.elementPrice < dragdatamultiple) {
      object.elementPrice = dragdatamultiple;
      object.elementLicense = "multiple";
    }
    if(object.elementPrice < dragdataright) {
      object.elementPrice = dragdataright;
      object.elementLicense = "right";
    }
}

function setDragMode(mode) {
    $('#imagetocrop').cropper('setDragMode', mode);
}

function zoom(val) {
    $('#imagetocrop').cropper('zoom', val);
}

function move(val1, val2) {
    $('#imagetocrop').cropper('move', val1, val2);
}

function rotate(val) {
    $('#imagetocrop').cropper('rotate', val);
}

function scaleX(val) {
    $('#imagetocrop').cropper('scaleX', val);
}

function scaleY(val) {
    $('#imagetocrop').cropper('scaleY', val);
}

function crop(mode) {
    $('#imagetocrop').cropper('crop', mode);
}

function clear(mode) {
    $('#imagetocrop').cropper('clear', mode);
}

function disable(mode) {
    $('#imagetocrop').cropper('disable', mode);
}

function enable(mode) {
    $('#imagetocrop').cropper('enable', mode);
}

function reset(mode) {
    $('#imagetocrop').cropper('reset', mode);
}

$("#getCroppedCanvas").click(function() {

    var cropcanvas = $('#imagetocrop').cropper('getCroppedCanvas');

    $("#spinnerModal").modal('show');
    $("#crop_imagepopup").modal('hide');

    var pngdataURL = cropcanvas.toDataURL("image/png");

    var currentTime = new Date();
    var month = currentTime.getMonth() + 1;
    var day = currentTime.getDate();
    var year = currentTime.getFullYear();
    var hours = currentTime.getHours();
    var minutes = currentTime.getMinutes();
    var seconds = currentTime.getSeconds();
    var filename = month + '' + day + '' + year + '' + hours + '' + minutes + '' + seconds + ".png";

    var formData = {
        pngimageData: pngdataURL,
        filename: filename
    }

    var type = "PUT";
    var my_url = app_base_url + "/savecropimage";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    $.ajax({
        type: type,
        url: my_url,
        data: formData,
        dataType: 'json',
        success: function(msg) {

            filepath = app_base_url +  "/uploads/croppedimages/" + filename;
            console.log('Upload success');

            var actObj = canvas.getActiveObject();

            if(!actObj) {
              $("#spinnerModal").modal('hide');
              return;
            }
            //replace image
            var img = new Image();
            img.onload = function() {
                var w = actObj.width * actObj.scaleX;
                var h = actObj.height * actObj.scaleY;
                actObj.setElement(img);

                scalex = w / this.width;
                scaley = h / this.height;

                actObj.scaleX = scalex;
                actObj.scaleY = scalex;

                //actObj.orgSrc = img.src;
                actObj.src = img.src;

                $("#spinnerModal").modal('hide');
                actObj.setCoords();
                canvas.renderAll();
            }
            img.src = filepath;
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
});

var dragdatasrc = "";
var dragdataclass = "";
var dragdatatexttype = "";
var dragdataid = "";
var dragdatatype = "";
var dragdatasingle = 0;
var dragdatamultiple = 0;
var dragdataright = 0;

function initDraggable() {

  $(".catImage, .bgImage, .textImage, .catSVGImage, .gridImage").draggable({
      //revert: true,
      helper: 'clone',
      appendTo: 'body',
      containment: "body",
      scroll: false,
      start: function(event, ui) {

          $(ui.helper).css({"opacity":"0.8","width":"200"});

          dragdatasrc = "";
          dragdataclass = "";
          dragdatatexttype = "";
          dragdataid = "";
          dragdatatype = "";
          dragdatasingle = 0;
          dragdatamultiple = 0;
          dragdataright = 0;

          fillpattern = "";

          setdragdata(this);
      },
      drag: function(event, ui) {

          $(ui.helper).css({"opacity":"0.8","width":"200"});
      }
  });
}

function setdragdata(lthis) {
      dragdatasrc = $(lthis).attr("src");
      dragdataclass = $(lthis).attr("class");
      dragdatatexttype = $(lthis).attr("texttype");
      dragdataid = $(lthis).attr("data-id");
      dragdatatype = $(lthis).attr("data-type");
      dragdatasingle = parseFloat($(lthis).attr("data-single"));
      dragdatamultiple = parseFloat($(lthis).attr("data-multiple"));
      dragdataright = parseFloat($(lthis).attr("data-right"));
}

var video;
$(".hidevideo").click(function() {
  if($("#videoplayer").is(":visible")) {
    $("#video").hide("slow");
    $(".hidevideo").html("Click here to show the video");
    $(".search-sec").css({"padding-top": "60px", "padding-bottom": "20px"});
    video = $("#videoplayer").attr("src");
    $("#videoplayer").attr("src","");
  } else {
    if(video)
    $("#videoplayer").attr("src",video);
    $("#video").show("slow");
    $(".hidevideo").html("Click here to hide the video");
    $(".search-sec").css({"padding-top": "100px", "padding-bottom": "80px"});
  }
});

$("#searchelements").keyup(function(event) {
    //enter or esc
    if(event.keyCode == 13 || event.keyCode == 27) {

      searchElements();
    }
});

function searchElements() {
      
      var keywords = document.getElementById('searchelements').value;

      if(keywords.trim().length == 0) keywords = 'all'; 

      $('ul.pictures-container').fadeOut();
      $('ul.pictures-container').load('/searchpictures/'+keywords, function() {
          $('ul.pictures-container').fadeIn();
          initDraggable();
      });
      $('ul.lines-container').fadeOut();
      $('ul.lines-container').load('/searchlines/'+keywords, function() {
          $('ul.lines-container').fadeIn();
          initDraggable();
      });
      $('ul.illustrations-container').fadeOut();
      $('ul.illustrations-container').load('/searchillustrations/'+keywords, function() {
          $('ul.illustrations-container').fadeIn();
          initDraggable();
      });
      $('ul.grids-container').fadeOut();
      $('ul.grids-container').load('/searchgrids/'+keywords, function() {
          $('ul.grids-container').fadeIn();
          initDraggable();
      });
      $('ul.frames-container').fadeOut();
      $('ul.frames-container').load('/searchframes/'+keywords, function() {
          $('ul.frames-container').fadeIn();
          initDraggable();
      });
      $('ul.backgrounds-container').fadeOut();
      $('ul.backgrounds-container').load('/searchbackgrounds/'+keywords, function() {
          $('ul.backgrounds-container').fadeIn();
          initDraggable();
      });
      
      hideElementDetails();
      hideBGElementDetails();
}

function deleteuserimage(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })
    $.ajax({
        type: "DELETE",
        url: "{{ url('/deleteuserimage') }}" + '/' + id, //resource
        success: function(affectedRows) {
            //refresh container
            getUserImages();
        }
    });
}

function getUserImages() {
    $('ul.spiff-userimages-container').fadeOut();
    $('ul.spiff-userimages-container').load(app_base_url + '/getuserimages?user_id=' + user_id, function() {
        $('ul.spiff-userimages-container').fadeIn();
        initDraggable();
    });
}

function getLayouts() {
    $('ul.spiff-layouts-container').fadeOut();
    $('ul.spiff-layouts-container').load(app_base_url + '/getlayouts?product_id=' + product_id + "&spiffdesigns=true", function() {
        $('ul.spiff-layouts-container').fadeIn();
    });
    $('ul.layouts-container').fadeOut();
    $('ul.layouts-container').load(app_base_url + '/getlayouts?product_id=' + product_id, function() {
        $('ul.layouts-container').fadeIn();
    });
}

@if (Auth::user()->isAdmin())
  $(".hidevideo").click();
@else
    //var tag = document.createElement('script');

    //tag.src = "https://www.youtube.com/iframe_api";
    //var firstScriptTag = document.getElementsByTagName('script')[0];
    //firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
@endif

/*var player;

function onYouTubeIframeAPIReady() {
    player = new YT.Player('videoplayer', {
        events: {
            'onPlayerReady': onPlayerReady
        }
    });
}

function onPlayerReady() {
    player.playVideo();
    // Mute!
    player.mute();
}*/

function hideProdTab() {
    document.getElementById("thumbnail-slider").style.visibility = "hidden";
}
function showProdTab() {
    document.getElementById("thumbnail-slider").style.visibility = "visible";
}

//https://github.com/vanderlee/colorpicker
var bgColorDiaHidden;
var textbgColorDiaHidden;
$(function() {
    bgColorDiaHidden = $('#bgcololrpicker').colorpicker({
        parts: ['swatches'],
        alpha: true,
        swatchesWidth: 50,
        layout: {
            preview: [0, 0, 0, 1],
        },
        position: {
            my: 'top+6%',
            at: 'left+100',
            of: '#textbgcolor'
        },
        init: function() {
        },
        select: function(event, color) {

            var colorval = ('#' + color.formatted);
            setCanvasBg(canvas, false, colorval);
        }
    });

    textbgColorDiaHidden = $('#textbgcolor-input').colorpicker({
        parts: ['cmyk', 'swatches'],
        alpha: true,
        layout: {
            preview: [0, 0, 0, 1],
        },
        position: {
            my: 'top+6%',
            at: 'left+100',
            of: '#textbgcolor'
        },
        open: function(event, color) {

            isTextClPickrOpen = true;

            var v = $('#textbgcolor i').css('backgroundColor');

            var rgb = v.replace(/^rgba?\(|\s+|\)$/g,'').split(',');

            var cmyk = rgbToCmyk(rgb[0],rgb[1],rgb[2])

            color.colorPicker.color.setCMYK(cmyk.c / 100.0, cmyk.m / 100.0, cmyk.y / 100.0, cmyk.k / 100.0);

            var i = 0;
            $('.ui-colorpicker-swatch').each(function(){
                if($(this).css('background-color') == v){
                    if(i == 1) {
                      $('.ui-colorpicker-swatches:eq(1)').animate({scrollTop: $(this).offset().top - $('.ui-colorpicker-swatches:eq(1)').offset().top},'slow');
                    }
                    i++;
                }
            });
        },
        close: function() {
          isTextClPickrOpen = false;
        },
        select: function(event, color) {

            var colorval = ('#' + color.formatted);
            $('#textbgcolor i').css('backgroundColor', colorval);
            var activeobject = canvas.getActiveObject();

            if(color && activeobject) {
              if (activeobject.type == "textbox" || activeobject.type == "text") {
                changeObjectColor(colorval);
                fillColor = colorval;
              }
            }
        }
    });

    var isTextClPickrOpen = false;
    $('#textbgcolor').click(function(e) {
        e.stopPropagation();
        textbgColorDiaHidden.colorpicker('open');
    });

    $( window ).scroll(function() {

        if(isTextClPickrOpen)
        textbgColorDiaHidden.colorpicker('close');

        if(isTextClPickrOpen) {
          var activeobject = canvas.getActiveObject();
          if(activeobject) {
            if (activeobject.type == "textbox" || activeobject.type == "text") {
              setTimeout(function() {
                  textbgColorDiaHidden.colorpicker('open');
              }, 300);
            }
          }

        }
    });
});

$(".fa-instagram").click(function(event) {
    event.stopPropagation();
    filepicker.setKey('AP0JVXMQMQjOqO8emYcB4z');

    filepicker.pick({
            mimetype: 'image/*',
            //container: 'window',
            services: ['INSTAGRAM']
        },
        function(Blob) {

          $("#spinnerModal").modal('show');
          $("#spinnerModal").modal('hide');

          filepicker.read (
          blob,
          function(imgdata) {

            $("#spinnerModal").modal('show');

            var formdata = {
                user_image: imgdata,
                filename: blob.filename
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            $.ajax({
                type: "PUT",
                dataType: "json",
                url: "{{ url('/saveuserimages') }}",
                data: formdata,
                success: function (data) {
                  var imgurl = app_base_url + "/uploads/userimages/" + blob.filename;
                  filepickerimageToCanvas(imgurl);
                  getUserImages();
                  $("#spinnerModal").modal('hide');
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
          });
        },
        function(FPError){
          $("#spinnerModal").modal('show');
          $("#spinnerModal").modal('hide');
        }
    );
});

$(".fa-facebook-square").click(function(event) {

    event.stopPropagation();
    filepicker.setKey('AP0JVXMQMQjOqO8emYcB4z');

    filepicker.pick(
        {
            mimetype: 'image/*',
            //container: 'window',
            services: ['FACEBOOK']
        },
        function(blob) {

          $("#spinnerModal").modal('show');
          $("#spinnerModal").modal('hide');

          filepicker.read (
          blob,
          function(imgdata) {

            $("#spinnerModal").modal('show');
            var formdata = {
                user_image: imgdata,
                filename: blob.filename
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })

            $.ajax({
                type: "PUT",
                dataType: "json",
                url: "{{ url('/saveuserimages') }}",
                data: formdata,
                success: function (data) {
                  var imgurl = app_base_url + "/uploads/userimages/" + blob.filename;
                  filepickerimageToCanvas(imgurl);
                  getUserImages();
                  $("#spinnerModal").modal('hide');
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
          });
        },
        function(FPError){
          $("#spinnerModal").modal('show');
          $("#spinnerModal").modal('hide');
        }
    );
});

$(document).ready(function() {

  $('#importfile').change(function () {
    $("#spinnerModal").modal('show');
    var form = document.forms.namedItem("uploadform");
    var formdata = new FormData(form);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    })

    $.ajax({
        async: true,
        type: "POST",
        dataType: "json",
        contentType: false, // high importance!
        url: "{{ url('/uploaduserimages') }}",
        data: formdata,
        processData: false,
        success: function (data) {
            getUserImages();
            $("#spinnerModal").modal('hide');
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });
  });
});

$("#tabs1-1").click();

//show popup when clicking the trigger
$('#openimgfiltersModallink').on('click touch', function(){
  $('#openimgfiltersModal').show("slow");
  initImageFilters();
});

$('.closebtn').on('click touch', function(){
  $('#openimgfiltersModal').hide();
  $('#gridsframesModal').hide();
});

//hide it when clicking anywhere else except the popup and the trigger
$(document).on('click touch', function(event) {
  if (!$(event.target).parents().addBack().is('#openimgfiltersModallink')) {
    $('#openimgfiltersModal').hide();
    $('#gridsframesModal').hide();
  }
});

// Stop propagation to prevent hiding "Modal" when clicking on it
$('#openimgfiltersModal').on('click touch', function(event) {
  event.stopPropagation();
});
$('#gridsframesModal').on('click touch', function(event) {
  event.stopPropagation();
});

Array.prototype.forEach.call(document.querySelectorAll('.clearable-input'), function(el) {
  var input = el.querySelector('input');

  conditionallyHideClearIcon();
  input.addEventListener('input', conditionallyHideClearIcon);
  el.querySelector('[data-clear-input]').addEventListener('click', function(e) {
    input.value = '';
    searchElements();
    conditionallyHideClearIcon();
  });

  function conditionallyHideClearIcon(e) {
    var target = (e && e.target) || input;
    target.nextElementSibling.style.display = target.value ? 'block' : 'none';
  }
});
</script>

</html>
