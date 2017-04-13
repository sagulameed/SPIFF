@extends('adminCMS/app')
   
@section('content')

<div class="maincontentwrap">
        
        <div class="leftmenu-tabpane leftmenu-tabpanelarge active" >
             
             <div class="tab-bodycontent">

                    <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                       

             <div class="contentHeader">

                    <div class="row">

                        <div class="col-sm-8">

                            <h1>Your Products</h1>

                        </div>
                    
                        <div class="col-sm-4">

                            <div class="contentHeaderSearch">

                                <input type="text" id="search_productinput" name="search_productinput" class="form-control" placeholder="Search images, elements, backgrounds...">

                                <a href="javascript:searchresource('products');" class="contentHeaderSearchicon"><span class="icon-search"></span></a>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="contentBody contentBodycustomscroll">

                    <div class="contentBodycustomscroll-inner">

                        <div class="row">
                            
                            @if( ! empty($products))
                             @foreach ($products as $product)
                        
                            <div class="col-sm-4">

                                <div class="imagebox-wrap">

                                    <div class="imagebox-title">{{$product->product_name}}</div>

                                    <div class="imagebox-inner">

                                        <img src="{{$product->product_image}}" style="object-fit: cover; width: 100%; height: 200px;"/>
                                        
                                        <a href="javascript:deleteresource({{ $product->id }}, '{{ url('adminCMS') }}/products');" class="imagebox-close"><span class="icon-close"></span></a>

                                         <a class="imagebox-footer" href="{{ url('adminCMS/editproducts') }}/{{$product->id}}">Edit</a>
                                        
                                    </div>

                                </div>

                            </div>
                            
                            @endforeach
                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

@endsection