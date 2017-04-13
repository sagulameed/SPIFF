@extends('adminCMS/app')
@section('content')
<div class="maincontentwrap">
  <div id="maincontent" class="maincontent clearfix">
    <div class="tab-bodycontent">
      <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
        @if( ! empty($success))
        <p style="color:green;font-size:15px;">{{$success}}
        </p>
        @endif
        <div class="contentHeader">
          <div class="row">
            <div class="col-sm-8">
              <h1>Your Elements
              </h1>
            </div>
            <div class="col-sm-4">
              <div class="contentHeaderSearch">
                <form action="{{url('adminCMS/searchElements')}}" method="POST">
                  {{ csrf_field() }}
                  <input type="text" id="searchinput" value="{{(!empty($tags)?$tags:'')}}" name="searchinput" required class="form-control" placeholder="Search illustrations: fashion,views,buildings...">
                  <input type="hidden" name="elementType" value="illustrations">
                  <a class="contentHeaderSearchicon">
                    <span class="icon-search"></span>
                  </a>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div>
          <ul class="elementsTabHead" style="margin-bottom: 20px;">
            <li>
              <a href="{{ url('adminCMS/pictures') }}" >Pictures
              </a>
            </li>
            <li>
              <a href="{{ url('adminCMS/lines') }}" >Lines
              </a>
            </li>
            <li class="active">
              <a href="{{ url('adminCMS/illustrations') }}" >illustrations
              </a>
            </li>
            <li>
              <a href="{{ url('adminCMS/grids') }}" >Grids
              </a>
            </li>
            <li>
              <a href="{{ url('adminCMS/frames') }}" >Frames
              </a>
            </li>
          </ul>
        </div>
        <div class="customscrollmedium customscrollinset">
          <div class="customscrollmedium-inner elementspics">
            <div class="row">
              @if( ! empty($illustrations))
              @foreach ($illustrations as $illustration)
              <div class="col-md-5ths col-sm-4">
                <div class="imagebox-wrap">
                  <div class="imagebox-inner">
                    <img src="{{$illustration->image}}" style="height:180px;">
                    <a class="imagebox-footer" href="{{ url('adminCMS/editillustrations') }}/{{$illustration->id}}">Edit
                    </a>
                  </div>
                </div>
              </div>
              @endforeach
              @endif
            </div>
          </div>
        </div>
        <div class="contentFooter">
          <div class="row">
            {!! Form::open(array('url' => 'adminCMS/illustrationcreate', 'method'=>'POST', 'files'=>'true')); !!}
            <div class="col-sm-8">
              <div class="custom-file-upload">
                {!! Form::file('illustrations[]', array('multiple'=>true, 'data-btnlabel'=>'New Illustration', "accept"=>".svg" )) !!}
              </div>
            </div>
            <div class="col-sm-4 text-sm-right">
              <button class="btn-outline btn-primary">Upload
              </button>
            </div>
            {!! Form::close(); !!}
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection
