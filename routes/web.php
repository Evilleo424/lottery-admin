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

Route::get('/login','LoginController@index');
Route::post('/login','LoginController@login');
Route::get('/logout','LoginController@logout');

Route::group(['middleware' => 'permissionCheck'],function(){
    Route::get('/home','HomeController@index');
    Route::resource('users','UserController',['except' => 'show']);
    Route::resource('roles','RoleController',['except' => 'show']);
    Route::resource('permissions','PermissionController',['except' => 'show']);
    Route::get('/roles/{role}/permission','RoleController@permission');
    Route::post('/roles/{role}/permission','RoleController@storePermission');
    Route::get('/users/{user}/role','UserController@role');
    Route::post('/users/{user}/role','UserController@storeRole');

    Route::get('/excel/import','ExcelController@import');
    Route::get('/excel/output','ExcelController@output');
    Route::get('/phpml/test1','PhpmlController@test1');
    Route::get('/phpml/test2','PhpmlController@test2');
    Route::get('/phpml/test3','PhpmlController@test3');

});



