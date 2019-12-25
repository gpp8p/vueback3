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

Route::get('/cardinstances', 'cardInstanceController@getLayoutCardInstances')->name('cardinstances');
Route::get('/blankLayout', 'LayoutController@createBlankLayout')->name('blanklayout');
Route::post('/createLayout', 'LayoutController@createNewLayout')->name('newlayout');
Route::get('/getLayout', 'cardInstanceController@getLayoutById')->name('getLayout');
Route::post('/saveCard', 'cardInstanceController@saveCard')->name('saveCard');
Route::get('/csrfTest', 'cardInstanceController@getCsrf')->name('csrfTest');
Route::get('/serveTest', 'cardInstanceController@serveTest')->name('serveTest');
Route::get('/layoutList', 'LayoutController@getLayoutList')->name('layoutList');
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
