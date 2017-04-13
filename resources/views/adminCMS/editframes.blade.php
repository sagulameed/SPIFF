@extends('adminCMS/app')

@section('content')

    @include('adminCMS.layouts.editElement',array('element'=>$frame, 'type'=>'frame'))

@endsection