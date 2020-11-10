<?php

namespace App\Http\Controllers;

use App\Models\Rdi;
use App\Models\RdiService;
use App\Models\RdiMaintenanceType;
use App\Models\RdiCriticalityType;
use App\Models\Status;
use App\Models\Client;
use App\Models\MotorBrand;
use Illuminate\Http\Request;

class RdiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        $rdis = Rdi::where('enabled', 1)->get();

        return view('rdi.index', compact('rdis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        $clientes = Client::where('enabled', 1)->where('client_type_id', 1)->get();
        $marcas = MotorBrand::where('enabled', 1)->get();
        $maintenancetype = RdiMaintenanceType::where('enabled', 1)->get();
        $criticalitytype = RdiCriticalityType::where('enabled', 1)->get();

        return view('rdi.create', compact('clientes', 'marcas', 'maintenancetype', 'criticalitytype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rules = array(
            //'ot_id'       => 'integer|required|exists:ots,id',
            'hecho_por'      => 'string|required',
            'enabled'      => 'boolean|required',
            'rdi'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'rdi_m1'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'rdi_m2'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'rdi_m3'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'rdi_card_services'      => 'string|required',
        );
        $this->validate($request, $rules);

        $rdi_card_services = $request->input('rdi_card_services');
        $services = json_decode($rdi_card_services, true);
        $services_count = count($services);

        $rdi = new Rdi();
        $rdi->ot_id = $id;
        $rdi->hecho_por = $request->input('hecho_por');
        $rdi->rdi = $request->input('rdi');
        $rdi->rdi_m1 = $request->input('rdi_m1');
        $rdi->rdi_m2 = $request->input('rdi_m2');
        $rdi->rdi_m3 = $request->input('rdi_m3');
        $rdi->enabled = $request->input('enabled');
        $rdi->save();

        $services_array = [];
        for ($i=0; $i < $services_count; $i++) { 
            $services_array[] = [
                'rdi_card_id' => $rdi->id,
                'area_id' => $services[$i]['area_id'] ? $services[$i]['area_id'] : null,
                'service_id' => $services[$i]['service'] ? $services[$i]['service'] : null,
                'personal' => $services[$i]['personal'],
                'ingreso' => $services[$i]['ingreso'],
                'salida' => $services[$i]['salida'],
                'subtotal' => $services[$i]['subtotal'],
            ];
        }
        RdiService::insert($services_array);

        $status = Status::where('id', 4)->first();
        if ($status) {
            \DB::table('status_ot')->insert([
                'status_id' => $status->id,
                'ot_id' => $id,
            ]);
        }

        activitylog('rdis', 'store', null, $rdi->toArray());

        $rdis = Rdi::where('enabled', 1)->get();
        return redirect('rdi.index')->with('rdis');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rdi  $rdi
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $crdi = Rdi::findOrFail($id);

        return view('rdi.show', compact('crdi'));
    }
    public function cc_show(Request $request, $ot_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $crdi = Rdi::where('ot_id', $ot_id)->firstOrFail();

        return view('rdi.show', compact('crdi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rdi  $rdi
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $rdi = Rdi::findOrFail($id);
        return view('rdi.edit', compact('rdi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rdi  $rdi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required|string|unique:rdis,name,'.$id,
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        // update
        $rdi = Rdi::findOrFail($id);
        $original_data = $rdi->toArray();

        $rdi->name       = $request->get('name');
        $rdi->enabled    = $request->get('enabled');
        $rdi->save();

        activitylog('rdi', 'update', $original_data, $rdi->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated rdi!');
        return redirect('rdi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rdi  $rdi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Rdi $rdi)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
