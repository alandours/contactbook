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
    return Redirect::to('contacts');
});

Route::get('contacts', 'ContactController@display');

Route::get('contacts/add', 'ContactController@addForm');

Route::post('contacts/add', 'ContactController@add');

Route::get('contacts/{id}/edit', 'ContactController@editForm');

Route::post('contacts/{id}/edit', 'ContactController@edit');

Route::get('contacts/{id}/delete', 'ContactController@delete');

Route::get('contacts/{id}', 'ContactController@display');








