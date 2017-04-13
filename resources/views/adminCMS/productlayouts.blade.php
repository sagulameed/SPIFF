@extends('adminCMS/app')
   
@section('content')
<div class="maincontentwrap">        
        <div class="leftmenu-tabpane leftmenu-tabpanelarge active" >             
             <div class="tab-bodycontent">

                <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                    <div class="contentHeader" style="width:90%;">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1>PRODUCTS</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row backgroundsec" style="margin-right: 0; margin-left: -172px;">
                        <div class="content-box">
                            <div class="customscrollmedium customscrollinset">
                                <div class="customscrollmedium-inner elementspics">
                            
                                <div class="row layout-container">
                                    
                                    @if( ! empty($products))
                                     @foreach ($products as $product)
                                    
                                        <div class="layout-box col-md-4">
                                            <span class="layout-title">{{$product->product_name}}</span>
                                            <img class="layout-img" src="{{$product->product_image}}" height="220">
                                            
                                            <a href="{{ url('adminCMS/editdesigns') }}/products/{{$product->id}}"><button class="layout-button" type="button">VIEW ALL</button></a>
                                        </div>
                                    
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>  
@endsection
