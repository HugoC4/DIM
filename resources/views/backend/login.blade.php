@extends('layouts.base')

@section('title', 'Login')
@section('bodyClasses', 'hold-transition login-page')
@section('layout')
    <div class="login-box">
        <div class="login-logo">
            <b>DIM</b>
            <br>
            <i class="subTitle">Da Vinci's Inschrijvingen Manager</i>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            {!! Form::open(array('action' => 'BackendController@LoginPost', 'method' => 'POST')) !!}
                <div class="form-group has-feedback">
                    <input type="email" name="email" class="form-control" placeholder="E-mail" value="@yield('emailValue', '')">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" class="form-control" placeholder="Password" value="@yield('passwordValue', '')">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        @yield('errors', '')
                    </div>
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

@endsection