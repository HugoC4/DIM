<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function events()
    {
        $res = $this->query("SELECT event_id, event_name, event_location FROM `event` WHERE event_signup_end > NOW() AND event_signup_start < NOW() ORDER BY event_signup_end ASC");

        return view('frontend.events', ["events" => $res]);
    }

    public function signUp($id) {
        $res = $this->query("SELECT * from `event` WHERE event_signup_end > NOW() AND event_signup_start < NOW() AND event_id=?", [$id]);
        if($res === false || empty($res))
            return redirect()->action("FrontEndController@Events");

        $resSectors = $this->query("SELECT * from `sector` WHERE sector_event_id=?", [$id]);
        $resTimeslots = $this->query("SELECT * from `timeslot` WHERE timeslot_event_id=?", [$id]);
        $resOptions = $this->query("SELECT * from `option` WHERE option_event_id=?", [$id]);

        if($resSectors === false || $resTimeslots === false || $resOptions === false)
            return redirect()->action("FrontEndController@Events");

        return view('frontend.signup', ["id" => $id, 'event' => $res, 'sectors' => $resSectors, 'options' => $resOptions, 'timeslots' => $resTimeslots]);
    }

    public function singUpPost($id, Request $request) {

    }
}