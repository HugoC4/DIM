@extends('backend.event.detail.base')
@section('form')
    {!! Form::open(array('action' => ['EventController@OptionsUpdate', $id], 'method' => 'POST')) !!}
    {!! Form::close() !!}
@endsection
@section('dataType', 'Onderdeel')
@section('dataTypes', 'Onderdelen')