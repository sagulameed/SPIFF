<main id="page-content-wrapper" role="main">
    <style>
        .small-check{
            width: 13px !important;
            height: 13px !important;
        }
        .check-text{
            margin-left: 5px;
            margin-top:5px;
            font-size: 13px;
        }
    </style>
    <div id="content">
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
        <div class="content-box col-md-12">
            <form action="{{url('adminCMS/updateElement')}}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="idElement" value="{{$element->id}}">
                <input type="hidden" name="type" value="{{$type}}">
                <div class="col-md-12">
                    <div class="back_button"><a href="{{ url('adminCMS/pictures') }}"><img src="{{ asset('adminCMS/img/backto.png') }}" width="30" height="30"/></a></div>
                    <div class="page-header no-margin-box">

                        <h3 class="no-bottom-margin-box">
                            YOUR ELEMENTS | {{strtoupper($type)}} | <span class="text-spiff">ID {{$element->id}}
                            </span>
                            <span style="font-size: 13px">
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
                            </span>
                        </h3>


                    </div>





                </div>

                <div class="col-md-12" style="margin-bottom:20px;">
                    <div class="spiff-header-border no-margin-box">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-12" style="height:400px;">
                        <div class="col-md-6 bg-details-div" style="padding-left:0px;">

                            <div class="checkbox-wrap">
                                <label class="checkbox-inline ">
                                    <input type="checkbox" id="pricecheckbox" name="pricecheckbox" style="display: none;"
                                           @if($element->isFree == 1)
                                                checked
                                            @endif
                                    >

                                    <label for="pricecheckbox"></label>
                                    <span class="checkboxlabel" ><h4 style="margin-left: 5px; margin-top:5px;">FREE</h4></span>
                                </label>
                            </div>

                            <div class="elements-edit-div @if($element->isFree == 1)
                                    hidden
                                @endif">
                                <div class="" style="margin-top:10px;padding-left:0px;">
                                    <hr class="spiff-hr" /></hr>
                                    <h5 class="text-spiff spiff-hr-title">Single use</h5>
                                    <div class="col-md-12" style="padding-left:0px;">
                                        <p>Remove the watermak for 24 hours to a single design</p>
                                    </div>
                                    <div class="col-md-12" style="padding-left:0px;padding-right:0px;float:right;">
                                        <div class="checkbox-wrap mark-checker" data-inputhide="singlePrice">
                                            <label class="checkbox-inline mark-checker">
                                                <input type="checkbox" class="checkmark" name="checkSinglePrice" id="checkSinglePrice" data-inputhide="singlePrice" style="display: none;" {{(empty($element->single)?'checked':'')}}>
                                                <label class="small-check "  for="checkSinglePrice"></label>
                                                <span class="checkboxlabel" ><h5 class="check-text " >NONE</h5></span>
                                            </label>
                                        </div>
                                        <input class="bg-price-button {{(empty($element->single)?'hidden':'')}}" id="singlePrice" name="singlePrice" type="text" placeholder="$ 1 USD" value="{{(!empty($element->single)?$element->single:'')}}">
                                    </div>
                                </div>

                                <div class="" style="margin-top:10px;padding-left:0px;">
                                    <hr class="spiff-hr" /></hr>
                                    <h5 class="text-spiff spiff-hr-title">Multiple use</h5>
                                    <div class="col-md-12" style="padding-left:0px;">
                                        <p>Remove the watermak for 24 hours to a single design</p>
                                    </div>
                                    <div class="col-md-12" style="padding-left:0px;padding-right:0px;float:right;">
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-inline" >
                                                <input type="checkbox" class="checkmark" id="checkMultiplePrice" data-inputhide="multiplePrice" name="checkMultiplePrice" style="display: none;" {{(empty($element->multiple)?'checked':'')}}>
                                                <label class="small-check"   for="checkMultiplePrice"></label>
                                                <span class="checkboxlabel" ><h5 class="check-text mark-checker" data-inputhide="multiplePrice" >NONE</h5></span>
                                            </label>
                                        </div>
                                        <input class="bg-price-button {{(empty($element->multiple)?'hidden':'')}}" id="multiplePrice" name="multiplePrice" type="text" placeholder="$ 10 USD" value="{{(!empty($element->multiple)?$element->multiple:'')}}">
                                    </div>
                                </div>

                                <div class="" style="margin-top:10px;padding-left:0px;">
                                    <hr class="spiff-hr" /></hr>
                                    <h5 class="text-spiff spiff-hr-title">Sale rights</h5>
                                    <div class="col-md-12" style="padding-left:0px;">
                                        <p>Multiple-use license plus extended rights for printing, reselling and multiple users</p>
                                    </div>
                                    <div class="col-md-12" style="padding-left:0px;padding-right:0px;float:right;">
                                        <div class="checkbox-wrap">
                                            <label class="checkbox-inline " >
                                                <input type="checkbox" class="checkmark" id="checkRightPrice" name="checkRightPrice" data-inputhide="rightPrice" style="display: none;" {{(empty($element->right)?'checked':'')}}>
                                                <label class="small-check "  for="checkRightPrice"></label>
                                                <span class="checkboxlabel" ><h5 class="check-text " >NONE</h5></span>
                                            </label>
                                        </div>
                                        <input class="bg-price-button {{(empty($element->right)?'hidden':'')}}" id="rightPrice" name="rightPrice" type="text" placeholder="$ 100 USD" value="{{(!empty($element->right)?$element->right:'')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                            <div class="parent background-container" style="display: flex;height: 400px;">
                                <img src="{{ $element->{$type.'_name'} }}" style="width: 400px;margin: auto;"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-bottom:10px;">
                    <div class="spiff-header-border no-margin-box">
                    </div>
                </div>


                <div class="row">

                    <div class="col-md-2" style="text-align:center;">
                        <div class="underline_span"><span class="title_span">ADD KEYWORDS</span></div>
                    </div>
                    <input type="hidden" name="tags" id='inputTags' value="{{$element->tags}}">

                    <div class="col-md-5">
                        <div class="form-group-lg">
                            <div class="tagswrap">
                                <div class="taginput">
                                    <input type="text" value="" placeholder="Add new tag" id="newTags">
                                    <span id="message"></span>
                                </div>
                                <div id="tagsVideo">
                                    @foreach($element->tags as $tag)
                                        <div class="tagsinner" > <div class="tags" id="tag_{{$tag->name}}">{{$tag->name}}&nbsp;<a href="" class="close-tag tagclose" data-tagname="{{$tag->name}}"><span class="icon-close"></span></a></div></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <button   type="submit" class="create_layout_button spiff-button" id="updateElement">SAVE</button>
                    </div>
                    <div class="col-md-1" style="float:right;">
                        <button  onClick="javascript:deleteresource({{ $element->id }}, '{{ url("adminCMS/".$type.'s') }}');" type="button" class="create_layout_button spiff-button">DELETE</button>
                    </div>
                    {{--<div class="col-md-1" style="float:right;">
                        <button  type="button" class="create_layout_button spiff-button">DELETE</button>
                    </div>--}}
                </div>
            </form>
        </div>
    </div>

</main>
@section('javascript')
    <script src="{{asset('js/editElements.js')}}"></script>
@endsection
