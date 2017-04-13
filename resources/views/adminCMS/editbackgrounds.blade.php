@extends('adminCMS/app')

@section('content')

    @include('adminCMS.layouts.editElement',array('element'=>$background, 'type'=>'background'))

@endsection