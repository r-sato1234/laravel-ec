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

/*
|--------------------------------------------------------------------------
| 1) User 認証不要
|--------------------------------------------------------------------------
*/
Route::get('/', function () { return redirect('/home'); });

/*
|--------------------------------------------------------------------------
| 2) User ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:user'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
});

/*
|--------------------------------------------------------------------------
| 3) Admin 認証不要
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function() {
    Route::get('/',         function () { return redirect('/admin/home'); });
    Route::get('login',     'Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login',    'Admin\LoginController@login');
});

/*
|--------------------------------------------------------------------------
| 4) Admin ログイン後
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
    Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');
    Route::get('home', 'Admin\HomeController@index')->name('admin.home');
    Route::get('items', 'Admin\ItemsController@index')->name('admin.items');
    Route::match(['get', 'post'], 'items/add', 'Admin\ItemsController@add')->name('admin.items.add');
    Route::match(['get', 'post'], 'items/edit/{id}', 'Admin\ItemsController@edit')->name('admin.items.edit');
    Route::post('items/create', 'Admin\ItemsController@create')->name('admin.items.create');
    Route::post('items/update/{id}', 'Admin\ItemsController@update')->name('admin.items.update');
    Route::get('items/view/{id}', 'Admin\ItemsController@view')->name('admin.items.view');
    Route::delete('items/delete/{id}', 'Admin\ItemsController@delete')->name('admin.items.delete');
    Route::post('items/sale/{id}', 'Admin\ItemsController@sale')->name('admin.items.sale');
    Route::post('items/saleStop/{id}', 'Admin\ItemsController@saleStop')->name('admin.items.sale_stop');
    Route::get('orders', 'Admin\OrdersController@index')->name('admin.orders');
    Route::get('orders/view/{id}', 'Admin\OrdersController@view')->name('admin.orders.view');
    Route::delete('orders/cancel/{id}', 'Admin\OrdersController@cancel')->name('admin.orders.cancel');
    Route::post('orders/fix/{id}', 'Admin\OrdersController@fix')->name('admin.orders.fix');
    Route::post('orders/deliveryComplete/{id}', 'Admin\OrdersController@deliveryComplete')->name('admin.orders.deliveryComplete');
});
