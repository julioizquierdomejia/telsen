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
    public function index()
    {
        //
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
        //
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
        //
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
    public function edit($id)
    {
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
    public function destroy(BrandMotor $brandMotor)
    {
        //
    }
}
