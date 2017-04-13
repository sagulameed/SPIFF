<!-- Modal -->
<style>
    .arrowleft{
        width: 30px;
        height: 30px;
        position: absolute;
        top: 50%;
        z-index: 5;
        display: inline-block;
        margin-top: 15px;
        right: 30%;
    }
    .arrowright{
        width: 30px;
        height: 30px;
        position: absolute;
        top: 50%;
        z-index: 5;
        display: inline-block;
        margin-top: 15px;
        left: 30%;
    }
    .carousel-inner {
        margin-top: 45px;
    }
</style>
<div class="modal fade " id="checkPostModal{{$share->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="top: 20%;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <img class="pull-left" src="{{asset('img/save.png')}}" alt="" width="30px">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel" style="color: #801C6B;">{{strtoupper($share->design->name)}}</h4>
            </div>
            <div class="modal-body" style="    padding-top: 0px;">

                <div id="carousel{{$share->id}}" class="carousel slide" data-ride="carousel" style="border: solid;border-color: white; border-top-color: #801C6B;">
                    <!-- Indicators -->
                    <h5 class="pull-right" style="color: #801C6B;">{{strtoupper($share->design->user->name)}}</h5>
                    <div class="carousel-inner" role="listbox">
                        <?php $counter =0;?>
                            @foreach($share->design->layouts as $layout)

                                <div class="item <?php echo ($counter==0)?'active':''; ?>">
                                    <img src="{{$layout->canvas_thumbnail}}" alt="..." class="image-responsive" style="object-fit: contain; width: 100%; height: 300px;">
                                    <div class="carousel-caption"></div>
                                </div>
                                <?php $counter++;?>
                            @endforeach

                    </div>
                    <!-- Controls -->
                    <a class="left carousel-control" href="#carousel{{$share->id}}" data-slide="prev">
                        <img class="arrowleft" src="{{asset('img/leftArrow.png')}}" alt="" width="30px">
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#carousel{{$share->id}}" data-slide="next">
                        <img class="arrowright" src="{{asset('img/rightArrow.png')}}" alt="" width="30px">
                        <span class="sr-only">Previous</span>
                    </a>

                </div>
            </div>
            <div class="modal-footer" style="border-top: none ">
                <form action="{{url('adminCMS/gallery')}}" method="POST" class="statusGallery">
                    {{ csrf_field() }}
                    <input type="hidden"  name="statusAprove" value="">
                    <input type="hidden"  name="shareId" value="{{$share->id}}">
                    <button type="submit" class="btn btn-primary pull-left isAprove" data-optionaproved="true" >Aprove</button>
                    <button type="submit" class="btn btn-default pull-right isAprove" data-optionaproved="false"  >Reject</button>
                </form>

            </div>
        </div>
    </div>
</div>