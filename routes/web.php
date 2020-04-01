<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

Route::get('/', function () {
    return view('auth.getotp');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/getlogin', 'UserController@getlogin')->name('get_otp');
Route::post('/getlogin', 'UserController@get_otp')->name('get_otp');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('products','ProductController');

// patients
    Route::get('/patients', 'PatientController@index')->name('patients');

// reports routes
    Route::get('/general-report', 'ReportController@generalReport')->name('generalReport');
    Route::get('/general-year-total-pple/{id}', 'ReportController@generalYearTotal');
    Route::get('/general-graph/{id}', 'ReportController@generalGraph')->name('generalGraph');
    Route::get('/general-graph', 'ReportController@generalGraph')->name('generalGraph1');
    Route::post('/general-graph', 'ReportController@generalGraphPost')->name('generalGraph1');
    Route::get('/general-people-year', 'ReportController@peopleYear')->name('peopleYear');
    Route::get('/general-people-year-graph', 'ReportController@peopleYearGraph')->name('peopleYearGraph');
    Route::get('/general-people-year-all', 'ReportController@peopleYearAll')->name('peopleYearAll');
    Route::any('/cancer/year', 'ReportController@cancerYear')->name('cancerYear');

// cancer-records
    Route::get('/cancer-records', 'PatientController@cancerRecord')->name('cancerRecord');
    Route::get('/cancer-record/add', 'PatientController@create')->name('cancerRecord.create');
    Route::post('/cancer-record/add', 'PatientController@store')->name('cancerRecord.store');
    Route::get('cancer-record/{id}', 'PatientController@show')->name('cancerRecord.show');
    Route::get('cancer-record/{id}/edit', 'PatientController@edit')->name('cancerRecord.edit');
    Route::post('cancer-record/{id}/update', 'PatientController@update')->name('cancerRecord.update');
    Route::get('cancer-record/{id}/delete', 'PatientController@destroy')->name('cancerRecord.delete');
});

Route::get('logActivity', 'HomeController@logActivity');
