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
    public function index()
    {
        //
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
        //
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
        //
        $brand = new ModelMotor();
        
        $brand->name = $request->input('name');
        $brand->description = $request->input('description');

        $brand->save();

        $modelos = ModelMotor::all();
        return view('modelos.index', compact('modelos'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModelMotor  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $marca = Client::findOrFail($id);

        return view('modelos.show', compact('marca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModelMotor  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $marca = ModelMotor::findOrFail($id);
        return view('modelos.edit', compact('marca'));
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
    public function destroy(ModelMotor $brandMotor)
    {
        //
    }
}
