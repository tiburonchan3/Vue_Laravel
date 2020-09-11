<?php

use Illuminate\Support\Facades\Route;
//retorna la vista del login
Route::get('/', function () {
    return view('auth.login');
});

Route::group(['prefix' => 'tipo'], function () {
    //muestra todos los registros
    Route::get('/show','TipoController@show');
    //muestra lor registros en el select
    Route::get('/showAll','TipoController@showAll');
    //guardar
    Route::post('/store','TipoController@store');
    //buscar y obtener el registro a editar
    Route::get('/edit/{id}','TipoController@edit');
    //actualizar
    Route::put('/update/{id}','TipoController@update');
    //eliminar
    Route::delete('/destroy/{id}','TipoController@destroy');
});

Route::group(['prefix' => 'producto'], function () {
    Route::get('/show','ProductoController@show');
    //buscar un producto
    Route::post('/search','ProductoController@search');
    //buscar productos por tipo
    Route::post('/searchType','ProductoController@searchType');
    //guardar producto
    Route::post('/store','ProductoController@store');
    //buscar y obtener el registro a editar
    Route::get('/edit/{id}','ProductoController@edit');
    //actualizar producto
    Route::put('/update/{id}','ProductoController@update');
    //eliminar producto
    Route::delete('/destroy/{id}','ProductoController@destroy');
    });
/***********************************************************/

//accede a la vista tipo
Route::get('/user', 'UserController@index')->middleware(['auth','role']);
//mostrar todos
Route::get('/user/show','UserController@show');
/***********************************************************/

//accede a la vista tipo
Route::get('/catalogo', 'CatalogoController@index')->middleware('auth');
//mostrar todos los productos
Route::get('/catalogo/show','ProductoController@show');
/***********************************************************/
//guardar la orden
Route::post('/order/store','CarritoController@store');
//rutas de laravel auth
Auth::routes();
//devuelve la vista home
Route::get('/home', 'HomeController@index')->name('home');
//muestra los productos agregados recientemenete
Route::get('/home/show','HomeController@show');
//retorna la vista de tipo por producto
Route::get('/categoria','ProductoController@ProductType')->middleware('auth');
//muestra todos los tipos de comida
Route::get('/product/getTypes','TipoController@showAll');
//muestra los detalles del producto por id
Route::get('/producto/detail/{id}','ProductoController@edit');
//guarda el rating del usuario
Route::post('/rating/new','RatingController@setRating');
//muestra el todos los rating del producto
Route::post('/rating/all','RatingController@all');
//muestra el ratign del usuario loggueado
Route::post('/rating/show','RatingController@show');
//obtiene los datos del usuario loggeado
Route::get('/user/profile','UserController@profile');
//retorna la vista de perfil de usuario
Route::get('/profile', function () {
    return view('auth.profile');
})->middleware('auth');
//recibe los datos para editar la info del usuario
Route::post('/user/update','UserController@update');
//Rutas para ventas
Route::get('/ventas','VentasController@index');
//mostrar las ventas
Route::get('/ventas/all','VentasController@show');
Route::get('/ventas/orders','VentasController@show');

Route::get('/home', function () {
    return view('layouts.app');
})->name('home');
