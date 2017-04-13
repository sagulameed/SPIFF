@foreach ($pictures as $picture)                                
<li>
  <a href="#">
    <img class="catImage" data-id='{{$picture->id}}' data-type='picture' data-single="{{$picture->single}}" data-multiple="{{$picture->multiple}}" data-right="{{$picture->right}}" src="{{$picture->picture_name}}" width="80" alt="" style="z-index:1000;">
    <?php
      $price = "Free";
      if($picture->single != 0) 
        $price = '$'. $picture->single . ' USD';
      else if($picture->multiple != 0) 
        $price = '$'. $picture->multiple . ' USD';
      else if($picture->right != 0)
        $price = '$'. $picture->right . ' USD';

    ?>
  </a>
  <a href="javascript: showElementDetails({{$picture->id}}, 'Picture', '{{$picture->single}}', '{{$picture->multiple}}', '{{$picture->right}}', '{{$picture->tags}}');">
    <span class="bg-black"><?php echo $price?><i class="fa fa-plus" style="float: right;margin-top:2px;"></i></span>
  </a>
  <!--<div class="">
    <a href="#" class="dropdown-toggle btn-dropdown" data-toggle="dropdown"></a>
    <ul class="dropdown-menu sep-product sep2">
      <li style="float:left;">Description</li>
      <li style="float:left;"><a href="#">Remove Watermark</a></li>
    </ul>
  </div>-->                              
</li>
@endforeach