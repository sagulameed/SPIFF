@extends('adminCMS.app')

@section('content')
    <style type="text/css">
        .label-default{
            background-color: #fff;
            color: black;
            margin-left: 3px;
            margin-right: 3px;
            margin-bottom: 3px;
        }
         .new-category:focus {
             outline: none !important;
             border:1px solid red;
             box-shadow: 0 0 10px #719ECE;
         }
        .file-upload-wrapper {
            display: none;
        }

    </style>
    <div class="container-fluid">
        <div class="maincontentwrap">
            <div class="tab-bodycontent">
                <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                    <div class="contentHeader">
                        <div class="row">
                            <div class="col-sm-6">
                                <h1>UPLOAD A NEW VIDEO </h1>

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

                    <form action="{{route('videos.store')}}" method="POST" enctype="multipart/form-data">
                        <div class="col-lg-5 col-md-5">
                            {!! csrf_field() !!}
                            <input type="hidden" name="tags" id='inputTags'>
                            <input type="hidden" name="category" id='category'>
                            <input type="hidden"  id='categoryPost' value="{{url('adminCMS/categories')}}">
                             <div class="form-group">
                                {!! Form::file('video', array('multiple'=>false, 'data-btnlabel'=>'Video','id'=>'videos','accept'=>'video/mp4')) !!}
                            </div>

                            <div class="form-group">
                                <label class="label-big">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Video title" required value="{{ old('title') }}"/>
                            </div>
                            <div class="form-group">
                                <label class="label-big">Sub Title</label>
                                <input type="text" name="subtitle" class="form-control" placeholder="Video Subtitle" value="{{ old('subtitle') }}" required/>
                            </div>

                            <div class="form-group">
                                <label class="label-big">Description</label>
                                <textarea name="description" class="form-control" id="description" cols="70" value="{{ old('description') }}" rows="14" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-offset-2 col-lg-offset-2 col-lg-4 col-md-4">
                            <div class="form-group">
                                <label class="label-big">Add thumbnail</label> <br>
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img id="previewImage" src="{{asset('img/addimage.jpg')}}" style="object-fit: cover; width: 100%; height: auto;">
                                    </label>
                                    <input id="file-input" id="thumbnail" name="thumbnail" type="file" accept="image/x-png,image/gif,image/jpeg" />
                                </div>
                            </div>
                           
                            <div class="form-group">
                                <label class="label-big">Select category</label>
                                <div class="form-group" > 
                                    <div class="btn-group" style="width: 100%">
                                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;background-color: #7f1c6b; color: white">
                                        Select category <span class="caret"></span>
                                    </button>
                                    <ul id="categoryList" class="dropdown-menu" style="width: 100%;background-color: rgba(230, 189, 227, 0.95);">
                                        <div id="innerCategoryList">
                                            @foreach($categories as $category)
                                                <li class="category-select text-center" id="{{$category->id}}">
                                                    <a href="#" style="color:white" data-category="{{$category->id}}">{{$category->name}}</a>
                                                </li>
                                            @endforeach
                                            <li id="openNewCategory" class="text-center dropdown-submenu">
                                                <a class="test" tabindex="-1" href="#" style="width: 100%;background-color: #7f1c6b; color: white">Create new category <span class="caret"></span></a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <input type="text" id="newCategory" class="new-category form-control" placeholder="Type new category">
                                                        <p id="helper-text" class="help-block" style="color: #f1c6f9;">Press enter to create.</p>
                                                    </li>
                                                </ul>
                                            </li>
                                        </div>
                                      </ul>
                                    </div>
                                 </div>
                            </div>

                            <div class="form-group-lg">
                                <label class="label-big">Add Tags</label>
                                <div class="tagswrap">
                                    <div class="taginput">
                                        <input type="text" value="" placeholder="Add new tag" id="newTags">
                                        <span id="message"></span>
                                    </div>
                                    <div id="tagsVideo">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn-outline btn-primary text-center" style="">Upload Video</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('javascript')
    <script src="{{asset('js/videosAddEdit.js')}}"> </script>

    <script type="text/javascript">
        var width = $('#categoryList').width();
        var height = $('#openNewCategory').outerHeight();
        $('#openNewCategory .dropdown-menu').css({
           'left' : width,
           'top' : -height - 4
        });

    </script>
@endsection