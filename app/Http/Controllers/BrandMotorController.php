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
        return view('marca.index', compact('marcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BrandMotor  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function show(BrandMotor $brandMotor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BrandMotor  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function edit(BrandMotor $brandMotor)
    {
        //
        return 'Editamos la marca';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BrandMotor  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BrandMotor $brandMotor)
    {
        //
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
