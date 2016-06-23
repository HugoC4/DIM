@extends('backend.login')

@section('emailValue', $email)
@section('passwordValue', $password)
@section('errors')
<i>{{$reason}}</i>
@endsection