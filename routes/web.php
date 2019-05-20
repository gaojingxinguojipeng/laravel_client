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
Route::any("encode","User\UserController@encode");
Route::any("decode","User\UserController@decode");
Route::any("eclist","User\UserController@eclist");
Route::any("rsa","User\UserController@rsa");
Route::any("pri","User\UserController@pri");



Route::any("login","User\LoginController@login");
Route::any("loginDo","User\LoginController@loginDo");
Route::any("reg","User\LoginController@reg");
Route::any("regDo","User\LoginController@regDo");
Route::any("kuayu","User\LoginController@kuayu");
Route::post("openreg","User\LoginController@openreg");
Route::post("openlogin","User\LoginController@openlogin");


Route::any("regpass","Index\IndexController@regpass");
Route::any("uploadImg","Index\IndexController@uploadImg");
Route::any("regpassDo","Index\IndexController@regpassDo");
Route::any("accessToken","Index\IndexController@accessToken");
Route::any("loginpass","Index\IndexController@loginpass");
Route::any("loginpassDo","Index\IndexController@loginpassDo");
Route::any("regpasslist","Index\IndexController@regpasslist");
Route::any("regstatus","Index\IndexController@regstatus");
Route::any("uaShow","Index\IndexController@uaShow");
Route::any("ipShow","Index\IndexController@ipShow")->middleware("fangshua");






















