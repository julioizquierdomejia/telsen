<?php

namespace App\Http\Controllers;

use App\Models\CostCard;
//use App\Models\CostCardService;
use App\Models\OtWork;
//use App\Models\CostCardServiceWork;
//use App\Models\ElectricalEvaluationWork;
//use App\Models\MechanicalEvaluationWork;
use App\Models\Ot;
use App\Models\Status;
use App\Models\StatusOt;
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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'tarjeta_de_costo', 'cotizador_tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);
        
        /*$ots = Ot::join('clients', 'clients.id', '=', 'ots.client_id')
                //->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->leftJoin('cost_cards', 'cost_cards.ot_id', '=', 'ots.id')
                ->join('electrical_evaluations as ee_val', 'ee_val.ot_id', '=', 'ots.id')
                ->join('mechanical_evaluations as me_val', 'me_val.ot_id', '=', 'ots.id')
                ->select('ots.*', 'clients.razon_social', 'ee_val.nro_equipo', 'ee_val.conex', 'me_val.hp_kw'
                    //,'cost_cards.id as cost_card'
                )
                ->where('ots.enabled', 1)
                ->where('clients.client_type_id', 2)
                ->where('clients.enabled', 1)
                //->groupBy('ots.id')
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_approved');
                })
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'me_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc');
                })
                ->get();*/

        /*$ots = [];
        foreach ($_ots as $key => $ot) {
            $array = array_column($ot->statuses->toArray(), "name");
            if (in_array("me_approved", $array) && in_array("ee_approved", $array) && !in_array("cc", $array)) {
                $ots[] = $ot;
            }
        }*/
        return view('costos.index'/*, compact('ots')*/);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'tarjeta_de_costo', 'cotizador_tarjeta_de_costo']);

        $cc = CostCard::where('ot_id', $id)->first();
        if ($cc) {
            return redirect('tarjeta-costo/'.$cc->ot_id.'/ver');
        }

        $ot = Ot::leftJoin('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                ->leftJoin('motor_models', 'motor_models.id', '=', 'ots.modelo_id')
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->join('electrical_evaluations as ee_val', 'ee_val.ot_id', '=', 'ots.id')
                ->join('mechanical_evaluations as me_val', 'me_val.ot_id', '=', 'ots.id')
                ->select('ots.*', 'motor_brands.name as marca', 'motor_models.name as modelo', 'clients.razon_social', 'clients.ruc', 'ee_val.nro_equipo', 'ee_val.frecuencia', 'ee_val.conex', 'ee_val.frame', 'ee_val.amperaje', 'me_val.hp_kw', 'me_val.serie', 'me_val.rpm', 'me_val.placa_caract_orig')
                ->where('ots.enabled', 1)
                ->where('ots.id', $id)
                ->firstOrFail();
        if ($ot->client_type_id == 1) {
            $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '=', 5)->get();
        } else {
            $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '<>', 5)->get();
        }

        $works_el = OtWork::join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select(
                    'ot_works.description',
                    'ot_works.medidas',
                    'ot_works.qty',
                    'ot_works.personal',
                    'services.name as service',
                    'services.id as service_id',
                    'areas.name as area',
                    'areas.id as area_id'
                )
                ->where('ot_works.type', 'electrical')
                ->where('ots.id', $ot->id)
                ->get();
        $works_mec = OtWork::join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select(
                    'ot_works.description',
                    'ot_works.medidas',
                    'ot_works.qty',
                    'ot_works.personal',
                    'services.name as service',
                    'services.id as service_id',
                    'areas.name as area',
                    'areas.id as area_id'
                )
                ->where('ot_works.type', 'mechanical')
                ->where('ots.id', $ot->id)
                ->get();

        return view('costos.calculate', compact('ot', 'areas', 'works_el', 'works_mec'));
    }

    public function upload(Request $request, $id)
    {
        if ($request->file('upload_file')) {
            $rules = array(
                'upload_file' => 'required|mimes:pdf|max:5000',
                'ot_id' => 'required|exists:ots,id',
            );
            $this->validate($request, $rules);

            $file = $request->file('upload_file');
            $ot_id = $request->get('ot_id');
            $ext = $file->getClientOriginalExtension();
            $uniqueFileName = preg_replace('/\s+/', "-", uniqid().'_'.$file->getClientOriginalName());

            $status = Status::where('name', 'cc_waiting')->first();
            if ($status) {
                $cost_card = CostCard::find($id);
                $cost_card->cotizacion = $uniqueFileName;
                $cost_card->save();

                $status_ot = new StatusOt();
                $status_ot->status_id = $status->id;
                $status_ot->ot_id = $ot_id;
                $status_ot->save();

                activitylog('cc_upload', 'store', null, $status_ot->getOriginal());

                //$file->move(storage_path('cotizacion'), $uniqueFileName);

                if (DIRECTORY_SEPARATOR === '/') {
                    $dir = '/var/www/html/uploads/cotizacion';
                    // unix, linux, mac
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777, true);
                    }
                    $file->move($dir, $uniqueFileName);
                } else {
                    $file->move(public_path('uploads/cotizacion'), $uniqueFileName);
                }
                
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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'tarjeta_de_costo', 'cotizador_tarjeta_de_costo']);

        $rules = array(
            //'ot_id'       => 'integer|required|exists:ots,id',
            'hecho_por'      => 'string|required',
            'enabled'      => 'boolean|required',
            /*'cost'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'cost_m1'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'cost_m2'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',
            'cost_m3'      => 'required|regex:/^\d+(\.\d{1,2})?$/|gt:0',*/
            //'cost_card_services'      => 'string|required',
            'works'         => 'array|nullable'
        );
        $this->validate($request, $rules);

        /*$cost_card_services = $request->input('cost_card_services');
        $services = json_decode($cost_card_services, true);
        $services_count = count($services);*/

        $cost = new CostCard();
        $cost->ot_id = $id;
        $cost->hecho_por = $request->input('hecho_por');
        /*$cost->cost = $request->input('cost');
        $cost->cost_m1 = $request->input('cost_m1');
        $cost->cost_m2 = $request->input('cost_m2');
        $cost->cost_m3 = $request->input('cost_m3');*/
        $cost->enabled = true;
        $cost->save();

        /*$services_array = [];
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
        CostCardService::insert($services_array);*/
        $works = $request->input('works');
        $services = [];
        foreach ($works as $key => $item) {
            if (isset($item['service_id'])) {
                $cc_work = new OtWork();
                $cc_work->ot_id = $cost->ot_id;
                $cc_work->type = "cc";
                $cc_work->service_id = isset($item['service_id']) ? $item['service_id'] : '';
                $cc_work->description = isset($item['description']) ? $item['description'] : '';
                $cc_work->medidas = isset($item['medidas']) ? $item['medidas'] : '';
                $cc_work->qty = isset($item['qty']) ? $item['qty'] : '';
                $cc_work->personal = isset($item['personal']) ? $item['personal'] : '';
                $cc_work->save();
            }
        }

        $status = Status::where('name', 'cc')->first();
        if ($status) {
            $status_ot = new StatusOt();
            $status_ot->status_id = $status->id;
            $status_ot->ot_id = $id;
            $status_ot->save();
        }

        activitylog('costos', 'store', null, $cost->toArray());

        return redirect('tarjeta-costo');
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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'tarjeta_de_costo', 'cotizador_tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo', 'fecha_de_entrega']);

        $ccost = CostCard::where('ot_id', $ot_id)
                ->join('ots', 'ots.id', '=', 'cost_cards.ot_id')
                ->leftJoin('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                ->leftJoin('motor_models', 'motor_models.id', '=', 'ots.modelo_id')
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->select('cost_cards.*', 'ots.code as ot_code', 'clients.razon_social', 'motor_brands.name as marca', 'motor_models.name as modelo', 'ots.fecha_entrega')
                ->firstOrFail();
        /*$services = CostCardService::where('cost_card_id', $ccost->id)
                    ->leftJoin('services', 'services.id', '=', 'cost_card_services.service_id')
                    ->leftJoin('areas', 'areas.id', '=', 'cost_card_services.area_id')
                    ->select('areas.name as area', 'areas.id as area_id','services.name as service','cost_card_services.personal', 'cost_card_services.ingreso', 'cost_card_services.salida', 'cost_card_services.subtotal')
                    ->get();*/
        $services = OtWork::where('ot_id', $ot_id)
                    ->where('type', 'cc')
                    ->leftJoin('services', 'services.id', '=', 'ot_works.service_id')
                    ->leftJoin('areas', 'areas.id', '=', 'services.area_id')
                    ->select('areas.name as area', 'areas.id as area_id','services.name as service','ot_works.*')
                    ->get();
        $works_el = OtWork::join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select(
                    'ot_works.description',
                    'ot_works.medidas',
                    'ot_works.qty',
                    'ot_works.personal',
                    'services.name as service',
                    'services.id as service_id',
                    'areas.name as area',
                    'areas.id as area_id'
                )
                ->where('ot_works.type', 'electrical')
                ->where('ots.id', $ot_id)
                ->get();
        $works_mec = OtWork::join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select(
                    'ot_works.description',
                    'ot_works.medidas',
                    'ot_works.qty',
                    'ot_works.personal',
                    'services.name as service',
                    'services.id as service_id',
                    'areas.name as area',
                    'areas.id as area_id'
                )
                ->where('ot_works.type', 'mechanical')
                ->where('ots.id', $ot_id)
                ->get();

        $ot_status = StatusOt::join('status', 'status_ot.status_id', '=', 'status.id')
                      ->where('status_ot.ot_id', '=', $ot_id)
                      ->select('status.id', 'status_ot.status_id', 'status.name')
                      ->get();

        $approved_by = \DB::table('logs')
                        ->join('users', 'users.id', '=', 'logs.user_id')
                        ->join('user_data', 'users.id', '=', 'user_data.user_id')
                        ->where('logs.action', 'store')
                        ->where('logs.section', 'cc_approved')
                        ->where('logs.data', 'like', '%"ot_id":"'. $ot_id . '"%')
                        ->select('logs.*', 'users.email', 'user_data.name')
                        ->first();

        $maded_by = \DB::table('logs')
                        ->join('users', 'users.id', '=', 'logs.user_id')
                        ->join('user_data', 'users.id', '=', 'user_data.user_id')
                        ->where('logs.section', 'cc_upload')
                        ->where('logs.action', 'store')
                        ->where('logs.data', 'like', '%"ot_id":"'. $ot_id . '"%')
                        ->select('logs.*', 'user_data.name')
                        ->first();

        return view('costos.show', compact('ccost', 'services', 'works_mec', 'works_el', 'ot_status', 'approved_by', 'maded_by'));
    }

    public function approveTC(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);

        $action = $request->input('action');

        $exist_status = StatusOt::join('status', 'status.id', '=', 'status_ot.status_id')
                        ->select('status_ot.*')
                        ->where('ot_id', $id)
                        ->where('name', 'cc_approved')->orWhere('name', 'cc_disapproved')
                        ->first();
        if ($exist_status) {
            return response()->json(['data'=>'Tarjeta de costo ya cambió de estado: ' . $exist_status->status_id,'success'=>false]);
        } else {
            if ($action == 1) {
                $status = Status::where('name', 'cc_approved')->first();
                if ($status) {
                    $data = new StatusOt();
                    $data->status_id = $status->id;
                    $data->ot_id = $id;
                    $data->save();
                }
            } else /*if($action == 2)*/ {
                $status = Status::where('name', 'cc_disapproved')->first();
                if ($status) {
                    $data = new StatusOt();
                    $data->status_id = $status->id;
                    $data->ot_id = $id;
                    $data->save();

                }
            }
            activitylog('cc_approved', 'store', null, $data->getOriginal());

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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);

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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);
        
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
