@extends('layouts.base')

@section('title', 'Dashboard')
@section('bodyClasses', 'hold-transition login-page')
@section('layout')
    <div class="login-box">
        <div class="login-logo">
            <b>DIM</b>
            <br>
            <i class="subTitle">Da Vinci's Inschrijvingen Manager</i>
        </div>
        <div class="login-box-body">
            @if(empty($events))
                <p class="login-box-msg">Er zijn op het moment geen evenementen om je voor in te schrijven.</p>
            @else
                <p class="login-box-msg">Kies een evenement om je voor in te schrijven.</p>
                <div class="form-group text-center">
                    @foreach($events as $k => $v)
                        {!! link_to_action('FrontEndController@SignUp', $title = "{$v['event_name']} ({$v['event_location']})", $parameters = array('id' => $v['event_id'])) !!}
                        <br>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection