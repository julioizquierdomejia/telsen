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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);
        
        $ots = Ot::join('clients', 'clients.id', '=', 'ots.client_id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->leftJoin('cost_cards', 'cost_cards.ot_id', '=', 'ots.id')
                ->join('electrical_evaluations', 'electrical_evaluations.ot_id', '=', 'ots.id')
                ->join('mechanical_evaluations', 'mechanical_evaluations.ot_id', '=', 'ots.id')
                        ->select('ots.*', 'clients.razon_social', 'clients.id as client_type_id', 'client_types.name as client_type', 'electrical_evaluations.nro_equipo', 'electrical_evaluations.conex', 'mechanical_evaluations.hp_kw'
                            //,'cost_cards.id as cost_card'
                        )
                        ->whereHas('statuses', function ($query) {
                            $query->where("status.name", "=", 'delivery_generated');
                        })
                        ->where('ots.enabled', 1)
                        ->where('clients.enabled', 1)
                        //->groupBy('ots.id')
                        ->get();

        return view('talleres.index', compact('ots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        return view('talleres.create');
    }*/
    public function calculate(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);

        $users = User::join('user_data', 'user_data.user_id', 'users.id')
                ->join('areas', 'areas.id', 'user_data.area_id')
                ->select('users.id', 'user_data.name', 'user_data.last_name', 'user_data.mother_last_name', 'user_data.area_id','areas.name as area')
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

        $user_id = \Auth::user()->id;
        $user_area_id = User::join('user_data', 'user_data.user_id', 'users.id')
                        ->join('areas', 'areas.id', 'user_data.area_id')
                        ->where('users.id', $user_id)
                        ->select('areas.id')->first();
        $services = [];
        if ($ot->client_type_id == 1) { //RDI
            $rdi = Rdi::where('ot_id', $ot->id)->firstOrFail();
            $services_list = Area::join('services', 'services.area_id', '=', 'areas.id')
                    ->join('rdi_works', 'rdi_works.service_id', 'services.id')
                    ->where('rdi_works.rdi_id', $rdi->id)
                    ->where('services.area_id', $user_area_id->id)
                    ->select('areas.name as area', 'areas.id', 'rdi_works.id', 'services.area_id', 'services.name as service')
                    ->get();
        } else { //No afiliado
            $cost_card = CostCard::where('ot_id', $ot->id)->firstOrFail();
            $services_list = Area::join('services', 'services.area_id', '=', 'areas.id')
                    ->join('cost_card_service_works', 'cost_card_service_works.service_id', 'services.id')
                    ->where('cost_card_service_works.cc_id', $cost_card->id)
                    ->where('services.area_id', $user_area_id->id)
                    ->select('areas.name as area', 'areas.id', 'cost_card_service_works.id', 'services.area_id', 'services.name as service', 'cost_card_service_works.personal')
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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);
        /*$rules = array(
            'user_id'      => 'required|array|min:1',
            'area_id'      => 'required|array|min:1',
        );*/
        foreach($request->get('data') as $key => $val){
            $rules['data.'.$key.'.user_id'] = 'required';
            $rules['data.'.$key.'.area_id'] = 'required';
            $this->validate($request, $rules);
        }
        $data = $request->input('data');
        //$data_count = count($data);
        foreach ($data as $key => $item) {
            $work_shop = new Workshop();
            $work_shop->ot_id = $id;
            $work_shop->area_id = $item['area_id'];
            $work_shop->user_id = $item['user_id'];
            $work_shop->save();
        }

        /*$status = Status::where('name', 'workshop')->first();
        if ($status) {
            $data = new StatusOt();
            $data->status_id = $status->id;
            $data->ot_id = $id;
            $data->save();
        }*/

        activitylog('workshop', 'store', null, $data);

        return redirect('talleres');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Workshop  $cost
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $ot_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);

        $ccost = Workshop::where('ot_id', $ot_id)
                ->join('ots', 'ots.id', '=', 'cost_cards.ot_id')
                ->join('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                ->join('motor_models', 'motor_models.id', '=', 'ots.modelo_id')
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->select('cost_cards.*', 'ots.id as ot_id', 'clients.razon_social', 'motor_brands.name as marca', 'motor_models.name as modelo', 'ots.fecha_entrega')
                ->firstOrFail();
        $services = WorkshopService::where('cc_id', $ccost->id)
                    ->leftJoin('services', 'services.id', '=', 'cost_card_service_works.service_id')
                    ->leftJoin('areas', 'areas.id', '=', 'cost_card_service_works.area_id')
                    ->select('areas.name as area', 'areas.id as area_id','services.name as service','cost_card_service_works.personal', 'cost_card_service_works.ingreso', 'cost_card_service_works.salida')
                    ->get();

        $ot_status = StatusOt::join('status', 'status_ot.status_id', '=', 'status.id')
                      ->where('status_ot.ot_id', '=', $ot_id)
                      ->select('status.id', 'status_ot.status_id', 'status.name')
                      ->get();

        return view('talleres.show', compact('ccost', 'services', 'ot_status'));
    }

    public function approveTC(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);

        $action = $request->input('action');

        $exist_status = StatusOt::join('status', 'status.id', '=', 'status_ot.status_id')
                        ->select('status.*')
                        ->where('ot_id', $id)
                        ->where('status.name', 'workshop_a')->orWhere('status.name', 'workshop_d')
                        ->first();
        if ($exist_status) {
            return response()->json(['data'=>'Tarjeta de costo ya cambió de estado: ' . $exist_status->status_id,'success'=>false]);
        } else {
            if ($action == 1) {
                $status = Status::where('name', 'workshop_a')->first();
                if ($status) {
                    $data = new StatusOt();
                    $data->status_id = $status->id;
                    $data->ot_id = $id;
                    $data->save();
                }
            } else /*if($action == 2)*/ {
                $status = Status::where('name', 'workshop_d')->first();
                if ($status) {
                    $data = new StatusOt();
                    $data->status_id = $status->id;
                    $data->ot_id = $id;
                    $data->save();
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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);

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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required|string|unique:costos,name,'.$id,
            'enabled'      => 'boolean|required',
        );
        $this->validate($request, $rules);

        // update
        $workshop = Workshop::findOrFail($id);
        $original_data = $workshop->toArray();

        $workshop->name       = $request->get('name');
        $workshop->enabled    = $request->get('enabled');
        $workshop->save();

        activitylog('workshop', 'update', $original_data, $workshop->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated cost!');
        return redirect('ordenes');
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
