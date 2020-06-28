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
    return view('welcome');
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
