@extends('adminCMS/app')
   
@section('content')


    <div class="maincontentwrap">

        <div id="maincontent" class="maincontent clearfix">

            <div class="tab-bodycontent">

                    <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                    	
						@if( ! empty($success))
						    <p style="color:green;font-size:15px;">{{$success}}</p>
						@endif

    				    <div class="contentHeader">

						    <div class="row">

						        <div class="col-sm-8">

						            <h1>Your Fonts</h1>

						        </div>
						        <div class="col-sm-4">

						            <div class="contentHeaderSearch">

						                <input type="text"  id="searchinput" name="searchinput" class="form-control" placeholder="Search images, elements, backgrounds..." required />

						                <a href="javascript:searchresource('fonts');" class="contentHeaderSearchicon"><span class="icon-search"></span></a>

						            </div>

					        	</div>

						    </div>

						</div>

						<div class="customscrollmedium" >

						    <div class="customscrollmedium-inner">

						        <div class="row">


								@if( ! empty($fonts))
                                @foreach ($fonts as $font)
                                                      
                                
						            <div class="col-md-6">

						                <div class="fonts-wrap">

						                    <div class="fonts-text">{{$font->font_name}}</div>
						                    <a href="javascript:deleteresource({{ $font->id }}, '{{ url('adminCMS') }}/fonts');" class="closemedium"><span class="icon-close"></span></a>

						                </div>

						            </div>

                                @endforeach
								@endif

						        </div>

						    </div>

						</div>

						<div class="contentFooter">

							<div class="row">
						
							{!! Form::open(array('url' => 'adminCMS/fontcreate', 'method'=>'POST', 'files'=>'true')); !!}

								<div class="col-sm-8">

									<div class="custom-file-upload">
										{!! Form::file('fonts[]', array('multiple'=>true, 'data-btnlabel'=>'New Font', "accept"=>".ttf")) !!}

						                <!--<input type="file" name="files" multiple data-btnlabel="New Font" id="files"/>-->

						            </div>

								</div>

								<div class="col-sm-4 text-right"><button type="submit" class="btn-outline btn-primary">Upload</button></div>

							{!! Form::close(); !!}

							</div>

						</div>
                    </div>

                    <div class="tabs-bodypane" id="products-bodycontent"><!--templates/products.html--></div>

                    <div class="tabs-bodypane" id="learn-bodycontent"></div>

                    <div class="tabs-bodypane" id="gallery-bodycontent"></div>

                    <div class="tabs-bodypane" id="users-bodycontent"></div>

            </div>

        </div>

    </div>
@endsection