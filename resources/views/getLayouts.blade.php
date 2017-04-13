<?php
    use App\Models\AdminLayout;
    use App\Models\Layout;
?>
@if( ! empty($userdesigns))
@foreach ($userdesigns as $design)
    <li>
    <?php
        $img = "";
        $layouts = Layout::where('design_id', '=', $design->id)->get();

        if(isset($layouts[0]) && $layouts[0] != "")
            $img = $layouts[0]->canvas_thumbnail;
    ?>

    <figure class="gallery">      
      <a href="{{ url('editlayouts') }}/products/{{$design->product_id}}/designs/{{$design->id}}">
      <img width="130px" src="{{$img}}?v=<?=rand();?>" alt="" style="width:140px;">
      </a>          
      <figcaption>Free <i class="fa fa-plus"></i></figcaption>
    </figure>
    <div class="dropdown">
    <a href="#" class="dropdown-toggle btn-dropdown" data-toggle="dropdown"><i class="fa fa-plus"></i></a>
      <ul class="dropdown-menu sep-product">
          <li>Price</li>
          <li>{{$design->id}}</li>
          <li>Keywords</li>
          </ul>
     </div>         
    </li>
@endforeach 
@endif

@if( ! empty($spiffdesigns))
@foreach ($spiffdesigns as $admindesign)
    <li>
    <?php
        $img = "";
        $layouts = AdminLayout::where('adminDesign_id', '=', $admindesign->id)->get();

        if(isset($layouts[0]) && $layouts[0] != "")
            $img = $layouts[0]->canvas_thumbnail;
    ?>

    <figure class="gallery">
      <a href="{{ url('editlayouts') }}/products/{{$admindesign->product_id}}/admindesigns/{{$admindesign->id}}">
      <img width="130px" src="{{$img}}?v=<?=rand();?>" alt="" style="width:140px;">    
      <figcaption>Free <i class="fa fa-plus"></i></figcaption>
      </a>          
    </figure>
    <div class="dropdown">
    <a href="#" class="dropdown-toggle btn-dropdown" data-toggle="dropdown"><i class="fa fa-plus"></i></a>
      <ul class="dropdown-menu sep-product">
          <li>Price</li>
          <li>{{$admindesign->id}}</li>
          <li>Keywords</li>
          </ul>
     </div>         
    </li>
@endforeach 
@endif