@extends('adminCMS.app')

@section('content')
    <style>
        .panel-default>.panel-heading{
            background-color: white;
        }
        .panel-default{
            border-color: white;
        }
        .panel-group .panel-heading+.panel-collapse .panel-body{
            border-color: white;
        }
        label{
            color:#801C6B ;
        }
        .colforms{
            border: solid 1px;
            border-color: white;
            border-bottom-color: #801C6B;
            border-top-color: #801C6B;
            padding-top: 10px;
            padding-bottom: 15px;
        }
        a.collapsemark:focus, a.collapsemark:hover {
            text-decoration: none !important;
            outline: none !important;
            color: #000000 !important;

        }
        a.collapsemark{
            outline: none !important;
            color: #000000 !important;
        }

    </style>
    <div class="container-fluid">
        <div class="maincontentwrap">
            <div class="tab-bodycontent">
                <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                    <div class="contentHeader">
                        <div class="row">
                            <div class="col-sm-6">
                                <h1>Users </h1>

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
                        <div class="col-sm-12">
                            @foreach($users as $user)

                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="heading{{$user->id}}">
                                            <h4 class="panel-title">
                                                <div class="row">
                                                    <div class="col-md-6" style="border-top-color: #801C6B">
                                                        <a class="collapsemark" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$user->id}}" aria-expanded="true" aria-controls="collapse{{$user->id}}" >
                                                            <h4>
                                                                <i class="fa fa-user" aria-hidden="true"></i>&nbsp&nbsp{{$user->name}}&nbsp&nbsp&nbsp<span class="caret"></span>
                                                            </h4>
                                                            <small>{{$user->email}}</small>
                                                        </a>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <form action="{{route('users.destroy',['id'=>$user->id])}}" method="post">
                                                            {{ method_field('DELETE') }}
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <button type="submit" class=" btn btn-primary btn-sm btn-outline" style="min-width: 120px; ">DELETE</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </h4>
                                        </div>
                                        <div id="collapse{{$user->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$user->id}}">
                                            <div class="panel-body">
                                               <div class="col-md-6 colforms">
                                                   <form action="{{route('users.update',['id'=>$user->id])}}" method="POST">
                                                       {{ method_field('PUT') }}
                                                       <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                       <div class="form-group">
                                                           <label for="name">Change name</label>
                                                           <input type="text" class="form-control" id="name" name="name" placeholder="Change user name">
                                                       </div>
                                                       <div class="form-group">
                                                           <label for="password">Password</label>
                                                           <input type="password" class="form-control" id="password" name="password" placeholder="***********">
                                                       </div>
                                                       <div class="form-group">
                                                           <label for="password_confirmation">Confirm Password</label>
                                                           <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="***********">
                                                       </div>

                                                       <button type="submit" class="btn-outline btn btn-primary pull-right">DONE</button>

                                                   </form>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascript')

@endsection