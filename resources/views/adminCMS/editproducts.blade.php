@extends('adminCMS/app')

@section('content')
    <style>
        ::-webkit-input-placeholder { /* WebKit, Blink, Edge */
            color: #909;
        }

        :-moz-placeholder { /* Mozilla Firefox 4 to 18 */
            color: #909;
            opacity: 1;
        }

        ::-moz-placeholder { /* Mozilla Firefox 19+ */
            color: #909;
            opacity: 1;
        }

        :-ms-input-placeholder { /* Internet Explorer 10-11 */
            color: #909;
        }

        input {
            color: #909;
        }

        .box-list-head {
            margin-bottom: 10px
        }
        .cinta{
             width: 100%;
             position: relative;
             bottom: 50px;
         }

    </style>
    <div class="container-fluid">

        <div class="maincontentwrap">

            <div class="tab-bodycontent">

                <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                    {!! Form::open(array('url' => 'adminCMS/updateproducts', 'method'=>'POST', 'files'=>'true', 'novalidate' => 'novalidate')) !!}

                    <div class="contentHeader">
                        <div class="row">
                            <div class="col-sm-12">
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
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <h1>Edit Product </h1>
                            </div>
                        </div>

                    </div>

                    <input type="hidden" name="product_id" id="product_id" class="form-control" placeholder="Product ID" value="{{$product->id}}"/>
                    <div class="row">
                        <div class="col-lg-5 col-md-6">
                            <div class="form-group">
                                <label class="label-big">Name</label>
                                <input type="text" name="productname" id="productname" class="form-control" placeholder="Product Name" value="{{$product->product_name}}"/>
                            </div>

                            <div class="lineheading">Product Features</div>
                            <div class="customscrollnormal">
                                <ul class="boxlist">
                                    {{ csrf_field() }}
                                    <input type="hidden" id="removeFeature" value="{{url('adminCMS/products/removeFeature')}}">
                                    @foreach($product->features as $feature)
                                        <li>
                                            <input type="hidden" name="features[]" value="{{$feature->id}}">
                                            <div class="box-list-head">
                                                <input class="btn-block" type="text" placeholder="Name of Feature" name="names[]" value="{{$feature->name}}">
                                            </div>
                                            <textarea class="form-control" rows="3" placeholder="Brief description of the feature"  name="descriptions[]" >{{$feature->description}}</textarea>
                                            <button type="button" class="btn btn-primary pull-right removefeaturestored" data-featureid="{{$feature->id}}">Remove</button>

                                        </li>
                                    @endforeach
                                    <li>
                                        <div class="box-list-head">
                                            <input class="btn-block" type="text" placeholder="Name of Feature" name="names[]">
                                        </div>
                                        <textarea class="form-control" rows="3" placeholder="Brrief description of the feature"  name="descriptions[]"></textarea>

                                    </li>
                                </ul>
                            </div>

                            <h5 class="text-danger" style="display: none" id="dangerEmpty">You can not add empty features</h5>
                            <button type="button" class="btn btn-primary btn-length" id="addFeature"><span>+</span> Add
                                new product description
                            </button>

                        </div>

                        <div class="col-lg-6 col-lg-offset-1 col-md-6">



                            <div class="addthumbsection">
                                <label class="lineheading">Add thumbnail</label> <br>
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img id="previewImage" src="{{$product->product_image}}"
                                             style="object-fit: contain; width: 100%; height: 300px;">
                                    </label>
                                    <input required id="file-input" id="addnewprod_image" name="thumbnail" type="file"/>
                                </div>

                            </div>

                            <div class="lineheading">Product View</div>

                            <div class="lineheadingsub">Only you can add to assign one image of your list to display in the "open" preview and other one in "close preview"</div>

                            <div class="customscrollnormal customscrollproductview productviewinner">

                                <div class="customscrollnormal-inner">

                                    <div class="row">

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="imagebox-wrap-small">
                                                <div class="imageboxsmall-inner image-upload">
                                                    <label for="openImage">
                                                        <img id="openImagePreview"  src="{{asset($product->thumbnails()->where('isOpen',1)->first()->image)}}" style="object-fit: cover; width: 100%; height: 200px;">
                                                    </label>
                                                    <input  id="openImage" name="openImage" type="file"multiple/>
                                                    <p class="text-center" style="color: #909;">OPEN</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="imagebox-wrap-small">
                                                <div class="imageboxsmall-inner image-upload">
                                                    <label for="closeImage">
                                                        <img id="closeImagePreview" src="{{asset($product->thumbnails()->where('isOpen',0)->first()->image)}}" style="object-fit: cover; width: 100%; height: 200px;">
                                                    </label>
                                                    <input  id="closeImage" name="closeImage" type="file" />
                                                    <p class="text-center" style="color: #909;">CLOSE</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <input type="hidden" value="" id="imgtodelete">
                                            <div class="imagebox-wrap-small">
                                                <div class="imageboxsmall-inner image-upload">
                                                    <label for="addpreview">
                                                        <img src="{{asset('img/addimage.jpg')}}" style="object-fit: cover; width: 100%; height: 200px;">
                                                    </label>
                                                    <input  id="addpreview" name="product_images[]" type="file"multiple/>
                                                    <p class="text-center" style="color: #909;">NEW GALLERY</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <h2 class="text-center">NEW GALLERY</h2></div>
                                        <div class="previewthumbnails">
                                        </div>
                                        @foreach($product->thumbnails()->where('isOpen',-1)->get() as $image)
                                            <div class="previewthumbnailsstored">
                                                <div class="col-lg-4 col-sm-6" id="thumb_{{$image->id}}">
                                                    <div class="imagebox-wrap-small">
                                                        <div class="imageboxsmall-inner">
                                                            <img src="{{$image->image}}" height="224" style="object-fit: cover; width: 100%; height: 200px;"/>
                                                            <a href="#" class="imagebox-close mygallclose" data-thumbid="{{$image->id}}">
                                                                <span class="icon-close"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <input type="hidden" id="thumsdel" value="" name="thumsdel">
                                    </div>
                                </div>
                            </div>



                            <div class="addvideosection">
                                <div class="custom-file-upload customfilemargin">
                                    <label for="file">File: </label>
                                    {!! Form::file('video', array('multiple'=>false, 'data-btnlabel'=>'Replace Video','id'=>'editvideos')) !!}
                                </div>
                            </div>
                            @if(!empty($product->video))
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="videoholder">
                                            <video width="320" height="240" controls preload="none" {{--poster="img/videocover.jpg"--}}>
                                                <source src="{{asset($product->video)}}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <a href="javascript:void(0)" class="imagebox-close"><span class="icon-close"></span></a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>

                    <div class="row rowsection">
                        <div class="col-lg-5 col-md-6">
                            <input type="hidden" name="tags" id='inputTags' value="{{json_encode($product->tags)}}">
                            <div class="">
                                <div class="lineheading">Add tags</div>
                            </div>
                            <div class="form-group-lg">
                                <div class="tagswrap">
                                    <div class="taginput">
                                        <input type="text" value="" placeholder="Add new tag" id="newTags">
                                        <span id="message"></span>
                                    </div>
                                    <div id="tagsVideo">
                                        @foreach($product->tags as $tag)
                                            <div class="tagsinner" > <div class="tags" id="tag_{{$tag->name}}">{{$tag->name}}&nbsp;<a href="" class="close-tag tagclose" data-tagname="{{$tag->name}}"><span class="icon-close"></span></a></div></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-6 col-lg-offset-1 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="lineheading text-center">Pricing</div>
                                    <div class="units-table">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th class="text-left" colspan="3">Pieces</th>
                                                <th>Price per unit</th>
                                            </tr>
                                            </thead>
                                            <tbody id="rankPrices">
                                            <input type="hidden" id="pricingJson" value="{{$product->pricingJson}}">
                                            <?php $idInt = 0;?>
                                                @foreach(json_decode($product->pricingJson) as $rowPrice)
                                                    <tr>
                                                        <td>
                                                            <input type="number" min="1" step="1" name="from[]"  id="{{$idInt++}}" {{($idInt==0)?'disabled':''}}
                                                                   class="form-control unitbox fromto" placeholder="From"  value="{{$rowPrice->from}}" >
                                                        </td>
                                                        <td>-</td>

                                                        <td>
                                                            <input type="number" min="0" step="1" name="to[]" id="{{$idInt++}}"
                                                                   class="form-control unitbox fromto" placeholder="To"  value="{{$rowPrice->to}}">
                                                        </td>
                                                        <td>
                                                            <input type="number" min="0" step="1" name="price[]"
                                                                   class="form-control unitbox" placeholder="$"  value="{{$rowPrice->price}}">
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            <input type="hidden" id="lastCounter" name="lastCounter" value="{{$idInt}}">
                                            </tbody>
                                        </table>
                                    </div>

                                    <h5 class="text-danger" style="display: none" id="wrongPrice"></h5>

                                    <button id="addPriceRank" type="button" class="btn btn-primary">
                                        <span>+</span> Add range pieces
                                    </button>
                                </div>

                                <div class="col-lg-6">
                                    <div class="shippingsection">
                                        <div class="lineheading text-center">Shipping</div>
                                        <div class="units-table">
                                            <table>

                                                <thead>
                                                <tr>
                                                    <th>Finished weight/unit</th>
                                                    <th>Delivery Charge per Kl</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="number" min="0" step="any" name="weight" step="1"
                                                               class="form-control unitbox" placeholder="Kg" value="{{$product->weight}}">
                                                    </td>
                                                    <td>

                                                        <input type="number" min="0" step="any" name="pricePerWeight" step="1"
                                                               class="form-control unitbox" placeholder="$"  value="{{$product->pricePerWeight}}">
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="lineheading">Visual creator</div>
                            <div class="row">
                                <div class="col-lg-5 col-md-12 visualcreatormain">
                                    <div class="visualcreatorhead">

                                        <div class="row">
                                            <div class="col-md-6">
                                                {!! Form::file('panelTarget', array('class'=>'btn btn-primary','id'=>'panelTarget', 'data-btnlabel'=>'Add .SVG Panel Target', "accept"=>".svg")) !!}
                                            </div>
                                            <div class="col-md-6">
                                                {!! Form::file('svgpanels[]', array('class'=>'btn btn-primary', 'multiple'=>true,'id'=>'filePanels', 'data-btnlabel'=>'Add .SVG panels', "accept"=>".svg")) !!}
                                            </div>
                                        </div>

                                    </div>
                                    <div class="customscrollnormal customscrollproductview customscrollheight2">
                                        <div class="customscrollnormal-inner">
                                            <input type="hidden" id="paneldel" name="panedel" value="">
                                            <div class="row">
                                                @foreach ($product->panels as $panel)
                                                    <div class="col-md-4 col-sm-6" id="pane_{{$panel->id}}">
                                                        <div class="frameholder-wrap">
                                                            <div class="frameholder">
                                                                <img src="{{asset($panel->image)}}" style="object-fit: contain; width: 100%; height: 100px;" />
                                                                <a href="#" class="imagebox-close paneclose" data-paneid="{{$panel->id}}"><span class="icon-close"></span></a>
                                                                @if($panel->isTarget)
                                                                    <a href="#" class="cinta">Marker</a>
                                                                @endif
                                                            </div>
                                                            <input type="text" placeholder="change panel name" class="form-control" name="minePanelsNames[]" value="{{$panel->name}}" />
                                                            <input type="hidden"  name="minepaneids[]" value="{{$panel->id}}">
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="row" id="previewPanelsTarget">


                                                </div>
                                                <div id="previewPanels">

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-lg-offset-1 col-md-12">

                                    <div class="visualcreatorhead">

                                        {!! Form::file('illustration_images[]', array('class'=>'btn btn-primary', 'multiple'=>true, 'data-btnlabel'=>'Add .SVG illustration', "accept"=>".svg")) !!}

                                        <button class="btn btn-link">Recommended illustrations for panel selected</button>

                                    </div>

                                    <div class="customscrollnormal customscrollproductview customscrollsvgill customscrollheight2">

                                        <div class="customscrollnormal-inner">
                                            <div class="row">
                                                <input type="hidden" id="illusdel" val="" name="illusdel">
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        @foreach ($product->illustrations as $illustration)
                                                            <div class="col-md-6" id="illus_{{$illustration->id}}">
                                                                <div class="imgholder">
                                                                    <img src="{{asset($illustration->image)}}" />
                                                                    <a href="#" class="closesmall myillusclose" data-illusid="{{$illustration->id}}">
                                                                        <span class="icon-close "></span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div id="illuspreview">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="contentFooter">
                        <div class="text-right">
                            <button id="uploadProductBtn" class="btn-outline btn-primary" >Update Product</button>
                        </div>
                    </div>

                </div>
                {!! Form::close() !!}

@endsection
@section('javascript')
    <script src="{{asset('adminCMS/js/addProduct.js')}}"></script>
    <script>
        $(document).ready(function () {

            var imagesPreview = function (input, placeToInsertImagePreview, templateType) {
                console.log('adding images')
                if (input.files) {
                    var filesAmount = input.files.length;

                    $(placeToInsertImagePreview).empty(); //clean container for new previews
                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();
                        reader.onload = function (event) {
                            if(templateType === 'addpreview'){
                                $(placeToInsertImagePreview).append('<div class="col-lg-4 col-sm-6"><div class="imagebox-wrap-small"><div class="imageboxsmall-inner"> <img src="'+event.target.result+'" height="224" style="object-fit: cover; width: 100%; height: 200px;"/> </div></div></div>');
                            }
                            if(templateType === 'filePanels'){
                                $(placeToInsertImagePreview).append('<div class="col-md-4 col-sm-6"> <div class="frameholder-wrap"> <div class="frameholder"> <img src="'+event.target.result+'" style="object-fit: contain; width: 100%; height: 200px;"/> </div> <input type="text" placeholder="change panel name" name="panelsNames[]" class="form-control" required/> </div></div>');
                            }
                            if(templateType === 'filePanelsT'){
                                $(placeToInsertImagePreview).append('<div class="col-md-4 col-sm-6"> <div class="frameholder-wrap"> <div class="frameholder"> <img src="'+event.target.result+'" style="object-fit: contain; width: 100%; height: 100px;"/>  </div> <input type="text" placeholder="change panel name" name="panelNameT" class="form-control" /> </div></div>');
                            }
                            if(templateType === 'illustration'){
                                $(placeToInsertImagePreview).append('<div class="col-md-6"><div class="imgholder"><img src="'+event.target.result+'" style="object-fit: contain; width: 100%; height: 200px;"/></div></div>');
                            }
                        }
                        reader.readAsDataURL(input.files[i]);
                    }
                }
            };
            $('#addpreview').on('change', function () {
                console.log('input changed')
                imagesPreview(this, '.previewthumbnails','addpreview');
            });
            $('#filePanels').on('change', function () {
                console.log('input changed panels')
                console.log('panels file changes')
                imagesPreview(this, '#previewPanels','filePanels');
            });
            $('#panelTarget').on('change', function () {
                console.log('input changed panels')
                console.log('panels file changes')
                imagesPreview(this, '#previewPanelsTarget','filePanelsT');
            });
            $('#illusFile').on('change', function () {
                console.log('input changed panels')
                console.log('panels file changes')
                imagesPreview(this, '#illuspreview','illustration');
            });

            $('#openImage').change(function(){
                console.log('input has changed')
                readURL(this,'#openImagePreview')
            })
            $('#closeImage').change(function(){
                console.log('input has changed')
                readURL(this,'#closeImagePreview')
            })

            function readURL(input,containerPreview) {
                if (input.files && input.files[0]) {
                    console.log('image setted')
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $(containerPreview).attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

        });
    </script>
@endsection
