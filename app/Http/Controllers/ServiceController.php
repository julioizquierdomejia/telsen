<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        $services = Service::join('areas', 'areas.id', '=', 'services.area_id')
                    ->select('services.*', 'areas.name as area')->get();
        return view('servicios.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $areas = Area::where('enabled', 1)->get();
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        return view('servicios.create', compact('areas'));
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
            'name'       => ['string', 'required', Rule::unique('services')
                                    ->where('name', $request->input('name'))
                                    ->where('area_id', $request->input('area_id'))],
            'area_id'      => 'integer|required',
            'enabled'      => 'boolean|required',
        );
        
        $this->validate($request, $rules);

        $service = new Service();
        
        $service->name = $request->input('name');
        $service->area_id = $request->input('area_id');
        $service->enabled = $request->input('enabled');

        $service->save();

        $ajax = $request->input('ajax');

        activitylog('services', 'store', null, $service->toArray());

        if ($ajax) {
            $services = Service::where('enabled', 1)
                        ->where('area_id', $service->area_id)
                        ->get();
            return $services;
        }
        $services = Service::where('enabled', 1)->get();
        return redirect('servicios')->with('services');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $service = Client::findOrFail($id);

        return view('servicios.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $areas = Area::where('enabled', 1)->get();
        $service = Service::where('area_id', '<>', 1) // No area cliente
                    ->findOrFail($id);
        return view('servicios.edit', compact('service', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required|string|unique:services,name,'.$id,
            'area_id'      => 'integer|required',
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        $service = Service::where('area_id', '<>', 1) // No area cliente
                    ->findOrFail($id);
        $original_data = $service->toArray();

        $service->name    = $request->get('name');
        $service->area_id = $request->get('area_id');
        $service->enabled = $request->get('enabled');
        $service->save();

        activitylog('services', 'update', $original_data, $service->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated service!');
        return redirect('servicios');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $service)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
