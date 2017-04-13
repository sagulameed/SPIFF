@extends('adminCMS.app')
   
@section('content')

<div class="maincontentwrap">
        
        <div class="leftmenu-tabpane leftmenu-tabpanelarge active" >
             
             <div class="tab-bodycontent">
                 <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                     <div class="contentHeader">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h1>Videos</h1>
                                </div>

                                <div class="col-sm-4">
                                    <div class="contentHeaderSearch">
                                         <input type="text" id="searchinput" name="searchinput" class="form-control" placeholder="Search images, elements, backgrounds...">
                                        <a href="javascript:searchresource('products');" class="contentHeaderSearchicon">
                                            <span class="icon-search"></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </div>

                <div class="contentBody contentBodycustomscroll" >
                    <div class="contentBodycustomscroll-inner" style="margin-top: 10px; padding-top: 1px;">
                        <img id="scrollLeft" class="autoScroll" src="{{ asset('adminCMS/img/backto.png') }}">
                        <div class="elementsTabHeadWrap">
                            <ul class="elementsTabHead" style="overflow: hidden;">
                                @foreach($categories as $category)
                                    <li <?php if($categoryId == $category->id) echo 'class="selected"'; ?> ><a href="{{ url('adminCMS/videos/category',[$category->id]) }}" >{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <img id="scrollRight" class="autoScroll" src="{{ asset('adminCMS/img/backto.png') }}">
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

                        <div class="row" style="padding-top: 25px">
                            @foreach( $videos as $video)
                                <div class="col-sm-4">
                                    <div class="imagebox-wrap">
                                        <div class="imagebox-inner">
                                            <img src="{{$video->thumbnail}}"  style="object-fit: cover; width: 100%; height: 200px;"/>
                                            <form class="deleteForm{{$video->id}}" action="{{route('videos.destroy',['id'=>$video->id])}}" method="POST">
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            </form>
                                            <a href="#" class="imagebox-close" data-videoid="{{$video->id}}"><span class="icon-close"></span></a>
                                            <a class="imagebox-footer" href="{{url("adminCMS/videos/$video->id/edit")}}">Edit</a>
                                        </div>
                                        <div class="imagebox-title" style="font-size: 16px;">{{$video->title}}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>



@endsection
@section('javascript')
    <script type="text/javascript">
            $(document).ready(function() {
                console.log('I am working')
                $('.imagebox-close').click(function(){
                    console.log('submit done ')
                    var videoid = $(this).data('videoid')
                    $('.deleteForm'+videoid).submit();
                });
            });

            //auto scroll width

            var autoScrollIconWidth = $('.autoScroll').width();
            var contentBodyCustomScrollWidth = $('.contentBodycustomscroll').width();
            contentBodyCustomScrollWidth = contentBodyCustomScrollWidth - (2 * autoScrollIconWidth) - 20;
            $('.elementsTabHeadWrap').width(contentBodyCustomScrollWidth);

            //category autocroll
            
            if($('li').hasClass('selected')){
                var offset = $('li.selected').position().left - contentBodyCustomScrollWidth;
                moveScroll(offset, 'right');
            }
         
            //auto sroll
            var move = false;
            var lastScrollPosition = 0;

            $(".autoScroll").hover(
              function(){
                if($(this).attr('id') == 'scrollLeft'){
                    var direction = 'left';
                }else{
                    var direction = 'right';
                }   
                move = true;

                var scrollPosition = $('.elementsTabHead').scrollLeft();
                moveScroll(scrollPosition, direction);
              }, function() {
                move = false;
                console.log(move);
              }
            );

            function moveScroll(scrollPosition, direction){
                if(direction ==  'left'){
                    var moveTo = scrollPosition - 100;
                }else{
                    var moveTo = scrollPosition + 100;
                }
                
                //console.log('move to - '+moveTo);
                $('.elementsTabHead').animate({scrollLeft: moveTo}, 100, function() {
                    scrollPosition = $('.elementsTabHead').scrollLeft();
                    if(move != false && scrollPosition != lastScrollPosition){
                        moveScroll(scrollPosition, direction);
                        $('#scrollLeft').css('visibility', 'visible');
                        $('#scrollRight').css('visibility', 'visible');
                    }else if(scrollPosition == lastScrollPosition && direction == 'left'){
                        $('#scrollLeft').css('visibility', 'hidden');
                    }else if(scrollPosition == lastScrollPosition && direction == 'right'){
                        $('#scrollRight').css('visibility', 'hidden');
                    }

                    lastScrollPosition = scrollPosition;
                });
            }

    </script>
@endsection