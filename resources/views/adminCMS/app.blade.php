<!DOCTYPE html>

<html class=''>

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="_token" content="{!! csrf_token() !!}" />

    <title>Spiff Editor</title>

    <meta name="description" content="">

    <link rel="stylesheet" href="{{ asset('adminCMS/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link href="{{ asset('adminCMS/css/fonts/scriptina/stylesheet.css') }}" rel='stylesheet' type='text/css'>

    <link href="{{ asset('adminCMS/css/fonts/isabella-script/stylesheet.css') }}" rel='stylesheet' type='text/css'>

    <link href="{{ asset('adminCMS/css/jquery.mCustomScrollbar.css') }}" type="text/css" rel="stylesheet">

    <link href="{{ asset('adminCMS/css/icomoon.css') }}" type="text/css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('adminCMS/css/style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('adminCMS/css/custom.css') }}">

    <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">


</head>
<body>

    <div class="container" id="page-container">

        <nav class="navbar navbar-inverse navbar-fixed-top">

            <div class="container-fluid">

                <!-- Brand and toggle get grouped for better mobile display -->

                <div class="">

                             <div class="navbar-header">

                             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#headernav">

                            <span class="icon-bar"></span>

                            <span class="icon-bar"></span>

                            <span class="icon-bar"></span>

                        </button>

                      <a href="{{ url('adminCMS/home') }}" class="logo-text"><img src="{{ asset('adminCMS/img/logo.jpg') }}" alt=""></a>

                    </div>

                </div>



                <div class="collapse navbar-collapse" id="headernav">

                 <ul class="nav navbar-nav text-center  navbar-topmenu">

                    <li class="

                        @if (\Request::is('adminCMS/home') || \Request::is('adminCMS/fonts') || \Request::is('adminCMS/pictures') || \Request::is('adminCMS/lines') || \Request::is('adminCMS/illustrations') || \Request::is('adminCMS/grids') || \Request::is('adminCMS/frames') || \Request::is('adminCMS/backgrounds') || \Request::is('adminCMS/editpictures/*'))
                          active
                        @endif

                    "><a id="createmenutop" href="#create-leftmenu" data-target="#create-leftmenu,#create-bodycontent" data-toggle="tab" >Create</a>
                    </li>

                    <li class="
                    @if (\Request::is('adminCMS/videos/*')))
                            active
                    @endif">
                        <a href="#learn-leftmenu" data-target="#learn-leftmenu,#learn-bodycontent" data-toggle="tab">Learn</a>
                    </li>

                    <li class="

                        @if (\Request::is('adminCMS/addproducts') || \Request::is('adminCMS/products')|| \Request::is('adminCMS/editproducts/*'))
                          active
                        @endif

                    "><a  href="#products-leftmenu" data-target="#products-leftmenu,#products-bodycontent" data-toggle="tab">Products</a></li>

                    <li class="
                    @if (\Request::is('adminCMS/gallery')))
                            active
                    @endif">
                        <a href="{{url('adminCMS/gallery')}}" {{--data-target="#gallery-leftmenu,#gallery-bodycontent" data-toggle="tab" --}}>Gallery
                            @if(count(\App\Models\Share::where('status', 'evaluating')->get())> 0)
                                <small style="color: #801C6B">News !</small>
                            @endif
                        </a>
                    </li>

                    <li class="
                        @if (\Request::is('adminCMS/users')))
                                active
                        @endif">
                        <a href="#users-leftmenu" data-target="#users-leftmenu,#users-bodycontent" data-toggle="tab">Users</a>
                    </li>

                    <li id="logoutlink" class="active pull-right">
                        <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        @if(Auth::check())
                            {{Auth::user()->name}}
                        @endif
                    </li>

                </ul>

          </div>

            <!-- /.navbar-collapse -->

    </div>

    <!-- /.container-fluid -->

    </nav>

    </div>

        <div id="leftmenu" class="leftmenuwrap">

            <div class="tabs-left">

                <div class="tab-content">
                    <div class="tab-pane
                        @if (\Request::is('adminCMS/home') || \Request::is('adminCMS/fonts') || \Request::is('adminCMS/pictures') || \Request::is('adminCMS/lines') || \Request::is('adminCMS/illustrations') || \Request::is('adminCMS/grids') || \Request::is('adminCMS/frames') || \Request::is('adminCMS/backgrounds')
                        || \Request::is('adminCMS/editpictures/*') || \Request::is('adminCMS/searchpictures/*') || \Request::is('adminCMS/picturecreate')
                        || \Request::is('adminCMS/editlines/*') || \Request::is('adminCMS/searchlines/*') || \Request::is('adminCMS/linecreate')
                        || \Request::is('adminCMS/editillustrations/*') || \Request::is('adminCMS/illustrationcreate')|| \Request::is('adminCMS/searchillustrations/*')
                        || \Request::is('adminCMS/editgrids/*') || \Request::is('adminCMS/gridcreate')|| \Request::is('adminCMS/searchgrids/*')
                        || \Request::is('adminCMS/editframes/*') || \Request::is('adminCMS/framecreate')|| \Request::is('adminCMS/searchframes/*')
                        || \Request::is('adminCMS/editbackgrounds/*') || \Request::is('adminCMS/backgroundcreate')|| \Request::is('adminCMS/searchbackgrounds/*')
                        || \Request::is('adminCMS/fontcreate')|| \Request::is('adminCMS/searchfonts/*')|| \Request::is('adminCMS/layouts') || \Request::is('adminCMS/editlayouts') || \Request::is('adminCMS/searchvideo')|| \Request::is('adminCMS/productlayouts')|| \Request::is('adminCMS/searchElements'))
                          active
                        @endif
                    " id="create-leftmenu">

                      <ul class="leftmenu">

                          <li>

                              <a href="{{ url('adminCMS/fonts') }}" data-target="#fontstab">

                                <span class="leftmenuhead">Fonts</span>

                                <span class="leftmenuimgholder">

                                    <img src="{{ asset('adminCMS/img/text.png') }}" alt="Fonts" height="62" />

                                    <i class="fa fa-plus" aria-hidden="true"></i>

                                </span>

                              </a>

                          </li>

                          <li>

                              <a href="{{ url('adminCMS/pictures') }}" data-target="" >

                                <span class="leftmenuhead">Elements</span>

                                <span class="leftmenuimgholder">

                                    <img src="{{ asset('adminCMS/img/elements.png') }}" alt="Elements" height="62" />

                                    <i class="fa fa-plus" aria-hidden="true"></i>

                                </span>

                              </a>

                          </li>

                          <li>

                              <a href="{{ url('adminCMS/backgrounds') }}">

                                <span class="leftmenuhead">Backgrounds</span>

                                <span class="leftmenuimgholder">

                                    <img src="{{ asset('adminCMS/img/backgrounds.png') }}" alt="Backgrounds" height="62" />

                                    <i class="fa fa-plus" aria-hidden="true"></i>

                                </span>

                              </a>

                          </li>

                          <li>

                              <a href="{{ url('adminCMS/productlayouts') }}">

                                <span class="leftmenuhead">Layout</span>

                                <span class="leftmenuimgholder">

                                    <img src="{{ asset('adminCMS/img/layouts.png') }}" alt="Layout" height="62" />

                                    <i class="fa fa-plus" aria-hidden="true"></i>

                                </span>

                              </a>

                          </li>

                          <li>

                              <a href="{{ url('adminCMS/searchvideo') }}">

                                <span class="leftmenuhead">Search Engine Video</span>

                                <span class="leftmenuimgholder">

                                    <img src="{{ asset('adminCMS/img/uploads.png') }}" alt="Search Engine Video" height="62" />

                                    <i class="fa fa-plus" aria-hidden="true"></i>

                                </span>

                              </a>

                          </li>

                      </ul>

                    </div>

                    <div class="tab-pane
                    @if (\Request::is('adminCMS/videos/*') || \Request::is('adminCMS/videos'))
                            active
                          @endif" id="learn-leftmenu">

                        <ul class="leftmenu">
                            <li>
                                <a href="{{url('adminCMS/videos/create')}}">
                                    <span class="leftmenuhead">Add Video</span>
                                    <span class="leftmenuimgholder">
                                    <img src="{{ asset('adminCMS/img/addVideo.png') }}" alt="Add Product" height="62" />
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{url('adminCMS/videos')}}">
                                    <span class="leftmenuhead">Videos</span>
                                    <span class="leftmenuimgholder">
                                    <img src="{{ asset('adminCMS/img/yourVideos.png') }}" alt="Add Product" height="62" />
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-pane

                        @if (\Request::is('adminCMS/addproducts') || \Request::is('adminCMS/products')|| \Request::is('adminCMS/editproducts/*')|| \Request::is('adminCMS/searchproducts/*'))
                          active
                        @endif

                        " id="products-leftmenu">

                      <ul class="leftmenu">

                          <li>

                              <a href="{{ url('adminCMS/addproducts') }}">

                                <span class="leftmenuhead">Add Product</span>

                                <span class="leftmenuimgholder">

                                    <img src="{{ asset('adminCMS/img/text.png') }}" alt="Add Product" height="62" />

                                    <i class="fa fa-plus" aria-hidden="true"></i>

                                </span>

                              </a>

                          </li>

                          <li>

                              <a href="{{ url('adminCMS/products') }}">

                                <span class="leftmenuhead">Your Products</span>

                                <span class="leftmenuimgholder">

                                    <img src="{{ asset('adminCMS/img/elements.png') }}" alt="Your Products" height="62" />

                                </span>

                              </a>

                          </li>

                      </ul>

                    </div>

                    <div class="tab-pane" id="gallery-leftmenu">

                      <h4 class="text-center">Nothing </h4>

                    </div>

                    <div class="tab-pane  @if (\Request::is('adminCMS/users') || \Request::is('adminCMS/users/*'))
                            active
                          @endif" id="users-leftmenu">

                        <ul class="leftmenu">
                            <li>
                                <a href="{{ url('adminCMS/users/create') }}">

                                    <span class="leftmenuhead">CREATE NEW USER</span>

                                    <span class="leftmenuimgholder">

                                    <img src="{{ asset('img/newUser.png') }}" alt="Your Products" height="62" />

                                </span>

                                </a>
                            </li>
                            <li>
                                <a href="{{ url('adminCMS/users') }}">

                                    <span class="leftmenuhead">USERS</span>

                                    <span class="leftmenuimgholder">

                                    <img src="{{ asset('img/yourUsers.png') }}" alt="Your Products" height="62" />

                                </span>

                                </a>
                            </li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>

	@yield('content')

</body>

<!-- Scripts -->

<script src="{{ asset('adminCMS/js/jquery.min.js') }}"></script>

<script src="{{ asset('adminCMS/js/jquery-ui.js') }}"></script>

<script src="{{ asset('adminCMS/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('adminCMS/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
@yield('javascript')

<!-- <script src="js/bootstrap-tour.js"></script>

<script type="text/javascript" src="./js/spectrum.js"></script>-->

<script type="text/javascript" src="{{ asset('adminCMS/js/script.js') }}"></script>

<script type="text/javascript">

	$(document).ready(function() {

	    $('#myCarousel').carousel({

	      interval: 10000

	  })

	});

</script>

<script>

  $( function() {

    $( "#tabs1" ).tabs();

    $( "#tabs2" ).tabs();

    $( "#tabs3" ).tabs();

    $( "#tabs4" ).tabs();

  } );



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


//hide tab pane by clicking again

$(document).off('click.tab.data-api');

$(document).on('click.tab.data-api', '[data-toggle="tab"]', function(e) {

    e.preventDefault();

    var tab = $($(this).attr('href'));

    var activate = !tab.hasClass('active');

    if (activate) {

        $('div.tab-content>div.tab-pane.active').removeClass('active');

        $('ul.nav.nav-tabs>li.active').removeClass('active');

        $(this).tab('show')

        $('#logoutlink').addClass('active');

    }

});

//hide tab pane by clicking again

//$(document).off('click.tab.data-api');
$(document).on('click', '[data-toggle="leftnav"]', function(e) {

    e.preventDefault();

    var tab = $($(this).attr('href'));

    var activate = !tab.hasClass('active');

    if (activate) {

        tab.find('.tabs-bodypane .leftmenu-tabpane.active').removeClass('active');

        $(this).tab('show')

    }

});

$(document).on('click', '[data-toggle="elementsnav"]', function(e) {

    e.preventDefault();

    var tab = $($(this).attr('href'));

    var activate = !tab.hasClass('active');

    if (activate) {

        $('.elementsTabBody > .elementsTabContent').removeClass('active');

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


</body>
</html>
