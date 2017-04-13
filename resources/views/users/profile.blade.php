@extends('landing.template.template')
@section('styles')
    <style>
        body{
            background: white;
        }
        .purple-color{
            color: #9E005C;
        }
        hr{
            border-top: 4px solid #9E005C;
            margin-top: 5px;
        }
        .btn.btn-primary{
            height: 40px;
            width: 80px;
            border-radius: 15px;
        }
        .fileButtonM{
            cursor: pointer;
            color: #801C6B;
            font-size: 12px;
            text-transform: uppercase;
            padding: 10px 20px;
            border: none;
            background-color: #fff;
        }
        form{
            margin-top: 10%;
        }
        div.img-div{
            height:200px;
            width:200px;
            overflow:hidden;
            border-radius:50%;
        }
        .img-div img{
            -webkit-transform:translate(-50%);
            margin-left:100px;
        }
        .pretty-input{
            border: none;
            outline: none;
            -webkit-box-shadow: none;
            box-shadow: none;
            webkit-appearance: none;
        }
        input:focus{
            border: none;
            outline: none !important;
        }
        .form-group{
            margin-top: 5%;
        }
        .form-control{
            border: 0;
            border-bottom: 3px solid #D9D9D9;
            box-shadow: none;
            border-radius: 0;
        }
        .confirm-pass{
            margin-top: 10%;
        }
    </style>
@endsection
@section('content')
   <div class="row">
       <div class="container">
           <div class="row">
               <form action="{{url('me/profile')}}"  method="POST" enctype="multipart/form-data">
                   {{ csrf_field() }}
                   @if(Session::has('status'))
                       @if(Session::get('status'))
                           <div class="alert alert-success" role="alert"  >
                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               <strong>{{ Session::get('mess')}}</strong>
                           </div>
                       @else
                           <div class="alert alert-danger" role="alert" >
                               <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                               {{ Session::get('mess')}}
                           </div>
                       @endif
                   @endif
                   @if (count($errors) > 0)
                       <div class="alert alert-danger">
                           <ul>
                               @foreach ($errors->all() as $error)
                                   <li>{{ $error }}</li>
                               @endforeach
                           </ul>
                       </div>
                   @endif
                   <div class="col-md-4 col-md-offset-4">
                       <h1 class="purple-color text-center">Profile</h1>

                       <div class="img-div center-block">
                           <img class="" src="{{Auth::user()->thumbnail}}" alt="" style="object-fit: contain; height: auto">
                       </div>
                       <div class="form-group text-center">
                           <div class="">
                               <label for="thumbnail" class="fileButtonM">
                                   Change Image Profile
                               </label>
                               <input id="thumbnail" name="thumbnail" type="file" style="display:none;" accept="image/jpeg">
                           </div>
                           <p id="statusImg"></p>
                       </div>
                   </div>

                   <div class="col-md-4 col-md-offset-4">

                     <div class="form-group login-password">

                         <img src="{{asset('adminCMS/img/username.png')}}" alt="" class="login-ico" height="27"/>

                         <input type="text" id="firstName" name="firstName" value="{{Auth::user()->firstName}}" class="form-control pretty-input" placeholder="First Name" />

                     </div>
                     <div class="form-group login-password">

                         <img src="{{asset('adminCMS/img/username.png')}}" alt="" class="login-ico" height="27"/>

                         <input type="text" id="secondName" name="secondName" value="{{Auth::user()->secondName}}" class="form-control pretty-input" placeholder="Last Name" />

                     </div>

                       <div class="form-group login-password">

                           <img src="{{asset('adminCMS/img/password.png')}}" alt="" class="login-ico" height="27"/>

                           <input type="password" id="password" name="password" class="form-control pretty-input" placeholder="Password" />

                       </div>

                       <div class="form-group login-password confirm-pass">

                           <img src="{{asset('adminCMS/img/password.png')}}" alt="" class="login-ico" height="27"/>

                           <input type="password" id="password_confirmation" name="password_confirmation" class="form-control pretty-input" placeholder="Confirm password" />

                       </div>

                       <button type="submit" class="btn btn-primary center-block btn-confirm">Confirm</button>
                   </div>
               </form>
           </div>
       </div>
   </div>

@endsection

@section('javascript')
    <script>
        $('input[name="thumbnail"]').change(function(){
            var fileName = $(this).val();
            $('#statusImg').text('Image uploaded: '+fileName.replace("C:\\fakepath\\",""))
        });
    </script>
@endsection
