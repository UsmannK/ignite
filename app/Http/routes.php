<?php

Route::auth();

Route::get('/', 'PageController@index');
Route::get('calendar', 'PageController@calendar');

Route::get('/home', function () {return redirect()->action('PageController@dashboard');});

Route::get('/dashboard', 'PageController@dashboard');
Route::get('rate/{id?}', 'PageController@showRate');
Route::post('submitRating', 'PageController@submitRating');
Route::post('submitDecision', 'PageController@submitDecision');
Route::post('submitInterviewDecision', 'PageController@submitInterviewDecision');
Route::post('submitInterviewAttribute', 'PageController@submitInterviewAttribute');
Route::get('applications', 'PageController@showApplications');
Route::post('applications/submitTimeSlot', 'PageController@submitTimeslot');

Route::get('interview/view', 'PageController@showAllInterviews');
Route::post('interview/update', 'PageController@updateInterview');
Route::get('interview/sendInterviewTimes', 'PageController@sendInterviewTimes');

Route::get('settings', 'PageController@showSettings');
Route::get('settings/picture', 'PageController@showSettingsPicture');
Route::post('settings', 'PageController@submitSettings');
Route::post('store', 'PageController@tempProfilePicStore');
Route::post('crop', 'PageController@cropPicture');


Route::get('datatables', ['as' => 'datatables.data', 'uses' => 'PageController@getApplications']);

Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function() {
	Route::get('interview/create', 'PageController@showCreateInterview');
	Route::post('interview/create', 'PageController@submitCreateInterview');
	Route::get('import', 'PageController@importExcel');
});

Route::get('interview/active/{id?}', 'PageController@showInterview')->where('id', '(.*)');