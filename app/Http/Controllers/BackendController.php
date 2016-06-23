<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Faker\Provider\zh_CN\DateTime;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function login()
    {
        return view('backend.login');
    }
	
	public function loginPost(Request $request) {
		$email = trim($request->input('email', ''));
        $password = $request->input('password', '');
        $err = view('backend.loginfail', ['email' => $email, 'password' => $password, 'reason' => 'Incorrecte inloggegevens gegeven.']);

        if(empty($email) || empty($password))
            return $err;

        $password = hash('sha256', $password);

        $res = $this->query("SELECT admin_id FROM `admin` WHERE admin_email=? AND admin_password=?", [$email, $password]);

        if(count($res) !== 1) // User/password combo doesn't exist
            return $err;

        $_SESSION['admin_id'] = $res[0]["admin_id"];
        return redirect()->route('backend::dashboard');
	}

    public function dashboard() {
        $res = $this->query("SELECT event_id, event_name, event_location FROM `event` ORDER BY event_signup_end ASC");

        return view('backend.dashboard.menu', ["events" => $res]);
    }

    public function eventOverview($id) {
        echo 1;
    }

    public function eventNew() {
        return view("backend.event.new");
    }

    public function eventNewPost(Request $request) {
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

        return redirect()->action("BackendController@EventOverview", ['id' => $success]);
    }
}