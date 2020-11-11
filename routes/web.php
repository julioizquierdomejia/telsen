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

Route::middleware(['guest:' . config('admin-auth.defaults.guard')])->group(function () {
	Route::get('/', function () {
	    return view('auth.login');
	});
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth:' . config('admin-auth.defaults.guard')])->group(function () {
	//rutas para ordenes de trabajo
	//Route::resource('ordenes', App\Http\Controllers\OtController::class);
	Route::get('ordenes', [App\Http\Controllers\OtController::class, 'index'])->name('ordenes.index');
	Route::get('ordenes/crear', [App\Http\Controllers\OtController::class, 'create'])->name('ordenes.create');
	Route::post('ordenes', [App\Http\Controllers\OtController::class, 'store'])->name('ordenes.store');
	Route::get('ordenes/{orden}/editar', [App\Http\Controllers\OtController::class, 'edit'])->name('ordenes.edit');
	Route::get('ordenes/procesovirtual', [App\Http\Controllers\OtController::class, 'pvirtual'])->name('ordenes.pvirtual');
	Route::get('ordenes/{orden}/ver', [App\Http\Controllers\OtController::class, 'ot_show'])->name('ordenes.ot_show');
	Route::get('ordenes/client/{orden}/ver', [App\Http\Controllers\OtController::class, 'show'])->name('ordenes.show');
	Route::post('ordenes/{orden}/editar', [App\Http\Controllers\OtController::class, 'update'])->name('ordenes.update');

	Route::get('ordenes/lista', [App\Http\Controllers\OtController::class, 'list'])->name('ordenes.list');

	//rutas para Clientes
	//Route::resource('clientes', App\Http\Controllers\ClientController::class);
	Route::get('clientes', [App\Http\Controllers\ClientController::class, 'index'])->name('clientes.index');
	Route::get('clientes/{client}/ver', [App\Http\Controllers\ClientController::class, 'show'])->name('clientes.ver');
	Route::get('clientes/crear', [App\Http\Controllers\ClientController::class, 'create'])->name('clientes.create');
	Route::post('clientes', [App\Http\Controllers\ClientController::class, 'store'])->name('clientes.store');
	Route::get('clientes/{client}/editar', [App\Http\Controllers\ClientController::class, 'edit'])->name('clientes.edit');
	Route::post('clientes/{client}/editar', [App\Http\Controllers\ClientController::class, 'update'])->name('clientes.update');


	//rutas para Marcas
	Route::get('marcas', [App\Http\Controllers\MotorBrandController::class, 'index'])->name('marcas.index');
	Route::get('marcas/crear', [App\Http\Controllers\MotorBrandController::class, 'create'])->name('marcas.create');
	Route::post('marcas', [App\Http\Controllers\MotorBrandController::class, 'store'])->name('marcas.store');
	Route::get('marcas/{marca}/editar', [App\Http\Controllers\MotorBrandController::class, 'edit'])->name('marcas.edit');
	Route::post('marcas/{marca}/editar', [App\Http\Controllers\MotorBrandController::class, 'update'])->name('marcas.update');

	//modelos
	Route::get('modelos', [App\Http\Controllers\MotorModelController::class, 'index'])->name('modelos.index');
	Route::get('modelos/crear', [App\Http\Controllers\MotorModelController::class, 'create'])->name('modelos.create');
	Route::post('modelos', [App\Http\Controllers\MotorModelController::class, 'store'])->name('modelos.store');
	Route::get('modelos/{modelo}/editar', [App\Http\Controllers\MotorModelController::class, 'edit'])->name('modelos.edit');
	Route::post('modelos/{modelo}/editar', [App\Http\Controllers\MotorModelController::class, 'update'])->name('modelos.update');

	//rutas para eval mechanical
	Route::get('formatos/mechanical', [App\Http\Controllers\MechanicalEvaluationController::class, 'index'])->name('formatos.mechanical');
	Route::get('formatos/mechanical/{id}/ver', [App\Http\Controllers\MechanicalEvaluationController::class, 'format_show'])->name('formatos.mechanical.show');
	Route::get('formatos/mechanical/{id}/evaluar', [App\Http\Controllers\MechanicalEvaluationController::class, 'evaluate'])->name('formatos.mechanical.evaluate');
	Route::post('formatos/mechanical/{id}/store', [App\Http\Controllers\MechanicalEvaluationController::class, 'store'])->name('formatos.mechanical.store');
	Route::get('formatos/mechanical/{id}/editar', [App\Http\Controllers\MechanicalEvaluationController::class, 'edit'])->name('formatos.mechanical.edit');
	Route::post('formatos/mechanical/{id}/editar', [App\Http\Controllers\MechanicalEvaluationController::class, 'update'])->name('formatos.mechanical.update');

	//rutas para eval electrical
	Route::get('formatos/electrical', [App\Http\Controllers\ElectricalEvaluationController::class, 'index'])->name('formatos.electrical');
	Route::get('formatos/electrical/{id}/ver', [App\Http\Controllers\ElectricalEvaluationController::class, 'format_show'])->name('formatos.electrical.show');
	Route::get('formatos/electrical/{id}/evaluar', [App\Http\Controllers\ElectricalEvaluationController::class, 'evaluate'])->name('formatos.electrical.evaluate');
	Route::post('formatos/electrical/{id}/store', [App\Http\Controllers\ElectricalEvaluationController::class, 'store'])->name('formatos.electrical.store');
	Route::get('formatos/electrical/{id}/editar', [App\Http\Controllers\ElectricalEvaluationController::class, 'edit'])->name('formatos.electrical.edit');
	Route::post('formatos/electrical/{id}/editar', [App\Http\Controllers\ElectricalEvaluationController::class, 'update'])->name('formatos.electrical.update');

	//rutas para Tarjeta Costos
	Route::get('tarjeta-costo', [App\Http\Controllers\CostCardController::class, 'index'])->name('card_cost.index');
	Route::get('tarjeta-costo/{id}/ver', [App\Http\Controllers\ElectricalEvaluationController::class, 'format_show'])->name('card_cost.cc_show');
	Route::get('tarjeta-costo/{id}/calcular', [App\Http\Controllers\CostCardController::class, 'calculate'])->name('card_cost.calculate');
	Route::post('tarjeta-costo/{id}/store', [App\Http\Controllers\CostCardController::class, 'store'])->name('card_cost.store');
	Route::get('tarjeta-costo/{cost}/editar', [App\Http\Controllers\CostCardController::class, 'edit'])->name('card_cost.edit');
	Route::post('tarjeta-costo/{cost}/editar', [App\Http\Controllers\CostCardController::class, 'update'])->name('card_cost.update');
	Route::get('tarjeta-costo/filterareas', [App\Http\Controllers\CostCardController::class, 'filterareas']);

	//rutas para Areas
	Route::get('areas', [App\Http\Controllers\AreaController::class, 'index'])->name('areas.index');
	Route::get('areas/crear', [App\Http\Controllers\AreaController::class, 'create'])->name('areas.create');
	Route::post('areas', [App\Http\Controllers\AreaController::class, 'store'])->name('areas.store');
	Route::get('areas/{area}/editar', [App\Http\Controllers\AreaController::class, 'edit'])->name('areas.edit');
	Route::post('areas/{area}/editar', [App\Http\Controllers\AreaController::class, 'update'])->name('areas.update');

	//rutas para Areas
	Route::get('servicios', [App\Http\Controllers\ServiceController::class, 'index'])->name('services.index');
	Route::get('servicios/crear', [App\Http\Controllers\ServiceController::class, 'create'])->name('services.create');
	Route::post('servicios', [App\Http\Controllers\ServiceController::class, 'store'])->name('services.store');
	Route::get('servicios/{servicio}/editar', [App\Http\Controllers\ServiceController::class, 'edit'])->name('services.edit');
	Route::post('servicios/{servicio}/editar', [App\Http\Controllers\ServiceController::class, 'update'])->name('services.update');

	//rutas para RDI
	Route::get('rdi', [App\Http\Controllers\RdiController::class, 'index'])->name('rdi.index');
	Route::get('rdi/{ot}/ver', [App\Http\Controllers\RdiController::class, 'show'])->name('rdi.show');
	Route::get('rdi/{ot}/crear', [App\Http\Controllers\RdiController::class, 'create'])->name('rdi.create');
	Route::post('rdi', [App\Http\Controllers\RdiController::class, 'store'])->name('rdi.store');
	Route::get('rdi/{ot}/editar', [App\Http\Controllers\RdiController::class, 'edit'])->name('rdi.edit');
	Route::post('rdi/{ot}/editar', [App\Http\Controllers\RdiController::class, 'update'])->name('rdi.update');

});
