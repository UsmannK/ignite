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
Route::get('/', 'PageController@index');
Route::get('/dashboard', 'PageController@dashboard');
Route::get('rate/{id?}', 'PageController@showRate');
Route::post('submitRating', 'PageController@submitRating');
Route::get('applications', 'PageController@showApplications');
Route::get('settings', 'PageController@showSettings');
Route::post('settings', 'PageController@submitSettings');
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
	Route::get('import', 'PageController@importExcel');
});
Route::controller('datatables', 'PageController', [
    'getApplications'  => 'datatables.data'
]);