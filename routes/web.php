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

Route::get('almacen/categoria', 'CategoriaController@index')->name('categoria');
Route::get('almacen/categoria/create', 'CategoriaController@create')->name('crear_categoria');
Route::post('almacen/categoria', 'CategoriaController@store')->name('guardar_categoria');
Route::get('almacen/categoria/{id}/edit', 'CategoriaController@edit')->name('editar_categoria');
Route::put('almacen/categoria/{id}', 'CategoriaController@update')->name('actualizar_categoria');
Route::get('almacen/categoria/{id}/destroy', 'CategoriaController@destroy')->name('eliminar_categoria');
