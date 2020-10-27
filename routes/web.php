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
//Route::resource('ordenes', App\Http\Controllers\OtController::class);
Route::get('ordenes', [App\Http\Controllers\OtController::class, 'index'])->name('ordenes.index');
Route::get('ordenes/crear', [App\Http\Controllers\OtController::class, 'create'])->name('ordenes.create');
Route::post('ordenes', [App\Http\Controllers\OtController::class, 'store'])->name('ordenes.store');
Route::get('ordenes/{orden}/editar', [App\Http\Controllers\OtController::class, 'edit'])->name('ordenes.edit');
Route::post('ordenes/{orden}/editar', [App\Http\Controllers\OtController::class, 'update'])->name('ordenes.update');


//rutas para Clientes
//Route::resource('clientes', App\Http\Controllers\ClientController::class);

Route::get('clientes', [App\Http\Controllers\ClientController::class, 'index'])->name('clientes.index');
Route::get('clientes/crear', [App\Http\Controllers\ClientController::class, 'create'])->name('clientes.create');
Route::post('clientes', [App\Http\Controllers\ClientController::class, 'store'])->name('clientes.store');
Route::get('clientes/{client}/editar', [App\Http\Controllers\ClientController::class, 'edit'])->name('clientes.edit');
Route::post('clientes/{client}/editar', [App\Http\Controllers\ClientController::class, 'update'])->name('clientes.update');


Route::get('marcas', [App\Http\Controllers\BrandMotorController::class, 'index'])->name('marcas.index');
Route::get('marcas/crear', [App\Http\Controllers\BrandMotorController::class, 'create'])->name('marcas.create');
Route::post('marcas', [App\Http\Controllers\BrandMotorController::class, 'store'])->name('marcas.store');
Route::get('marcas/{marca}/editar', [App\Http\Controllers\BrandMotorController::class, 'edit'])->name('marcas.edit');
Route::post('marcas/{marca}/editar', [App\Http\Controllers\BrandMotorController::class, 'update'])->name('marcas.update');

Route::get('modelos', [App\Http\Controllers\ModelMotorController::class, 'index'])->name('modelos.index');
Route::get('modelos/crear', [App\Http\Controllers\ModelMotorController::class, 'create'])->name('modelos.create');
Route::post('modelos', [App\Http\Controllers\ModelMotorController::class, 'store'])->name('modelos.store');
Route::get('modelos/{marca}/editar', [App\Http\Controllers\ModelMotorController::class, 'edit'])->name('modelos.edit');
Route::post('modelos/{marca}/editar', [App\Http\Controllers\ModelMotorController::class, 'update'])->name('modelos.update');