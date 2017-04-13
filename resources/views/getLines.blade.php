@foreach ($lines as $line)
                                
<li>
  <a href="#">
    <img class="catImage" data-id='{{$line->id}}' data-type='line' data-single="{{$line->single}}" data-multiple="{{$line->multiple}}" data-right="{{$line->right}}" data-id='{{$line->id}}' data-type='line' src="{{$line->line_name}}" width="80" alt="" style="z-index:1000;">
    <?php
      $price = "Free";
      if($line->single != 0) 
        $price = '$'. $line->single . ' USD';
      else if($line->multiple != 0) 
        $price = '$'. $line->multiple . ' USD';
      else if($line->right != 0)
        $price = '$'. $line->right . ' USD';

    ?>
    <a href="javascript: showElementDetails({{$line->id}}, 'Line', '{{$line->single}}', '{{$line->multiple}}', '{{$line->right}}', '{{$line->tags}}');">
      <span class="bg-black"><?php echo $price?><i class="fa fa-plus" style="float: right;margin-top:2px;"></i></span>
    </a>
  </a>
</li>

@endforeach 