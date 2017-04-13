@extends('landing.template.template')
@section('content')
    <style>
        p {
            line-height: 7px;
            margin-top: 10px;
        }
        .products{
            margin-top: 50px;
        }

    </style>

    <div class="container">
        <div class="col-md-12 products">
            @foreach($products as $product)
                <div class="col-sm-4 col-md-3 col-xs-12">
                    <div class="thumbnail">
                        <a href="{{url("discover/$product->id")}}" data-toggle="modal" >
                            <img class="img-responsive" src="{{$product->product_image}}" alt="..." style="object-fit: cover; width: 100%; height: 200px;">
                        </a>
                        <div class="caption " style="background-color: grey; color: white">
                            @if(count($product->features))
                                <p style="word-wrap: break-word;">
                                    {{substr($product->features[0]->description,0,20)}}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
@endsection
