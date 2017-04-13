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
              <h1>Your Backgrounds
              </h1>
            </div>
            <div class="col-sm-4">
              <div class="contentHeaderSearch">
                <input type="text" id="searchinput" name="searchinput" class="form-control" placeholder="Search images, elements, backgrounds...">
                <a href="javascript:searchresource('backgrounds');" class="contentHeaderSearchicon">
                  <span class="icon-search">
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div>
          <ul class="elementsTabHead" style="margin-bottom: 20px;">
          </ul>
        </div>
        <div class="customscrollmedium customscrollinset">
          <div class="customscrollmedium-inner elementspics">
            <div class="row">
              @if( ! empty($backgrounds))
              @foreach ($backgrounds as $background)
              <div class="col-md-5ths col-sm-4">
                <div class="imagebox-wrap">
                  <div class="imagebox-inner">
                    <img src="{{$background->background_name}}" style="height:180px;">
                    <a class="imagebox-footer" href="{{ url('adminCMS/editbackgrounds') }}/{{$background->id}}">Edit
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
            {!! Form::open(array('url' => 'adminCMS/backgroundcreate', 'method'=>'POST', 'files'=>'true')); !!}
            <div class="col-sm-8">
              <div class="custom-file-upload">
                {!! Form::file('backgrounds[]', array('multiple'=>true, 'data-btnlabel'=>'New Background', "accept"=>".png,.jpg" )) !!}
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
</div>
@endsection
