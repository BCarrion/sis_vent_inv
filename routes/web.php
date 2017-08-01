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
    return view('auth/login');
});

Route::resource('almacen/articulo', 'ArticuloController');
Route::resource('almacen/categoria', 'CategoriaController');
Route::resource('ventas/cliente', 'ClienteController');
Route::resource('compras/proveedor', 'ProveedorController');
Route::resource('compras/ingreso', 'IngresoController');
Route::resource('ventas/venta', 'VentaController');
Route::resource('informes/inventario', 'InventarioController');

Route::get('inventario/reporte_inventario',array(
            'as'=>'reporte_inventario',
            'uses'=>'InventarioController@reporteIventario'
            ));

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
