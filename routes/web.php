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

Route::resource('almacen/articulo', 'ArticuloController');
Route::resource('almacen/categoria', 'CategoriaController');
Route::resource('ventas/cliente', 'ClienteController');
Route::resource('compras/proveedor', 'ProveedorController');

Route::resource('almacen/detalle_ingreso', 'DetalleIngresoController');
Route::resource('almacen/detalle_venta', 'DetalleVentaController');
Route::resource('almacen/ingreso', 'IngresoController');
Route::resource('almacen/inventario', 'InventarioController');
Route::resource('almacen/persona', 'PersonaController');
Route::resource('almacen/venta', 'VentaController');
