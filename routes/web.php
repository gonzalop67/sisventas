<?php

use Illuminate\Support\Facades\Route;

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

//RUTAS CRUD CATEGORIAS
Route::get('almacen/categoria', 'CategoriaController@index')->name('categoria');
Route::get('almacen/categoria/create', 'CategoriaController@create')->name('crear_categoria');
Route::post('almacen/categoria', 'CategoriaController@store')->name('guardar_categoria');
Route::get('almacen/categoria/{id}/edit', 'CategoriaController@edit')->name('editar_categoria');
Route::put('almacen/categoria/{id}', 'CategoriaController@update')->name('actualizar_categoria');
Route::get('almacen/categoria/{id}/destroy', 'CategoriaController@destroy')->name('eliminar_categoria');

//RUTAS CRUD PRODUCTOS
Route::get('almacen/producto', 'ProductoController@index')->name('producto');
Route::get('almacen/producto/create', 'ProductoController@create')->name('crear_producto');
Route::post('almacen/producto', 'ProductoController@store')->name('guardar_producto');
Route::get('almacen/producto/{id}/edit', 'ProductoController@edit')->name('editar_producto');
Route::put('almacen/producto/{id}', 'ProductoController@update')->name('actualizar_producto');
Route::get('almacen/producto/{id}/destroy', 'ProductoController@destroy')->name('eliminar_producto');

//RUTAS CRUD CLIENTES
Route::get('ventas/cliente', 'ClienteController@index')->name('cliente');
Route::get('ventas/cliente/create', 'ClienteController@create')->name('crear_cliente');
Route::post('ventas/cliente', 'ClienteController@store')->name('guardar_cliente');
Route::get('ventas/cliente/{id}/edit', 'ClienteController@edit')->name('editar_cliente');
Route::put('ventas/cliente/{id}', 'ClienteController@update')->name('actualizar_cliente');
Route::get('ventas/cliente/{id}/destroy', 'ClienteController@destroy')->name('eliminar_cliente');

//RUTAS CRUD PROVEEDORES
Route::get('compras/proveedor', 'ProveedorController@index')->name('proveedor');
Route::get('compras/proveedor/create', 'ProveedorController@create')->name('crear_proveedor');
Route::post('compras/proveedor', 'ProveedorController@store')->name('guardar_proveedor');
Route::get('compras/proveedor/{id}/edit', 'ProveedorController@edit')->name('editar_proveedor');
Route::put('compras/proveedor/{id}', 'ProveedorController@update')->name('actualizar_proveedor');
Route::get('compras/proveedor/{id}/destroy', 'ProveedorController@destroy')->name('eliminar_proveedor');

//RUTAS CRUD INGRESOS
Route::get('compras/ingreso', 'IngresoController@index')->name('ingreso');
Route::get('compras/ingreso/create', 'IngresoController@create')->name('crear_ingreso');
Route::post('compras/ingreso', 'IngresoController@store')->name('guardar_ingreso');
Route::get('compras/ingreso/{id}/show', 'IngresoController@show')->name('mostrar_ingreso');
Route::put('compras/ingreso/{id}', 'IngresoController@update')->name('actualizar_ingreso');
Route::get('compras/ingreso/{id}/destroy', 'IngresoController@destroy')->name('eliminar_ingreso');

//RUTAS CRUD VENTAS
Route::get('ventas/venta', 'VentaController@index')->name('venta');
Route::get('ventas/venta/create', 'VentaController@create')->name('crear_venta');
Route::post('ventas/venta', 'VentaController@store')->name('guardar_venta');
Route::get('ventas/venta/{id}/show', 'VentaController@show')->name('mostrar_venta');
Route::put('ventas/venta/{id}', 'VentaController@update')->name('actualizar_venta');
Route::get('ventas/venta/{id}/destroy', 'VentaController@destroy')->name('eliminar_venta');

//RUTAS CRUD USUARIOS
Route::get('seguridad/usuario', 'UsuarioController@index')->name('usuario');
Route::get('seguridad/usuario/create', 'UsuarioController@create')->name('crear_usuario');
Route::post('seguridad/usuario', 'UsuarioController@store')->name('guardar_usuario');
Route::get('seguridad/usuario/{id}/edit', 'UsuarioController@edit')->name('editar_usuario');
Route::put('seguridad/usuario/{id}', 'UsuarioController@update')->name('actualizar_usuario');
Route::get('seguridad/usuario/{id}/destroy', 'UsuarioController@destroy')->name('eliminar_usuario');

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/{slug?}', 'HomeController@index');
//Route::get('/home', 'HomeController@index')->name('home');
