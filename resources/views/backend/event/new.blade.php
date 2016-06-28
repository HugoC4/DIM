@extends('layouts.base')

@section('title', 'Dashboard')
@section('bodyClasses', 'hold-transition login-page')
@section('layout')
    <div class="login-box event-new-box">
        <div class="login-logo">
            <b>Nieuw evenement</b>
        </div>
        <div class="login-box-body">
            {!! Form::open(array('action' => 'EventController@EventNewPost', 'method' => 'POST')) !!}
                <div class="col-md-6">
                    <span class="control-label">Evenement naam/titel</span>
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" value="@yield('nameValue','')" required>
                    </div>
                    <span class="control-label">Datum van evenement</span>
                    <div class="form-group">
                        <input type="date" name="date" class="form-control" value="@yield('dateValue','')" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="control-label">Evenement (hoofd)locatie</span>
                    <div class="form-group">
                        <input type="text" name="location" class="form-control" value="@yield('locationValue','')" required>
                    </div>
                    <span class="control-label">Maximaal aantal deelnemers*</span>
                    <div class="form-group">
                        <input type="number" name="participants" class="form-control" min="0" max="99999" value="@yield('participantsValue',0)" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="control-label">Begin inschrijfperiode</span>
                    <div class="form-group">
                        <input type="date" name="entry_start" class="form-control" value="@yield('entryStartValue','')" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="control-label">Eind inschrijfperiode</span>
                    <div class="form-group">
                        <input type="date" name="entry_end" class="form-control" value="@yield('entryEndValue','')" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="control-label">Minimaal aantal keuzes*</span>
                    <div class="form-group">
                        <input type="number" name="choice_min" class="form-control" min="0" max="99999" value="@yield('choiceMinValue',0)" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <span class="control-label">Maximaal aantal keuzes*</span>
                    <div class="form-group">
                        <input type="number" name="choice_max" class="form-control" min="0" max="99999" value="@yield('choiceMaxValue',0)" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" name="choice_acceptsame" @yield('acceptsameValue', 'checked="checked"')> Meerdere keer dezelfde keuze toestaan
                            </label>
                        </div>
                    </div>
                </div>
                @yield('errors', '')
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Creëer!</button>
                </div>
            {!! Form::close() !!}
            <div class="clearfix"></div>
            <br>
            <small><i>* Bij 0 betekent dit ongelimiteerd</i></small>
        </div>
    </div>

@endsection