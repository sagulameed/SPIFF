@extends('landing.template.template')
@section('content')

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
            <h2 class="text-uppercase">#{{$tagsStr}}</h2>
            @if(count($uniqueVideos)>0)
                @foreach($uniqueVideos as $video)
                    <div class="col-sm-3">
                        <a href="{{url("learn/videos/".$video['id'])}}">
                            <img src="{{$video['thumbnail']}}" alt="Image" class="img-responsive" style="object-fit: cover; width: 100%; height: 200px;">
                        </a>
                        <h4 style="margin-top: 15px">{{$video['title']}}</h4>
                    </div>
                @endforeach
                @else
                    <h1>Sorry we dont found videos with these tags</h1>
            @endif

        </div>
    </div>

@endsection