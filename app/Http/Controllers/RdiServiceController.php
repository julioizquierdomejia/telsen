<?php

namespace App\Http\Controllers;

use App\Models\RdiService;
use Illuminate\Http\Request;

class RdiServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rdi_services = RdiService::where('enabled', 1)->get();
        return view('rdi_services.index', compact('rdi_services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        return view('rdi_services.create');
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
            'name'       => 'string|required',
            'subtotal'      => 'string|required',
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        $rdiservices = new RdiService();
        
        $rdiservices->name = $request->input('name');
        $rdiservices->subtotal = $request->input('subtotal');
        $rdiservices->enabled = $request->input('enabled');

        $rdiservices->save();

        activitylog('rdiservices', 'store', null, $rdiservices->toArray());

        $rdi_services = RdiService::where('enabled', 1)->get();
        return redirect('rdi_services')->with('rdi_services');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RdiService  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $marca = Client::findOrFail($id);

        return view('rdi_services.show', compact('marca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RdiService  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $modelo = RdiService::findOrFail($id);
        return view('rdiservices.edit', compact('modelo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RdiService  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'string|required',
            'subtotal'      => 'string|required',
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        $model = RdiService::findOrFail($id);
        $original_data = $model->toArray();
        $model->name       = $request->get('name');
        $model->subtotal  = $request->get('subtotal');
        $model->enabled      = $request->get('enabled');
        $model->save();

        activitylog('rdiservices', 'update', $original_data, $model->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated model!');
        return redirect('rdiservices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RdiService  $brandMotor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RdiService $brandMotor)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
