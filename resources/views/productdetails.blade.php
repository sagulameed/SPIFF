<!DOCTYPE html>
<html class=''>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spiff Product Details</title>
    <meta name="description" content="">    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{asset('css/style.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('css/custom.css')}}" type="text/css" rel="stylesheet">
</head>
<style type="text/css">
    .image-upload > input {
        display: none;
    }
   #imagetocrop {
     max-width: 100%;
  }
    .white-names{
        color: white; padding-top: 5%
    }
    .pink-names{
        color: #871e72;
    }

</style>

<body>
<div class="container" id="page-container">
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-header col-md-3">
         <div class="navbar-header">
            <a href="" class="logo-text"><img src="{{asset('img/logo.jpg')}}" alt=""></a>
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
    </nav>
</div>
<div class="container-fluid bg-clr">
  <div class="container">
    <div class="row product-example">
      <div class="col-md-12">
        <h2 class="text-center" style="color: white;">{{$product->product_name}}</h2>
          <hr>
        <ul class="list-inline text-center">
          <li>
            <figure>
              <a href="#">
                <img src="{{asset($product->thumbnails()->where('isOpen',1)->first()->image)}}" alt="" class="img-responsive"  style="object-fit: cover; width: 300px; height: 200px;">
                <figcaption class="white-names">CLOSE</figcaption>
              </a>
            </figure>
          </li>
          <li>
            <figure>
              <a href="#">
                <img src="{{asset($product->thumbnails()->where('isOpen',0)->first()->image)}}" alt="" class="img-responsive" style="object-fit: cover; width: 300px; height: 200px;">
                <figcaption class="white-names">OPEN</figcaption>
              </a>
            </figure>
          </li>
            @if(!empty($product->video))
              <li>
                <figure>
                  <video width="300" height="200" controls preload="none" poster="{{asset('img/videocover.jpg')}}">

                    <source src="{{asset($product->video)}}" type="video/mp4">

                    Your browser does not support the video tag.

                  </video>
                  <figcaption class="white-names">WATCH</figcaption>
                </figure>
              </li>
            @endif
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="container">
    <div class="row product-list">
      <div class="col-md-12">
        <h2><span>{{$product->product_name}}</span></h2>
        <ul class="list-inline" style="text-align: center;">

          @if( ! empty($panels))                       
          @foreach ($panels as $panel)
            <li>
              <figure>
                <a href="{{ url('/editlayouts') }}/products/{{$product->id}}/panels/{{$panel->id}}">
                  <img src="{{$panel->image}}" alt="" class="img-responsive center-block" style="object-fit: fill; width: 100%; height: auto;">
                  <figcaption class="pink-names">{{$panel->name}}</figcaption>
                </a>
              </figure>
            </li>
          @endforeach
          @endif

        </ul>
      </div>
    </div>
</div>
</body>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" ></script>
</html>