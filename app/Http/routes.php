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
Route::auth();
Route::get('/home', 'PageController@index');
Route::get('/', 'PageController@index');
Route::get('rate/{id?}', 'PageController@showRate');
Route::post('submitRating', 'PageController@submitRating');
Route::get('applications', 'PageController@showApplications');