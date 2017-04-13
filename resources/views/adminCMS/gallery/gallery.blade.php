@extends('adminCMS.app')

@section('content')

    <div class="maincontentwrap">

        <div class="leftmenu-tabpane leftmenu-tabpanelarge active" >

            <div class="tab-bodycontent">
                <div class="tabs-bodypane tabs-bodypane-largegutter active" id="create-bodycontent">
                    <div class="contentHeader">
                        <div class="row">
                            <div class="col-sm-6">
                                <h1>Users Shares</h1>
                            </div>
                            <div class="col-sm-6">
                                @if(Session::has('status'))
                                    @if(Session::get('status'))
                                        <div class="alert alert-success pull-right" role="alert"  >
                                            <strong>{{ Session::get('mess')}}</strong><img src="{{asset('img/check.png')}}" width="30px" alt="">
                                        </div>
                                    @else
                                        <div class="alert alert-danger pull-right" role="alert" >
                                            {{ Session::get('mess')}}
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="contentBody contentBodycustomscroll" >
                        <div class="contentBodycustomscroll-inner" style="margin-top: 10px; padding-top: 1px;">

                            @foreach( $shares as $share)
                                <div class="col-sm-3">
                                    <div class="imagebox-wrap">
                                        <div class="imagebox-title text-uppercase" style="font-size: 16px;"> {{strtoupper($share->design->name)}}</div>
                                        <div class="imagebox-title" style="font-size: 16px;">{{strtoupper($share->design->user->name)}} </div>
                                        <div class="imagebox-inner">
                                            <img src="{{$share->design->layouts[0]->canvas_thumbnail}}"  style="object-fit: contain; width: 100%; height: 200px;"/>
                                            <form class="deleteForm{{$share->id}}" action="{{route('videos.destroy',['id'=>$share->id])}}" method="POST">
                                                {{ method_field('DELETE') }}
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            </form>
                                            <a class="imagebox-footer" href="" style="bottom: 40%;    opacity: .8;" data-toggle="modal" data-target="#checkPostModal{{$share->id}}">
                                                CHECK POST
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                @include('adminCMS.modals.checkpost',['share'=>$share])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


@endsection
@section('javascript')
        <script>
            $('form').submit(function(event){
                event.preventDefault()
                var btn = $(document.activeElement);
                var status = btn.data('optionaproved')
                var statusAproveBtn = btn.siblings('input[name="statusAprove"]')
                statusAproveBtn.val(status)
                $(this)[0].submit();

            })
        </script>
@endsection