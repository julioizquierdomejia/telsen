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

	Route::get('usuarios', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
	Route::get('usuarios/list', [App\Http\Controllers\UserController::class, 'getUsers'])->name('users.list');
	Route::get('usuarios/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
	Route::post('usuarios/create', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
	Route::get('usuario/perfil', [App\Http\Controllers\UserController::class, 'perfil'])->name('users.perfil');
	Route::get('usuario/perfil/update', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('users.perfil.update');
	Route::get('usuario/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
	Route::post('usuarios/{user}/edit', [App\Http\Controllers\UserController::class, 'update'])->name('users.edit');
	//Route::post('users/{user}/eliminar', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.delete');
	Route::post('users/{user}/cambiarstatus', [App\Http\Controllers\UserController::class, 'userStatus'])->name('users.status');

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
	Route::post('ordenes/{orden}/fechaentrega', [App\Http\Controllers\OtController::class, 'generateOTDate'])->name('ordenes.generateotdate');

	Route::get('ordenes/lista', [App\Http\Controllers\OtController::class, 'list'])->name('ordenes.list');

	Route::get('ordenes/disapproved', [App\Http\Controllers\OtController::class, 'disapproved_ots'])->name('ordenes.disapproved_ots');
	Route::get('ordenes/enabled', [App\Http\Controllers\OtController::class, 'enabled_ots'])->name('ordenes.enabled_ots');
	Route::get('ordenes/disabled', [App\Http\Controllers\OtController::class, 'disabled_ots'])->name('ordenes.disabled_ots');
	Route::get('formatos/pending', [App\Http\Controllers\OtController::class, 'pending_eval_ots'])->name('formatos.pending_ots');
	Route::get('formatos/pending_list', [App\Http\Controllers\OtController::class, 'list_eval_pending'])->name('formatos.list_pending');
	Route::post('ordenes/{orden}/activar', [App\Http\Controllers\OtController::class, 'enabling_ot'])->name('ordenes.enabling_ot');
	Route::post('ordenes/{orden}/eliminar', [App\Http\Controllers\OtController::class, 'destroy'])->name('ordenes.destroy');
	Route::get('ordenes/{orden}/status', [App\Http\Controllers\OtController::class, 'getOTStatus'])->name('ordenes.status');

	Route::post('ordenes/{orden}/gallery', [App\Http\Controllers\OtController::class, 'galleryStore'])->name('gallery.store');
	Route::post('ordenes/{id}/quitarimagen', [App\Http\Controllers\OtController::class, 'galleryDelete'])->name('gallery.delete');

	Route::get('ordenes/ee_list', [App\Http\Controllers\OtController::class, 'ee_list'])->name('ordenes.ee_ots');
	Route::get('ordenes/me_list', [App\Http\Controllers\OtController::class, 'me_list'])->name('ordenes.me_ots');

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
	Route::post('formatos/mechanical/{id}/aprobar', [App\Http\Controllers\MechanicalEvaluationController::class, 'approve'])->name('formatos.mechanical.approve');

	//rutas para eval electrical
	Route::get('formatos/electrical', [App\Http\Controllers\ElectricalEvaluationController::class, 'index'])->name('formatos.electrical');
	Route::get('formatos/electrical/{id}/ver', [App\Http\Controllers\ElectricalEvaluationController::class, 'format_show'])->name('formatos.electrical.show');
	Route::get('formatos/electrical/{id}/evaluar', [App\Http\Controllers\ElectricalEvaluationController::class, 'evaluate'])->name('formatos.electrical.evaluate');
	Route::post('formatos/electrical/{id}/store', [App\Http\Controllers\ElectricalEvaluationController::class, 'store'])->name('formatos.electrical.store');
	Route::get('formatos/electrical/{id}/editar', [App\Http\Controllers\ElectricalEvaluationController::class, 'edit'])->name('formatos.electrical.edit');
	Route::post('formatos/electrical/{id}/editar', [App\Http\Controllers\ElectricalEvaluationController::class, 'update'])->name('formatos.electrical.update');
	Route::post('formatos/electrical/{id}/aprobar', [App\Http\Controllers\ElectricalEvaluationController::class, 'approve'])->name('formatos.electrical.approve');

	//rutas para Tarjeta Costos
	Route::get('tarjeta-costo', [App\Http\Controllers\CostCardController::class, 'index'])->name('card_cost.index');
	Route::get('tarjeta-costo/list', [App\Http\Controllers\OtController::class, 'cc_list'])->name('card_cost.list');
	Route::get('tarjeta-costo/{id}/ver', [App\Http\Controllers\CostCardController::class, 'cc_show'])->name('card_cost.cc_show');
	Route::get('tarjeta-costo/{id}/calcular', [App\Http\Controllers\CostCardController::class, 'calculate'])->name('card_cost.calculate');
	Route::post('tarjeta-costo/{id}/store', [App\Http\Controllers\CostCardController::class, 'store'])->name('card_cost.store');
	Route::get('tarjeta-costo/{cost}/editar', [App\Http\Controllers\CostCardController::class, 'edit'])->name('card_cost.edit');
	Route::post('tarjeta-costo/{cost}/editar', [App\Http\Controllers\CostCardController::class, 'update'])->name('card_cost.update');
	Route::post('tarjeta-costo/{id}/cotizacion', [App\Http\Controllers\CostCardController::class, 'upload'])->name('card_cost.upload');
	Route::post('tarjeta-costo/{cost}/aprobar', [App\Http\Controllers\CostCardController::class, 'approveTC'])->name('card_cost.approve');

	//dentro de formatos
	Route::get('cotizaciones/pending', [App\Http\Controllers\OtController::class, 'pending_cc_ots'])->name('card_cost.pending');
	Route::get('cotizaciones/pending_list', [App\Http\Controllers\OtController::class, 'list_cc_pending'])->name('card_cost.list_pending');

	//dentro de cotizaciones
	Route::get('cotizaciones', [App\Http\Controllers\OtController::class, 'cc_ots'])->name('card_cost.cz');
	Route::get('cotizaciones/list_waiting', [App\Http\Controllers\OtController::class, 'list_cc_waiting'])->name('card_cost.list_waiting');

	Route::get('cotizaciones/list_approved', [App\Http\Controllers\OtController::class, 'list_cc_approved'])->name('card_cost.list_approved');

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
	Route::post('servicios/{servicio}/eliminar', [App\Http\Controllers\ServiceController::class, 'destroy'])->name('services.destroy');
	Route::post('servicios/{servicio}/status', [App\Http\Controllers\ServiceController::class, 'changeStatus'])->name('services.status');
	Route::get('servicios/{servicio}/editar', [App\Http\Controllers\ServiceController::class, 'edit'])->name('services.edit');
	Route::post('servicios/{servicio}/editar', [App\Http\Controllers\ServiceController::class, 'update'])->name('services.update');
	Route::get('servicios/filterareas', [App\Http\Controllers\ServiceController::class, 'filterareas']);

	Route::get('servicios.lista', [App\Http\Controllers\ServiceController::class, 'services_list'])->name('services.list');

	//rutas para RDI
	Route::get('rdi', [App\Http\Controllers\RdiController::class, 'index'])->name('rdi.index');
	Route::get('rdi/list', [App\Http\Controllers\OtController::class, 'rdi_list'])->name('rdi.list');
	Route::get('rdi/{ot}/ver', [App\Http\Controllers\RdiController::class, 'show'])->name('rdi.show');
	Route::get('rdi/{ot}/calcular', [App\Http\Controllers\RdiController::class, 'calculate'])->name('rdi.calculate');
	Route::post('rdi', [App\Http\Controllers\RdiController::class, 'store'])->name('rdi.store');
	Route::get('rdi/{id}/editar', [App\Http\Controllers\RdiController::class, 'edit'])->name('rdi.edit');
	Route::post('rdi/{id}/editar', [App\Http\Controllers\RdiController::class, 'update'])->name('rdi.update');
	Route::post('rdi/{ot}/aprobarrdi', [App\Http\Controllers\RdiController::class, 'approveRDI'])->name('rdi.approve');

	Route::get('rdi/list-group', [App\Http\Controllers\RdiController::class, 'list_group'])->name('rdi.list_group');
	Route::get('rdi/list_waiting', [App\Http\Controllers\OtController::class, 'list_rdi_waiting'])->name('rdi.list_waiting');
	Route::get('rdi/list_approved', [App\Http\Controllers\OtController::class, 'list_rdi_approved'])->name('rdi.list_approved');

	Route::get('fecha-entrega', [App\Http\Controllers\OtController::class, 'delivery_date'])->name('delivery_date.index');
	Route::get('fecha-entrega/list_delivery_pending', [App\Http\Controllers\OtController::class, 'list_delivery_pending'])->name('delivery_date.pending');
	Route::get('fecha-entrega/list_delivery_generated', [App\Http\Controllers\OtController::class, 'list_delivery_generated'])->name('delivery_date.generated');

	//rutas para Talleres
	Route::get('talleres', [App\Http\Controllers\WorkshopController::class, 'index'])->name('workshop.index');
	Route::get('talleres/crear', [App\Http\Controllers\WorkshopController::class, 'create'])->name('workshop.create');
	Route::post('talleres/{ot}/store', [App\Http\Controllers\WorkshopController::class, 'store'])->name('workshop.store');
	Route::get('talleres/{area}/editar', [App\Http\Controllers\WorkshopController::class, 'edit'])->name('workshop.edit');
	Route::post('talleres/{area}/editar', [App\Http\Controllers\WorkshopController::class, 'update'])->name('workshop.update');
	Route::get('talleres/{ot}/asignar', [App\Http\Controllers\WorkshopController::class, 'assign'])->name('workshop.assign');

	Route::get('talleres/list', [App\Http\Controllers\OtController::class, 'list_workshop'])->name('talleres.list_workshop');
	Route::get('talleres/tareas', [App\Http\Controllers\WorkshopController::class, 'services_list'])->name('workshop.services');

	Route::get('talleres/closure', [App\Http\Controllers\OtController::class, 'closure'])->name('workshop.closure');
	Route::get('talleres/closurelist', [App\Http\Controllers\OtController::class, 'list_closure'])->name('workshop.closurelist');

	Route::post('talleres/aprobartarea', [App\Http\Controllers\WorkshopController::class, 'approveWork'])->name('workshop.approvework');

	//Codigos Rotor
	//1
	Route::get('rotorcoderodajept/1', [App\Http\Controllers\RotorCodRodajePt1Controller::class, 'index'])->name('rotorcoderpt1.index');

	Route::get('rotorcoderodajept/1/list', [App\Http\Controllers\RotorCodRodajePt1Controller::class, 'list'])->name('rotorcoderpt1.list');

	Route::get('rotorcoderodajept/1/crear', [App\Http\Controllers\RotorCodRodajePt1Controller::class, 'create'])->name('rotorcoderpt1.create');
	Route::post('rotorcoderodajept/1', [App\Http\Controllers\RotorCodRodajePt1Controller::class, 'store'])->name('rotorcoderpt1.store');
	Route::get('rotorcoderodajept/1/{id}/editar', [App\Http\Controllers\RotorCodRodajePt1Controller::class, 'edit'])->name('rotorcoderpt1.edit');
	Route::post('rotorcoderodajept/1/{id}/editar', [App\Http\Controllers\RotorCodRodajePt1Controller::class, 'update'])->name('rotorcoderpt1.update');
	//2
	Route::get('rotorcoderodajept/2', [App\Http\Controllers\RotorCodRodajePt2Controller::class, 'index'])->name('rotorcoderpt2.index');

	Route::get('rotorcoderodajept/2/list', [App\Http\Controllers\RotorCodRodajePt2Controller::class, 'list'])->name('rotorcoderpt2.list');

	Route::get('rotorcoderodajept/2/crear', [App\Http\Controllers\RotorCodRodajePt2Controller::class, 'create'])->name('rotorcoderpt2.create');
	Route::post('rotorcoderodajept/2', [App\Http\Controllers\RotorCodRodajePt2Controller::class, 'store'])->name('rotorcoderpt2.store');
	Route::get('rotorcoderodajept/2/{id}/editar', [App\Http\Controllers\RotorCodRodajePt2Controller::class, 'edit'])->name('rotorcoderpt2.edit');
	Route::post('rotorcoderodajept/2/{id}/editar', [App\Http\Controllers\RotorCodRodajePt2Controller::class, 'update'])->name('rotorcoderpt2.update');

	//Work Log
	Route::post('worklog/store', [App\Http\Controllers\WorkLogController::class, 'store'])->name('worklog.store');
	Route::post('worklog/{log}/update', [App\Http\Controllers\WorkLogController::class, 'update'])->name('worklog.update');
	Route::post('worklog/update-data', [App\Http\Controllers\WorkLogController::class, 'update_coldata'])->name('worklog.update_coldata');

});
