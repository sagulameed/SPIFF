@if( ! empty($adminlayouts))
  @foreach ($adminlayouts as $adminlayout)
      <li>  
        <a href="javascript:loadLayout({{$adminlayout->id}});">
          <img src="{{$adminlayout->canvas_thumbnail}}?v=<?=rand();?>" class="img-responsive center-block" alt="">
          {{$adminlayout->name}}
        </a>
      </li>  
  @endforeach 
@elseif( ! empty($layouts))
  @foreach ($layouts as $layout)
      <li>
        <a href="javascript:loadLayout({{$layout->id}});">
          <img src="{{$layout->canvas_thumbnail}}?v=<?=rand();?>" class="img-responsive center-block" alt="">
          {{$layout->name}}
        </a>
      </li>  
  @endforeach 
@elseif( ! empty($panels))
  @foreach ($panels as $panel)
      <li>
        <a href="javascript:showPanel({{$panel->id}}, '{{$panel->image}}', {{$panel->isTarget}}, '{{$panel->name}}');">
          <img id="panel{{$panel->id}}" src="{{$panel->image}}?v=<?=rand();?>" class="img-responsive center-block panelimg" alt="">
          {{$panel->name}}
        </a>
      </li>  
  @endforeach 
@endif

