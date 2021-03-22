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
    Route::post('classrooms/join', 'ClassroomController@requestJoin')->name('classroom.join.request');
    Route::get('classrooms/{classroom_id}', 'ClassroomController@show')->name('classroom.show');

    Route::get('join/request/sent', 'JoinRequestController@index')->name('join.request.sent');
    Route::get('join/request/received', 'JoinRequestController@received')->name('join.request.received');
});
