<?php

namespace App\Http\Controllers;

use App\Models\Rdi;
use App\Models\RdiService;
use App\Models\RdiIngreso;
//use App\Models\RdiServiceCost;
//use App\Models\RdiWork;
use App\Models\OtWork;
use App\Models\ElectricalEvaluationWork;
use App\Models\MechanicalEvaluationWork;
use App\Models\RdiMaintenanceType;
use App\Models\RdiCriticalityType;
use App\Models\Status;
use App\Models\StatusOt;
use App\Models\Service;
use App\Models\Area;
use App\Models\Client;
use App\Models\MotorBrand;
use App\Models\Ot;
use Illuminate\Http\Request;

class RdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'rdi']);
        
        /*$rdis = Ot::join('clients', 'clients.id', '=', 'ots.client_id')
                //->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->leftJoin('cost_cards', 'cost_cards.ot_id', '=', 'ots.id')
                ->join('electrical_evaluations as ee_val', 'ee_val.ot_id', '=', 'ots.id')
                ->join('mechanical_evaluations as me_val', 'me_val.ot_id', '=', 'ots.id')
                ->select('ots.*', 'clients.razon_social', 'ee_val.nro_equipo', 'ee_val.conex', 'me_val.hp_kw'
                )
                ->where('ots.enabled', 1)
                ->where('clients.client_type_id', 1)
                ->where('clients.enabled', 1)
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_approved');
                })
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'me_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'rdi_waiting');
                })
                ->get();*/

        /*$rdis = [];
        foreach ($_ots as $key => $ot) {
            $array = array_column($ot->statuses->toArray(), "name");
            if (in_array("me", $array) && in_array("ee", $array) && !in_array("cc", $array) && !in_array("rdi_waiting", $array)) {
                $rdis[] = $ot;
            }
        }*/

        return view('rdi.index'/*, compact('rdis')*/);
    }

    public function list_group(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'aprobador_rdi']);
        
        return view('rdi.list_group');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request, $ot_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'rdi']);

        $rdi = Rdi::where('ot_id', $ot_id)->first();
        if ($rdi) {
            return redirect('rdi/'.$rdi->id.'/ver');
        }
        $ot = Ot::where('ots.enabled', 1)
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->join('electrical_evaluations as ee_val', 'ee_val.ot_id', '=', 'ots.id')
                ->join('mechanical_evaluations as me_val', 'me_val.ot_id', '=', 'ots.id')
                ->select('ots.*', 'clients.razon_social')
                ->where('ots.id', $ot_id)
                ->firstOrFail();
        $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '=', 5)->get();
        $counter = RDI::count() + 1;
        $clientes = Client::where('enabled', 1)->where('client_type_id', 1)->get();
        $marcas = MotorBrand::where('enabled', 1)->get();
        $maintenancetype = RdiMaintenanceType::where('enabled', 1)->get();
        $criticalitytype = RdiCriticalityType::where('enabled', 1)->get();
        //$services = RdiService::where('enabled', 1)->get();
        /*$services = Service::where('enabled', 1) //Servicios de area cliente
                ->where('enabled', 1)
                ->where('area_id', 5) //Area clientes
                ->select('services.id', 'services.name')
                ->get();*/

        $works_el = OtWork::join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select(
                    'ot_works.description',
                    'ot_works.medidas',
                    'ot_works.qty',
                    'ot_works.personal',
                    'services.name as service',
                    'services.id as service_id',
                    'areas.name as area',
                    'areas.id as area_id'
                )
                ->where('ot_works.type', 'electrical')
                ->where('ots.id', $ot->id)
                ->get();
        $works_mec = OtWork::join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select(
                    'ot_works.description',
                    'ot_works.medidas',
                    'ot_works.qty',
                    'ot_works.personal',
                    'services.name as service',
                    'services.id as service_id',
                    'areas.name as area',
                    'areas.id as area_id'
                )
                ->where('ot_works.type', 'mechanical')
                ->where('ots.id', $ot->id)
                ->get();

        return view('rdi.calcular', compact('ot', 'counter', 'clientes', 'marcas', 'maintenancetype', 'criticalitytype', 'works_el', 'works_mec', 'areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'rdi']);

        $rules = array(
            'rdi_codigo' => 'required|string',
            'version' => 'required|string',
            //'client_id' => 'required|integer',
            'contact' => 'string|nullable',
            'area' => 'string|nullable',
            'equipo' => 'string|nullable',
            'codigo' => 'string|nullable',
            'ot_id' => 'integer|exists:ots,id',
            'fecha_ingreso' => 'required|date_format:Y-m-d',
            'tiempo_entrega' => 'integer|required',
            'orden_servicio' => 'string|nullable',
            'marca_id' => 'integer|required',
            'nro_serie' => 'string|nullable',
            'frame' => 'string|nullable',
            'potencia' => 'string|nullable',
            'tension' => 'string|nullable',
            'corriente' => 'string|nullable',
            'velocidad' => 'string|nullable',
            'conexion' => 'string|nullable',
            'deflexion_eje' => 'string|nullable',
            'rodaje_delantero' => 'string|nullable',
            'rodaje_posterior' => 'string|nullable',
            'antecedentes' => 'string|nullable',

            'placa_caracteristicas' => 'boolean|nullable',
            'caja_conexion' => 'boolean|nullable',
            'bornera' => 'boolean|nullable',
            'escudos' => 'boolean|nullable',
            'ejes' => 'boolean|nullable',
            'funda' => 'boolean|nullable',
            'ventilador' => 'boolean|nullable',
            'acople' => 'boolean|nullable',
            'chaveta' => 'boolean|nullable',

            //'services' => 'array|required',
            'diagnostico_actual' => 'string|required',
            'aislamiento_masa_ingreso' => 'string|required',

            'rdi_maintenance_type_id' => 'required|integer|exists:rdi_maintenance_types,id',
            'rdi_criticality_type_id' => 'required|integer|exists:rdi_criticality_types,id',
            'hecho_por' => 'string|nullable',
            //'cost' => 'required||regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'enabled' => 'boolean|required',

            'works' => 'array',
        );
        $this->validate($request, $rules);

        $rdi = new Rdi();
        $rdi->rdi_codigo = $request->input('rdi_codigo');
        $rdi->version = $request->input('version');
        //$rdi->client_id = $request->input('client_id');
        $rdi->contact = $request->input('contact');
        $rdi->area = $request->input('area');
        $rdi->equipo = $request->input('equipo');
        $rdi->codigo = $request->input('codigo');
        $rdi->ot_id = $request->input('ot_id');
        $rdi->fecha_ingreso = $request->input('fecha_ingreso');
        $rdi->tiempo_entrega = $request->input('tiempo_entrega');
        $rdi->orden_servicio = $request->input('orden_servicio');
        $rdi->marca_id = $request->input('marca_id');
        $rdi->nro_serie = $request->input('nro_serie');
        $rdi->frame = $request->input('frame');
        $rdi->potencia = $request->input('potencia');
        $rdi->tension = $request->input('tension');
        $rdi->corriente = $request->input('corriente');
        $rdi->velocidad = $request->input('velocidad');
        $rdi->conexion = $request->input('conexion');
        $rdi->deflexion_eje = $request->input('deflexion_eje');
        $rdi->rodaje_delantero = $request->input('rodaje_delantero');
        $rdi->rodaje_posterior = $request->input('rodaje_posterior');
        $rdi->antecedentes = $request->input('antecedentes');
        $rdi->diagnostico_actual = $request->input('diagnostico_actual');
        $rdi->aislamiento_masa_ingreso = $request->input('aislamiento_masa_ingreso');
        $rdi->rdi_maintenance_type_id = $request->input('rdi_maintenance_type_id');
        $rdi->rdi_criticality_type_id = $request->input('rdi_criticality_type_id');
        $rdi->hecho_por = $request->input('hecho_por');
        //$rdi->cost = $request->input('cost');
        $rdi->enabled = $request->has('enabled');
        $rdi->save();

        //Ingresó con
        $placa_caracteristicas = $request->input('placa_caracteristicas') ?? 0;
        $caja_conexion = $request->input('caja_conexion') ?? 0;
        $bornera = $request->input('bornera') ?? 0;
        $escudos = $request->input('escudos') ?? 0;
        $ejes = $request->input('ejes') ?? 0;
        $funda = $request->input('funda') ?? 0;
        $ventilador = $request->input('ventilador') ?? 0;
        $acople = $request->input('acople') ?? 0;
        $chaveta = $request->input('chaveta') ?? 0;

        $rdi_ingreso = new RdiIngreso();
        $rdi_ingreso->rdi_id = $rdi->id;
        $rdi_ingreso->placa_caracteristicas = $placa_caracteristicas;
        $rdi_ingreso->caja_conexion = $caja_conexion;
        $rdi_ingreso->bornera = $bornera;
        $rdi_ingreso->escudos = $escudos;
        $rdi_ingreso->ejes = $ejes;
        $rdi_ingreso->funda = $funda;
        $rdi_ingreso->ventilador = $ventilador;
        $rdi_ingreso->acople = $acople;
        $rdi_ingreso->chaveta = $chaveta;
        $rdi_ingreso->save();

        $works = $request->input('works');
        foreach ($works as $key => $item) {
            if (isset($item['service_id'])) {
                $rdi_work = new OtWork();
                $rdi_work->ot_id = $rdi->ot_id;
                $rdi_work->type = "rdi";
                $rdi_work->service_id = isset($item['service_id']) ? $item['service_id'] : '';
                $rdi_work->description = isset($item['description']) ? $item['description'] : '';
                $rdi_work->medidas = isset($item['medidas']) ? $item['medidas'] : '';
                $rdi_work->qty = isset($item['qty']) ? $item['qty'] : '';
                $rdi_work->personal = isset($item['personal']) ? $item['personal'] : '';
                $rdi_work->save();
            }
        }

        //Actividades por realizar
        /*$services = $request->input('services');
        if ($services) {
            //$services_count = count($services);

            foreach ($services as $key => $service) {
                if (isset($service)) {
                    $services_array[] = [
                        'rdi_id' => $rdi->id,
                        'service_id' => $key,
                        'subtotal' => $service,
                    ];   
                }
            }
            RdiServiceCost::insert($services_array);
        }*/

        $status = Status::where('name', 'rdi_waiting')->first();
        if ($status) {
            $status_ot = new StatusOt();
            $status_ot->status_id = $status->id;
            $status_ot->ot_id = $rdi->ot_id;
            $status_ot->save();
        }

        activitylog('rdis', 'store', null, $rdi->toArray());

        return redirect('rdi');
    }

    public function approveRDI(Request $request, $ot_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'aprobador_rdi']);

        $action = $request->input('action');

        $exist_status = StatusOt::join('status', 'status.id', '=', 'status_ot.status_id')
                        ->select('status.*')
                        ->where('ot_id', $ot_id)
                        ->where('name', "rdi_approved")->where('name', "rdi_disapproved")
                        ->first();
        if ($exist_status) {
            return response()->json(['data'=>'RDI ya cambió de estado', 'success'=>false]);
        } else {
            if ($action == 1) {
                $status = Status::where('name', 'rdi_approved')->first();
                if ($status) {
                    $data = new StatusOt();
                    $data->status_id = $status->id;
                    $data->ot_id = $ot_id;
                    $data->save();
                }
            } else /*if($action == 2)*/ {
                $status = Status::where('name', 'rdi_disapproved')->first();
                if ($status) {
                    $data = new StatusOt();
                    $data->status_id = $status->id;
                    $data->ot_id = $ot_id;
                    $data->save();
                }
            }
            activitylog('rdi_approved', 'store', null, $data->getOriginal());

            return response()->json(['data'=>json_encode($data),'success'=>true]);
        }
        return response()->json(['success'=>false]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rdi  $rdi
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'rdi', 'aprobador_rdi', 'fecha_de_entrega']);

        $rdi = Rdi::join('ots', 'ots.id', '=', 'rdi.ot_id')
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->join('motor_brands', 'motor_brands.id', '=', 'rdi.marca_id')
                ->join('rdi_maintenance_types', 'rdi_maintenance_types.id', '=', 'rdi.rdi_maintenance_type_id')
                ->join('rdi_criticality_types', 'rdi_criticality_types.id', '=', 'rdi.rdi_criticality_type_id')
                ->select('rdi.*', 'clients.razon_social', 'motor_brands.name as marca', 'rdi_maintenance_types.name as maintenancetype', 'rdi_criticality_types.name as criticalitytype', 'ots.fecha_entrega')
                ->where('rdi.id', $id)
                ->firstOrFail();

        $ingresos = RdiIngreso::where('rdi_id', $id)->first();

        /*$services = RdiServiceCost::where('rdi_id', $id)
                    ->join('services', 'services.id', '=', 'rdi_service_costs.service_id')
                    ->select('services.id', 'services.name', 'rdi_service_costs.subtotal')
                    ->get();*/
        $works = OtWork::join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select(
                    'ot_works.description',
                    'ot_works.medidas',
                    'ot_works.qty',
                    'ot_works.personal',
                    'services.name as service',
                    'services.id as service_id',
                    'areas.name as area',
                    'areas.id as area_id'
                )
                ->where('ot_works.type', 'rdi')
                ->where('ots.id', $rdi->ot_id)
                ->get();

        $ot_status = StatusOt::join('status', 'status_ot.status_id', '=', 'status.id')
                      ->where('status_ot.ot_id', '=', $rdi->ot_id)
                      ->select('status.id', 'status_ot.status_id', 'status.name')
                      ->get();

        $maded_by = \DB::table('logs')
                        ->join('users', 'users.id', '=', 'logs.user_id')
                        ->join('user_data', 'users.id', '=', 'user_data.user_id')
                        ->where('logs.section', 'rdis')
                        ->where('logs.action', 'store')
                        ->where('logs.data', 'like', '%"ot_id":"'. $rdi->ot_id . '"%')
                        ->select('logs.*', 'user_data.name')
                        ->first();

        $approved_by = \DB::table('logs')
                        ->join('users', 'users.id', '=', 'logs.user_id')
                        ->join('user_data', 'users.id', '=', 'user_data.user_id')
                        ->where('logs.action', 'store')
                        ->where('logs.section', 'rdi_approved')
                        ->where('logs.data', 'like', '%"ot_id":"'. $rdi->ot_id . '"%')
                        ->select('logs.*', 'users.email', 'user_data.name')
                        ->first();

        return view('rdi.show', compact('rdi', 'works', 'ingresos', 'ot_status', 'maded_by', 'approved_by'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rdi  $rdi
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'rdi']);

        $rdi = Rdi::join('ots', 'ots.id', '=', 'rdi.ot_id')
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->join('motor_brands', 'motor_brands.id', '=', 'rdi.marca_id')
                ->join('rdi_maintenance_types', 'rdi_maintenance_types.id', '=', 'rdi.rdi_maintenance_type_id')
                ->join('rdi_criticality_types', 'rdi_criticality_types.id', '=', 'rdi.rdi_criticality_type_id')
                ->join('rdi_ingresos', 'rdi_ingresos.rdi_id', '=', 'rdi.id')
                ->select('rdi.*', 'clients.razon_social', 'motor_brands.name as marca', 'rdi_maintenance_types.id as maintenancetype', 'rdi_criticality_types.id as criticalitytype', 'ots.fecha_entrega',
                    'rdi_ingresos.placa_caracteristicas',
                    'ots.code as ot_code',
                    'rdi_ingresos.caja_conexion',
                    'rdi_ingresos.bornera',
                    'rdi_ingresos.escudos',
                    'rdi_ingresos.ejes',
                    'rdi_ingresos.funda',
                    'rdi_ingresos.ventilador',
                    'rdi_ingresos.acople',
                    'rdi_ingresos.chaveta'
            )
                ->where('rdi.id', $id)
                ->firstOrFail();
        $clientes = Client::where('enabled', 1)->where('client_type_id', 1)->get();
        $marcas = MotorBrand::where('enabled', 1)->get();
        $maintenancetype = RdiMaintenanceType::where('enabled', 1)->get();
        $criticalitytype = RdiCriticalityType::where('enabled', 1)->get();
        /*$services = RdiServiceCost::where('rdi_id', $id)
                    ->join('rdi_services', 'rdi_services.id', '=', 'rdi_service_costs.service_id')
                    ->select('rdi_services.id', 'rdi_services.name', 'rdi_service_costs.subtotal')
                    ->where('rdi_services.enabled', 1)
                    ->get();*/
        $works = OtWork::join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select(
                    'ot_works.description',
                    'ot_works.medidas',
                    'ot_works.qty',
                    'ot_works.personal',
                    'services.name as service',
                    'services.id as service_id',
                    'areas.name as area',
                    'areas.id as area_id'
                )
                ->where('ot_works.type', 'rdi')
                ->where('ots.id', $rdi->ot_id)
                ->get();

        $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '=', 5)->get();

        return view('rdi.edit', compact('rdi', 'clientes', 'marcas', 'works', 'maintenancetype', 'criticalitytype', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rdi  $rdi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'rdi']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'rdi_codigo' => 'required|string',
            'version' => 'required|string',
            //'client_id' => 'required|integer',
            'contact' => 'string|nullable',
            'area' => 'string|nullable',
            'equipo' => 'string|nullable',
            'codigo' => 'string|nullable',
            //'ot_id' => 'integer|exists:ots,id',
            'fecha_ingreso' => 'required|date_format:Y-m-d',
            'tiempo_entrega' => 'integer|required',
            'orden_servicio' => 'string|nullable',
            'marca_id' => 'integer|required',
            'nro_serie' => 'string|nullable',
            'frame' => 'string|nullable',
            'potencia' => 'string|nullable',
            'tension' => 'string|nullable',
            'corriente' => 'string|nullable',
            'velocidad' => 'string|nullable',
            'conexion' => 'string|nullable',
            'deflexion_eje' => 'string|nullable',
            'rodaje_delantero' => 'string|nullable',
            'rodaje_posterior' => 'string|nullable',
            'antecedentes' => 'string|nullable',

            'placa_caracteristicas' => 'boolean|nullable',
            'caja_conexion' => 'boolean|nullable',
            'bornera' => 'boolean|nullable',
            'escudos' => 'boolean|nullable',
            'ejes' => 'boolean|nullable',
            'funda' => 'boolean|nullable',
            'ventilador' => 'boolean|nullable',
            'acople' => 'boolean|nullable',
            'chaveta' => 'boolean|nullable',

            //'services' => 'array|required',
            'diagnostico_actual' => 'string|required',
            'aislamiento_masa_ingreso' => 'string|required',

            'rdi_maintenance_type_id' => 'required|integer|exists:rdi_maintenance_types,id',
            'rdi_criticality_type_id' => 'required|integer|exists:rdi_criticality_types,id',
            'hecho_por' => 'string|nullable',
            //'cost' => 'required||regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'enabled' => 'boolean|required',

            'works' => 'array',
        );
        $this->validate($request, $rules);

        // update
        $rdi = Rdi::findOrFail($id);
        $original_data = $rdi->toArray();

        $rdi->rdi_codigo = $request->input('rdi_codigo');
        $rdi->version = $request->input('version');
        $rdi->contact = $request->input('contact');
        $rdi->area = $request->input('area');
        $rdi->equipo = $request->input('equipo');
        $rdi->codigo = $request->input('codigo');
        $rdi->fecha_ingreso = $request->input('fecha_ingreso');
        $rdi->tiempo_entrega = $request->input('tiempo_entrega');
        $rdi->orden_servicio = $request->input('orden_servicio');
        $rdi->marca_id = $request->input('marca_id');
        $rdi->nro_serie = $request->input('nro_serie');
        $rdi->frame = $request->input('frame');
        $rdi->potencia = $request->input('potencia');
        $rdi->tension = $request->input('tension');
        $rdi->corriente = $request->input('corriente');
        $rdi->velocidad = $request->input('velocidad');
        $rdi->conexion = $request->input('conexion');
        $rdi->deflexion_eje = $request->input('deflexion_eje');
        $rdi->rodaje_delantero = $request->input('rodaje_delantero');
        $rdi->rodaje_posterior = $request->input('rodaje_posterior');
        $rdi->antecedentes = $request->input('antecedentes');
        $rdi->diagnostico_actual = $request->input('diagnostico_actual');
        $rdi->aislamiento_masa_ingreso = $request->input('aislamiento_masa_ingreso');
        $rdi->rdi_maintenance_type_id = $request->input('rdi_maintenance_type_id');
        $rdi->rdi_criticality_type_id = $request->input('rdi_criticality_type_id');
        $rdi->hecho_por = $request->input('hecho_por');
        $rdi->enabled = $request->has('enabled');
        $rdi->save();

        //Ingresó con
        $placa_caracteristicas = $request->input('placa_caracteristicas') ?? 0;
        $caja_conexion = $request->input('caja_conexion') ?? 0;
        $bornera = $request->input('bornera') ?? 0;
        $escudos = $request->input('escudos') ?? 0;
        $ejes = $request->input('ejes') ?? 0;
        $funda = $request->input('funda') ?? 0;
        $ventilador = $request->input('ventilador') ?? 0;
        $acople = $request->input('acople') ?? 0;
        $chaveta = $request->input('chaveta') ?? 0;

        $rdi_ingreso = RdiIngreso::where('rdi_id', $rdi->id)->first();
        $rdi_ingreso->rdi_id = $rdi->id;
        $rdi_ingreso->placa_caracteristicas = $placa_caracteristicas;
        $rdi_ingreso->caja_conexion = $caja_conexion;
        $rdi_ingreso->bornera = $bornera;
        $rdi_ingreso->escudos = $escudos;
        $rdi_ingreso->ejes = $ejes;
        $rdi_ingreso->funda = $funda;
        $rdi_ingreso->ventilador = $ventilador;
        $rdi_ingreso->acople = $acople;
        $rdi_ingreso->chaveta = $chaveta;
        $rdi_ingreso->save();

        OtWork::where('ot_id', $rdi->ot_id)->delete();

        $works = $request->input('works');
        foreach ($works as $key => $item) {
            if (isset($item['service_id'])) {
                $rdi_work = new OtWork();
                $rdi_work->ot_id = $rdi->ot_id;
                $rdi_work->type = "rdi";
                $rdi_work->service_id = isset($item['service_id']) ? $item['service_id'] : '';
                $rdi_work->description = isset($item['description']) ? $item['description'] : '';
                $rdi_work->medidas = isset($item['medidas']) ? $item['medidas'] : '';
                $rdi_work->qty = isset($item['qty']) ? $item['qty'] : '';
                $rdi_work->personal = isset($item['personal']) ? $item['personal'] : '';
                $rdi_work->save();
            }
        }

        activitylog('rdi', 'update', $original_data, $rdi->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated rdi!');
        return redirect('rdi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rdi  $rdi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Rdi $rdi)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
