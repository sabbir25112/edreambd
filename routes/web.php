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

    Route::get('class-exam/{classroom_id}', 'ExamController@index')->name('classroom.exam');
    Route::get('class-exam/{classroom_id}/create', 'ExamController@create')->name('classroom.exam.create');
    Route::post('class-exam/{classroom_id}', 'ExamController@store')->name('classroom.exam.store');
    Route::get('class-exam/{exam}/edit', 'ExamController@edit')->name('classroom.exam.edit');
    Route::post('class-exam/{exam}/update', 'ExamController@update')->name('classroom.exam.update');
    Route::get('class-exam/{exam}/questions', 'QuestionController@index')->name('classroom.exam.question');
    Route::get('class-exam/{exam}/questions/create', 'QuestionController@create')->name('classroom.exam.question.create');
    Route::post('class-exam/{exam}/questions', 'QuestionController@store')->name('classroom.exam.question.store');
    Route::get('class-exam/{exam}/questions/{question}/edit', 'QuestionController@edit')->name('classroom.exam.question.edit');
    Route::post('class-exam/{exam}/questions/{question}', 'QuestionController@update')->name('classroom.exam.question.update');
    Route::get('class-exam/{exam}/enter', 'ExamController@enter')->name('classroom.exam.enter');
    Route::get('class-exam/{exam}/finish', 'ExamController@finish')->name('classroom.exam.finish');
    Route::get('class-exam/{exam}/answer-submit', 'ExamController@answerSubmit')->name('classroom.exam.answer.submit');
    Route::get('class-exam/{exam}/result', 'ExamController@result')->name('classroom.exam.result');
    Route::get('class-exam/{exam}/result/{student}', 'ExamController@resultIndividual')->name('classroom.exam.result.individual');

    Route::get('classroom-attendance/{classroom_id}', 'AttendanceController@index')->name('classroom.attendance');
});
