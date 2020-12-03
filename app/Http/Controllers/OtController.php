<?php

namespace App\Http\Controllers;

use App\Models\Ot;
use App\Models\Client;
use App\Models\MotorBrand;
use App\Models\MotorModel;
use App\Models\Status;
use App\Models\StatusOt;
use App\Models\ElectricalEvaluation;
use App\Models\MechanicalEvaluation;
use App\Models\OtGallery;
use App\Models\CostCard;
use App\Models\WorkShop;
use App\Models\Rdi;
use Illuminate\Http\Request;

class OtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'evaluador', 'aprobador_de_evaluaciones', 'tarjeta_de_costo', 'crear_ot']);
        
        //Listar OTs
        $ordenes = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->where('ots.enabled', 1)->get();

        return view('ordenes.index', compact('ordenes'));
    }

    public function enabled_ots(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'evaluador', 'aprobador_de_evaluaciones', 'tarjeta_de_costo', 'crear_ot']);

        $role_names = validateActionbyRole();
        $admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
        $evaluador = in_array("evaluador", $role_names) || in_array("aprobador_de_evaluaciones", $role_names) || in_array("tarjeta_de_costo", $role_names);
        $allowed_users = $admin || $evaluador;

        $counter = 0;
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $totalRecords = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where('ots.enabled', 1)->count();
        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where('clients.razon_social', 'like', '%' .$searchValue . '%')->where('ots.enabled', 1)->count();

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where('clients.razon_social', 'like', '%' .$searchValue . '%')
                    ->orderBy($columnName, $columnSortOrder)

                    ->where('ots.enabled', 1)->get();

        $counter = $start;
        $ots_array = [];

        foreach ($records as $key => $ot) {
            $ot_status_arr = array_column($ot->statuses->toArray(), "name");
            if (!in_array('cc_disapproved', $ot_status_arr) && 
                !in_array('rdi_disapproved', $ot_status_arr) && 
                !in_array('ee_disapproved', $ot_status_arr) && 
                !in_array('me_disapproved', $ot_status_arr)
                ) {
                $counter++;

                $created_at = date('d-m-Y', strtotime($ot->created_at));
                $status_data = self::getOTStatus($ot);
                $fecha_entrega = '-';
                if(isset($status_data['fecha_entrega'])) {
                    $start = strtotime($status_data['fecha_entrega']);
                    $end   = strtotime(date('d-m-Y'));
                    $days  = date('d', $start - $end);
                    $fecha = date('d-m-Y', $start);
                    $i_class = ($days > 0) ? ' badge-danger ' : ' badge-success ';
                    $fecha_entrega = '<span class="badge'. $i_class. 'px-2 py-1 w-100">'.$fecha.'</span>';
                    if($days > 0) {
                        $fecha_entrega .= '<span class="text-nowrap">quedan ' .$days . ' días</span>';
                    } else {
                        $fecha_entrega .= '<span class="text-nowrap text-muted">pasado</span>';
                    }
                }
                $ot_id = 'OT-'.zerosatleft($ot->id, 3);
                $status = $status_data['html'];
                $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
                $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
                $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>'.
                ($admin ? '<a href="/ordenes/'.$ot->id.'/editar" class="btn btn-sm btn-warning"><i class="fal fa-edit"></i></a> <button type="button" class="btn btn-sm btn-danger btn-mdelete" data-otid="'.$ot->id.'" data-toggle="modal" data-target="#modalDelOT"><i class="fal fa-trash"></i></button>' : ' ')
                . ($allowed_users ? $status_data['eval'] : '');

                $ots_array[] = array(
                  "created_at" => $created_at,
                  "id" => $ot_id,
                  "status" => $status,
                  "razon_social" => $client,
                  "numero_potencia" => $potencia ? $potencia :   '-',
                  "fecha_entrega" => $fecha_entrega,
                  "tools" => $tools
                );
            }
        };

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $ots_array
        );

        echo json_encode($response);
        exit;
    }

    public function disapproved_ots(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'crear_ot']);

        $counter = 0;
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        /*$totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where('clients.razon_social', 'like', '%' .$searchValue . '%')->where('ots.enabled', 1)->count();*/

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where('clients.razon_social', 'like', '%' .$searchValue . '%')
                    ->orderBy($columnName, $columnSortOrder)

                    ->where('ots.enabled', 1)->get();

        $counter = $start;

        foreach ($records as $key => $ot) {
            $ot_status_arr = array_column($ot->statuses->toArray(), "name");
            if (in_array('cc_disapproved', $ot_status_arr) || 
                in_array('rdi_disapproved', $ot_status_arr) ||
                in_array('ee_disapproved', $ot_status_arr) ||
                in_array('me_disapproved', $ot_status_arr)) {

                $counter++;

                $created_at = date('d-m-Y', strtotime($ot->created_at));
                $status_data = self::getOTStatus($ot);
                $fecha_entrega = '-';
                if(isset($status_data->fecha_entrega)) {
                    $start = strtotime($status_data->fecha_entrega);
                    $end   = time();
                    $days  = date($start - $end);
                    $fecha = date('d-m-Y', $start);
                    $i_class = ($days > 0) ? ' badge-danger ' : ' badge-success ';
                    $fecha_entrega = '<span class="badge'. $i_class. 'px-2 py-1 w-100">'.$fecha.'</span>';
                    if($days > 0) {
                        $fecha_entrega .= '<span class="text-nowrap">quedan ' .$days . ' días</span>';
                    } else {
                        $fecha_entrega .= '<span class="text-nowrap text-muted">pasado</span>';
                    }
                }
                $ot_id = zerosatleft($ot->id, 3);
                $status = $status_data['html'];
                $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
                $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
                $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                <button type="button" class="btn btn-sm btn-primary btn-mdelete" data-otid="'.$ot->id.'" data-toggle="modal" data-target="#modalDelOT"><i class="fal fa-trash-restore"></i></button>';

                $ots_array[] = array(
                  "created_at" => $created_at,
                  "id" => $ot_id,
                  "status" => $status,
                  "razon_social" => $client,
                  "numero_potencia" => $potencia ? $potencia :   '-',
                  "fecha_entrega" => $fecha_entrega,
                  "tools" => $tools
                );
            }
        };

        $totalRecords = count($ots_array);
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $ots_array
        );

        echo json_encode($response);
        exit;
    }

    public function disabled_ots(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'crear_ot']);

        $counter = 0;
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        /*$totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where('clients.razon_social', 'like', '%' .$searchValue . '%')->where('ots.enabled', 2)->count();*/

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where('clients.razon_social', 'like', '%' .$searchValue . '%')
                    ->orderBy($columnName, $columnSortOrder)

                    ->where('ots.enabled', 2)->get();

        $counter = $start;

        foreach ($records as $key => $ot) {
            $counter++;
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot);
            $fecha_entrega = '-';
            if(isset($status_data->fecha_entrega)) {
                $start = strtotime($status_data->fecha_entrega);
                $end   = time();
                $days  = date($start - $end);
                $fecha = date('d-m-Y', $start);
                $i_class = ($days > 0) ? ' badge-danger ' : ' badge-success ';
                $fecha_entrega = '<span class="badge'. $i_class. 'px-2 py-1 w-100">'.$fecha.'</span>';
                if($days > 0) {
                    $fecha_entrega .= '<span class="text-nowrap">quedan ' .$days . ' días</span>';
                } else {
                    $fecha_entrega .= '<span class="text-nowrap text-muted">pasado</span>';
                }
            }
            $ot_id = zerosatleft($ot->id, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
            <button data-href="/ordenes/'. $ot->id .'/activar" class="btn btn-sm btn-primary btn-enablingot"><i class="far fa-trash-restore"></i> Restaurar</button>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_id,
              "status" => $status,
              "razon_social" => $client,
              "numero_potencia" => $potencia ? $potencia :   '-',
              "fecha_entrega" => $fecha_entrega,
              "tools" => $tools
            );
        };

        $totalRecords = count($ots_array);
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $ots_array
        );

        echo json_encode($response);
        exit;
    }

    protected function getOTStatus(Ot $ot)
    {
        $statuses = $ot->statuses;

        $rdi = Rdi::where('enabled', 1)->where('ot_id', $ot->id)
                ->select('id')
                ->first();

        $meval = MechanicalEvaluation::where('ot_id', $ot->id)
                ->select('mechanical_evaluations.id')
                ->first();

        $eeval = ElectricalEvaluation::where('ot_id', $ot->id)
                ->select('electrical_evaluations.id')
                ->first();

        $cost_card = CostCard::where('ot_id', $ot->id)
                ->select('cost_cards.id')
                ->first();

        /*$work_shop = WorkShop::where('ot_id', $ot->id)
                ->select('id as ws_id')
                ->first();*/

        $status['status'] = $statuses;
        $status['html'] = '';

        if ($statuses) {
            foreach ($statuses as $key => $item) {
                if($item->name == 'cc' || $item->name == 'rdi') {
                  $status['html'] = '<span class="badge badge-primary px-2 py-1 w-100">'.$item->description.'</span>';
                } else if(strpos($item->name, '_waiting') !== false) {
                  $status['html'] = '<span class="badge badge-danger px-2 py-1 w-100">'.$item->description.'</span>';
                } else if(strpos($item->name, '_disapproved') !== false) {
                  $status['html'] = '<span class="badge badge-danger px-2 py-1 w-100">'.$item->description.'</span>';
                } else if(strpos($item->name, '_approved') !== false || $item->name == 'delivery_generated') {
                    $status['html'] = '<span class="badge badge-success px-2 py-1 w-100">'.$item->description.'</span>';
                    if($item->name == 'delivery_generated') {
                        $status['fecha_entrega'] = $ot->fecha_entrega;
                    }
                } else {
                  $status['html'] = '<span class="badge badge-secondary px-2 py-1 w-100">'.$item->description.'</span>';
                }
            }
        }

        $eval_html = "";
        if($cost_card || $rdi || $meval || $eeval) {
            $eval_html = '<div class="dropdown d-inline-block dropleft">
            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" title="Ver Evaluaciones" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-check"></i></button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            if($cost_card) {
              $eval_html .= '<a class="dropdown-item" href="/tarjeta-costo/'.$ot->id.'/ver"><i class="fas fa-money-check-alt pr-2"></i> Ver Tarjeta de Costo</a>';
            }
            if($rdi) {
            $eval_html .= '<a class="dropdown-item" href="/rdi/'.$rdi->id.'/ver"><i class="fas fa-money-check-alt pr-2"></i> Ver RDI</a>';
            }
            if($meval) {
            $eval_html .= '<a class="dropdown-item" href="/formatos/mechanical/'.$meval->id.'/ver"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>';
            }
            if($eeval) {
            $eval_html .= '<a class="dropdown-item" href="/formatos/electrical/'.$eeval->id.'/ver"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>';
            }
            $eval_html .= '</div></div>';
        }
        $status['eval'] = $eval_html;

        return $status;
        /*return response()->json([
            'status' => json_encode($ot_status),
            'rdi' => json_encode($rdi),
            'meval' => json_encode($meval),
            'eeval' => json_encode($eeval),
            'cost_card' => json_encode($cost_card),
            //'work_shop' => json_encode($work_shop),
            'success' => true
        ]);*/
    }

    public function list(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'client']);
        //Listar OTs
        $ordenes = Ot::join('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                    ->select('ots.*', 'motor_brands.name as marca')
                    ->where('enabled', 1)->get();

        return view('procesovirtual.list', compact('ordenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'crear_ot']);
        //
        //Revisar el ultimo numero de OT
        $totalOts = Ot::count();
        $ot_numero = $totalOts + 1;

        $clientes = Client::where('clients.enabled', 1)
                    /*->where('client_type_id', 2)*/
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('clients.*', 'client_types.id as client_type_id', 'client_types.name as client_type')
                    ->get();
        $marcas = MotorBrand::where('enabled', 1)->get();
        $modelos = MotorModel::where('enabled', 1)->get();

        return view('ordenes.create', compact('ot_numero', 'clientes', 'marcas', 'modelos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'crear_ot']);
        //
        $rules = [
            'client_id' => 'required|integer',
            //'fecha_creacion' => 'required',
            'guia_cliente' => 'string|nullable',
            'solped' => 'string|nullable',
            'descripcion_motor' => 'string|nullable',
            'codigo_motor' => 'string|nullable',
            'marca_id' => 'integer|nullable',
            'modelo_id' => 'integer|nullable',
            'numero_potencia' => 'string|nullable',
            'medida_potencia' => 'string|nullable',
            'voltaje' => 'string|nullable',
            'velocidad' => 'string|nullable',
            'enabled' => 'required|boolean',
        ];

        $messages = [
            //'ruc.required' => 'Agrega el nombre del estudiante.',
        ];

        $this->validate($request, $rules);

        //creamos una variable que es un objeto de nuesta instancia de nuestro modelo
        $ot = new Ot();
        
        $ot->client_id = $request->input('client_id');
        //$ot->fecha_creacion = $request->input('fecha_creacion');
        $ot->guia_cliente = $request->input('guia_cliente');
        $ot->solped = $request->input('solped');
        $ot->descripcion_motor = $request->input('descripcion_motor');
        $ot->codigo_motor = $request->input('codigo_motor');
        $ot->marca_id = $request->input('marca_id');
        $ot->modelo_id = $request->input('modelo_id');
        $ot->numero_potencia = $request->input('numero_potencia');
        $ot->medida_potencia = $request->input('medida_potencia');
        $ot->voltaje = $request->input('voltaje');
        $ot->velocidad = $request->input('velocidad');
        $ot->enabled = $request->input('enabled');

        $ot->save();

        $status = Status::where('name', 'ot_created')->first();
        if ($status) {
            $status_ot = new StatusOt();
            $status_ot->status_id = $status->id;
            $status_ot->ot_id = $ot->id;
            $status_ot->save();
        }

        activitylog('ots', 'store', null, $ot->toArray());

        return redirect('ordenes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'client']);
        
        $orden = Ot::join('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                    ->select('ots.*', 'motor_brands.name as marca')
                    ->where('ots.enabled', 1)
                    ->findOrFail($id);

        $ordenes = Ot::where('ots.id', '<>', $id)
                    ->join('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                    ->select('ots.*', 'motor_brands.name as marca')
                    ->where('ots.enabled', 1)
                    ->get();

        return view('procesovirtual.show', compact('orden', 'ordenes'));
    }

    public function ot_show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'evaluador', 'aprobador_de_evaluaciones', 'crear_ot']);

        /*$validate_ot = Ot::where('ots.enabled', 1)->where('ots.id', $id)
                    ->join('clients', 'clients.id', '=', 'ots.client_id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('client_types.id')->firstOrFail();
                    dd($validate_ot);*/
            $ot = Ot::leftJoin('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                ->leftJoin('motor_models', 'motor_models.id', '=', 'ots.modelo_id')
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->leftJoin('cost_cards', 'cost_cards.ot_id', '=', 'ots.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'motor_brands.name as marca', 'motor_models.name as modelo', 'clients.razon_social', 'client_types.id as tipo_cliente_id', 'client_types.name as tipo_cliente', 'cost_cards.cotizacion')
                    ->where('ots.enabled', 1)
                    ->findOrFail($id); 
        $rdi = Ot::join('rdi', 'rdi.ot_id', '=', 'ots.id')
                ->where('rdi.enabled', 1)
                ->where('rdi.ot_id', $id)
                ->first();
        $meval = MechanicalEvaluation::where('ot_id', $id)->first();
        $eeval = ElectricalEvaluation::where('ot_id', $id)->first();

        $cost_card = CostCard::where('ot_id', $id)
                ->select('cost_cards.id as cc_id')
                ->first();

        return view('ordenes.show', compact('ot', 'rdi', 'meval', 'eeval', 'cost_card'));
    }

    public function pvirtual(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'client']);

        $ordenes = Ot::where('enabled', 1)->get();
        return view('procesovirtual.index', compact('ordenes'));
    }

    public function generateOTDate(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'fecha_de_entrega']);

        $ot = Ot::findOrFail($id);
        if ($ot->fecha_entrega != null) {
            return response()->json(['data'=>'Ya se generó la fecha de entrega: ' . $ot->fecha_entrega,'success'=>false]);
        }

        $status = Status::where('name', 'delivery_generated')->first();
        if ($status) {
            $status_ot = new StatusOt();
            $status_ot->status_id = $status->id;
            $status_ot->ot_id = $id;
            $status_ot->save();

            $ot->fecha_entrega = $request->input('fecha_entrega');
            $original_data = $ot->toArray();
            $ot->save();
        }

        activitylog('ots', 'update', $original_data, $ot->toArray());

        return response()->json(['data'=>json_encode($ot),'success'=>true]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'crear_ot']);

        $clientes = Client::where('clients.enabled', 1)
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->select('clients.*', 'client_types.name as client_type')
                ->get();
        $marcas = MotorBrand::where('enabled', 1)->get();
        $modelos = MotorModel::where('enabled', 1)->get();
        $orden = Ot::where('enabled', 1)->findOrFail($id);

        return view('ordenes.edit', compact('orden', 'clientes', 'marcas', 'modelos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'crear_ot']);

        $rules = array(
            'client_id' => 'required|integer',
            //'fecha_creacion' => 'required',
            'guia_cliente' => 'string|nullable',
            'solped' => 'string|nullable',
            'descripcion_motor' => 'string|nullable',
            'codigo_motor' => 'string|nullable',
            'marca_id' => 'nullable',
            'modelo_id' => 'nullable',
            'numero_potencia' => 'string|nullable',
            'medida_potencia' => 'string|nullable',
            'voltaje' => 'string|nullable',
            'velocidad' => 'string|nullable',
            'enabled' => 'required|boolean',
        );
        $this->validate($request, $rules);

        $ot = Ot::find($id);
        $original_data = $ot->toArray();
        $ot->client_id = $request->get('client_id');
        //$ot->fecha_creacion = $request->get('fecha_creacion');
        $ot->guia_cliente = $request->get('guia_cliente');
        $ot->solped = $request->get('solped');
        $ot->descripcion_motor = $request->get('descripcion_motor');
        $ot->codigo_motor = $request->get('codigo_motor');
        $ot->marca_id = $request->get('marca_id');
        $ot->modelo_id = $request->get('modelo_id');
        $ot->numero_potencia = $request->get('numero_potencia');
        $ot->medida_potencia = $request->get('medida_potencia');
        $ot->voltaje = $request->get('voltaje');
        $ot->velocidad = $request->get('velocidad');
        $ot->enabled = $request->get('enabled');
        $ot->save();

        activitylog('ots', 'update', $original_data, $ot->toArray());

        // redirect
        \Session::flash('message', '¡Se actualizó la orden!');
        return redirect('ordenes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ot  $ot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'crear_ot']);

        $ot = Ot::findOrFail($id);
        $ot->enabled = 2;
        $ot->save();

        return response()->json(['data'=>json_encode($ot), 'success'=>true]);
    }

    public function enabling_ot(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'crear_ot']);

        $ot = Ot::findOrFail($id);
        $ot->enabled = 1;
        $ot->save();

        return response()->json(['data'=>json_encode($ot), 'success'=>true]);
    }

    public function galleryStore(Request $request, $ot_id)
    {
        $rules = array(
            'file' => 'mimes:jpeg,jpg,png,gif|required|max:10000' // max 10000kb
        );
        $this->validate($request, $rules);

        $image = $request->file('file');
        $eval_type = $request->input('eval_type');

        $avatarName = $image->getClientOriginalName();
        $ext = $image->getClientOriginalExtension();
        $url = 'uploads/ots/'.$ot_id.'/'.$eval_type;
        $image->move(public_path($url), $avatarName);
        
        /*if ($eval_type == 'mechanical') {
            $imageUpload = new OtGallery();
            $imageUpload->name = $avatarName;
            $imageUpload->ot_id = $ot_id;
            $imageUpload->eval_type = $eval_type;
            $imageUpload->save();
        } else if($eval_type == 'electrical') {
            $imageUpload = new OtGallery();
            $imageUpload->name = $avatarName;
            $imageUpload->ot_id = $ot_id;
            $imageUpload->eval_type = $eval_type;
            $imageUpload->save();
        }*/
        return response()->json(['name'=>$avatarName, 'url' => $url .'/'.$avatarName]);
    }

    public function galleryDelete(Request $request, $image_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'worker']);

        $ot_gallery = OtGallery::findOrFail($image_id);
        $ot_gallery->enabled = 0;
        $ot_gallery->save();

        return response()->json(['data'=>json_encode($ot_gallery), 'success'=>true]);
    }
}
