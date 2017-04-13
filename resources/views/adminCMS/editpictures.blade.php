@extends('adminCMS/app')

@section('content')

    @include('adminCMS.layouts.editElement',array('element'=>$picture, 'type'=>'picture'))

@endsection