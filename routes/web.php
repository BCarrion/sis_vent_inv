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
Route::resource('informes/ventas/ventas_dia', 'VentasDiaController');
Route::resource('informes/ventas/ventas_general', 'VentasGeneralController');
Route::resource('administracion/usuario', 'UsuarioController');

Route::get('inventario/reporte_inventario',array(
            'as'=>'reporte_inventario',
            'uses'=>'InventarioController@reporteIventario'
            ));
Route::get('ventas/ventas_dia/reporte_dia',array(
            'as'=>'reporte_dia',
            'uses'=>'VentasDiaController@reporteDia'
            ));
Route::get('ventas/ventas_dia/reporte_general',array(
            'as'=>'reporte_general',
            'uses'=>'VentasGeneralController@reporteGeneral'
            ));

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
