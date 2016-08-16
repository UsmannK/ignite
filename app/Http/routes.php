<?php

Route::auth();
Route::get('/', 'PageController@index');
Route::get('/dashboard', 'PageController@dashboard');
Route::get('rate/{id?}', 'PageController@showRate');
Route::post('submitRating', 'PageController@submitRating');
Route::get('applications', 'PageController@showApplications');
Route::get('settings', 'PageController@showSettings');
Route::get('settings/picture', 'PageController@showSettingsPicture');
Route::post('settings', 'PageController@submitSettings');

Route::get('interview/active/{id?}', 'PageController@showInterview');
Route::get('interview/view', 'PageController@showAllInterviews');
Route::post('applications/submitTimeSlot', 'PageController@submitTimeslot');
Route::post('interview/update', 'PageController@updateInterview');
Route::post('store', 'PageController@tempProfilePicStore');
Route::post('crop', 'PageController@cropPicture');

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
	Route::get('interview/create', 'PageController@showCreateInterview');
	Route::post('interview/create', 'PageController@submitCreateInterview');
	Route::get('import', 'PageController@importExcel');
});
Route::controller('datatables', 'PageController', [
    'getApplications'  => 'datatables.data'
]);