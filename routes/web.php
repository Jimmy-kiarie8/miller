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

Auth::routes();
Route::group(['middleware' => ['auth']], function () {

	Route::get('/manage', function () {
		return view('welcome');
	});
	Route::get('/home', 'HomeController@index')->name('home');
	Route::get('manage/${name}', function () {
		return redirect('/');
	})->where('name', '[A-Za-z]+');

	Route::resource('users', 'UserController');
	Route::resource('society', 'SocietyController');
	Route::resource('buyers', 'BuyerController');
	Route::resource('coffee', 'CoffeeTypeController');
	Route::resource('units', 'PackingUnitController');
	Route::resource('derivery', 'DeriveryController');
	Route::resource('supply', 'SupplyController');
	Route::resource('millers', 'MilledController');
	Route::resource('invoice', 'InvoiceController');
	Route::resource('receipt', 'ReceiptController');
	Route::resource('reports', 'ReportController');

	Route::post('/getUsers', 'UserController@getUsers')->name('getUsers');
	Route::post('/profile/{id}', 'UserController@profile')->name('profile');
	Route::post('/userUpdate', 'UserController@userUpdate')->name('userUpdate');

	Route::post('/getSociety', 'SocietyController@getSociety')->name('getSociety');
	Route::post('/getBuyers', 'BuyerController@getBuyers')->name('getBuyers');
	Route::post('/getCoffee', 'CoffeeTypeController@getCoffee')->name('getCoffee');
	Route::post('/getUnits', 'PackingUnitController@getUnits')->name('getUnits');
	Route::post('/getderivery', 'DeriveryController@getderivery')->name('getderivery');
	Route::post('/getsupply', 'SupplyController@getsupply')->name('getsupply');
	Route::post('/getMiller', 'MilledController@getMiller')->name('getMiller');
	Route::post('/getInvoice', 'InvoiceController@getInvoice')->name('getInvoice');
	Route::post('/getReceipts', 'ReceiptController@getReceipts')->name('getReceipts');

	// Sort
	Route::post('/getMillerSort', 'MilledController@getMillerSort')->name('getMillerSort');
	Route::post('/getInvoiceSort', 'InvoiceController@getInvoiceSort')->name('getInvoiceSort');
	Route::post('/getReceiptSort', 'ReceiptController@getReceiptSort')->name('getReceiptSort');

	Route::post('/fewUsers', 'UserController@fewUsers')->name('fewUsers');
	Route::post('/fewSocieties', 'SocietyController@fewSocieties')->name('fewSocieties');
	Route::post('/fewBuyers', 'BuyerController@fewBuyers')->name('fewBuyers');

	// Reports
	Route::post('/getBuyersReport/{id}', 'ReportController@getBuyersReport')->name('getBuyersReport');
	Route::post('/getDerivery/{id}', 'ReportController@getDerivery')->name('getDerivery');
});
