<?php

namespace App\Http\Controllers;

use App\Models\RotorCodRodajePt2;
use Illuminate\Http\Request;

class RotorCodRodajePt2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        $cods = RotorCodRodajePt2::where('enabled', 1)->get();
        return view('cods.index', compact('cods'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        return view('clientes.create');
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

        $rules = [
            'name' => 'required',
            'asiento_rodaje' => 'string|required',
            'alojamiento_rodaje' => 'string|required',
            'enabled' => 'boolean',
        ];

        $this->validate($request, $rules);

        //creamos una variable que es un objeto de nuesta instancia de nuestro modelo
        $rotor_cod = new RotorCodRodajePt2();
        
        $rotor_cod->name = $request->input('name');
        $rotor_cod->asiento_rodaje = $request->input('asiento_rodaje');
        $rotor_cod->alojamiento_rodaje = $request->input('alojamiento_rodaje');
        $rotor_cod->enabled = $request->input('enabled');

        $rotor_cod->save();

        activitylog('rotor cod rodaje pt2', 'store', null, $rotor_cod->toArray());

        return redirect('rotores');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $cods = RotorCodRodajePt2::where('enabled', 1)->findOrFail($id);
        return $cods;

        //return view('clientes.show', compact('cliente'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $cods = RotorCodRodajePt2::where('enabled', 1)->findOrFail($id);
        return view('clientes.edit', compact('cods'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rules = array(
            'name' => 'required',
            'asiento_rodaje' => 'string|required',
            'alojamiento_rodaje' => 'string|required',
            'enabled' => 'boolean',
        );
        $this->validate($request, $rules);

        // update
        $rotor_cod = RotorCodRodajePt2::find($id);
        $original_data = $rotor_cod->toArray();
        
        $rotor_cod->name = $request->input('name');
        $rotor_cod->asiento_rodaje = $request->input('asiento_rodaje');
        $rotor_cod->alojamiento_rodaje = $request->input('alojamiento_rodaje');
        $rotor_cod->enabled = $request->input('enabled');

        $rotor_cod->save();

        activitylog('rotor cod rodaje pt2', 'update', $original_data, $client->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated model!');
        return redirect('clientes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Client $client)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
