@extends('adminCMS/app')
   
@section('content')
<div class="maincontentwrap">

        <div id="maincontent" class="maincontent clearfix">

            <div class="tab-bodycontent">

                    <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
<div class="contentHeader">
    <div class="row">
        <div class="col-sm-8">
            <h1>Replace Search Engine Video</h1>
        </div>
        <!--<div class="col-sm-4">
            <div class="contentHeaderSearch">
                <input name="" class="form-control" placeholder="Search img, elements, backgrounds..." type="text">
                <a href="javascript:void(0)" class="contentHeaderSearchicon"><span class="icon-search"></span></a>
            </div>
        </div>-->
    </div>
</div>
        <div class="row backgroundsec" style="margin-right: 0;">
        <div class="col-md-12">
                            <div style="height:65px;">
                            <button type="button" class="create_layout_button spiff-button" style="float:left;margin-right:6px;">UPLOAD NEW VIDEO</button>
                            <div class="file_location_text" style="margin-top:10px;"><span>C:\Windows\Spiff\Video_files...</span></div>
                            </div>
                            <div class="video-form">
                                <input class="form-control" placeholder="CHANGE VIDEO TITLE" type="text">
                                <div style="margin-top:10px;height:200px;border:1px solid #ccc">
                                     
                                </div>
                                <div style="height:35px;">
                                    <button type="button" class="create_layout_button spiff-button" style="float:left;margin-right:6px;">REPLACE</button>
                                </div>
                                <div style="margin-top:20px;">
                                    <p class="text-spiff" style="color:#800080;">Add / change compressed thumbnail</p>
                                    <div style="margin-top:10px;height:50px;border:1px solid #ccc;text-align:center;vertical-align:middle;padding-top:10px;">
                                        <img src="img/thumbnail_upload.png" width="100" height="30">
                                    </div>
                                    <button type="button" class="create_layout_button spiff-button" style="float:left;margin-right:6px;">REPLACE</button>
                                </div>
                            </div>
                            <div class="video-form-right">
                                <p class="text-spiff clr-pink" style="color:#800080;">Current Video</p>
                                <h5>VIDEO TITLE</h5>
                                <img src="img/video_big_image.png" width="300" height="200">
                                <p class="text-spiff" style="margin-top:30px; color:#800080;">Current Compressed Image</p>
                                <img src="img/video_compressed_image.png" width="300">
                            </div>
                        </div>
</div>
<!--<div class="row">
    <div class="col-md-12 marg-top50">
        <div class="spiff-header-border no-margin-box">
        </div>
    </div>
    
    <div class="col-md-12">
        <button type="button" class="create_layout_button spiff-button" style="float:left;margin-right:6px;">NEW PICTURE</button>
        <div class="file_location_text"><span>C:\Windows\PICTRUES\SPIFF...</span></div>
        <button type="button" class="create_layout_button spiff-button">UPLOAD</button>
    </div>-->
</div>
</div>
</div>
</div>
</div>
@endsection