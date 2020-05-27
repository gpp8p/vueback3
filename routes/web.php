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

//Route::get('/cardinstances', 'cardInstanceController@getLayoutCardInstances')->name('cardinstances');
//Route::get('/blankLayout', 'LayoutController@createBlankLayout')->name('blanklayout');
//Route::post('/createLayout', 'LayoutController@createNewLayout')->name('newlayout');
Route::post('/createLayoutNoBlanks', 'LayoutController@createNewLayoutNoBlanks')->name('newlayoutNoBlanks');
Route::post('/saveCard', 'cardInstanceController@saveCard')->name('saveCard');
Route::post('/saveCardOnly', 'cardInstanceController@saveCardOnly')->name('saveCardOnly');
Route::post('/imageUpload', 'FileUploadController@recieveFile')->name('imageUpload');
Route::post('/imageUploadCk', 'FileUploadController@recieveFileCk')->name('imageUploadCk');
Route::post('/saveCardParameters','cardInstanceController@saveCardParameters')->name('saveCardParameters');
Route::post('/saveCardContent','cardInstanceController@saveCardContent')->name('saveCardContent');
Route::get('/getCardDataById', 'cardInstanceController@getCardDataById')->name('getCardDataById');
Route::get('/getLayout', 'cardInstanceController@getLayoutById')->name('getLayout');
Route::get('/getLayout2', 'cardInstanceController@getLayoutById2')->name('getLayout2');
//Route::post('/saveCard', 'cardInstanceController@saveCard')->name('saveCard');
Route::get('/csrfTest', 'cardInstanceController@getCsrf')->name('csrfTest');
Route::post('postCsrf', 'cardInstanceController@postCsrf')->name('postCsrf');
//Route::get('/serveTest', 'cardInstanceController@serveTest')->name('serveTest');
//Route::get('/layoutList', 'LayoutController@getLayoutList')->name('layoutList');
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, X-CSRF-TOKEN, X-Requested-With, Authorization');
