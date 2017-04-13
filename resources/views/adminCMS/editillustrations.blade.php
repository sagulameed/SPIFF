@extends('adminCMS/app')

@section('content')

    @include('adminCMS.layouts.editElement',array('element'=>$illustration, 'type'=>'illustration'))

@endsection