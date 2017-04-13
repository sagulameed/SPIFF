@extends('adminCMS/app')

@section('content')

    <div class="maincontentwrap">

        <div id="maincontent" class="maincontent clearfix">

            <div class="tab-bodycontent">

                    <div class="tabs-bodypane tabs-bodypane-largegutter" id="create-bodycontent"><!--templates/create.html--></div>

                    <div class="tabs-bodypane" id="products-bodycontent"><!--templates/products.html--></div>

                    <div class="tabs-bodypane" id="learn-bodycontent"></div>

                    <div class="tabs-bodypane" id="gallery-bodycontent"></div>

                    <div class="tabs-bodypane" id="users-bodycontent"></div>

            </div>

            <div class="selectmenuinfo" id="selectmenuinfo">

                <h1>Create section Content Management</h1>

                <p>Select a menu from the left panel</p>

            </div>

        </div>

    </div>

@endsection
