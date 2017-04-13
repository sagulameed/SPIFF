@extends('landing.template.template')



@section('content')
  <div class="container-fluid bg-clr">
    <div class="container">
      <div class="row">
        <div class="col-md-12 create-tab">
          <h2><span>I want to create</span></h2>

          <div class="slider">
            <div id="thumbnail-slider" style="">
              <div class="inner">
                <ul>
                  @if(!empty($products))
                   @foreach ($products as $product)

                      <li class="">
                        <a href="{{ url('/productdetails') }}/products/{{$product->id}}">
                          <figure>
                              <img style="height: 200px;overflow: hidden;" src="{{$product->product_image}}" alt="">
                              <figcaption>{{$product->product_name}}</figcaption>
                          </figure>              
                        </a>
                      </li>
                  
                  @endforeach
                  @endif

                </ul>                                   
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
      <div class="row mycreations">
          @if(Auth::check())
              <div class="col-md-12">
                  <h2><span>My Creations</span></h2>
              </div>

              @foreach (Auth::user()->designs as $design)
                  <div class="col-md-3 col-xs-6">
                      {{$design->name}}

                      @if(count($design->layouts)>0)
                          <a href="{{ url('editlayouts') }}/products/{{$design->product_id}}/designs/{{$design->id}}">
                              @if(!empty($design->layouts()->where('isTarget',1)->first()->canvas_thumbnail))
                                  <img src="{{$design->layouts()->where('isTarget',1)->first()->canvas_thumbnail}}" class="img-responsive marg-btm20" alt="">
                              @else
                                  <img src="{{$design->layouts[0]->canvas_thumbnail}}" class="img-responsive marg-btm20" alt="">
                              @endif

                          </a>
                      @endif
                  </div>
              @endforeach

          {{--@else
              <h1>Trending section</h1>
              <h1>Discover section</h1>
              <h1>USer gallery</h1>--}}
          @endif

      </div>
  </div>
@endsection