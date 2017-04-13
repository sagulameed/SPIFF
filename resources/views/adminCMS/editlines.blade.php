@extends('adminCMS/app')

@section('content')

    @include('adminCMS.layouts.editElement',array('element'=>$line, 'type'=>'line'))

@endsection