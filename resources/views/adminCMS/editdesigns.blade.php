
@extends('adminCMS/app')

<?php
    use App\Models\AdminLayout;
?>
   
@section('content')
<div class="maincontentwrap">        
        <div class="leftmenu-tabpane leftmenu-tabpanelarge active">
             <div class="tab-bodycontent">
                <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                    <div class="contentHeader" style="width:90%;">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="back_button"><a href="{{ url('adminCMS/productlayouts') }}"><img src="{{ asset('adminCMS/img/backto.png') }}" width="40" height="40" style="margin-top:-20px;margin-left:-10px;"/></a></div>
                                <h1>PRODUCT DESIGNS / {{$product->product_name}}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row backgroundsec" style="margin-right: 0;margin-left: -170px;">
                        <div class="content-box">
                            <div class="customscrollmedium customscrollinset">
                                <div class="customscrollmedium-inner elementspics">
                            
                                <div class="row layout-container">
                                    
                                    @if( ! empty($admindesigns))
                                     @foreach ($admindesigns as $admindesign)

                                        <div class="layout-box col-md-4">
                                            <span class="layout-title">{{$admindesign->name}}</span>
                                            <?php
                                                $img = "";
                                                $admin_layouts = AdminLayout::where('adminDesign_id', '=', $admindesign->id)->get();

                                                if(isset($admin_layouts[0]) && $admin_layouts[0] != "")
                                                    $img = $admin_layouts[0]->canvas_thumbnail;
                                            ?>
                                            <img class="layout-img" src="{{$img}}" width="220">
                                            <a href="javascript:deleteresource({{ $admindesign->id }}, '{{ url('adminCMS/editdesigns') }}', '{{ url('adminCMS/editdesigns') }}/products/{{$product->id}}');"  class="imagebox-close"><span class="icon-close"></span></a>
                                            <a href="{{ url('adminCMS/admineditor') }}/products/{{$product->id}}/admindesigns/{{$admindesign->id}}"><button class="layout-button" type="button">EDIT</button></a>
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
                        <a href="{{ url('adminCMS/admineditor') }}/products/{{$product->id}}"><button type="button" class="create_layout_button spiff-button">CREATE NEW DESIGN</button></a>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>  
@endsection   

