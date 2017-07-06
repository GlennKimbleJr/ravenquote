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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'FormsController@index')->name('home');
Route::get('/forms/create', 'FormsController@create')->name('form');
Route::post('/forms', 'FormsController@store')->name('form');
Route::get('/forms/{uuid}', 'FormsController@show')->name('view_form');
Route::post('/forms/{uuid}', 'FormSubmissionController@store')->name('form_submit');

Route::get('/submissions/{id}', 'FormSubmissionController@show')->name('submission');
