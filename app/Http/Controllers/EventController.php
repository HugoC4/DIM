<?php

namespace App\Http\Controllers;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class EventController extends Controller
{
    public function events() {
        if(!$this->_auth()) return $this->_redlog();
        $res = $this->query("SELECT event_id, event_name, event_location FROM `event` ORDER BY event_signup_end ASC");

        return view('backend.events', ["events" => $res]);
    }

    public function eventOverview($id) {
        if(!$this->_auth()) return $this->_redlog();
        $res = $this->query("SELECT * FROM `event` WHERE event_id=?", [$id]);
        $res2 = $this->query("SELECT timeslot_id, timeslot_name FROM timeslot WHERE timeslot_event_id=?", [$id]);
        $res3 = $this->query("SELECT option_id, option_name FROM `option` WHERE option_event_id=?", [$id]);
        $res4 = $this->query("SELECT sector_id, sector_name FROM sector WHERE sector_event_id=?", [$id]);

        if($res === false || count($res) !== 1 || $res2 === false || $res3 === false || $res4 === false)
            return redirect()->action("EventController@Events");

        $event = $res[0];
        $event['event_date'] = \DateTime::createFromFormat("Y-m-d H:i:s", $event['event_date']);
        $event['event_signup_start'] = \DateTime::createFromFormat("Y-m-d H:i:s", $event['event_signup_start']);
        $event['event_signup_end'] = \DateTime::createFromFormat("Y-m-d H:i:s", $event['event_signup_end']);

        $timeslots = [];
        foreach($res2 as $kv)
            $timeslots[$kv['timeslot_id']] = $kv['timeslot_name'];


        $options = [];
        foreach($res3 as $kv)
            $options[$kv['option_id']] = $kv['option_name'];


        $sectors = [];
        foreach($res4 as $kv)
            $sectors[$kv['sector_id']] = $kv['sector_name'];
        return view("backend.event.overview", [
            'id' => $id,
            'event' => $event,
            'timeslots' => $timeslots,
            'options' => $options,
            'sectors' => $sectors
        ]);
    }

    public function EventGeneral($id) {
        if(!$this->_auth()) return $this->_redlog();
        $res = $this->query("SELECT * FROM `event` WHERE event_id=?", [$id]);

        if($res === false || count($res) !== 1)
            return redirect()->action("EventController@Events");

        $event = $res[0];
        $event['event_date'] = \DateTime::createFromFormat("Y-m-d H:i:s", $event['event_date']);
        $event['event_signup_start'] = \DateTime::createFromFormat("Y-m-d H:i:s", $event['event_signup_start']);
        $event['event_signup_end'] = \DateTime::createFromFormat("Y-m-d H:i:s", $event['event_signup_end']);
        return view("backend.event.general", [
            'id' => $id,
            'event' => $event
        ]);
    }

    public function eventNew() {
        if(!$this->_auth()) return $this->_redlog();
        return view("backend.event.new");
    }

    public function eventUpdate($id, Request $request) {
        if(!$this->_auth()) return $this->_redlog();
        $res = $this->query("SELECT * FROM `event` WHERE event_id=?", [$id]);

        if($res === false || count($res) !== 1)
            return redirect()->action("EventController@Events");

        $event = $res[0];
        $event['event_date'] = \DateTime::createFromFormat("Y-m-d H:i:s", $event['event_date']);
        $event['event_signup_start'] = \DateTime::createFromFormat("Y-m-d H:i:s", $event['event_signup_start']);
        $event['event_signup_end'] = \DateTime::createFromFormat("Y-m-d H:i:s", $event['event_signup_end']);
        $params = [
            'name', 'location',
            'date', 'participants',
            'entry_start', 'entry_end',
            'choice_min', 'choice_max',
            'choice_acceptsame'
        ];

        $dates = [
            'date' => $request->input('date', ''),
            'entry_start' => $request->input('entry_start', ''),
            'entry_end' => $request->input('entry_end', '')
        ];

        $numbers = [
            'participants' => $request->input('participants', ''),
            'choice_min' => $request->input('choice_min', ''),
            'choice_max' => $request->input('choice_max', ''),
        ];

        foreach($params as $param)
            if(!$request->has($param) && !empty(trim($request->input($param))))
                return view('backend.event.updatefail', ['id' => $id, 'reason' => 'Vul a.u.b. alle velden in.', 'request' => $request, "event" => $event]);

        foreach($dates as $k => $v) {
            try {
                $date = \DateTime::createFromFormat('d-m-Y', $v);
                if($date === false)
                    return view('backend.event.updatefail', ['id' => $id, 'reason' => 'De datum velden zijn in een incorrect formaat.', 'request' => $request, "event" => $event]);

                $dates[$k] = $date;
            }
            catch (\Exception $e){
                return view('backend.event.updatefail', ['id' => $id, 'reason' => 'Er is een fout opgetreden bij het omzetten van de datums.', 'request' => $request, "event" => $event]);
            }
        }

        foreach($numbers as $k => $v) {
            try {
                $num = filter_var($v, FILTER_VALIDATE_INT);
                if($num === false)
                    return view('backend.event.updatefail', ['id' => $id, 'reason' => 'De nummer velden zijn geen gehele getallen.', 'request' => $request, "event" => $event]);
                $numbers[$k] = $num;
            }
            catch (\Exception $e){
                return view('backend.event.updatefail', ['id' => $id, 'reason' => 'Er is een fout opgetreden bij het omzetten van de nummers.', 'request' => $request, "event" => $event]);
            }
        }

        $success = $this->update("UPDATE `event` SET `event_name`=?, `event_location`=?, `event_signup_start`=?, `event_signup_end`=?, `event_date`=?, `event_choices_min`=?, `event_choices_max`=?, `event_participants_max`=?, `event_choices_multiple`=? WHERE `event_id`=?", [
            trim($request->input('name')),
            trim($request->input('location')),
            $dates["entry_start"]->format("Y-m-d"),
            $dates["entry_end"]->format("Y-m-d"),
            $dates["date"]->format("Y-m-d"),
            $numbers["choice_min"],
            $numbers["choice_max"],
            $numbers["participants"],
            $request->input('choice_acceptsame') == true ? 1 : 0,
            $id
        ]);

        if($success === false)
            return view('backend.event.updatefail', ['id' => $id, 'reason' => 'Er is een onbekende fout opgetreden bij het creëeren van een nieuw evenement.', 'request' => $request, "event" => $event]);

        return redirect()->action("EventController@EventOverview", ['id' => $id]);
    }

    public function eventNewPost(Request $request) {
        if(!$this->_auth()) return $this->_redlog();
        $params = [
            'name', 'location',
            'date', 'participants',
            'entry_start', 'entry_end',
            'choice_min', 'choice_max',
            'choice_acceptsame'
        ];

        $dates = [
            'date' => $request->input('date', ''),
            'entry_start' => $request->input('entry_start', ''),
            'entry_end' => $request->input('entry_end', '')
        ];

        $numbers = [
            'participants' => $request->input('participants', ''),
            'choice_min' => $request->input('choice_min', ''),
            'choice_max' => $request->input('choice_max', ''),
        ];

        foreach($params as $param)
            if(!$request->has($param) && !empty(trim($request->input($param))))
                return view('backend.event.newfail', ['reason' => 'Vul a.u.b. alle velden in.', 'request' => $request]);

        foreach($dates as $k => $v) {
            try {
                $date = \DateTime::createFromFormat('d-m-Y', $v);
                if($date === false)
                    return view('backend.event.newfail', ['reason' => 'De datum velden zijn in een incorrect formaat.', 'request' => $request]);

                $dates[$k] = $date;
            }
            catch (\Exception $e){
                return view('backend.event.newfail', ['reason' => 'Er is een fout opgetreden bij het omzetten van de datums.', 'request' => $request]);
            }
        }

        foreach($numbers as $k => $v) {
            try {
                $num = filter_var($v, FILTER_VALIDATE_INT);
                if($num === false)
                    return view('backend.event.newfail', ['reason' => 'De nummer velden zijn geen gehele getallen.', 'request' => $request]);
                $numbers[$k] = $num;
            }
            catch (\Exception $e){
                return view('backend.event.newfail', ['reason' => 'Er is een fout opgetreden bij het omzetten van de nummers.', 'request' => $request]);
            }
        }

        $success = $this->insert("INSERT INTO `event` (`event_id`, `event_name`, `event_location`, `event_signup_start`, `event_signup_end`, `event_date`, `event_choices_min`, `event_choices_max`, `event_participants_max`, `event_choices_multiple`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            null,
            trim($request->input('name')),
            trim($request->input('location')),
            $dates["entry_start"]->format("Y-m-d"),
            $dates["entry_end"]->format("Y-m-d"),
            $dates["date"]->format("Y-m-d"),
            $numbers["choice_min"],
            $numbers["choice_max"],
            $numbers["participants"],
            $request->input('choice_acceptsame') == true ? 1 : 0
        ]);

        if($success === false)
            return view('backend.event.newfail', ['reason' => 'Er is een onbekende fout opgetreden bij het creëeren van een nieuw evenement.', 'request' => $request]);

        return redirect()->action("EventController@EventOverview", ['id' => $success]);
    }

    public function sectors($id) {
        if(!$this->_auth()) return $this->_redlog();
        $data = $this->query("select sector_id, sector_name, sector_limit from sector where sector_event_id=?", [$id]);
        if($data === false)
            return redirect()->action("EventController@EventOverview", [$id]);
        $rows = [];
        foreach($data as $kv)
            $rows[] = [$kv['sector_id'], $kv['sector_name'], $kv['sector_limit']];
        return view("backend.event.detail.sectors", ['id'=>$id, 'data' => $rows, 'hasLimit' => false]);
    }

    public function sectorsUpdate($id, Request $request) {
        if(!$this->_auth()) return $this->_redlog();
        return $this->updateData($id, $request->input("data", '[]'), 'sector', false);
    }

    public function timeslots($id) {
        if(!$this->_auth()) return $this->_redlog();
        $data = $this->query("select timeslot_id, timeslot_name, timeslot_limit from timeslot where timeslot_event_id=?", [$id]);
        if($data === false)
            return redirect()->action("EventController@EventOverview", [$id]);
        $rows = [];
        foreach($data as $kv)
            $rows[] = [$kv['timeslot_id'], $kv['timeslot_name'], $kv['timeslot_limit']];
        return view("backend.event.detail.timeslots", ['id'=>$id, 'data' => $rows, 'hasLimit' => true]);
    }

    public function timeslotsUpdate($id, Request $request) {
        if(!$this->_auth()) return $this->_redlog();
        return $this->updateData($id, $request->input("data", '[]'), 'timeslot', true);
    }

    public function options($id) {
        if(!$this->_auth()) return $this->_redlog();
        $data = $this->query("select option_id,  option_name, option_limit from `option` where option_event_id=?", [$id]);
        if($data === false)
            return redirect()->action("EventController@EventOverview", [$id]);
        $rows = [];
        foreach($data as $kv)
            $rows[] = [$kv['option_id'], $kv['option_name'], $kv['option_limit']];
        return view("backend.event.detail.options", ['id'=>$id, 'data' => $rows, 'hasLimit' => true]);
    }

    public function optionsUpdate($id, Request $request) {
        if(!$this->_auth()) return $this->_redlog();
        return $this->updateData($id, $request->input("data", '[]'), 'option', true);
    }

    private function updateData($id, $data, $type) {
        if(!$this->_auth()) return $this->_redlog();
        $existingIds = [];
        try {
            $data = json_decode($data, false);
            $res = $this->query("select {$type}_id from `{$type}` where {$type}_event_id=?", [$id]);
            if($res === false || $data === null)
                return view("backend.event.detail.{$type}s", ['id' => $id, 'data' => $data, 'reason' => "Er is een onbekende fout opgetreden!", 'hasLimit' => $hasLimit]);

            foreach($res as $v)
                $existingIds[] = $v["{$type}_id"];
        }
        catch(Exception $e) {
            return view("backend.event.detail.{$type}s", ['id' => $id, 'data' => $data, 'reason' => "Er is een onbekende fout opgetreden!", 'hasLimit' => $hasLimit]);
        }

        foreach($data as $kv) {
            if($kv[0] === null) {
                $this->insert("insert into `{$type}` ({$type}_name, {$type}_limit, {$type}_event_id) VALUES(?,?,?)",[$kv[1], $kv[2], $id]);
            }
            else if(in_array($kv[0], $existingIds, false)) {
                foreach($existingIds as $k => $v)
                    if($v == $kv[0])
                        unset($existingIds[$k]);
                $this->insert("UPDATE `{$type}` SET {$type}_name = ?, {$type}_limit=? where {$type}_id=?",[$kv[1], $kv[2], $kv[0]]);
            }
        }

        foreach($existingIds as $v) {
            $this->delete("DELETE FROM `{$type}` WHERE {$type}_id=?", [$v]);
        }

        return redirect()->action("EventController@EventOverview", [$id]);
    }

}