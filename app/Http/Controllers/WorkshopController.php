<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\Ot;
use App\Models\Status;
use App\Models\Service;
use App\Models\Rdi;
use App\Models\RdiServiceCost;
use App\Models\CostCard;
use App\Models\Area;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class WorkshopController extends Controller
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
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->leftJoin('cost_cards', 'cost_cards.ot_id', '=', 'ots.id')
                ->join('electrical_evaluations', 'electrical_evaluations.ot_id', '=', 'ots.id')
                ->join('mechanical_evaluations', 'mechanical_evaluations.ot_id', '=', 'ots.id')
                        ->select('ots.*', 'clients.razon_social', 'clients.id as client_type_id', 'client_types.name as client_type', 'electrical_evaluations.nro_equipo', 'electrical_evaluations.conex', 'mechanical_evaluations.hp_kw'
                            //,'cost_cards.id as cost_card'
                        )
                        ->where('ots.enabled', 1)
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
            if (in_array(11, $array)) {
                $ots[] = $ot;
            }
        }
        return view('talleres.index', compact('ots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        return view('talleres.create');
    }*/
    public function calculate(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $users = User::join('user_data', 'user_data.user_id', 'users.id')
                ->join('user_area', 'user_area.user_id', 'users.id')
                ->join('areas', 'areas.id', 'user_area.area_id')
                ->select('users.id', 'user_data.name', 'user_data.last_name', 'user_data.mother_last_name', 'user_area.area_id','areas.name as area')
                ->get()
                ;

        $ot = Ot::join('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                ->join('motor_models', 'motor_models.id', '=', 'ots.modelo_id')
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->join('electrical_evaluations', 'electrical_evaluations.ot_id', '=', 'ots.id')
                ->join('mechanical_evaluations', 'mechanical_evaluations.ot_id', '=', 'ots.id')
                ->select('ots.*', 'motor_brands.name as marca', 'motor_models.name as modelo', 'clients.razon_social', 'clients.ruc', 'electrical_evaluations.nro_equipo', 'electrical_evaluations.frecuencia', 'electrical_evaluations.conex', 'electrical_evaluations.frame', 'electrical_evaluations.amperaje', 'mechanical_evaluations.hp_kw', 'mechanical_evaluations.serie', 'mechanical_evaluations.rpm', 'mechanical_evaluations.placa_caract_orig',
                    'clients.client_type_id'
            )
                ->where('ots.enabled', 1)
                ->where('ots.id', $id)
                ->firstOrFail();
        $services = [];
        if ($ot->client_type_id == 1) { //RDI
            $rdi = Rdi::where('ot_id', $ot->id)->firstOrFail();
            $services_list = Area::join('services', 'services.area_id', '=', 'areas.id')
                    ->join('rdi_service_costs', 'rdi_service_costs.service_id', 'services.id')
                    ->where('rdi_service_costs.rdi_id', $rdi->id)
                    ->select('areas.name as area', 'rdi_service_costs.id', 'services.area_id', 'services.name as service', 'rdi_service_costs.subtotal')
                    ->get();
        } else { //No afiliado
            $cost_card = CostCard::where('ot_id', $ot->id)->firstOrFail();
            $services_list = Area::join('services', 'services.area_id', '=', 'areas.id')
                    ->join('cost_card_services', 'cost_card_services.service_id', 'services.id')
                    ->where('cost_card_services.cost_card_id', $cost_card->id)
                    ->select('areas.name as area', 'cost_card_services.id', 'services.area_id', 'services.name as service', 'cost_card_services.subtotal', 'cost_card_services.personal')
                    ->get();
        }
        foreach($services_list as $key => $item) {
            $services[$item->area_id][$key] = $item->toArray();
        }
        //$clientes = Client::where('enabled', 1)->get();

        return view('talleres.calculate', compact('ot', 'services', 'users'));
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
            'user_id'      => 'required|array|min:1',
            'area_id'      => 'required|array|min:1',
        );
        foreach($request->get('data') as $key => $val){
            $rules['data.'.$key.'.user_id'] = 'required';
            $rules['data.'.$key.'.area_id'] = 'required';
        }
        $this->validate($request, $rules);
        dd($request->get('data'));

        $data = $request->input('data');
        $data_count = count($data);
        
        WorkshopService::insert($data_array);

        /*$status = Status::where('id', 4)->first();
        if ($status) {
            \DB::table('status_ot')->insert([
                'status_id' => $status->id,
                'ot_id' => $id,
            ]);
        }

        activitylog('costos', 'store', null, $cost->toArray());*/

        return redirect('tarjeta-costo')->with('costos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workshop  $cost
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $ccost = Workshop::findOrFail($id);

        return view('talleres.show', compact('ccost'));
    }
    public function cc_show(Request $request, $ot_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $ccost = Workshop::where('ot_id', $ot_id)
                ->join('ots', 'ots.id', '=', 'cost_cards.ot_id')
                ->join('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                ->join('motor_models', 'motor_models.id', '=', 'ots.modelo_id')
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->select('cost_cards.*', 'ots.id as ot_id', 'clients.razon_social', 'motor_brands.name as marca', 'motor_models.name as modelo', 'ots.fecha_entrega')
                ->firstOrFail();
        $services = WorkshopService::where('cost_card_id', $ccost->id)
                    ->leftJoin('services', 'services.id', '=', 'cost_card_services.service_id')
                    ->leftJoin('areas', 'areas.id', '=', 'cost_card_services.area_id')
                    ->select('areas.name as area', 'areas.id as area_id','services.name as service','cost_card_services.personal', 'cost_card_services.ingreso', 'cost_card_services.salida', 'cost_card_services.subtotal')
                    ->get();

        return view('talleres.show', compact('ccost', 'services'));
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
            return response()->json(['data'=>'Tarjeta de costo ya cambió de estado: ' . $exist_status->status_id,'success'=>false]);
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
     * @param  \App\Models\Workshop  $cost
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

        $cost = Workshop::findOrFail($id);
        return view('talleres.edit', compact('cost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workshop  $cost
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
        $cost = Workshop::findOrFail($id);
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
     * @param  \App\Models\Workshop  $cost
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Workshop $cost)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
