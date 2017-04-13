<!DOCTYPE html>

<html class=''>

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Spiff Login</title>

    <meta name="description" content="">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" type="text/css" href="css/custom.css">

    <link href="../adminCMS/css/fonts/isabella-script/stylesheet.css" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

</head>


<body class="loginbg">
<div>

    <nav class="navbar navbar-inverse">
        <div class="container" id="page-container">
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-header col-md-3">
                    <div class="navbar-header">
                        <a href="" class="logo-text" ><img src="{{asset('img/logo.jpg')}}" alt=""></a>
                    </div>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav land-nav">
                        <li class="active"><a href="{{ url('create') }}">Create</a></li>
                        <li><a href="{{url('learn')}}">Learn</a></li>
                        <li><a href="{{url('discover')}}">Discover</a></li>
                        <li><a href="{{url('gallery')}}">Gallery</a></li>
                    </ul>
                    <ul class="nav navbar-nav land-nav navbar-right ">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
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
                                        <a href="{{ url('/logout') }}"
                                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
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
            </nav>
        </div>

    </nav>


</div>





<!--<div>

    <nav class="navbar navbar-inverse">

    </nav>

</div>-->



<div class="loginwrap">

    <div class="logincontainer">

        <div class="loginlogo"><img src="{{asset('adminCMS/img/loginlogo2.png')}}" alt="Admin Login - SPIFF" height="124" /></div>


        <div class="loginform">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group login-username">

                    <img src="{{asset('adminCMS/img/username.png')}}" alt="" class="login-ico" height="27"/>

                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder=" Name or email address...">

                </div>

                <div class="form-group login-password">

                    <img src="{{asset('adminCMS/img/password.png')}}" alt="" class="login-ico" height="27"/>

                    <input type="password" name="password" class="form-control" placeholder="Password" />

                </div>

                <div class="loginfooter has-text-centered">

                    <input type="submit" value="SIGN IN" class="loginbtn" />

                    <div class=""><a href="{{ url('/password/reset') }}">Forgot your password?</a></div>
                    <div class=""><a href="{{ url('/register') }}">Register</a></div>

                </div>

            </form>


        </div>

    </div>

</div>



</body>

<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" ></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('#myCarousel').carousel({

            interval: 10000

        })

    });

</script>

</html>
