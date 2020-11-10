<?php

namespace App\Http\Controllers;

use App\Models\RdiMaintenanceType;
use Illuminate\Http\Request;

class RdiMaintenanceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rdi_maintenance_types = RdiMaintenanceType::where('enabled', 1)->get();
        return view('rdi_maintenance_types.index', compact('rdi_maintenance_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        return view('rdi_maintenance_types.create');
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
            'name'       => 'string|required|unique:rdi_criticality_types',
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        $rdictypes = new RdiMaintenanceType();
        
        $rdictypes->name = $request->input('name');
        $rdictypes->enabled = $request->input('enabled');

        $rdictypes->save();

        activitylog('rdicriticalitytypes', 'store', null, $rdictypes->toArray());

        $rdi_maintenance_types = RdiMaintenanceType::where('enabled', 1)->get();
        return redirect('rdi_maintenance_types')->with('rdi_maintenance_types');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RdiMaintenanceType  $RdiMaintenanceType
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rdicriticalitytype = Client::findOrFail($id);

        return view('rdi_maintenance_types.show', compact('rdicriticalitytype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RdiMaintenanceType  $RdiMaintenanceType
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rdicriticalitytype = RdiMaintenanceType::findOrFail($id);
        return view('rdicriticalitytypes.edit', compact('rdicriticalitytype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RdiMaintenanceType  $RdiMaintenanceType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'string|required|unique:rdi_criticality_types,name,'.$id,
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        $rdictype = RdiMaintenanceType::findOrFail($id);
        $original_data = $rdictype->toArray();
        $rdictype->name       = $request->get('name');
        $rdictype->enabled    = $request->get('enabled');
        $rdictype->save();

        activitylog('rdicriticalitytypes', 'update', $original_data, $rdictype->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated rdi_criticality_type!');
        return redirect('rdicriticalitytypes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RdiMaintenanceType  $RdiMaintenanceType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RdiMaintenanceType $RdiMaintenanceType)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
