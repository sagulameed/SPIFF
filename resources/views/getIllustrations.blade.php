@foreach ($illustrations as $illustration)
                                
<li>
  <a href="#">
    <img class="catSVGImage" data-id='{{$illustration->id}}' data-type='illustration' data-single="{{$illustration->single}}" data-multiple="{{$illustration->multiple}}" data-right="{{$illustration->right}}" data-id='{{$illustration->id}}' data-type='illustration' src="{{$illustration->image}}" alt="" width="80" style="z-index:1000;">
    <?php
      $price = "Free";
      if($illustration->single != 0) 
        $price = '$'. $illustration->single . ' USD';
      else if($illustration->illustration != 0) 
        $price = '$'. $illustration->multiple . ' USD';
      else if($illustration->right != 0)
        $price = '$'. $illustration->right . ' USD';

    ?>
   <a href="javascript: showElementDetails({{$illustration->id}}, 'Illustration', '{{$illustration->single}}', '{{$illustration->multiple}}', '{{$illustration->right}}', '{{$illustration->tags}}');">
    <span class="bg-black"><?php echo $price?><i class="fa fa-plus" style="float: right;margin-top:2px;"></i></span>
   </a>
  </a>
</li>

@endforeach 