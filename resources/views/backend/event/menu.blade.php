<?php $action = substr(Route::getCurrentRoute()->getActionName(), strpos(Route::getCurrentRoute()->getActionName(), "@")+1) ?>
<li {!! $action == "EventOverview" ?  'class="active"' : ""!!}>
    <a href="{!! action("EventController@EventOverview", ['id' => $id]) !!}">
        <i class="fa fa-line-chart"></i> <span>Overzicht</span>
    </a>
</li>
<li {!! $action == "EventGeneral" || $action == "EventUpdate" ?  'class="active"' : "" !!}>
    <a href="{!! action("EventController@EventGeneral", ['id' => $id]) !!}">
        <i class="fa fa-bars"></i> <span>Algemene informatie</span>
    </a>
</li>
<li {!! $action == "Options" || $action == "OptionsUpdate" ?  'class="active"' : "" !!}>
    <a href="{!! action("EventController@Options", ['id' => $id]) !!}">
        <i class="fa fa-hand-pointer-o"></i> <span>Onderdelen</span>
    </a>
</li>
<li  {!! $action == "Timeslots" || $action == "TimeslotsUpdate" ?  'class="active"' : "" !!}>
    <a href="{!! action("EventController@Timeslots", ['id' => $id]) !!}">
        <i class="fa fa-clock-o"></i> <span>Keuzemomenten</span>
    </a>
</li>
<li  {!! $action == "Sectors" || $action == "SectorsUpdate" ?  'class="active"' : "" !!}>
    <a href="{!! action("EventController@Sectors", ['id' => $id]) !!}">
        <i class="fa fa-building-o"></i> <span>Sectoren</span>
    </a>
</li>