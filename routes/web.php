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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//rutas para ordenes de trabajo
Route::resource('ordenes', App\Http\Controllers\OtController::class);
/*
Route::get('ordenes', [App\Http\Controllers\OtController::class, 'index'])->name('ot');
Route::get('ordenes.crear', [App\Http\Controllers\OtController::class, 'create'])->name('crearot');
Route::put('ordenes.store', [App\Http\Controllers\OtController::class, 'store'])->name('ot.store');
*/


//rutas para Clientes
//Route::resource('clientes', App\Http\Controllers\ClientController::class);

Route::get('clientes', [App\Http\Controllers\ClientController::class, 'index'])->name('clientes.index');
Route::get('clientes/crear', [App\Http\Controllers\ClientController::class, 'create'])->name('clientes.create');
Route::post('clientes', [App\Http\Controllers\ClientController::class, 'store'])->name('clientes.store');
Route::get('clientes/{client}/editar', [App\Http\Controllers\ClientController::class, 'edit'])->name('clientes.edit');
Route::post('clientes/{client}/editar', [App\Http\Controllers\ClientController::class, 'update'])->name('clientes.update');



Route::get('marca', [App\Http\Controllers\BrandMotorController::class, 'index'])->name('marca.index');
Route::get('marca/{marca}/editar', [App\Http\Controllers\BrandMotorController::class, 'editar'])->name('marca.edit');