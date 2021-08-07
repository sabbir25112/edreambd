<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::get('classrooms', 'ClassroomController@index')->name('classroom.index');
    Route::post('classrooms', 'ClassroomController@store')->name('classroom.store');
    Route::get('classrooms/create', 'ClassroomController@create')->name('classroom.create');
    Route::get('classrooms/join', 'ClassroomController@join')->name('classroom.join');
    Route::get('classrooms/as-student', 'ClassroomController@asStudent')->name('classroom.as.student');
    Route::post('classrooms/join', 'ClassroomController@requestJoin')->name('classroom.join.request');
    Route::get('classrooms/{classroom_id}', 'ClassroomController@show')->name('classroom.show');
    Route::post('classrooms/{classroom_id}', 'ClassroomController@update')->name('classroom.update');
    Route::get('classrooms/{classroom_id}/edit', 'ClassroomController@edit')->name('classroom.edit');
    Route::get('classrooms/{classroom_id}/add/student', 'ClassroomController@addStudent')->name('classroom.add.student');
    Route::post('classrooms/{classroom_id}/add', 'ClassroomController@storeStudent')->name('classroom.store.student');

    Route::get('join/request/sent', 'JoinRequestController@sent')->name('join.request.sent');
    Route::get('join/request/received', 'JoinRequestController@received')->name('join.request.received');
    Route::get('join/request/{join_request}/accept', 'JoinRequestController@accept')->name('join.request.accept');
    Route::get('join/request/{join_request}/reject', 'JoinRequestController@reject')->name('join.request.reject');

    Route::get('classroom-resource/{classroom_id}', 'ResourceController@classroom')->name('classroom.resource');
    Route::get('classroom-resource/{classroom_id}/add', 'ResourceController@add')->name('classroom.resource.add');
    Route::post('classroom-resource/{classroom_id}', 'ResourceController@store')->name('classroom.resource.store');

    Route::get('classroom-attendance/{classroom_id}', 'AttendanceController@index')->name('classroom.attendance');
});
