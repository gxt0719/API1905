<?php
Route::get('info', function () {
    phpinfo();
});
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
Route::get('/test/pay','TestController@alipay');        //去支付
Route::get('/test/alipay/return','Alipay\PayController@aliReturn');
Route::post('/test/alipay/notify','Alipay\PayController@notify');
Route::any('/text/text','Api\TextController@text');
Route::post('/login/login','Api\LoginController@login');
Route::post('/login/logon','Api\LoginController@logon');
Route::any('/login/list','Api\LoginController@list');
Route::any('/login/test','Api\LoginController@test');
Route::get('/work/jiami/','Api\Work1Controller@jiami');
Route::get('/work/jiemi','Api\Work1Controller@jiemi');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
//解密数据
Route::get('/user/decrypt/data','User\IndexController@decrypt1');
Route::post('/user/decrypt/data','User\IndexController@decrypt2');

// 用户管理
Route::get('/user/addkey','User\IndexController@addSSHKey1');
Route::post('/user/addkey','User\IndexController@addSSHKey2');
Route::get('/user/de','User\IndexController@de');
Route::any('/user/decrypt3','User\IndexController@decrypt3');
Route::any('/user/encrypt3','User\IndexController@encrypt3');


Route::middleware(['checkUser'])->group(function(){
	Route::any('/text/reg','Api\TextController@reg');
	Route::any('/text/login','Api\TextController@login');
	Route::any('/text/showData','Api\TextController@showData');
});

//对称加密
Route::any('/user/encrypt3','User\IndexController@encrypt3');//加密
Route::any('/user/encrypt3','User\IndexController@encrypt3');//解密