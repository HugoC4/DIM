<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function login()
    {
        if($this->_auth()) return $this->_redevt();
        return view('backend.login');
    }
	
	public function loginPost(Request $request) {
        if($this->_auth()) return $this->_redevt();
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
        return redirect()->action('EventController@Events');
	}

    public function Logout() {
        if(!$this->_auth()) return $this->_redlog();
        session_unset();
        session_destroy();
        return redirect()->action("BackendController@Login");
    }
}