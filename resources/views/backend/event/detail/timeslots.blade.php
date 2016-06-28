@extends('backend.event.detail.base')
@section('form')
    {!! Form::open(array('action' => ['EventController@TimeslotsUpdate', $id], 'method' => 'POST')) !!}
    {!! Form::close() !!}
@endsection
@section('dataType', 'Keuzemoment')
@section('dataTypes', 'Keuzemomenten')