@extends('adminCMS.app')

@section('content')
    <style>
        input[type="text"],input[type="password"]{
            border-top: 0;
            border-right: 0;
            border-left: 0;

            -webkit-box-shadow: none;
            box-shadow: none;
        }
        input[type="text"]:focus,input[type="password"]:focus {
            -webkit-box-shadow: none;
            box-shadow: none;
        }
    </style>
    <div class="container-fluid">
        <div class="maincontentwrap">
            <div class="tab-bodycontent">
                <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                    <div class="contentHeader">
                        <div class="row">
                            <div class="col-sm-6">
                                <h1>CREATE NEW ADMIN USER </h1>
                            </div>
                            <div class="col-sm-6">

                                @if(Session::has('status'))
                                    @if(Session::get('status'))
                                        <div class="alert alert-success pull-right" role="alert" style="padding: 0px;" >
                                            <strong>{{ Session::get('mess')}}</strong> <img src="{{asset('img/check.png')}}" width="30px" alt="">
                                        </div>
                                    @else
                                        <div class="alert alert-danger text-center pull-right" role="alert" >
                                            {{ Session::get('mess')}}
                                        </div>
                                    @endif
                                @endif

                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12" style="margin-top: 3%">
                            <!--Errors sections -->
                            @if (count($errors) > 0)
                                <div class="alert alert-danger text-center">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>

                    <form class="form-horizontal" action="{{route('users.store')}}" method="POST" >
                        <div class="col-lg-9 col-md-9 col-lg-offset-1">
                            {!! csrf_field() !!}

                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">
                                    <i class="fa fa-user fa-2x" aria-hidden="true"></i>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text"  name="username" class="form-control" placeholder="User name" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">
                                    <i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
                                </label>
                                <div class="col-sm-10">
                                    <input type="text" name="email" class="form-control" placeholder="Email" required/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">
                                    <i class="fa fa-lock fa-2x" aria-hidden="true"></i>
                                </label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="confirm_password" class="col-sm-2 control-label">
                                    <i class="fa fa-lock fa-2x" aria-hidden="true"></i>
                                </label>
                                <div class="col-sm-10">
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required/>
                                </div>
                            </div>

                            <button type="submit" class="btn-outline btn-primary text-center pull-right" style="">CREATE</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascript')

@endsection