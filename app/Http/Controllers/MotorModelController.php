<?php

namespace App\Http\Controllers;

use App\Models\MotorModel;
use Illuminate\Http\Request;

class MotorModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $modelos = MotorModel::where('enabled', 1)->get();
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

        $rules = array(
            'name'       => 'string|required|unique:motor_models',
            'description'      => 'string|nullable',
            'enabled'      => 'boolean',
        );
        $this->validate($request, $rules);

        $brand = new MotorModel();
        
        $brand->name = $request->input('name');
        $brand->description = $request->input('description');
        $brand->enabled = $request->has('enabled');

        $brand->save();

        activitylog('models', 'store', null, $brand->toArray());

        $modelos = MotorModel::where('enabled', 1)->get();
        return redirect('modelos')->with('modelos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MotorModel  $brandMotor
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
     * @param  \App\Models\MotorModel  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $modelo = MotorModel::findOrFail($id);
        return view('modelos.edit', compact('modelo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MotorModel  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'string|required|unique:motor_models,name,'.$id,
            'description'      => 'string|nullable',
            'enabled'      => 'boolean',
        );
        $this->validate($request, $rules);

        $model = MotorModel::findOrFail($id);
        $original_data = $model->toArray();
        $model->name       = $request->get('name');
        $model->description  = $request->get('description');
        $model->enabled      = $request->get('enabled');
        $model->save();

        activitylog('models', 'update', $original_data, $model->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated model!');
        return redirect('modelos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MotorModel  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MotorModel $brandMotor)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
