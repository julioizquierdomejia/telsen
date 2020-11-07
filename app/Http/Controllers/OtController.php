<?php

namespace App\Http\Controllers;

use App\Models\Ot;
use App\Models\Client;
use App\Models\BrandMotor;
use App\Models\ModelMotor;
use App\Models\Status;
use Illuminate\Http\Request;

class OtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception', 'mechanical', 'electrical']);
        
        //Listar OTs
        $ordenes = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->select('ots.*', 'clients.razon_social')->get();

        return view('ordenes.index', compact('ordenes'));
    }

    public function list(Request $request)
    {
        $request->user()->authorizeRoles(['client']);
        //Listar OTs
        $ordenes = Ot::all();

        return view('procesovirtual.list', compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        //
        //Revisar el ultimo numero de OT
        $totalOts = Ot::count();
        $ot_numero = $totalOts + 1;

        $clientes = Client::where('enabled', 1)->get();
        $marcas = BrandMotor::where('enabled', 1)->get();
        $modelos = ModelMotor::where('enabled', 1)->get();

        return view('ordenes.create', compact('ot_numero', 'clientes', 'marcas', 'modelos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        //
        $rules = [
            'client_id' => 'required|integer',
            //'fecha_creacion' => 'required',
            'guia_cliente' => 'nullable|string',
            //'solped' => 'required',
            'descripcion_motor' => 'nullable|string',
            'codigo_motor' => 'nullable|string',
            'marca_id' => 'nullable|string',
            'modelo_id' => 'nullable|string',
            'numero_potencia' => 'nullable|string',
            'medida_potencia' => 'nullable|string',
            'voltaje' => 'nullable|string',
            'velocidad' => 'nullable|string',
            'enabled' => 'boolean',
        ];

        $messages = [
            //'ruc.required' => 'Agrega el nombre del estudiante.',
        ];

        $this->validate($request, $rules);

        //creamos una variable que es un objeto de nuesta instancia de nuestro modelo
        $ot = new Ot();
        
        $ot->client_id = $request->input('client_id');
        //$ot->fecha_creacion = $request->input('fecha_creacion');
        $ot->guia_cliente = $request->input('guia_cliente');
        //$ot->solped = $request->input('solped');
        $ot->descripcion_motor = $request->input('descripcion_motor');
        $ot->codigo_motor = $request->input('codigo_motor');
        $ot->marca_id = $request->input('marca_id');
        $ot->modelo_id = $request->input('modelo_id');
        $ot->numero_potencia = $request->input('numero_potencia');
        $ot->medida_potencia = $request->input('medida_potencia');
        $ot->voltaje = $request->input('voltaje');
        $ot->velocidad = $request->input('velocidad');
        $ot->enabled = $request->input('enabled');

        $ot->save();

        $status = Status::where('id', 1)->first();
        if ($status) {
            \DB::table('status_ot')->insert([
                'status_id' => $status->id,
                'ot_id' => $ot->id,
            ]);
        }

        activitylog('ots', 'store', null, $ot->toArray());

        return redirect('ordenes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['client']);
        
        $orden = Ot::findOrFail($id);

        $ordenes = Ot::where('id', '<>', $id)->get();

        return view('procesovirtual.show', compact('orden', 'ordenes'));
    }

    public function pvirtual(Request $request)
    {
        $request->user()->authorizeRoles(['client']);

        $ordenes = Ot::all();
        return view('procesovirtual.index', compact('ordenes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $clientes = Client::where('enabled', 1)->get();
        $marcas = BrandMotor::where('enabled', 1)->get();
        $modelos = ModelMotor::where('enabled', 1)->get();
        $orden = Ot::findOrFail($id);

        return view('ordenes.edit', compact('orden', 'clientes', 'marcas', 'modelos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rules = array(
            'client_id' => 'required|integer',
            //'fecha_creacion' => 'required',
            'guia_cliente' => 'required',
            //'solped' => 'required',
            'descripcion_motor' => 'required',
            'codigo_motor' => 'required',
            'marca_id' => 'required',
            'modelo_id' => 'required',
            'numero_potencia' => 'required',
            'medida_potencia' => 'required',
            'voltaje' => 'required',
            'velocidad' => 'required',
            'enabled' => 'boolean',
        );
        $this->validate($request, $rules);

        $ot = Ot::find($id);
        $original_data = $ot->toArray();
        $ot->client_id = $request->get('client_id');
        //$ot->fecha_creacion = $request->get('fecha_creacion');
        $ot->guia_cliente = $request->get('guia_cliente');
        //$ot->solped = $request->get('solped');
        $ot->descripcion_motor = $request->get('descripcion_motor');
        $ot->codigo_motor = $request->get('codigo_motor');
        $ot->marca_id = $request->get('marca_id');
        $ot->modelo_id = $request->get('modelo_id');
        $ot->numero_potencia = $request->get('numero_potencia');
        $ot->medida_potencia = $request->get('medida_potencia');
        $ot->voltaje = $request->get('voltaje');
        $ot->velocidad = $request->get('velocidad');
        $ot->enabled = $request->get('enabled');
        $ot->save();

        activitylog('ots', 'update', $original_data, $ot->toArray());

        // redirect
        \Session::flash('message', '¡Se actualizó la orden!');
        return redirect('ordenes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ot $ot)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
