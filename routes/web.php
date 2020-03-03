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

// pathology
    Route::get('/pathology', 'PatientController@pathology')->name('pathology');
    Route::get('/pathology/add', 'PatientController@create')->name('pathology.create');
    Route::post('/pathology/add', 'PatientController@store')->name('pathology.store');
    Route::get('pathology/{id}', 'PatientController@show')->name('pathology.show');
    Route::get('pathology/{id}/edit', 'PatientController@edit')->name('pathology.edit');
    Route::post('pathology/{id}/update', 'PatientController@update')->name('pathology.update');
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
