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
        .removepricerow{
            border-radius: 50px !important;
            width: 22px !important;
            height: 22px !important;
            padding: 0px !important;
        }

    </style>

    <div class="container-fluid">

        <div class="maincontentwrap">

            <div class="tab-bodycontent">

                <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                    {!! Form::open(array('url' => 'adminCMS/addproducts', 'method'=>'POST', 'files'=>'true')) !!}

                    <div class="contentHeader">
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
                        <div class="col-sm-12">

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

                        <div class="row">
                            <div class="col-sm-12">
                                <h1>New Product</h1>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-lg-5 col-md-6">
                            <div class="form-group">
                                <label class="label-big">Name</label>
                                <input type="text" name="productname" id="productname" class="form-control" required
                                       placeholder="Product Name"/>
                            </div>

                            <div class="lineheading">Product Features</div>
                            <div class="customscrollnormal">
                                <ul class="boxlist">
                                    <li>
                                        <div class="box-list-head">
                                            <input class="btn-block" type="text" placeholder="Name of Feature"
                                                   name="names[]">
                                        </div>
                                        <textarea class="form-control" rows="3"
                                                  placeholder="Brrief description of the feature"
                                                  name="descriptions[]"></textarea>
                                        <button type="button" class="btn btn-primary pull-right removefeature" >Remove</button>
                                    </li>
                                    {{--<li><div class="box-list-head" ><input class="btn-block" name="name[]" type="text" placeholder="Name of Feature"></div><textarea class="form-control" rows="3" name="description[]" placeholder="Brrief description of the feature"></textarea></li>--}}
                                </ul>
                            </div>
                            <h5 class="text-danger" style="display: none" id="dangerEmpty">You can not add empty features</h5>
                            <button type="button" class="btn btn-primary btn-length" id="addFeature"><span>+</span> Add
                                new product description
                            </button>
                        </div>

                        <div class="col-lg-6 col-lg-offset-1 col-md-6">

                            <div class="addthumbsection">
                                <div class="lineheading">Add thumbnail</div>
                                <div class="image-upload">
                                    <label for="file-input">
                                        <img id="previewImage" src="{{asset('img/addimage.jpg')}}" style="object-fit: contain; width: 80%; height: 300px;">
                                    </label>
                                    <input required id="file-input" id="addnewprod_image" name="thumbnail" type="file"/>
                                </div>

                            </div>

                            <div class="lineheading">Product View</div>

                            <div class="lineheadingsub">Only you can add to assign one image of your list to display in
                                the "open" preview and other one in "close preview"
                            </div>

                            <div class="customscrollnormal customscrollproductview productviewinner">

                                <div class="customscrollnormal-inner">

                                    <div class="row">

                                        <div class="col-lg-6 col-sm-6">
                                            <div class="imagebox-wrap-small">
                                                <div class="imageboxsmall-inner image-upload">
                                                    <label for="openImage">
                                                        <img id="openImagePreview"  src="{{asset('img/addimage.jpg')}}" style="object-fit: cover; width: 100%; height: 200px;">
                                                    </label>
                                                    <input  id="openImage" name="openImage" type="file"multiple/>
                                                    <p class="text-center" style="color: #909;">OPEN*</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-6">
                                            <div class="imagebox-wrap-small">
                                                <div class="imageboxsmall-inner image-upload">
                                                    <label for="closeImage">
                                                        <img id="closeImagePreview" src="{{asset('img/addimage.jpg')}}" style="object-fit: cover; width: 100%; height: 200px;">
                                                    </label>
                                                    <input  id="closeImage" name="closeImage" type="file" />
                                                    <p class="text-center" style="color: #909;">CLOSE*</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-6">
                                            <div class="imagebox-wrap-small">
                                                <div class="imageboxsmall-inner image-upload">
                                                    <label for="addpreview">
                                                        <img src="{{asset('img/addimage.jpg')}}" style="object-fit: cover; width: 100%; height: 200px;">
                                                    </label>
                                                    <input  id="addpreview" name="product_images[]" type="file"multiple/>
                                                    <p class="text-center" style="color: #909;">GALLERY*</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="previewthumbnails">
                                            {{--<div class="col-lg-4 col-sm-6">
                                                <div class="imagebox-wrap-small">
                                                    <div class="imageboxsmall-inner">
                                                        <img src="img/productimg.jpg" height="224" />
                                                        <a href="javascript:void(0)" class="imagebox-close"><span class="icon-close"></span></a>
                                                    </div>
                                                </div>
                                            </div>--}}


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="addvideosection">
                                        <div class="custom-file-upload customfilemargin">
                                            <label for="file">Add Video File: </label>
                                            {!! Form::file('video', array('multiple'=>false, 'data-btnlabel'=>'Add Video','id'=>'videos')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row rowsection">
                        <input type="hidden" name="tags" id='inputTags'>
                        <div class="col-lg-5 col-md-6">
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
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-lg-offset-1 col-md-6">

                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="lineheading text-center">Pricing*</div>
                                    <div class="units-table">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th class="text-left" colspan="3">Pieces</th>
                                                <th>Price per unit*</th>
                                            </tr>
                                            </thead>
                                            <tbody id="rankPrices">
                                            <input type="hidden" id="pricingJson" value="">
                                            <tr>
                                                <td>
                                                    <input type="number" min="1" step="1" name="from[]" id="0" class="form-control unitbox fromto disabled" placeholder="From" value="1" required>
                                                </td>
                                                <td><span class="ndash"></span></td>

                                                <td>
                                                    <input type="number" min="0" step="1" name="to[]" id="1"
                                                           class="form-control unitbox fromto" placeholder="To" required>
                                                </td>
                                                <td>
                                                    <input type="number" min="0" step="any" name="price[]"
                                                           class="form-control unitbox" placeholder="$" required>
                                                </td>
                                                {{--<td>
                                                    <button type="button" class="btn btn-primary removepricerow" ><i class="fa fa-times" aria-hidden="true"></i></button>
                                                </td>--}}
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h5 class="text-danger" style="display: none" id="wrongPrice"></h5>
                                    <button id="addPriceRank" type="button" class="btn btn-primary disabled">
                                        <span>+</span> Add range pieces
                                    </button>
                                </div>

                                <div class="col-lg-4">
                                    <div class="shippingsection">
                                        <div class="lineheading text-center">Shipping</div>
                                        <div class="units-table">
                                            <table>
                                                <thead>
                                                <tr>
                                                    <th>Finished weight/unit*</th>
                                                    <th>Delivery Charge per Kl*</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="number" min="0" step="any" name="weight" step="1"
                                                               class="form-control unitbox" placeholder="Kg" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" min="0" step="any" name="pricePerWeight" step="1"
                                                               class="form-control unitbox" placeholder="$" required>
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
                                        <!--<button class="btn btn-primary"><span>+</span> Add .SVG panels</button>-->

                                        <div class="row">
                                            <div class="col-md-6">
                                                {!! Form::file('panelTarget', array('class'=>'btn btn-primary','id'=>'panelTarget', 'data-btnlabel'=>'Add .SVG Panel Target', "accept"=>".svg")) !!}
                                            </div>
                                            <div class="col-md-6">
                                                {!! Form::file('svgpanels[]', array('multiple'=>true,'id'=>'filePanels' ,'required' => true,'data-btnlabel'=>'+ Add .SVG panels', "accept"=>".svg")) !!}
                                            </div>
                                        </div>

                                    </div>


                                    <div class="customscrollnormal customscrollproductview customscrollheight2">

                                        <div class="customscrollnormal-inner">
                                            <div class="row" id="previewPanelsTarget">


                                            </div>
                                            <div class="row" id="previewPanels">


                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-lg-offset-1 col-md-12">
                                    <div class="visualcreatorhead">
                                        <!--<button class="btn btn-primary"><span>+</span> Add .SVG illustration</button>-->
                                        {!! Form::file('illustration_images[]', array('class'=>'btn btn-primary','id' =>'illusFile','multiple'=>true, 'data-btnlabel'=>'+ Add .SVG illustration', "accept"=>".svg")) !!}

                                        <button class="btn btn-link">Recommended illustrations for panel selected</button>

                                    </div>
                                    <div class="customscrollnormal customscrollproductview customscrollsvgill customscrollheight2">
                                        <div class="customscrollnormal-inner">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row" id="illuspreview">


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
                            <button id="uploadProductBtn" class="btn-outline btn-primary" style="display: none;">Upload Product</button>
                        </div>
                    </div>

                </div>
                {!! Form::close() !!}

                @endsection
                @section('javascript')
                    <script src="{{asset('adminCMS/js/addProduct.js')}}"></script>
                    <script>
                        $(document).ready(function () {

                            var removeRequire = function(element){
                                input = element.siblings('input[type="text"]');
                                input.removeAttr('required');
                            }

                            removeRequire($('#panelTarget'))
                            removeRequire($('#videos'))
                            removeRequire($('#illusFile'))
                            removeRequire($('#openImage'))
                            removeRequire($('#closeImage'))
                            removeRequire($('#addpreview'))


                            var imagesPreview = function (input, placeToInsertImagePreview, templateType, clear=true) {
                                console.log('adding images')
                                if (input.files) {
                                    var filesAmount = input.files.length;

                                    if (clear){
                                        $(placeToInsertImagePreview).empty(); //clean container for new previews
                                    }


                                    for (i = 0; i < filesAmount; i++) {
                                        var reader = new FileReader();
                                        reader.onload = function (event) {
                                            if(templateType === 'addpreview'){
                                                $(placeToInsertImagePreview).append('<div class="col-lg-4 col-sm-6"><div class="imagebox-wrap-small"><div class="imageboxsmall-inner"> <img src="'+event.target.result+'" height="224" style="object-fit: cover; width: 100%; height: 200px;"/> </div></div></div>');
                                            }
                                            if(templateType === 'filePanels'){
                                                $(placeToInsertImagePreview).append('<div class="col-md-4 col-sm-6"> <div class="frameholder-wrap"> <div class="frameholder"> <img src="'+event.target.result+'" style="object-fit: contain; width: 100%; height: 100px;"/>  </div> <input type="text" placeholder="change panel name" name="panelsNames[]" class="form-control" /> </div></div>');
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