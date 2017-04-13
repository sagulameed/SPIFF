@foreach ($grids as $grid)
                    
  <li>
  <a href="#">
  <img class="gridImage" data-id='{{$grid->id}}' data-type='grid' data-single="{{$grid->single}}" data-multiple="{{$grid->multiple}}" data-right="{{$grid->right}}" src="{{$grid->grid_name}}" width="80" alt="" style="z-index:1000;">
    <?php
      $price = "Free";
      if($grid->single != 0) 
        $price = '$'. $grid->single . ' USD';
      else if($grid->multiple != 0) 
        $price = '$'. $grid->multiple . ' USD';
      else if($grid->right != 0)
        $price = '$'. $grid->right . ' USD';

    ?>
    <a href="javascript: showElementDetails({{$grid->id}}, 'Grid', '{{$grid->single}}', '{{$grid->multiple}}', '{{$grid->right}}', '{{$grid->tags}}');">
      <span class="bg-black"><?php echo $price?><i class="fa fa-plus" style="float: right;margin-top:2px;"></i></span>
    </a>
  </a>    
  </li>

@endforeach