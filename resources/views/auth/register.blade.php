@extends('landing.template.template')

@section('content')
    <style>
        body{
            background: white;
        }
    </style>
    <div class="container" style="margin-top: 10%">

        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}
            <img class="center-block" src="{{asset('img/logo-modal.png')}}" alt="" width="10%">
            <br><br>
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {{--<label for="name" class="col-md-4 control-label">Username</label>--}}

                <div class="col-md-4 col-md-offset-4">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Username">

                    @if ($errors->has('name'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                {{--<label for="firstName" class="col-md-4 control-label">First Name</label>--}}

                <div class="col-md-4 col-md-offset-4">
                    <input id="firstName" type="text" class="form-control" name="firstName" value="{{ old('firstName') }}" required autofocus placeholder="First Name">

                    @if ($errors->has('firstName'))
                        <span class="help-block">
                            <strong>{{ $errors->first('firstName') }}</strong>
                        </span>
                    @endif
                </div>
            </div>


            <div class="form-group{{ $errors->has('secondName') ? ' has-error' : '' }}">
                {{--<label for="secondName" class="col-md-4 control-label">Second Name</label>--}}

                <div class="col-md-4 col-md-offset-4">
                    <input id="secondName" type="text" class="form-control" name="secondName" value="{{ old('secondName') }}" required autofocus placeholder="Second Name">

                    @if ($errors->has('secondName'))
                        <span class="help-block">
                            <strong>{{ $errors->first('secondName') }}</strong>
                        </span>
                    @endif
                </div>
            </div>



            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {{--<label for="email" class="col-md-4 control-label">E-Mail Address</label>--}}

                <div class="col-md-4 col-md-offset-4">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="E-mail">

                    @if ($errors->has('email'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                {{--<label for="password" class="col-md-4 control-label">Password</label>--}}

                <div class="col-md-4 col-md-offset-4">
                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password">

                    @if ($errors->has('password'))
                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                {{--<label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>--}}

                <div class="col-md-4 col-md-offset-4">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-4 col-md-offset-4">
                    <button type="submit" class="btn btn-primary  center-block" style="border-radius: 10px">
                        Register
                    </button>
                </div>
            </div>
        </form>
    </div>


@endsection









