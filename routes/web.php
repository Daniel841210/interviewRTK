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

//登入相關(網址前綴為login開頭)
Route::group(['prefix'=>'login' ], function(){
    Route::get('/','AuthController@loginPage'); //登入頁面
    Route::post('/submit','AuthController@login'); //處理登入
});

//登出相關(網址前綴為logout開頭)
Route::group(['prefix'=>'logout' ], function(){
    Route::get('/','AuthController@logout'); //處理登出
});

//一般員工相關(網址前綴為student開頭，並使用middleware做權限控管)
Route::group(['prefix'=>'employee', 'middleware'=>'employee.has.auth'], function(){
    Route::get('/','EmployeeController@showProfile'); //顯示個人資料
});

//主管相關(網址前綴為manager開頭，並使用middleware做權限控管)
Route::group(['prefix'=>'manager', 'middleware'=>'manager.has.auth' ], function(){
    Route::get('/','ManagerController@showProfile'); //顯示個人資料&一般員工資料
});
