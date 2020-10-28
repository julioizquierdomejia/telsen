<?php

namespace App\Http\Controllers;

use App\Models\Ot;
use App\Models\Client;
use App\Models\BrandMotor;
use App\Models\ModelMotor;
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
        //Listar OTs
        $ordenes = Ot::all();

        return view('ordenes.index', compact('ordenes'));
    }

    public function list(Request $request)
    {
        //Listar OTs
        $ordenes = Ot::all();

        return view('ordenes.list', compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        //
        //Revisar el ultimo numero de OT
        $totalOts = Ot::count();
        $ot_numero = $totalOts + 1;

        $clientes = Client::all();
        $marcas = BrandMotor::all();
        $modelos = ModelMotor::all();


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
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        //
        $rules = [
            'client_id' => 'required|integer',
            'fecha_creacion' => 'required',
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
        ];

        $messages = [
            //'ruc.required' => 'Agrega el nombre del estudiante.',
        ];

        $this->validate($request, $rules);

        //creamos una variable que es un objeto de nuesta instancia de nuestro modelo
        $ot = new Ot();
        
        $ot->client_id = $request->input('client_id');
        $ot->fecha_creacion = $request->input('fecha_creacion');
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

        $ot->save();

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
        $orden = Ot::findOrFail($id);

        $ordenes = Ot::where('id', '<>', $id)->get();

        return view('ordenes.show', compact('orden', 'ordenes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $clientes = Client::all();
        $marcas = BrandMotor::all();
        $modelos = ModelMotor::all();
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
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rules = array(
            'client_id' => 'required|integer',
            'fecha_creacion' => 'required',
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
        );
        $validator = \Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('ordenes/' . $id . '/editar')
                ->withErrors($validator);
        } else {
            // store
            $ot = Ot::find($id);
            $ot->client_id = $request->get('client_id');
            $ot->fecha_creacion = $request->get('fecha_creacion');
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
            $ot->save();

            // redirect
            \Session::flash('message', '¡Se actualizó la orden!');
            return redirect('ordenes');
        }
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
