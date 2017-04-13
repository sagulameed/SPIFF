<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body text-centered">
        <img id="logospiff" class="center-block img-responsive" src="{{asset('img/spiffDoneLogo.png')}}" alt=""> <br>
        <img id="tick" class="center-block"  src="{{asset('img/tickDone.png')}}" alt="">
        <h4 class="white-color text-center">THANKS FOR YOUR PURCHASE !</h3>
          <p class="white-color text-center">
            You already ordered <strong>{{$design->order->numPieces}}</strong> pieces <br> and  <br>
            you paid <strong>$ {{$design->order->total}} USD</strong>
          </p>
        <div class="text-center">
          <a href="{{url('create')}}" class="btn btn-primary outline-btn">CREATE NEW PROJECT</a>
          <a href="{{url('/')}}" class="btn btn-primary outline-btn">RETURN TO MAIN MENU</a>
        </div>
      </div>

    </div>
  </div>
</div>
