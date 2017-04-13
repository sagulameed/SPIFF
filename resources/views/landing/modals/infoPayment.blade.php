<div class="modal fade" id="paymentConf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">Select Your Card and Shipping</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group btn-block">
                            <button type="button" class="btn btn-default dropdown-toggle btn-block btn-card-select" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select Card <span class="caret"></span>
                            </button>
                            <ul id="cardList" class="dropdown-menu btn-block">
                                @foreach($cards as $card)
                                    <li class="text-center card-select" data-cardid="{{$card->id}}"><a href="#">{{$card->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group btn-block">
                            <button type="button" class="btn btn-default dropdown-toggle btn-block btn-shipping-select" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Select Shipping <span class="caret"></span>
                            </button>
                            <ul id="shippingList" class="dropdown-menu btn-block">
                                @foreach($shippings as $shipp)
                                    <li class="text-center shipping-select" data-shippingid="{{$shipp->id}}"><a href="#">{{$shipp->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary paymentButton"  id="payAndOrder">Pay & Order</button>
            </div>
        </div>
    </div>
</div>