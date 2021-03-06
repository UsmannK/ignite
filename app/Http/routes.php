<?php

Route::auth();

// SPA Routes
Route::get('/', 'PageController@index');
Route::get('calendar', 'PageController@calendar');
Route::get('/home', function () {return redirect()->action('PageController@dashboard');});

// User Routes
Route::get('/dashboard', 'PageController@dashboard');
Route::get('community', 'PageController@showCommunity');
Route::get('settings', 'PageController@showSettings');
Route::get('settings/picture', 'PageController@showSettingsPicture');
Route::post('settings', 'PageController@submitSettings');
Route::post('store', 'PageController@tempProfilePicStore');
Route::post('crop', 'PageController@cropPicture');


Route::get('datatables', ['as' => 'datatables.data', 'uses' => 'PageController@getApplications']);

// Admin Routes
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
	Route::get('interview/create', 'PageController@showCreateInterview');
	Route::post('interview/create', 'PageController@submitCreateInterview');
	Route::get('import', 'PageController@importExcel');
	Route::get('interview/sendInterviewTimes', 'PageController@sendInterviewTimes');
	Route::post('submitDecision', 'PageController@submitDecision');
	Route::post('applications/submitTimeSlot', 'PageController@submitTimeslot');
});

// Mentor or Admin Routes
Route::group(['prefix' => 'mentor', 'middleware' => ['role:admin|mentor', 'phase:1']], function() {
	Route::get('rate/{id?}', 'PageController@showRate');
	Route::post('submitRating', 'PageController@submitRating');
	Route::post('submitInterviewDecision', 'PageController@submitInterviewDecision');
	Route::post('submitInterviewAttribute', 'PageController@submitInterviewAttribute');
	Route::get('applications', 'PageController@showApplications');
	Route::get('interview/view', 'PageController@showAllInterviews');
	Route::post('interview/update', 'PageController@updateInterview');
	Route::get('interview/active/{id?}', 'PageController@showInterview')->where('id', '(.*)');
});
