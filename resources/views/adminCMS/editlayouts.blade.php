
@extends('adminCMS/app')
   
@section('content')
<div class="maincontentwrap">        
        <div class="leftmenu-tabpane leftmenu-tabpanelarge active">
             <div class="tab-bodycontent">
                <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                    <div class="contentHeader" style="width:90%;">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="back_button"><a href="{{ url('adminCMS/productlayouts') }}"><img src="{{ asset('adminCMS/img/backto.png') }}" width="40" height="40" style="margin-top:-20px;margin-left:-10px;"/></a></div>
                                <h1>Your Layout | PULL &amp; POP</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row backgroundsec" style="margin-right: 0;margin-left: -170px;">
                        <div class="content-box">
                            <div class="customscrollmedium customscrollinset">
                                <div class="customscrollmedium-inner elementspics">
                            
                                <div class="row layout-container">
                                    
                                    @if( ! empty($layouts))
                                     @foreach ($layouts as $layout)

                                        <div class="layout-box col-md-4">
                                            <span class="layout-title">{{$layout->layout_name}}</span>
                                            <img class="layout-img" src="{{$layout->canvas_thumbnail}}" height="220" width="220">
                                            <a href="javascript:deleteresource({{ $layout->id }}, '{{ url('adminCMS/editlayouts') }}');"  class="imagebox-close"><span class="icon-close"></span></a>
                                            <a href="{{ url('adminCMS/admineditor') }}?product_id={{$product_id}}&layout_id={{$layout->id}}"><button class="layout-button" type="button">EDIT</button></a>
                                        </div>
                                    
                                    @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>        
                    </div>

                    <div class="col-md-12 marg-top50">
                        <div class="spiff-header-border no-margin-box" style="width:82%; margin-left: 152px;">
                        </div>
                    </div>
                    
                    <div>
                        <a href="{{ url('adminCMS/admineditor') }}?product_id={{$product_id}}"><button type="button" class="create_layout_button spiff-button">CREATE NEW LAYOUT</button></a>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>  
@endsection   

