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

    return view('orders.request');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/users/api/getAuth', 'HomeController@login')->name('getAuth');


Route::get('/customers', 'CustomerController@index')->name('customers');
Route::get('/customers/update/{id}', 'CustomerController@update')->name('customerUpdate');
Route::post('/customers/update/', 'CustomerController@edit')->name('customer_Update');

Route::get('/model/{id}', 'CustomerModelController@index')->name('customer_models');
Route::get('/model/{customerId}/{id}', 'CustomerModelController@update')->name('modelUpdate');
Route::post('/model/update/', 'CustomerModelController@edit')->name('model_Update');


Route::get('/bom/{id}', 'BomController@index')->name('model_bom');

Route::get('/items', 'ItemController@index')->name('items');
Route::get('/items/update', 'ItemController@update')->name('itemUpdate');

Route::post('/items/uploadfile', 'ItemController@upload')->name('itemsFile');
Route::get('/items/api', 'ItemController@filter')->name('itemAjax');
Route::get('/items/api/description', 'ItemController@details')->name('item-description');
Route::get('/bom/api/add', 'BomController@store')->name('addItemToBom');


Route::get('/orders/' , "OrderController@index")->name('request_order');

