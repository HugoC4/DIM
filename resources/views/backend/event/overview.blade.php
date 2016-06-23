@extends('layouts.dashboard')

@section("pageTitle", $eventName)
@section("pageSubTitle", $eventDate->format("d-m-Y"))

@section('menu')
    @include('backend.event.menu')
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Inschrijvingen</span>
                    <span class="info-box-number">0/{{$eventParticipantsMax}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-bar-chart"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Keuzemomenten</span>
                    <span class="info-box-number">0/X</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
@endsection