@extends('landing.template.template')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/orderAndBuy.css')}}">
    <style media="screen">
      #myModal{
        top: 10%;
      }
      #myModal>.modal-dialog>.modal-content{
        background-color: transparent;
        border:none;
        box-shadow:none;
        -webkit-box-shadow:none;
      }
      .modal-backdrop
      {
        opacity: 0.8 !important;
      }
      .white-color{
        color: white
      }
      .outline-btn{
        background: transparent !important;
        border: solid 2px #801C6B !important;
      }
      #logospiff{
        width: 40%
      }
      #tick{
        width: 25%
      }
    </style>
@endsection

@section('content')
  <input type="hidden" id="checkOrderId" value="{{isset($design->order)?$design->order:''}}">
    <form action="{{route('orders.store')}}" method="POST" id="payAndOrderForm">
        {{ csrf_field() }}
        <input type="hidden" name="designId" value="{{$design->id}}">
        <input type="hidden" name="card" id="cardId" value="">
        <input type="hidden" name="shipping" id="shippingId" value="">
        <input type="hidden" name="ordered_at" id="ordered_at" value="">
        <div class="row">
            <div class="content" style="margin-top: 2%; margin-left: 2%">
                <div class="col-lg-3 sidebar ">
                    <h4 class="purple text-center">ORDER AND BUY</h4>
                    <input type="hidden" id="priceJson" value="{{$product->pricingJson}}">
                    <hr>
                    <table id="orderPricesRank" class="table text-center">
                        <thead>
                            <tr>
                                <td>Pieces</td>
                                <td>Price per Unit</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(json_decode($product->pricingJson) as $price)
                            <tr>
                                <td>
                                    {{$price->from}} - {{$price->to}}
                                </td>
                                <td>
                                    $ {{$price->price}} usd
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <table class="table text-center">
                        <thead>
                            <tr>
                                <td>Finish <br> weight / unit </td>
                                <td>Delivery <br> charge per unit</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <input type="hidden" name="weightUnit" id="weightUnit" value="{{$product->weight}}">
                                <td>
                                    {{$product->weight}}
                                </td>
                                <input type="hidden" name="pricePerWeigh" id="pricePerWeigh" value="{{$product->pricePerWeight}}">
                                <td>
                                    $ {{$product->pricePerWeight}} usd
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <hr>
                    @if(!isset($design->order))
                      <table class="table text-center">
                          <thead>
                              <tr>
                                  <td>Number of <br> pieces you wish <br> to order</td>
                                  <td>Price</td>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                  <td>
                                      <input class="center-value " id="numPieces" name="numPieces" type="number" min="1" placeholder="Type a number" value="1">
                                  </td>
                                  <td class="pricePieces">

                                  </td>
                              </tr>
                          </tbody>
                      </table>
                    @endif
                    <hr>
                    <div id="previewElementPrices" style="display: none">
                        <h4 class="text-center">Picture <span id="elementIdPrev"></span></h4>

                        <div class="singleDiv">
                            <h4 class="purple">Single use <span class="pull-right" id="singlePricePrev"></span></h4>
                            <small>Remove the watermark for 24 hours to a single design.</small>
                            <br>
                            <button type="button" id="btnSingleLicense" class="button btn btn-default paymentButton licenseBtn" data-licenseele="single" data-price="" data-elementtype="" data-elementid=""> BUY</button>
                        </div>

                        <div class="multipleDiv">
                            <h4 class="purple">Multiple use <span class="pull-right" id="multiplePricePrev"></span></h4>
                            <small>Remove the watermark, you can use in all your designs</small>
                            <br>
                            <button type="button" id="btnMultipleLicense" class="button btn btn-default paymentButton licenseBtn" data-licenseele="multiple" data-price="" data-elementtype="" data-elementid=""> BUY</button>
                        </div>

                        <div class="rightDiv">
                            <h4 class="purple">Right use <span class="pull-right" id="rightPricePrev"></span></h4>
                            <small>Multiple-use license plus extended rights for printing, reselling and multiple users</small>
                            <br>
                            <button type="button" id="btnRightLicense" class="button btn btn-default paymentButton licenseBtn" data-licenseele="right" data-price="" data-elementtype="" data-elementid=""> BUY</button>
                        </div>
                    </div>

                </div>
                <div class="col-lg-8 resources ">
                    <h4>PANEL PREVIEW</h4>
                    <hr>
                    <div class="row section">
                        <div class="layouts">
                            @foreach($design->layouts as $layout)
                                <div class="col-md-{{12/count($design->layouts)}} col-lg-{{12/count($design->layouts)}}">
                                    <img src="{{$layout->canvas_thumbnail}}" alt="" class="center-block img-responsive text-center" style="object-fit: contain; width: 180px; height: 180px">
                                    <span class="center-block text-capitalize purple text-center layout-title">{{$layout->name}}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row section">
                        <div class="col-lg-12 canvas-elements">
                            <div class="content-included-elements">
                                <h4 >INCLUDED ELEMENTS</h4>
                                <div class="slider">
                                    <div id="thumbnail-slider" style="">
                                        <div class="inner">
                                            <ul>
                                                @foreach($elements as $element)
                                                    <li class="elementsCanvas" data-singlep="{{$element['single']}}" data-multiplep="{{$element['multiple']}}" data-rightp="{{$element['right']}}"  data-isfree="{{$element['isFree']}}" data-ispurchased="{{$element['isPurchased']}}" data-elementtype="{{$element['elementType']}}" data-elementid="{{$element['elementId']}}">
                                                        <a href="#">
                                                            <figure>
                                                                <figcaption class="purple">{{substr($element['elementType'],0,4)}}_{{$element['elementId']}}</figcaption>
                                                                <img class="carrusel-image" src="{{$element['src']}}" alt="">
                                                                <figcaption class="black-text">
                                                                    @if($element['isFree'] == 1)
                                                                        FREE
                                                                    @elseif($element['isPurchased'])
                                                                        PURCHASED
                                                                    @else
                                                                        SELECT PLAN
                                                                    @endif
                                                                </figcaption>
                                                            </figure>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row section">
                        <div class="col-lg-3 col-lg-offset-2">
                            <h4 class="purple text-center">INCLUDED ELEMENTS</h4>
                            <hr>
                            <input type="hidden" id="elementsPurchased" name="elementsPurchased" value="{{$elements->toJson()}}">

                            <table class="table text-center">
                                <tbody id="listElements">
                                @foreach($elements as $element)
                                    @if($element['isFree'])
                                        <tr id="elementList{{$element['elementId'].$element['elementType']}}">
                                            <td>
                                                <span>{{$element['elementType']}}_{{$element['elementId']}}</span>
                                            </td>
                                            <td>
                                                FREE
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr id="rowTotalListElements">
                                    <td></td>
                                    <td class="purple" id="totalElementList"></td>
                                </tr>
                                </tbody>

                            </table>
                        </div>
                        <div class="col-lg-3 col-lg-offset-1">
                            <h4 class="purple text-center">TOTAL PRICE</h4>
                            <hr>
                            <table id="totals" class="table">
                                <tbody>
                                <tr>
                                    <td>
                                        ORDERED PIECES
                                    </td>
                                    <td>-</td>
                                    <td class="pricePieces" id="txtPricePieces" data-totalprice="">

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        DELIVERY CHARGE
                                    </td>
                                    <td>-</td>
                                    <td id="txtDeliveryCharge" data-totalprice="">

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        INCLUIDED ELEMENTS
                                    </td>
                                    <td>-</td>
                                    <td id="txtElementCharge" data-totalprice="0">
                                        $ 0 usd
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            <div class="text-center purple" id="totalBilling"></div>
                            @if(!isset($design->order))
                              <div class="text-center"> <button type="submit" class="btn btn-default btn-lg paymentButton" id="paymentButton" style="margin-top: 6%;" data-toggle="modal" data-target="#paymentConf">BUY NOW</button></div>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <!--Errors sections -->

                        <div class="col-sm-8" style="margin-top: 10px">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger text-center">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(Session::has('status'))
                                @if(Session::get('status'))
                                    <div class="alert alert-success text-center" role="alert"  >
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p>{{ Session::get('mess')}}</p>
                                    </div>
                                @else
                                    <div class="alert alert-danger text-center" role="alert" >
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{ Session::get('mess')}}
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if(isset($design->order))
      @include('landing.modals.modalOrderPaid')
    @endif
    @include('landing.modals.infoPayment')
@endsection

@section('javascript')
  <script>
    $( document ).ready(function() {
      if($('#checkOrderId').val()!=''){
        $('#myModal').modal({backdrop: 'static', keyboard: false});
        $('#myModal').modal('show')
      }

    });
  </script>
  @if(!isset($design->order))
    <script src="{{asset('js/orderCalc.js')}}"></script>

    <script>
        $( document ).ready(function() {

            var today = new Date();
            var isoDate = today.toISOString()
            console.log(isoDate);
            $('#ordered_at').val(isoDate);



            $('#paymentButton').click(function(e){
                e.preventDefault();
            })

            $("#cardList").on('click','li.card-select',function(event){
                $(".btn-card-select").html('Card :'+  $(this).text()+ '<span class="caret"></span>');
                $(".btn-card-select").val($(this).text());
                $('#cardId').val($(this).data('cardid'))

            });
            $("#shippingList").on('click','li.shipping-select',function(event){
                $(".btn-shipping-select").html('Shipping :'+  $(this).text()+ '<span class="caret"></span>');
                $(".btn-shipping-select").val($(this).text());
                $('#shippingId').val($(this).data('shippingid'))

            });
            $('#payAndOrder').click(function(){
                $('#payAndOrderForm').submit();
            })


            $('#paymentConf').on('show.bs.modal', function (event) {

                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('whatever') // Extract info from data-* attributes

            })
        });
    </script>
  @endif
@endsection
