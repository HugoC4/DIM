@extends('backend.event.new')

@section('nameValue',$request->input('name', ''))
@section('dateValue', $request->input('date', ''))
@section('locationValue', $request->input('location', ''))
@section('participantsValue', $request->input('participants', 0))
@section('entryStartValue', $request->input('entry_start', ''))
@section('entryEndValue', $request->input('entry_end', ''))
@section('choiceMinValue', $request->input('choice_min', 0))
@section('choiceMaxValue', $request->input('choice_max', 0))
@section('acceptsameValue', $request->input('choice_acceptsame', '') == true ? 'checked="checked"' : '')


@section('errors')
    <i>{{$reason}}</i>
@endsection