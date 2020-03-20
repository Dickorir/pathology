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

// cancer-records
    Route::get('/cancer-records', 'PatientController@cancerRecord')->name('cancerRecord');
    Route::get('/cancer-record/add', 'PatientController@create')->name('cancerRecord.create');
    Route::post('/cancer-record/add', 'PatientController@store')->name('cancerRecord.store');
    Route::get('cancer-record/{id}', 'PatientController@show')->name('cancerRecord.show');
    Route::get('cancer-record/{id}/edit', 'PatientController@edit')->name('cancerRecord.edit');
    Route::post('cancer-record/{id}/update', 'PatientController@update')->name('cancerRecord.update');
});

Route::get('logActivity', 'HomeController@logActivity');


// students
Route::get('/students', 'StudentController@index')->name('students');
Route::get('/student/add', 'StudentController@create')->name('student.create');
Route::post('/student/add', 'StudentController@store')->name('student.store');
Route::get('student/{admin}/edit', 'StudentController@edit')->name('student.edit');
Route::post('student/update', 'StudentController@create')->name('student.update');
Route::get('student/{admin}/delete', 'StudentController@delete')->name('student.delete');


// marks
Route::get('/marks', 'StudentMarksController@index')->name('marks');
Route::get('/mark/add', 'StudentMarksController@create')->name('mark.create');
Route::post('/mark/add', 'StudentMarksController@store')->name('mark.store');
Route::get('mark/{admin}/edit', 'StudentMarksController@edit')->name('mark.edit');
Route::post('mark/{admin}/update', 'StudentMarksController@update')->name('mark.update');
Route::get('mark/{admin}/delete', 'StudentMarksController@delete')->name('mark.delete');
Route::any('mark/search', 'StudentMarksController@search')->name('mark.search');
Route::any('mark/add/select', 'StudentMarksController@create')->name('student.select');
