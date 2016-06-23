<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['as' => 'backend::'], function () {
	if(!isset($_SESSION["admin_id"])) {
		Route::get('backend/login', ['as' => 'login', "uses" => "BackendController@Login"]);
		Route::post('backend/login', ['as' => 'login', 'before' => 'csrf', "uses" => "BackendController@LoginPost"]);
		Route::get('backend/{rest?}', ['as' => 'redirect', function () {
			return redirect()->route('backend::login');
		}]);
		Route::get('backend/dashboard', ['as' => 'dashboard', "uses" => "BackendController@Dashboard"]);
		return;
	}
	Route::get('backend/events', ['as' => 'dashboard', "uses" => "EventController@Events"]);
	Route::get('backend/event/new', ['as' => 'dashboard', "uses" => "EventController@EventNew"]);
	Route::post('backend/event/new', ['as' => 'dashboard', 'before' => 'csrf', "uses" => "EventController@EventNewPost"]);
	Route::get('backend/event/{id}', ['as' => 'dashboard', "uses" => "EventController@EventOverview"]);
});