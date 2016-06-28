@extends('backend.event.detail.base')

@section('form')
    {!! Form::open(array('action' => ['EventController@SectorsUpdate', $id], 'method' => 'POST')) !!}
    {!! Form::close() !!}
@endsection

@section('errors')
    @if(isset($reason))
        <i>{{$reason}}</i>
    @endif
@endsection

@section('dataType', 'Sector')
@section('dataTypes', 'Sectoren')