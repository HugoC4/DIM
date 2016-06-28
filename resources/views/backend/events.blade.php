@extends('layouts.base')

@section('title', 'Dashboard')
@section('bodyClasses', 'hold-transition login-page')
@section('layout')
    <div class="logout">
        <a href="{!! action("BackendController@Logout", []) !!}">
            Logout <i class="fa fa-sign-out"></i>
        </a>
    </div>
    <div class="login-box">
        <div class="login-logo">
            <b>Evenementen</b>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Kies een evenement of creeër een nieuwe</p>
            <div class="form-group text-center">
                @foreach($events as $k => $v)
                    {!! link_to_action('EventController@EventOverview', $title = "{$v['event_name']} ({$v['event_location']})", $parameters = array('id' => $v['event_id'])) !!}
                    <br>
                @endforeach
                <button type="button" onclick="window.location = '{!! action('EventController@EventNew', []) !!}'" class="btn btn-primary btn-block btn-flat">Creëer nieuw evenement</button>
            </div>
        </div>
    </div>

@endsection