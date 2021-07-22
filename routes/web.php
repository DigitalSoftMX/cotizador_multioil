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
	Route::resource('fits', 'FeeController', ['except' => ['show', 'destroy']]);
	Route::get('getfee/{terminal}/{company}/{base}/{date?}', 'FeeController@getFees')->name('getfee');
	Route::resource('companies', 'CompanyController');
	Route::get('getshopping/{company}', 'CompanyController@getshopping')->name('getshopping');
	Route::get('getshoppings/{company}/{month}', 'CompanyController@getshoppings')->name('getshoppings');
	Route::resource('prices', 'CompetitionPriceController', ['except' => 'show', 'destroy']);
	Route::get('getprices/{company}/{date?}', 'CompetitionPriceController@getPrices')->name('getprices');
	Route::post('getprice', 'CompetitionPriceController@getPrice')->name('getprice');
	Route::get('getlastprice/{company}/{terminal}', 'CompetitionPriceController@getLastPrice')->name('getlastprice');
});
//rutas pemex
Route::group(['middleware' => 'auth'], function () {
	Route::resource('pedidos', 'PedidoController');
	Route::resource('validacion', 'validacionSController', ['only' => ['index']]);
});

//rutas cotizador
Route::group(['middleware' => 'auth'], function () {
	Route::get('pricesterminal/{terminal_id}/{month}/{company?}', 'HomeController@getPricesJson')->name('pricesterminal');
	Route::resource('orders', 'OrderController', ['except' => ['create', 'edit', 'destroy']]);
	Route::resource('orders/{order}/payments', 'PaymentController');
	Route::resource('invoices', 'InvoiceController', ['only' => ['edit', 'update']]);
	Route::post('invoice/{invoice}', 'InvoiceController@updateinvoice')->name('invoice');
	Route::get('downloadfile/{order}/{file}/{type}', 'InvoiceController@download')->name('download');
	Route::get('excel', 'OrderController@downloadExcel')->name('excel');
	Route::get('sales', 'OrderController@downloadSales')->name('sales');
	Route::get('excel2', 'PedidoController@downloadExcel')->name('excel2');
	Route::resource('validations', 'ValidationController', ['only' => ['index']]);
	Route::post('validations/accept/{order}', 'ValidationController@accept')->name('accept');
	Route::post('validations/deny/{order}', 'ValidationController@deny')->name('deny');
	Route::post('validacion/accept/{pedido}', 'validacionSController@accept')->name('accepts');
	Route::post('validacion/deny/{pedido}', 'validacionSController@deny')->name('denys');
});

//rutas cotizador
Route::group(['middleware' => 'auth'], function () {
	Route::resource('levels', 'LevelController', ['except' => ['show']]);
});
