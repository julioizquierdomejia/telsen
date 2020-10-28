<?php

namespace App\Http\Controllers;

use App\Models\BrandMotor;
use Illuminate\Http\Request;

class BrandMotorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        $marcas = BrandMotor::all();
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

        $brand = new BrandMotor();
        
        $brand->name = $request->input('name');
        $brand->description = $request->input('description');

        $brand->save();

        $marcas = BrandMotor::all();
        return view('marcas.index', compact('marcas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BrandMotor  $brandMotor
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
     * @param  \App\Models\BrandMotor  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $marca = BrandMotor::findOrFail($id);
        return view('marcas.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BrandMotor  $brandMotor
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
            return redirect('marcas/' . $id . '/editar')
                ->withErrors($validator);
        } else {
            // store
            $marca = BrandMotor::find($id);
            $marca->name       = $request->get('name');
            $marca->description      = $request->get('description');
            $marca->save();

            // redirect
            \Session::flash('message', 'Successfully updated marca!');
            return redirect('marcas');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BrandMotor  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, BrandMotor $brandMotor)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
