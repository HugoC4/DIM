@extends('layouts.dashboard')

@section("pageTitle", $event['event_name'])
@section("pageSubTitle", $event['event_date']->format("d-m-Y"))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Algemene informatie</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    {!! Form::open(array('action' => ['EventController@EventUpdate', $id], 'method' => 'POST')) !!}
                    <div class="col-md-6">
                        <span class="control-label">Evenement naam/titel</span>
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" value="@yield('nameValue', $event['event_name'])" required>
                        </div>
                        <span class="control-label">Datum van evenement</span>
                        <div class="form-group">
                            <input type="date" name="date" class="form-control" value="@yield('dateValue', $event['event_date']->format("d-m-Y"))" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="control-label">Evenement (hoofd)locatie</span>
                        <div class="form-group">
                            <input type="text" name="location" class="form-control" value="@yield('locationValue', $event['event_location'])" required>
                        </div>
                        <span class="control-label">Maximaal aantal deelnemers*</span>
                        <div class="form-group">
                            <input type="number" name="participants" class="form-control" min="0" max="99999" value="@yield('participantsValue', $event['event_participants_max'])" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="control-label">Begin inschrijfperiode</span>
                        <div class="form-group">
                            <input type="date" name="entry_start" class="form-control" value="@yield('entryStartValue', $event['event_signup_start']->format("d-m-Y"))" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="control-label">Eind inschrijfperiode</span>
                        <div class="form-group">
                            <input type="date" name="entry_end" class="form-control" value="@yield('entryEndValue', $event['event_signup_end']->format("d-m-Y"))" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="control-label">Minimaal aantal keuzes*</span>
                        <div class="form-group">
                            <input type="number" name="choice_min" class="form-control" min="0" max="99999" value="@yield('choiceMinValue', $event['event_choices_min'])" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="control-label">Maximaal aantal keuzes*</span>
                        <div class="form-group">
                            <input type="number" name="choice_max" class="form-control" min="0" max="99999" value="@yield('choiceMaxValue', $event['event_choices_max'])" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="choice_acceptsame" @yield('acceptsameValue', $event['event_choices_multiple'] == 1 ? "checked='checked'" : "")> Meerdere keer dezelfde keuze toestaan
                                </label>
                            </div>
                        </div>
                    </div>
                    @yield('errors', '')
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Update!</button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <!-- ./box-body -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection