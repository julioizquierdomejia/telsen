<?php

namespace App\Http\Controllers;

use App\Models\RdiCriticalityTypes;
use Illuminate\Http\Request;

class RdiCriticalityTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rdi_services = RdiCriticalityTypes::where('enabled', 1)->get();
        return view('rdi_services.index', compact('rdi_services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rules = array(
            'name'       => 'string|required|unique:rdi_criticality_types',
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        $rdictypes = new RdiCriticalityTypes();
        
        $rdictypes->name = $request->input('name');
        $rdictypes->enabled = $request->input('enabled');

        $rdictypes->save();

        activitylog('rdicriticalitytypes', 'store', null, $rdictypes->toArray());

        $rdi_services = RdiCriticalityTypes::where('enabled', 1)->get();
        return redirect('rdi_services')->with('rdi_services');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RdiCriticalityTypes  $Rdicriticalitytype
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rdicriticalitytype = Client::findOrFail($id);

        return view('rdi_services.show', compact('rdicriticalitytype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RdiCriticalityTypes  $Rdicriticalitytype
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rdicriticalitytype = RdiCriticalityTypes::findOrFail($id);
        return view('rdicriticalitytypes.edit', compact('rdicriticalitytype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RdiCriticalityTypes  $Rdicriticalitytype
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

        $rdictype = RdiCriticalityTypes::findOrFail($id);
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
     * @param  \App\Models\RdiCriticalityTypes  $Rdicriticalitytype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, RdiCriticalityTypes $Rdicriticalitytype)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
