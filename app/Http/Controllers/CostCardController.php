<?php

namespace App\Http\Controllers;

use App\Models\CostCard;
use App\Models\CostCardService;
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
                //->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->leftJoin('cost_cards', 'cost_cards.ot_id', '=', 'ots.id')
                ->join('electrical_evaluations', 'electrical_evaluations.ot_id', '=', 'ots.id')
                ->join('mechanical_evaluations', 'mechanical_evaluations.ot_id', '=', 'ots.id')
                        ->select('ots.*', 'clients.razon_social', 'electrical_evaluations.nro_equipo', 'electrical_evaluations.conex', 'mechanical_evaluations.hp_kw'
                            //,'cost_cards.id as cost_card'
                        )
                        ->where('ots.enabled', 1)
                        ->where('clients.client_type_id', 2)
                        ->where('clients.enabled', 1)
                        //->groupBy('ots.id')
                        ->get();

        $ots = [];
        foreach ($_ots as $key => $ot) {
            $ot_status = \DB::table('status_ot')->where('status_ot.ot_id', '=', $ot->id)->get();
            $array = [];
            foreach ($ot_status as $key => $status) {
                $array[] = $status->status_id;
            }
            if (in_array(2, $array) && in_array(3, $array) && !in_array(4, $array)) {
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

        $ot = Ot::join('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                ->join('motor_models', 'motor_models.id', '=', 'ots.modelo_id')
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->join('electrical_evaluations', 'electrical_evaluations.ot_id', '=', 'ots.id')
                ->join('mechanical_evaluations', 'mechanical_evaluations.ot_id', '=', 'ots.id')
                ->select('ots.*', 'motor_brands.name as marca', 'motor_models.name as modelo', 'clients.razon_social', 'clients.ruc', 'electrical_evaluations.nro_equipo', 'electrical_evaluations.frecuencia', 'electrical_evaluations.conex', 'electrical_evaluations.frame', 'electrical_evaluations.amperaje', 'mechanical_evaluations.hp_kw', 'mechanical_evaluations.serie', 'mechanical_evaluations.rpm', 'mechanical_evaluations.placa_caract_orig')
                ->where('ots.enabled', 1)
                ->where('ots.id', $id)
                ->firstOrFail();
        $areas = Area::where('enabled', 1)->where('id', '<>', 1)->get();
        //$clientes = Client::where('enabled', 1)->get();

        return view('costos.calculate', compact('ot', 'areas'));
    }

    public function filterareas(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $id = $request->input('id');
        $areas = Service::where('area_id', $id)
                ->where('enabled', 1)
                ->select('services.id', 'services.name')
                ->get();
        if ($areas) {
            return response()->json(['data'=>json_encode($areas),'success'=>true]);
        }
        return response()->json(['success'=>false]);
    }

    public function upload(Request $request, $id)
    {
        if ($request->hasFile('upload_file')) {
            $rules = array(
                'upload_file' => 'required|mimes:pdf|max:5000',
                'cost_id' => 'required|exists:ots,id',
            );
            $this->validate($request, $rules);

            $file = $request->file('upload_file');
            $cost_id = $request->get('cost_id');
            $ext = $file->getClientOriginalExtension();
            $uniqueFileName = uniqid() . preg_replace('/\s+/', "-", $file->getClientOriginalName()) . '.' . $ext;

            $cost_card = CostCard::findOrFail($id);
            $cost_card->cotizacion = $uniqueFileName;
            $cost_card->save();

            $status = Status::where('id', 5)->first();
            if ($status) {
                \DB::table('status_ot')->insert([
                    'status_id' => $status->id,
                    'ot_id' => $cost_id,
                ]);
            }

            $file->move(public_path('uploads/cotizacion'), $uniqueFileName);
            if (isset($cost_card->id)) {
                return response()->json(['data'=>json_encode($cost_card->id),'success'=>true]);
            }
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
            'cost'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'cost_m1'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'cost_m2'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'cost_m3'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'cost_card_services'      => 'string|required',
        );
        $this->validate($request, $rules);

        $cost_card_services = $request->input('cost_card_services');
        $services = json_decode($cost_card_services, true);
        $services_count = count($services);

        $cost = new CostCard();
        $cost->ot_id = $id;
        $cost->hecho_por = $request->input('hecho_por');
        $cost->cost = $request->input('cost');
        $cost->cost_m1 = $request->input('cost_m1');
        $cost->cost_m2 = $request->input('cost_m2');
        $cost->cost_m3 = $request->input('cost_m3');
        $cost->enabled = $request->input('enabled');
        $cost->save();

        $services_array = [];
        for ($i=0; $i < $services_count; $i++) { 
            $services_array[] = [
                'cost_card_id' => $cost->id,
                'area_id' => $services[$i]['area_id'] ? $services[$i]['area_id'] : null,
                'service_id' => $services[$i]['service'] ? $services[$i]['service'] : null,
                'personal' => $services[$i]['personal'],
                'ingreso' => $services[$i]['ingreso'],
                'salida' => $services[$i]['salida'],
                'subtotal' => $services[$i]['subtotal'],
            ];
        }
        CostCardService::insert($services_array);

        $status = Status::where('id', 4)->first();
        if ($status) {
            \DB::table('status_ot')->insert([
                'status_id' => $status->id,
                'ot_id' => $id,
            ]);
        }

        activitylog('costos', 'store', null, $cost->toArray());

        $costos = CostCard::where('enabled', 1)->get();
        return redirect('tarjeta-costo')->with('costos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CostCard  $cost
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $ccost = CostCard::findOrFail($id);

        return view('costos.show', compact('ccost'));
    }
    public function cc_show(Request $request, $ot_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $ccost = CostCard::where('ot_id', $ot_id)
                ->join('ots', 'ots.id', '=', 'cost_cards.ot_id')
                ->join('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                ->join('motor_models', 'motor_models.id', '=', 'ots.modelo_id')
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->select('cost_cards.*', 'ots.id as ot_id', 'clients.razon_social', 'motor_brands.name as marca', 'motor_models.name as modelo')
                ->firstOrFail();
        $services = CostCardService::where('cost_card_id', $ccost->id)
                    ->leftJoin('services', 'services.id', '=', 'cost_card_services.service_id')
                    ->leftJoin('areas', 'areas.id', '=', 'cost_card_services.area_id')
                    ->select('areas.name as area', 'areas.id as area_id','services.name as service','cost_card_services.personal', 'cost_card_services.ingreso', 'cost_card_services.salida', 'cost_card_services.subtotal')
                    ->get();

        return view('costos.show', compact('ccost', 'services'));
    }

    public function approveTC(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $action = $request->input('action');

        $exist_status = \DB::table('status_ot')
                        ->where('ot_id', $id)
                        ->where('status_id', 6)->orWhere('status_id', 7)
                        ->first();
        if ($exist_status) {
            return response()->json(['data'=>'Tarjeta de costo ya cambió de estado' . $exist_status->id,'success'=>false]);
        } else {
            if ($action == 1) {
                $status = Status::where('id', 6)->first();
                if ($status) {
                    $data = \DB::table('status_ot')->insert([
                        'status_id' => $status->id,
                        'ot_id' => $id,
                    ]);
                }
            } else /*if($action == 2)*/ {
                $status = Status::where('id', 7)->first();
                if ($status) {
                    $data = \DB::table('status_ot')->insert([
                        'status_id' => $status->id,
                        'ot_id' => $id,
                    ]);
                }
            }
            return response()->json(['data'=>json_encode($data),'success'=>true]);
        }
        return response()->json(['success'=>false]);
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
        $this->validate($request, $rules);

        // update
        $cost = CostCard::findOrFail($id);
        $original_data = $cost->toArray();

        $cost->name       = $request->get('name');
        $cost->enabled    = $request->get('enabled');
        $cost->save();

        activitylog('costos', 'update', $original_data, $cost->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated cost!');
        return redirect('costos');
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
