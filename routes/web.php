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
    return redirect('home/');
});

Route::get('/excel',"HomeController@excel_export")->name("excel_report");

Route::post('/item/Admin/action', 'ItemController@actions')->name('item_action');


Route::get('/request', "HomeController@request");

Route::get('/profiles', "HomeController@profiles");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::post('/users/api/getAuth', 'HomeController@login')->name('getAuth');


Route::get('/customers', 'CustomerController@index')->name('customers');
Route::get('/customers/update/{id}', 'CustomerController@update')->name('customerUpdate');



Route::post('/customers/update/', 'CustomerController@edit')->name('customer_Update');

Route::get('/model/{id}', 'CustomerModelController@index')->name('customer_models');
Route::get('/model/{customerId}/{id}', 'CustomerModelController@update')->name('modelUpdate');
Route::post('/model/update/', 'CustomerModelController@edit')->name('model_Update');

Route::get('/api/getByClient', 'HomeController@getModelsbyClient')->name('getModelsbyClient');


Route::get('/bom/{id}', 'BomController@index')->name('model_bom');

Route::post('/items/update/', 'ItemController@edit')->name('item_Update');
Route::get('/items', 'ItemController@index')->name('items');
Route::get('/items/update', 'ItemController@update')->name('itemUpdate');
Route::get('/Items/update/{id}', 'ItemController@update')->name('ItemUpdate');

Route::get('/Items/view/{id}', 'ItemController@view')->name('ItemView');



Route::post('/items/uploadfile', 'ItemController@upload')->name('itemsFile');
Route::post('/items/uploadfile/temp', 'ItemController@upload2')->name('itemsFile2');


Route::post('/customer/model/update', 'BomController@uploadBoom')->name('itemsFile3');

Route::post('/customer/models/updatecuantity', 'CustomerModelController@uploaddemand')->name('itemsFile4');



Route::get('/items/report', 'ItemController@report')->name('itemReport');

Route::get('/items/api', 'HomeController@filter')->name('itemAjax');
Route::get('/items/api/v2/', 'HomeController@filter2')->name('itemAjax2');
Route::get('/items/api/description', 'HomeController@details')->name('item-description');
Route::get('/order/set/', 'HomeController@setRequest')->name('setRequest');

Route::get('/orders/close/{order}' , "OrderController@close")->name('closeOrder');

Route::get('/orders/provide/' , "OrderItemsController@update")->name('provideOrder');

Route::get('/bom/api/add', 'BomController@store')->name('addItemToBom');
Route::get('/bom/api/update/item', 'BomController@update')->name('update-quantityforunit');
Route::get('/bom/api/update/model/quantity', 'CustomerModelController@updatequantity')->name('update-quantityformodel');
Route::get('/bom/api/delete/item', 'BomController@destroy')->name('delete-itemforbom');



Route::get("orders/" , "OrderController@index")->name('request_order');
Route::get("orders/view/{order}" , "OrderController@view")->name('view_order');
Route::get("orders/register/{id}" , "OrderController@update")->name('registered-order');


Route::get('history/orders' , "OrderController@show")->name('history');


Route::get('user/getdata', 'HomeController@getUser' )->name('getuser');
Route::post('user/edit', 'HomeController@update' )->name('edituser');

/*
@@@
@
@
@
@
@@@
*/

Route::get('test/loadCustoemr', 'HomeController@load_customer' );


