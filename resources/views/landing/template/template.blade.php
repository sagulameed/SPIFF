<!DOCTYPE html>
<html class=''>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spiff Editor</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> -->
{{--    <link href="{{asset('css/spectrum.css')}}" type="text/css" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <link href="{{asset('plugins/slider/thumbnail-slider.css')}}" rel="stylesheet" />
    @yield('styles')
</head>
<style type="text/css">
    .image-upload > input {
        display: none;
    }
    #imagetocrop {
        max-width: 100%;
    }

</style>

<body>

<div class="container" id="page-container">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header col-md-3">
            <div class="navbar-header">
                <a href="{{url('home')}}" class="logo-text"><img src="{{asset('img/logo.jpg')}}" alt=""></a>
            </div>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav land-nav">
                <li class="{{(Request::is('create'))?'active':''}}">
                    <a href="{{url('create')}}">Create</a>
                </li>
                <li class="{{(Request::is('learn')||Request::is('learn/*'))?'active':''}}">
                    <a href="{{url('learn')}}">Learn</a>
                </li>
                </li>
                <li class="{{(Request::is('discover')||Request::is('discover/*'))?'active':''}}"><a href="{{url('discover')}}">Discover</a></li>
                <li class="{{(Request::is('gallery')||Request::is('gallery/*'))?'active':''}}"><a href="{{url('gallery')}}">Gallery</a></li>


            </ul>
            <ul class="nav navbar-nav land-nav navbar-right ">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    {{--<li><a href="{{ url('/register') }}">Register</a></li>--}}
                @else
                    <li>
                        <a href=""><img src="{{asset('img/search.png')}}" width="20" alt=""></a>
                    </li>
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

            

        </span>
        </div>
    </nav>
</div>
    @yield('content')


</body>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" ></script>
<script src="{{asset('plugins/slider/thumbnail-slider.js')}}" type="text/javascript"></script>
@yield('javascript')
</html>