<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\Ot;
use App\Models\Status;
use App\Models\Service;
use App\Models\Rdi;
use App\Models\RdiServiceCost;
use App\Models\OtWorkReason;
use App\Models\OtWork;
use App\Models\WorkStatus;
//use App\Models\OtWorkStatus;
use App\Models\WorkLog;
//use App\Models\MechanicalEvaluationWork;
//use App\Models\ElectricalEvaluationWork;
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
        
        /*$ots = Ot::join('clients', 'clients.id', '=', 'ots.client_id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->leftJoin('cost_cards', 'cost_cards.ot_id', '=', 'ots.id')
                ->join('electrical_evaluations', 'electrical_evaluations.ot_id', '=', 'ots.id')
                ->join('mechanical_evaluations', 'mechanical_evaluations.ot_id', '=', 'ots.id')
                ->select('ots.*', 'clients.razon_social', 'clients.id as client_type_id', 'client_types.name as client_type', 'electrical_evaluations.nro_equipo', 'electrical_evaluations.conex', 'mechanical_evaluations.hp_kw'
                )
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'delivery_generated');
                })
                ->where('ots.enabled', 1)
                ->where('clients.enabled', 1)
                ->get();*/

        return view('talleres.index'
            //, compact('ots')
        );
    }

    public function services_list(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'worker']);

        $work_reasons = OtWorkReason::
                          where('code', '<>', 'start')
                        ->where('code', '<>', 'end')
                        ->where('code', '<>', 'continue')
                        ->where('code', '<>', 'restart')
                        ->get();
        $area_id = \Auth::user()->data->area->id;

        $roles = validateActionbyRole();
        if (in_array("superadmin", $roles) || in_array("admin", $roles)) {
            $services = OtWork::join('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                ->join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select('ots.created_at', 'ot_works.id', 'services.id as service_id' ,'services.name as service', 'ots.code', \DB::raw('CONCAT(ots.numero_potencia, " ",ots.medida_potencia) AS potencia'))
                ->get();
        } else {
            if (in_array("supervisor", $roles)) {
                $services = OtWork::join('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                    ->join('services', 'services.id', '=', 'ot_works.service_id')
                    ->join('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                    ->select('ots.created_at', 'ot_works.id', 'services.id as service_id' ,'services.name as service', 'ots.code', \DB::raw('CONCAT(ots.numero_potencia, " ",ots.medida_potencia) AS potencia'))
                    ->where('user_data.area_id', $area_id)

                    /*->whereHas('work_logs', function ($query) {
                        $query->where("work_logs.type", "=", 'end');
                    })*/

                    ->get();
            } else {
                $user_id = \Auth::id();

                $services = OtWork::join('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                    ->join('services', 'services.id', '=', 'ot_works.service_id')
                    ->join('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                    ->select('ots.created_at', 'ot_works.id', 'services.id as service_id' ,'services.name as service', 'ots.code', \DB::raw('CONCAT(ots.numero_potencia, " ",ots.medida_potencia) AS potencia'))
                    ->where('workshops.user_id', $user_id)
                    //->where('user_data.area_id', $area_id)

                    /*->whereDoesntHave('work_logs', function ($query) {
                        $query->where("work_logs.type", "=", 'end');
                    })
                    ->whereDoesntHave('ot_work_status', function ($query) {
                        $query->where("ot_work_status.work_status_id", "=", 1); //No mostrar los aprobados
                    })
                    ->whereHas('work_logs', function ($query) {
                        $query->where("work_logs.type", "=", 'restart');
                    })*/

                    ->get();
            }
        }

        return view('talleres.services', compact('services', 'work_reasons', 'roles')
        );
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
    public function assign(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);

        $users = User::join('user_data', 'user_data.user_id', 'users.id')
                ->join('areas', 'areas.id', 'user_data.area_id')
                ->select('users.id', 'user_data.name', 'user_data.last_name', 'user_data.mother_last_name', 'user_data.area_id','areas.name as area')
                ->where('users.enabled', 1)
                ->get()
                ;

        $ot = Ot::leftJoin('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                ->leftJoin('motor_models', 'motor_models.id', '=', 'ots.modelo_id')
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
        $u_area_id = User::join('user_data', 'user_data.user_id', 'users.id')
                        ->join('areas', 'areas.id', 'user_data.area_id')
                        ->where('users.id', $user_id)
                        ->select('areas.id')->first();
        if ($u_area_id) {
            $user_area_id = $u_area_id->id;
        } else {
            $user_area_id = 0;
        }

        $works = OtWork::join('services', 'services.id', '=', 'ot_works.service_id')
            ->join('areas', 'areas.id', '=', 'services.area_id')
            ->leftJoin('workshops', 'workshops.ot_work_id', '=', 'ot_works.id')
            ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
            ->select(
                'ot_works.id',
                'services.id as service_id',
                'ot_works.description',
                'ot_works.id as ot_work_id',
                'areas.name as area',
                'services.area_id',
                'services.name as service',
                'ot_works.personal',
                \DB::raw('CONCAT(user_data.name, " ",user_data.last_name, " ", user_data.mother_last_name) AS user_name'),
                'user_data.user_id'
            )
            ->where('ot_works.ot_id', $ot->id)
            ->get();

        //$services = [];
        /*if ($ot->client_type_id == 1) { //RDI
            $rdi = Rdi::where('ot_id', $ot->id)->firstOrFail();
            $services_list = Area::join('services', 'services.area_id', '=', 'areas.id')
                    ->join('ot_works', 'ot_works.service_id', 'services.id')
                    ->leftJoin('workshops', 'services.id', '=', 'workshops.service_id')
                    ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->where('ot_works.ot_id', $rdi->ot_id)
                    //->where('services.area_id', $user_area_id->id)
                    ->select(
                        'areas.name as area',
                        'services.id as service_id',
                        'ot_works.description',
                        'services.area_id',
                        'services.name as service',
                        \DB::raw('CONCAT(user_data.name, " ",user_data.last_name, " ", user_data.mother_last_name) AS user_name'),
                        'user_data.user_id'
                    )
                    ->get();
        } else { //No afiliado
            $cost_card = CostCard::where('ot_id', $ot->id)->firstOrFail();
            $services_list = Area::join('services', 'services.area_id', '=', 'areas.id')
                    ->join('ot_works', 'ot_works.service_id', 'services.id')
                    ->leftJoin('workshops', 'services.id', '=', 'workshops.service_id')
                    ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->where('ot_works.ot_id', $cost_card->ot_id)
                    //->where('services.area_id', $user_area_id->id)
                    ->select(
                        'areas.name as area',
                        'services.id as service_id',
                        'ot_works.description',
                        'services.area_id',
                        'services.name as service',
                        'ot_works.personal',
                        \DB::raw('CONCAT(user_data.name, " ",user_data.last_name, " ", user_data.mother_last_name) AS user_name'),
                        'user_data.user_id'
                    )
                    ->get();
        }*/
        /*foreach($services_list as $key => $item) {
            $services[$item->area_id][$key] = $item->toArray();
        }
        foreach($works_mec as $key => $item) {
            $services[$item->area_id][$key] = $item->toArray();
        }*/
        foreach($works as $key => $item) {
            $services[$item->area_id][$key] = $item->toArray();
        }
        /*$workshop = Workshop::join('services', 'services.id', '=', 'workshops.service_id')
                    ->join('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->select('workshops.id', 'services.name as service', 'user_data.name as user')
                    ->get();
                    dd($workshop);*/
        //$clientes = Client::where('enabled', 1)->get();

        return view('talleres.assign', compact('ot', 'services', 'users', 'user_area_id'));
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
        
        $data = $request->input('data');
        if (!is_array($data)) {
            $rules = array(
                'user_id'      => 'required|array|min:1',
                'ot_work_id'      => 'required|array|min:1',
            );
            $this->validate($request, $rules);
        }
        /*if ($data) {
            foreach($request->input('data') as $key => $val){
                $rules['data.'.$key.'.user_id'] = 'required';
                $rules['data.'.$key.'.ot_work_id'] = 'required';
                $this->validate($request, $rules);
            }
        } else {
            $rules = array(
                'user_id'      => 'required|array|min:1',
                'ot_work_id'      => 'required|array|min:1',
            );
            $this->validate($request, $rules);
        }*/
        Workshop::join('ot_works', 'ot_works.id', '=', 'workshops.ot_work_id')
                ->where('ot_works.ot_id', $id)
                ->delete();

        //$data_count = count($data);
        foreach ($data as $key => $item) {
            if ($item['user_id']) {
                $work_shop = new Workshop();
                //$work_shop->ot_id = $id;
                $work_shop->ot_work_id = $item['ot_work_id'];
                $work_shop->user_id = $item['user_id'];
                $work_shop->save();
            }
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
                ->leftJoin('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                ->leftJoin('motor_models', 'motor_models.id', '=', 'ots.modelo_id')
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->select('cost_cards.*', 'ots.id as ot_code', 'clients.razon_social', 'motor_brands.name as marca', 'motor_models.name as modelo', 'ots.fecha_entrega')
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

    public function approveWork(Request $request)
    {
        //$request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);

        $rules = array(
            'status_id'      => 'required|exists:work_status,id',
            'work_id'      => 'required|integer|exists:ot_works,id',
        );
        $this->validate($request, $rules);

        $status = $request->input('status_id');
        $work_id = $request->input('work_id');

        $work_log = WorkLog::where('work_id', $work_id)
                    ->orderBy('id', 'desc')
                    ->where('type', 'end')
                    ->where('status_id', 0)
                    ->first();

        $work_log->status_id = $status;
        $work_log->save();

        /*$ot_work_status = new OtWorkStatus();
        $ot_work_status->work_status_id = $status;
        $ot_work_status->ot_work_id = $work_id;
        $ot_work_status->save();*/

        /*if ($ot_work_status->work_status_id == 1) { //Aprobado
            
        } else {
            $reason = OtWorkReason::where('code', 'restart')->first();
            if ($reason) {
                $work_log = new WorkLog();
                $work_log->work_id = $request->input('work_id');
                $work_log->user_id = \Auth::id();
                $work_log->type = 'restart';
                $work_log->description = 'Reinició el trabajo';
                $work_log->reason_id = $reason->id;
                $work_log->save();
            }
        }*/

        return response()->json(['data'=>json_encode($work_log), 'success'=>true]);
    }
}
