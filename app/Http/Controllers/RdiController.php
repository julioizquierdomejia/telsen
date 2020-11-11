<?php

namespace App\Http\Controllers;

use App\Models\Rdi;
use App\Models\RdiService;
use App\Models\RdiIngreso;
use App\Models\RdiServiceCost;
use App\Models\RdiMaintenanceType;
use App\Models\RdiCriticalityType;
use App\Models\Status;
use App\Models\Client;
use App\Models\MotorBrand;
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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        $rdis = Rdi::join('clients', 'clients.id', '=', 'rdi.client_id')
                ->select('rdi.*', 'clients.razon_social')
                ->where('rdi.enabled', 1)->get();

        return view('rdi.index', compact('rdis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $ot = Ot::where('enabled', 1)->where('id', $id)->firstOrFail();
        $counter = RDI::count() + 1;
        $clientes = Client::where('enabled', 1)->where('client_type_id', 1)->get();
        $marcas = MotorBrand::where('enabled', 1)->get();
        $maintenancetype = RdiMaintenanceType::where('enabled', 1)->get();
        $criticalitytype = RdiCriticalityType::where('enabled', 1)->get();
        $services = RdiService::where('enabled', 1)->get();

        return view('rdi.create', compact('ot', 'counter', 'clientes', 'marcas', 'services', 'maintenancetype', 'criticalitytype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rules = array(
            'rdi_codigo' => 'required|string',
            'version' => 'required|string',
            'client_id' => 'required|integer',
            'contact' => 'string|nullable',
            'area' => 'string|nullable',
            'equipo' => 'string|nullable',
            'codigo' => 'string|nullable',
            'ot' => 'string|nullable',
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

            'services' => 'array|required',
            'diagnostico_actual' => 'string|required',
            'aislamiento_masa_ingreso' => 'string|required',

            'rdi_maintenance_type_id' => 'integer|exists:rdi_services,id',
            'rdi_criticality_type_id' => 'integer|exists:rdi_criticality_types,id',
            'hecho_por' => 'string|nullable',
            'cost' => 'required||regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'enabled' => 'boolean|required',
        );
        $this->validate($request, $rules);

        $rdi = new Rdi();
        $rdi->rdi_codigo = $request->input('rdi_codigo');
        $rdi->version = $request->input('version');
        $rdi->client_id = $request->input('client_id');
        $rdi->contact = $request->input('contact');
        $rdi->area = $request->input('area');
        $rdi->equipo = $request->input('equipo');
        $rdi->codigo = $request->input('codigo');
        $rdi->ot = $request->input('ot');
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
        $rdi->enabled = $request->input('enabled');
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

        //Actividades por realizar
        $services = $request->input('services');
        if ($services) {
            $services_count = count($services);

            $services_array = [];
            foreach ($services as $key => $service) {
                if (isset($service[$key + 1])) {
                    $services_array[] = [
                        'rdi_id' => $rdi->id,
                        'rdi_service_id' => $key + 1,
                        'subtotal' => $service[$key + 1],
                    ];   
                }
            }
            RdiServiceCost::insert($services_array);
        }

        /*$status = Status::where('id', 4)->first();
        if ($status) {
            \DB::table('status_ot')->insert([
                'status_id' => $status->id,
                'ot_id' => $id,
            ]);
        }*/

        activitylog('rdis', 'store', null, $rdi->toArray());

        return redirect('rdi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rdi  $rdi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $crdi = Rdi::findOrFail($id);

        return view('rdi.show', compact('crdi'));
    }
    public function cc_show(Request $request, $ot_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $crdi = Rdi::where('ot_id', $ot_id)->firstOrFail();

        return view('rdi.show', compact('crdi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rdi  $rdi
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rdi = Rdi::join('clients', 'clients.id', '=', 'rdi.client_id')
                ->select('rdi.*', 'clients.razon_social')
                ->where('rdi.enabled', 1)->firstOrFail();
        $clientes = Client::where('enabled', 1)->where('client_type_id', 1)->get();
        $marcas = MotorBrand::where('enabled', 1)->get();
        $maintenancetype = RdiMaintenanceType::where('enabled', 1)->get();
        $criticalitytype = RdiCriticalityType::where('enabled', 1)->get();
        $services = RdiService::where('enabled', 1)->get();
        return view('rdi.edit', compact('rdi', 'clientes', 'marcas', 'services', 'maintenancetype', 'criticalitytype'));
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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required|string|unique:rdis,name,'.$id,
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        // update
        $rdi = Rdi::findOrFail($id);
        $original_data = $rdi->toArray();

        $rdi->name       = $request->get('name');
        $rdi->enabled    = $request->get('enabled');
        $rdi->save();

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
