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
	Route::post('/fechas', 'HomeController@fechas');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');


Route::group(['middleware' => 'auth'], function () {

	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('users', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
// rutas de actividades
Route::group(['middleware' => 'auth'], function () {
	Route::resource('actividades', 'LoginActController');
});
// rutas de estaciones
Route::group(['middleware' => 'auth'], function () {
	Route::resource('estaciones', 'EstacionController');
	Route::post('estaciones/edit', 'EstacionController@edit');
});
// rutas terminales, FEE, empresas y captura de precios
Route::group(['middleware' => 'auth'], function () {
	Route::resource('terminals', 'TerminalController', ['except' => ['show']]);
	Route::get('getcompanies/{terminal?}', 'TerminalController@getCompanies')->name('getcompanies');
	Route::resource('fits', 'FeeController', ['except' => ['show', 'edit', 'update', 'destroy']]);
	Route::resource('companies', 'CompanyController');
	Route::resource('prices', 'CompetitionPriceController');
	Route::get('getprice/{terminal}/{company}/{date}', 'CompetitionPriceController@getPrice')->name('getprice');
	Route::get('getlastprice/{company}/{terminal}', 'CompetitionPriceController@getLastPrice')->name('getlastprice');
});
//rutas pemex
Route::group(['middleware' => 'auth'], function () {
	Route::resource('pemex', 'PemexController');
	Route::post('pemex/create', 'PemexController@create');
	Route::post('pemex/store', 'PemexController@store');
});


//rutas cotizador
Route::group(['middleware' => 'auth'], function () {
	Route::resource('orders', 'OrderController', ['except' => ['create', 'edit', 'destroy']]);
	Route::get('excel', 'OrderController@downloadExcel')->name('excel');
	Route::get('export', 'OrderController@export');
	Route::resource('validations', 'ValidationController');
	Route::post('validations/accept/{order}', 'ValidationController@accept')->name('accept');
	Route::post('validations/deny/{order}', 'ValidationController@deny')->name('deny');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('table_descount', 'DiscountController');
	Route::post('table_descount/create', 'DiscountController@create');
	Route::post('table_descount/store', 'DiscountController@store');
});

//rutas cotizador
Route::group(['middleware' => 'auth'], function () {
	Route::resource('levels', 'LevelController', ['except' => ['show']]);
});

// Ventas Controller
Route::group(['middleware' => 'auth'], function () {

	/* Nuevas Rutas */
	Route::get('ventas', 'VentasController@index')->name('ventas.index');
	Route::get('ventas/agregar-prospecto', 'VentasController@agregar_prospecto')->name('ventas.agregar_prospecto');
	Route::post('ventas/guardar-prospecto', 'VentasController@guardar_prospecto')->name('ventas.guardarProspecto');
	Route::post('ventas/asignar-prospecto-vendedor', 'VentasController@asignar_prospecto_vendedor')->name('ventas.asignar_prospecto_vendedor');
	Route::post('ventas/agregar-dias-prospecto', 'VentasController@agregar_dias_prospecto')->name('ventas.agregar_dias_prospecto');
	Route::get('ventas/editar-prospecto/{id}', 'VentasController@editar_prospecto')->name('ventas.editar_prospecto');
	Route::get('ventas/visualizar-prospecto/{id}', 'VentasController@visualizar_prospecto')->name('ventas.visualizar_prospecto');
	Route::post('ventas/actualizar-prospecto', 'VentasController@actualizar_prospecto')->name('ventas.actualizar_prospecto');
	Route::get('ventas/agregar-cliente/{id}', 'VentasController@agregar_cliente')->name('ventas.agregar_cliente');
	Route::post('ventas/guardar-cliente', 'VentasController@guardar_cliente')->name('ventas.guardar_cliente');
	Route::post('ventas/guardar-documento', 'VentasController@guardar_documento')->name('ventas.guardar_documento');
	Route::post('ventas/eliminar-documento', 'VentasController@eliminar_documento')->name('ventas.eliminar_documento');
	Route::post('ventas/guardar-propuesta', 'VentasController@guardar_propuesta')->name('ventas.guardar_propuesta');
	Route::post('ventas/eliminar-propuesta', 'VentasController@eliminar_propuesta')->name('ventas.eliminar_propuesta');
	Route::get('ventas/editar-cliente/{id}', 'VentasController@editar_cliente')->name('ventas.editar_cliente');
	Route::post('ventas/guardar-cambios-cliente', 'VentasController@guardar_cambios_cliente')->name('ventas.guardar_cambios_cliente');
	Route::get('ventas/visualizar-cliente/{id}', 'VentasController@visualizar_cliente')->name('ventas.visualizar_cliente');
	Route::get('ventas/agregar-vendedor', 'VentasController@agregar_vendedor')->name('ventas.agregar_vendedor');
	Route::post('ventas/guardar-vendedor-nuevo', 'VentasController@guardar_vendedor_nuevo')->name('ventas.guardar_vendedor_nuevo');
	Route::post('ventas/actualizar-vendedor', 'VentasController@actualizar_vendedor')->name('ventas.actualizar_vendedor');

	Route::get('ventas/editar-vendedor/{id}', 'VentasController@editar_vendedor')->name('ventas.editar_vendedor');

	Route::get('ventas/agregar-documentacion/{id}', 'VentasController@agregar_documentacion')->name('ventas.agregar_documentacion');

	Route::post('ventas/agregar-comentario-bitacora', 'VentasController@agregar_comentario_bitacora')->name('ventas.agregar_comentario_bitacora');

	Route::post('ventas/agregar-comentario-bitacora-cliente', 'VentasController@agregar_comentario_bitacora_cliente')->name('ventas.agregar_comentario_bitacora_cliente');

	Route::get('ventas/bitacora/{id}', 'VentasController@bitacora')->name('ventas.bitacora');
	Route::get('ventas/bitacora-cliente/{id}', 'VentasController@bitacora_cliente')->name('ventas.bitacora_cliente');
	Route::post('ventas/agregar-datos', 'VentasController@agregar_datos')->name('ventas.agregar_datos');

	Route::post('ventas/eliminar', 'VentasController@eliminar')->name('ventas.eliminar');

	Route::post('ventas/eliminar-vendedor', 'VentasController@eliminar_vendedor')->name('ventas.eliminar_vendedor');
});

// Vendedores Controller
Route::group(['middleware' => 'auth'], function () {
	Route::get('clientes', 'VendedorClienteController@index')->name('clientes.index');
});

Route::get('clientes/download/{name_file}', 'VendedorClienteController@download_client')->name('clientes.downloadclient');
