<?php

namespace App\Http\Controllers;

use App\Models\RdiIngreso;
use Illuminate\Http\Request;

class RdiIngresoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rdi_ingreso = RdiIngreso::where('enabled', 1)->get();
        return view('rdi_ingreso.index', compact('rdi_ingreso'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        return view('rdi_ingreso.create');
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

        $rules = array(
            'rdi_id' => 'boolean|required',
            'placa_caracteristicas' => 'boolean|required',
            'caja_conexion' => 'boolean|required',
            'bornera' => 'boolean|required',
            'escudos' => 'boolean|required',
            'ejes' => 'boolean|required',
            'funda' => 'boolean|required',
            'ventilador' => 'boolean|required',
            'acople' => 'boolean|required',
            'chaveta' => 'boolean|required',
            'enabled' => 'boolean|required',
        );
        $this->validate($request, $rules);

        $rdi_ingreso = new RdiIngreso();
        
        $rdi_ingreso->placa_caracteristicas = $request->get('placa_caracteristicas');
        $rdi_ingreso->caja_conexion = $request->get('caja_conexion');
        $rdi_ingreso->bornera = $request->get('bornera');
        $rdi_ingreso->escudos = $request->get('escudos');
        $rdi_ingreso->ejes = $request->get('ejes');
        $rdi_ingreso->funda = $request->get('funda');
        $rdi_ingreso->ventilador = $request->get('ventilador');
        $rdi_ingreso->acople = $request->get('acople');
        $rdi_ingreso->chaveta = $request->get('chaveta');
        $rdi_ingreso->enabled = $request->get('enabled');

        $rdi_ingreso->save();

        activitylog('rdi_ingreso', 'store', null, $rdi_ingreso->toArray());

        return redirect('rdi_ingreso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RdiIngreso  $RdiIngreso
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rdicriticalitytype = Client::findOrFail($id);

        return view('rdi_ingreso.show', compact('rdicriticalitytype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RdiIngreso  $RdiIngreso
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rdicriticalitytype = RdiIngreso::findOrFail($id);
        return view('rdi_ingreso.edit', compact('rdicriticalitytype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RdiIngreso  $RdiIngreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'rdi_id' => 'boolean|required',
            'placa_caracteristicas' => 'boolean|required',
            'caja_conexion' => 'boolean|required',
            'bornera' => 'boolean|required',
            'escudos' => 'boolean|required',
            'ejes' => 'boolean|required',
            'funda' => 'boolean|required',
            'ventilador' => 'boolean|required',
            'acople' => 'boolean|required',
            'chaveta' => 'boolean|required',
            'enabled' => 'boolean|required',
        );
        $this->validate($request, $rules);

        $rdi_ingreso = RdiIngreso::findOrFail($id);
        $original_data = $rdi_ingreso->toArray();

        $rdi_ingreso->placa_caracteristicas = $request->get('placa_caracteristicas');
        $rdi_ingreso->caja_conexion = $request->get('caja_conexion');
        $rdi_ingreso->bornera = $request->get('bornera');
        $rdi_ingreso->escudos = $request->get('escudos');
        $rdi_ingreso->ejes = $request->get('ejes');
        $rdi_ingreso->funda = $request->get('funda');
        $rdi_ingreso->ventilador = $request->get('ventilador');
        $rdi_ingreso->acople = $request->get('acople');
        $rdi_ingreso->chaveta = $request->get('chaveta');
        $rdi_ingreso->enabled    = $request->get('enabled');
        $rdi_ingreso->save();

        activitylog('rdi_ingreso', 'update', $original_data, $rdi_ingreso->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated rdi_criticality_type!');
        return redirect('rdi_ingreso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RdiIngreso  $RdiIngreso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RdiIngreso $RdiIngreso)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
