<?php

namespace App\Http\Controllers;

use App\Models\CostCard;
use App\Models\Ot;
use App\Models\Status;
use App\Models\Service;
use App\Models\Area;
use App\Models\Client;
use Illuminate\Http\Request;

class CostCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        $_ots = Ot::join('clients', 'clients.id', '=', 'ots.client_id')
                        ->select('ots.*', 'clients.razon_social')
                        ->where('ots.enabled', 1)
                        ->where('clients.enabled', 1)
                        ->groupBy('ots.id')
                        ->get();

        $ots = [];
        foreach ($_ots as $key => $ot) {
            $ot_status = \DB::table('status_ot')->where('status_ot.ot_id', '=', $ot->id)->get();
            $array = [];
            foreach ($ot_status as $key => $status) {
                $array[] = $status->status_id;
            }
            if (in_array(2, $array) && in_array(3, $array)) {
                $ots[] = $ot;
            }
        }
        return view('costos.index', compact('ots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        return view('costos.create');
    }*/
    public function calculate(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $ot = Ot::join('brand_motors', 'brand_motors.id', '=', 'ots.marca_id')
                ->join('model_motors', 'model_motors.id', '=', 'ots.marca_id')
                ->select('ots.*', 'brand_motors.name as marca', 'model_motors.name as modelo')
                ->where('ots.enabled', 1)
                ->where('ots.id', $id)
                ->firstOrFail();
        $areas = Area::where('enabled', 1)->get();
        $clientes = Client::where('enabled', 1)->get();

        return view('costos.calculate', compact('ot', 'areas', 'clientes'));
    }

    public function filterareas(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $id = $request->input('id');
        $areas = Service::where('area_id', $id)->where('enabled', 1)
                ->select('services.id', 'services.name')
                ->get();
        if ($areas) {
            return response()->json(['data'=>json_encode($areas),'success'=>true]);
        }
        return response()->json(['success'=>false]);
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
            'cost'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cost_m1'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cost_m2'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cost_m3'      => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'cost_card_service'      => 'string|required',
        );
        $this->validate($request, $rules);

        $services = json_decode($cost_card_service);
        $services_count = count($services);

        /*$cost = new CostCard();
        $cost->name = $request->input('hecho_por');
        $cost_card_service = $request->input('cost_card_service');
        $cost->name = $request->input('cost');
        $cost->cost_m1 = $request->input('cost_m1');
        $cost->cost_m2 = $request->input('cost_m2');
        $cost->cost_m3 = $request->input('cost_m3');
        $cost->enabled = $request->input('enabled');
        $cost->save();*/

        $services_array = [];
        for ($i=0; $i < $services_count; $i++) { 
            $services_array[] = [
                'cost_card_id' => $id,
                'area_id' => $services[$i],
                'question_id' => $services[$i]
                'question_id' => $services[$i]
                'question_id' => $services[$i]
            ];
        }
        //CostCardService::insert($services_array);
        //dd($services);

        activitylog('costos', 'store', null, $cost->toArray());

        $costos = CostCard::where('enabled', 1)->get();
        return redirect('costos')->with('costos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CostCard  $cost
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cost = CostCard::findOrFail($id);

        return view('costos.show', compact('cost'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CostCard  $cost
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $cost = CostCard::findOrFail($id);
        return view('costos.edit', compact('cost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CostCard  $cost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required|string|unique:costos,name,'.$id,
            'enabled'      => 'boolean|required',
        );
        $validator = \Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('costos/' . $id . '/editar')
                ->withErrors($validator);
        } else {
            // store
            $cost = CostCard::find($id);
            $original_data = $cost->toArray();

            $cost->name       = $request->get('name');
            $cost->enabled      = $request->get('enabled');
            $cost->save();

            activitylog('costos', 'update', $original_data, $cost->toArray());

            // redirect
            \Session::flash('message', 'Successfully updated cost!');
            return redirect('costos');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CostCard  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, CostCard $cost)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}