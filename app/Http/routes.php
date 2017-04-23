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

// route to show the login form
Route::get('login', array('uses' => 'HomeController@showLogin'));

// route to process the form
Route::post('login', array('uses' => 'HomeController@doLogin'));

// route to show the signup form
Route::get('signup', array('uses' => 'HomeController@showsignup'));

// route to show the signup form
Route::post('signup', array('uses' => 'HomeController@dosignup'));

// route to logout form dashboard
Route::get('logout', array('uses' => 'HomeController@dologout'));

// route to show archived contacts
Route::get('archived', array('uses' => 'DashboardController@archived'));

 // route to show the dashboard
Route::resource('dashboard', 'DashboardController');
