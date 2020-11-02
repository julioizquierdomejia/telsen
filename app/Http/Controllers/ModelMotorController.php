<?php

namespace App\Http\Controllers;

use App\Models\ModelMotor;
use Illuminate\Http\Request;

class ModelMotorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $modelos = ModelMotor::all();
        return view('modelos.index', compact('modelos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        return view('modelos.create');
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

        $brand = new ModelMotor();
        
        $brand->name = $request->input('name');
        $brand->description = $request->input('description');

        $brand->save();

        $modelos = ModelMotor::all();
        return redirect('modelos')->with('modelos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModelMotor  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $marca = Client::findOrFail($id);

        return view('modelos.show', compact('marca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModelMotor  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $modelo = ModelMotor::findOrFail($id);
        return view('modelos.edit', compact('modelo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModelMotor  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'description'      => 'required',
        );
        $validator = \Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('modelos/' . $id . '/editar')
                ->withErrors($validator);
        } else {
            // store
            $marca = ModelMotor::find($id);
            $marca->name       = $request->get('name');
            $marca->description      = $request->get('description');
            $marca->save();

            // redirect
            \Session::flash('message', 'Successfully updated marca!');
            return redirect('modelos');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModelMotor  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ModelMotor $brandMotor)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
