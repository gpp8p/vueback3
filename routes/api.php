<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('register', 'JWTAuthController@register');
    Route::post('login', 'JWTAuthController@login');
    Route::post('logout', 'JWTAuthController@logout');
    Route::post('refresh', 'JWTAuthController@refresh');
    Route::get('profile', 'JWTAuthController@profile');
    Route::get('loggedInUser','JWTAuthController@getLoggedInUser');

});

Route::group([
    'middleware' => 'api',
    'prefix' => 'shan'

], function ($router) {

//    Route::get('loggedInUser', )
    Route::get('layoutList', 'LayoutController@getLayoutList');
    Route::get('orgHome','OrgController@getOrgHomeFromName');
    Route::get('orgId','OrgController@getOrgIdFromName');
    Route::post('setCookie', 'JWTAuthController@setCookie');
    Route::get('viewableLayouts', 'LayoutController@getViewableLayoutList');
    Route::get('layoutPerms', 'LayoutController@getLayoutPerms');
    Route::post('setLayoutPerms', 'LayoutController@setLayoutPerms');
    Route::get('orgList', 'OrgController@getOrgList');
    Route::get('orgUsers', 'OrgController@getOrgUsers');
    Route::get('orgLayouts', 'LayoutController@getOrgLayouts');
    Route::get('allUsers', 'OrgController@getAllUsers');
    Route::post('newOrg', 'OrgController@newOrg');
    Route::post('createUser', 'userController@createUser');
    Route::get('groupMembers', 'GroupsController@getGroupMembers');


});
