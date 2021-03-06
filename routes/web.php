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

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('auth.login');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'HomeController@index')->name('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');


Route::group(['middleware' => 'auth'], function () {

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('users', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
// rutas terminales, FEE, empresas y captura de precios
Route::group(['middleware' => 'auth'], function () {
	Route::resource('terminals', 'TerminalController', ['except' => ['show']]);
	Route::get('getcompanies/{terminal?}', 'TerminalController@getCompanies')->name('getcompanies');
	Route::resource('fits', 'FeeController', ['except' => ['show']]);
	Route::get('getfee/{terminal}/{company}/{base}/{date?}', 'FeeController@getFees')->name('getfee');
	Route::resource('companies', 'CompanyController');
	Route::get('getshopping/{company}', 'CompanyController@getshopping')->name('getshopping');
	Route::get('showcompanie/{id}', 'CompanyController@showClientChart')->name('showcompanie');
	Route::get('getshoppings/{company}/{month}', 'CompanyController@getshoppings')->name('getshoppings');
	Route::get('getcommision/{user}', 'OrderController@getShoppingsCommision')->name('getcommision');
	Route::get('commissionexcel/{user}', 'OrderController@commissionexcel')->name('commissionexcel');
	Route::get('commission/{user}/{month}', 'OrderController@commission')->name('commission');
	Route::resource('prices', 'CompetitionPriceController', ['except' => 'show', 'destroy']);
	Route::get('getprices/{company}/{date?}', 'CompetitionPriceController@getPrices')->name('getprices');
	Route::post('getprice', 'CompetitionPriceController@getPrice')->name('getprice');
	Route::get('getlastprice/{company}/{terminal}/{date?}', 'CompetitionPriceController@getLastPrice')->name('getlastprice');
});
//rutas pemex
Route::group(['middleware' => 'auth'], function () {
	Route::resource('pedidos', 'PedidoController');
	Route::resource('validacion', 'validacionSController', ['only' => ['index']]);
});

//rutas cotizador
Route::group(['middleware' => 'auth'], function () {
	Route::get('pricesterminal/{terminal_id}/{month}/{year}/{company?}', 'HomeController@getPricesJson')->name('pricesterminal');
	Route::get('monthstothepresentliters/', 'HomeController@monthsToThePresentLiters')->name('monthstothepresentliters');
	Route::get('monthsdaysproduct/', 'HomeController@monthsDaysProduct')->name('monthsdaysproduct');
	Route::resource('orders', 'OrderController', ['except' => ['create', 'edit', 'destroy']]);
	Route::resource('orders/{order}/payments', 'PaymentController');
	Route::get('downloadvoucher/{payment}/{file}', 'PaymentController@downloadVoucher')->name('downloadVoucher');
	Route::resource('invoices', 'InvoiceController', ['only' => ['edit', 'update']]);
	Route::post('invoice/{invoice}', 'InvoiceController@updateinvoice')->name('invoice');
	Route::post('shipper/{invoice}', 'InvoiceController@shipper')->name('shipper');
	Route::post('credit/{invoice}', 'InvoiceController@credit')->name('credit');
	Route::get('downloadfile/{order}/{file}/{type}', 'InvoiceController@download')->name('download');
	Route::get('excel', 'OrderController@downloadExcel')->name('excel');
	Route::get('sales', 'OrderController@downloadSales')->name('sales');
	Route::get('excel2', 'PedidoController@downloadExcel')->name('excel2');
	Route::get('validations/{month?}/{year?}', 'ValidationController@index')->name('validations.index');
	Route::post('validations/accept/{order}', 'ValidationController@accept')->name('accept');
	Route::post('validations/deny/{order}', 'ValidationController@deny')->name('deny');
	Route::post('validations/restore/{order}', 'ValidationController@restore')->name('restore');
	Route::post('validacion/accept/{pedido}', 'validacionSController@accept')->name('accepts');
	Route::post('validacion/deny/{pedido}', 'validacionSController@deny')->name('denys');
});

//rutas cotizador
Route::group(['middleware' => 'auth'], function () {
	Route::resource('levels', 'LevelController', ['except' => ['show']]);
	Route::get('logins', 'LastLoginController@index')->name('logins.index');
});


Route::group(['middleware' => 'auth'], function () {
	Route::get('totaltransporte/{year?}', 'GraficasController@gastoTotalTransporte')->name('totaltransporte');
	Route::get('transporte/{month?}', 'GraficasController@totalTransporte');
	Route::get('guerrera/{month?}', 'GraficasController@totalClienteGuerrera');
	Route::get('valeroguerrera/{month?}', 'GraficasController@totalValeroGuerrera');
	Route::get('utilidadcliente/{year?}', 'GraficasController@utilidadCliente');
	Route::get('utilidadgeneral/{month?}', 'GraficasController@utilidadGeneral');
	Route::get('utilidadguerrera/{year?}', 'GraficasController@utilidadGuerrera');
	Route::get('iva/{year?}', 'GraficasController@iva');
	Route::get('mermaporclientemes/{month?}', 'GraficasController@mermaPorClienteMes');
	Route::get('ultimosmeses/{revers?}', 'GraficasController@mouthLast');
});
