@foreach ($frames as $frame)
                                
<li>
  <a href="#">
    <img class="gridImage" data-id='{{$frame->id}}' data-type='frame' data-single="{{$frame->single}}" data-multiple="{{$frame->multiple}}" data-right="{{$frame->right}}" src="{{$frame->frame_name}}" width="80" alt="" style="z-index:1000;">
    <?php
      $price = "Free";
      if($frame->single != 0) 
        $price = '$'. $frame->single . ' USD';
      else if($frame->multiple != 0) 
        $price = '$'. $frame->multiple . ' USD';
      else if($frame->right != 0)
        $price = '$'. $frame->right . ' USD';

    ?>
    <a href="javascript: showElementDetails({{$frame->id}}, 'Frame', '{{$frame->single}}', '{{$frame->multiple}}', '{{$frame->right}}', '{{$frame->tags}}');">
      <span class="bg-black"><?php echo $price?><i class="fa fa-plus" style="float: right;margin-top:2px;"></i></span>
    </a>
  </a>
</li>

@endforeach