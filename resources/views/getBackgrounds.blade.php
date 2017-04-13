@foreach ($backgrounds as $background)
                                  
  <li>
    <a href="#">
      <figure>
      <img class="bgImage" data-id='{{$background->id}}' data-type='background' data-single="{{$background->single}}" data-multiple="{{$background->multiple}}" data-right="{{$background->right}}" src="{{$background->background_name}}" width="80" height="60" alt="" style="z-index:1000;">
      <?php
        $price = "Free";
        if($background->single != 0) 
          $price = '$'. $background->single . ' USD';
        else if($background->multiple != 0) 
          $price = '$'. $background->multiple . ' USD';
        else if($background->right != 0)
          $price = '$'. $background->right . ' USD';

      ?>
      <figcaption>
      <a href="javascript: showBGElementDetails({{$background->id}}, 'Background', '{{$background->single}}', '{{$background->multiple}}', '{{$background->right}}', '{{$background->tags}}');">
        <span class="bg-black"><?php echo $price?><i class="fa fa-plus" style="float: right;margin-top:2px;"></i></span></figcaption>
      </a>
      </figure>
    </a>
  </li>

@endforeach 