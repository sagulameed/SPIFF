@extends('landing.template.template')
@section('styles')
    <style>
        body{
            background: #ffffff !important;
        }
        .purple-color{
            color: #9E005C;
        }
        hr{
            border-top: 4px solid #9E005C;
            margin-top: 5px;
        }
        hr.hr-trans{
            border-top: none;
        }
        label{
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="container">
            <h2 class="purple-color">
                <a href="{{ url()->previous() }}">
                    <img class="arrowleft" src="{{asset('img/leftArrow.png')}}" alt="" width="3%">
                </a>
                COMPLETE REGISTER
            </h2>
            <hr>
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
                            <strong>{{ Session::get('mess')}}</strong>
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
    <div class="row ">
        <div class="container">
            <form id="form-new-credit-card" action="{{url('me/creditcard')}}" method="POST">
                <div class="col-lg-4 col-md-4">
                    {{ csrf_field() }}
                    <input type="hidden" id="idC" name="idC" value="">

                    <div class="btn-group btn-block">
                        <button type="button" class="btn-cards-select btn btn-default btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Credit Cards <span class="caret"></span>
                        </button>
                        <ul id="cardsList" class="dropdown-menu btn-block">
                            @foreach($cards as $card)
                                <li class="cards-select text-center" data-jsoninfo="{{json_encode($card)}}" data-cardtok="{{$card->id}}">
                                    <a href="#" >{{$card->name}}</a>
                                </li>
                            @endforeach
                            <li role="separator" class="divider"></li>
                            <li id="newCard" class="cards-select text-center" data-jsoninfo='{"id":"","object":"","address_city":"","address_country":"","address_line1":"","address_line2":"","address_state":"","address_zip":"","brand":"","country":"","exp_month":"","exp_year":"","last4":"","name":""}'>
                                <a href="#">New Credit Card</a>
                            </li>
                        </ul>
                    </div>
                    <hr class="hr-trans">
                    <div class="form-group {{ $errors->has('card-number') ? ' has-error' : '' }}">
                        <label for="card-number">Number Card</label>
                        <input type="text" class="form-control" name="card-number" id="card-number" placeholder="number card" value="" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('card-number') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('card-expiry-month') ? ' has-error' : '' }}">
                        <label for="card-expiry-month">Expiration Mont</label>
                        <input type="number" class="form-control" name="card-expiry-month" id="exp_month" min="1" max="12" placeholder="month" value="" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('card-expiry-month') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('card-expiry-year') ? ' has-error' : '' }}">
                        <label for="card-expiry-year">Expiration Year</label>
                        <input type="number" class="form-control" name="card-expiry-year" id="exp_year" placeholder="year" value="" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('card-expiry-year') }}</strong>
                            </span>
                        @endif
                    </div>


                    <div class="form-group {{ $errors->has('card-cvc') ? ' has-error' : '' }}">
                        <label for="card-cvc">Security Code (CVC) </label>
                        <input type="text" class="form-control" name="card-cvc" id="card-cvc" placeholder="code" value="" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('card-cvc') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h4 class="text-center text-capitalize">Billing address</h4>
                    <hr class="hr-trans">
                    <div class="form-group {{ $errors->has('customerName') ? ' has-error' : '' }}">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" name="customerName" id="customer-name" placeholder="Name" value="" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('customerName') }}</strong>
                            </span>
                        @endif
                    </div>


                    <div class="form-group {{ $errors->has('address_line1') ? ' has-error' : '' }}">
                        <label for="address_line1">Exterior Address</label>
                        <input type="text" class="form-control" name="address_line1" id="address_line1" placeholder="Exterior Address" value="" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('customerName') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="address_line2">Interior Address</label>
                        <input type="text" class="form-control" name="address_line2" id="address_line2" placeholder="Interior Address" value="">
                    </div>

                    <div class="form-group {{ $errors->has('address_city') ? ' has-error' : '' }}">
                        <label for="address_city">City</label>
                        <input type="text" class="form-control" name="address_city" id="address_city" placeholder="City" value="" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address_city') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('address_country') ? ' has-error' : '' }}">
                        <label for="address_country">Country</label>
                        <input type="text" class="form-control" name="address_country" id="address_countryC" placeholder="Country" value="" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address_country') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('address_state') ? ' has-error' : '' }}">
                        <label for="address_state">State</label>
                        <input type="text" class="form-control" name="address_state" id="address_state" placeholder="State" value="" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address_state') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('address_zip') ? ' has-error' : '' }}">
                        <label for="address_zip">Zip (postal code)</label>
                        <input type="text" class="form-control" name="address_zip" id="address_zip" placeholder="Zip" value="" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address_zip') }}</strong>
                            </span>
                        @endif
                    </div>


                    <div class="form-group">
                        <button type="submit" id="card-btn-submit" class="btn btn-primary center-block">Add Credit Card</button>
                    </div>
                </div>
            </form>

            <div class="col-lg-4 col-md-4">
                {{--<h4 class="text-center text-capitalize">Shipping address</h4>--}}
                <div class="btn-group btn-block">
                    <button type="button" class="btn-shipping-select btn btn-default btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        My Shipping Addresses <span class="caret"></span>
                    </button>
                    <ul id="shippingAddresses" class="dropdown-menu btn-block">
                        @foreach($shippings as $shipp)
                            <li class="shipping-select text-center" data-jsoninfo="{{json_encode($shipp)}}">
                                <a href="#" >{{$shipp->name}}</a>
                            </li>
                        @endforeach
                            <li role="separator" class="divider"></li>
                            <li id="newshipping" class="shipping-select text-center" data-jsoninfo='{"id":"","name":"","businessName":"","phone":"","line1":"","line2":"","city":"","country":"","state":"","postal_code":""}'>
                                <a href="#">New Shipping</a>
                            </li>
                    </ul>
                </div>
                <hr class="hr-trans">


                <form id="form-shipping" action="{{url('me/shippingaddress')}}" method="POST" >
                    {{ csrf_field() }}
                    <input type="hidden" id="id" name="id" value="">
                    <div class="form-group {{ $errors->has('address_zip') ? ' has-error' : '' }}">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address_zip') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('businessName') ? ' has-error' : '' }}">
                        <label for="businessName">Business Name</label>
                        <input type="text" class="form-control" id="businessName" name="businessName" required placeholder="Business Name" >
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('address_zip') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('line1') ? ' has-error' : '' }}">
                        <label for="address_line1">Exterior Address</label>
                        <input type="text" class="form-control" name="line1" id="line1" placeholder="Exterior Address" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('line1') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group ">
                        <label for="address_line2">Interior Address</label>
                        <input type="text" class="form-control" name="line2" id="line2" placeholder="Interior Address" >
                    </div>

                    <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
                        <label for="address_city">City</label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="City" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('city') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
                        <label for="address_country">Country</label>
                        <input type="text" class="form-control" name="country" id="country" placeholder="Country" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('country') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                        <label for="address_state">State</label>
                        <input type="text" class="form-control" name="state" id="state" placeholder="State" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('state') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('postal_code') ? ' has-error' : '' }}">
                        <label for="address_zip">Zip (postal code)</label>
                        <input type="text" class="form-control" name="postal_code" id="postal_code" placeholder="Zip" required>
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('postal_code') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" id="shipping-btn-submit" class="btn btn-primary center-block">Add Shipping Address</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('javascript')
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="{{asset('js/formsCrdandShp.js')}}"></script>
@endsection
