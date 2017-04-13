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
                            <div class="col-sm-12">
                                <h1>Edit Video</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
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

                    <form action="{{route('videos.update',['videos'=>$video->id])}}" method="POST" enctype="multipart/form-data">
                        <div class="col-lg-5 col-md-5">
                            {!! csrf_field() !!}
                            <input name="_method" type="hidden" value="PUT">
                            <input type="hidden" name="tags" id='inputTags' value="{{json_encode($video->tags)}}">
                            <input type="hidden" name="category" id='category' value="{{$video->categories[0]->id}}">
                            <input type="hidden"  id='categoryPost' value="{{url('adminCMS/categories')}}">

                            <div class="form-group">
                                <input type="file" class="editFile" name="video" data-btnlabel = "Video" id="videos">
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#video">
                                    Watch Saved Video
                                </button>
                            </div>
                            <div class="form-group">
                                <label class="label-big">Title</label>
                                <input type="text" name="title" class="form-control" value="{{$video->title}}" placeholder="Title Name" required/>
                            </div>
                            <div class="form-group">
                                <label class="label-big">Sub Title</label>
                                <input type="text" name="subtitle" class="form-control" value="{{$video->subtitle}}"  placeholder="Sub Title Name" required/>
                            </div>

                            <div class="form-group">
                                <label class="label-big">Description</label>
                                <textarea name="description" class="form-control" id="description" cols="70"  rows="10" required>{{$video->description}}</textarea>
                            </div>
                        </div>
                        <div class="col-md-offset-2 col-lg-offset-2 col-lg-4 col-md-4">
                            {{--<div class="form-group">
                                <label class="label-big">Thumbail</label>
                                <input type="file" class="editFile" name="thumbnail" data-btnlabel = "Thumbnail">

                            </div>--}}
                            <div class="form-group">
                                <label class="label-big">Add thumbnail</label> <br>
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img id="previewImage" src="{{$video->thumbnail}}" style="object-fit: cover; width: 100%; height: auto;">
                                    </label>
                                    <input id="file-input" id="thumbnail" name="thumbnail" type="file"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="label-big">Select category</label>
                                <div class="form-group" >
                                    <div class="btn-group" style="width: 100%">
                                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%;background-color: #7f1c6b; color: white">
                                        {{$video->categories[0]->name}} <span class="caret"></span>
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
                                        @foreach($video->tags as $tag)
                                            <div class="tagsinner" > <div class="tags" id="tag_{{$tag->name}}">{{$tag->name}}&nbsp;<a href="" class="close-tag tagclose" data-tagname="{{$tag->name}}"><span class="icon-close"></span></a></div></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <button class="btn-outline btn-primary text-center">Save Video</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div id="video" class="modal fade" role="dialog" style="margin-top: 10%;">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content" style="padding-bottom: 30px;">
                <div class="modal-header text-center" style="border-bottom: 1px solid #801C6B;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color: #801C6B">Current Video</h4>
                </div>
                <div class="modal-body text-center">
                    <div class="embed-responsive embed-responsive-16by9">
                        <video id="productVideo" width="100%" height="300" controls>
                            <source src="{{$video->video}}" tyzpe="video/mp4">
                        </video>
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
@section('javascript')
    <script src="{{asset('js/videosAddEdit.js')}}"> </script>
    <script>
        $( document ).ready(function() {
            $('.file-upload-input').prop('required',null);

            var width = $('#categoryList').width();
            var height = $('#openNewCategory').outerHeight();
            $('#openNewCategory .dropdown-menu').css({
               'left' : width,
               'top' : -height - 4
            });
        });
    </script>
@endsection
