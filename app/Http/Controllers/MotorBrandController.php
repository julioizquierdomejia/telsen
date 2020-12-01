<?php

namespace App\Http\Controllers;

use App\Models\MotorBrand;
use Illuminate\Http\Request;

class MotorBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        $marcas = MotorBrand::where('enabled', 1)->get();
        return view('marcas.index', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        return view('marcas.create');
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
            'name'       => 'string|required|unique:motor_brands',
            'description'      => 'string|nullable',
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        $brand = new MotorBrand();
        
        $brand->name = $request->input('name');
        $brand->description = $request->input('description');
        $brand->enabled = $request->input('enabled');

        $brand->save();

        activitylog('brands', 'store', null, $brand->toArray());

        $marcas = MotorBrand::where('enabled', 1)->get();
        return redirect('marcas')->with('marcas');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MotorBrand  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $marca = Client::findOrFail($id);

        return view('marcas.show', compact('marca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MotorBrand  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $marca = MotorBrand::findOrFail($id);
        return view('marcas.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MotorBrand  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required|string|unique:motor_brands,name,'.$id,
            'description'      => 'string|nullable',
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        // update
        $brand = MotorBrand::findOrFail($id);
        $original_data = $brand->toArray();

        $brand->name       = $request->get('name');
        $brand->description      = $request->get('description');
        $brand->enabled      = $request->get('enabled');
        $brand->save();

        activitylog('brands', 'update', $original_data, $brand->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated marca!');
        return redirect('marcas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MotorBrand  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MotorBrand $brandMotor)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
