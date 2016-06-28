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

	Route::get('backend/login', ['as' => 'login', "uses" => "BackendController@Login"]);
	Route::post('backend/login', ['as' => 'login', 'before' => 'csrf', "uses" => "BackendController@LoginPost"]);
	Route::get('backend/logout', ['as' => 'logout', "uses" => "BackendController@Logout"]);

	Route::get('backend/events', ['as' => 'events', "uses" => "EventController@Events"]);
	Route::get('backend/event/new', ['as' => 'events_new', "uses" => "EventController@EventNew"]);
	Route::post('backend/event/new', ['as' => 'events_new', 'before' => 'csrf', "uses" => "EventController@EventNewPost"]);

	Route::get('backend/event/{id}/sectors', ['as' => 'events', "uses" => "EventController@Sectors"]);
	Route::post('backend/event/{id}/sectors', ['as' => 'events', 'before' => 'csrf', "uses" => "EventController@SectorsUpdate"]);

	Route::get('backend/event/{id}/timeslots', ['as' => 'events', "uses" => "EventController@Timeslots"]);
	Route::post('backend/event/{id}/timeslots', ['as' => 'events', 'before' => 'csrf', "uses" => "EventController@TimeslotsUpdate"]);

	Route::get('backend/event/{id}/options', ['as' => 'events', "uses" => "EventController@Options"]);
	Route::post('backend/event/{id}/options', ['as' => 'events', 'before' => 'csrf', "uses" => "EventController@OptionsUpdate"]);

	Route::get('backend/event/{id}', ['as' => 'event_overview', "uses" => "EventController@EventOverview"]);
	Route::get('backend/event/{id}/general', ['as' => 'event_general', "uses" => "EventController@EventGeneral"]);
	Route::post('backend/event/{id}/update', ['as' => 'event_update', "uses" => "EventController@EventUpdate"]);

	Route::get('backend/{rest1?}/{rest2?}/{rest3?}/{rest4?}', ['as' => 'redirect', function () {
		return redirect()->action('BackendController@Login');
	}]);
});