<?php

namespace App\Http\Controllers;

use App\Models\Ot;
use App\Models\Client;
use App\Models\MotorBrand;
use App\Models\MotorModel;
use App\Models\Status;
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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception', 'worker']);
        
        //Listar OTs
        $ordenes = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->where('ots.enabled', 1)->get();

        return view('ordenes.index', compact('ordenes'));
    }

    public function enabled_ots(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception', 'worker']);

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

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where('clients.razon_social', 'like', '%' .$searchValue . '%')->where('ots.enabled', 1)->count();

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
            $ot_status = \DB::table('status_ot')
                  ->join('status', 'status_ot.status_id', '=', 'status.id')
                  ->where('status_ot.ot_id', '=', $ot->id)
                  ->select('status_ot.status_id', 'status.id', 'status.name')
                  ->get();
            $ot_status_arr = array_column($ot_status->toArray(), "status_id");
            if (!in_array(7, $ot_status_arr) && !in_array(10, $ot_status_arr)) {
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
                $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                <a href="/ordenes/'.$ot->id.'/editar" class="btn btn-sm btn-warning"><i class="fal fa-edit"></i></a>
                <button type="button" class="btn btn-sm btn-danger btn-mdelete" data-otid="'.$ot->id.'" data-toggle="modal" data-target="#modalDelOT"><i class="fal fa-trash"></i></button>
                '. self::getStatusHtml($status_data, $ot);

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
            "iTotalRecords" => $totalRecordswithFilter,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $ots_array
        );

        echo json_encode($response);
        exit;
    }

    function getStatusHtml($data, $ot) {
      $html = "";
      if(!empty($data['cost_card']) || !empty($data['rdi']) || !empty($data['meval']) || !empty($data['eeval'])) {
        $html = '<div class="dropdown d-inline-block dropleft">
          <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" title="Ver Evaluaciones" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-check"></i></button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            if($data['cost_card']) {
              $html .= '<a class="dropdown-item" href="/tarjeta-costo/'.$ot->id.'/ver"><i class="fas fa-money-check-alt pr-2"></i> Ver Tarjeta de Costo</a>';
            }
            if($data['rdi']) {
            $html .= '<a class="dropdown-item" href="/rdi/'.$data['rdi']->rdi_id.'/ver"><i class="fas fa-money-check-alt pr-2"></i> Ver RDI</a>';
            }
            if($data['meval']) {
            $html .= '<a class="dropdown-item" href="/formatos/mechanical/'.$data['meval']->meval_id.'/ver"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>';
            }
            if($data['eeval']) {
            $html .= '<a class="dropdown-item" href="/formatos/electrical/'.$data['eeval']->eeval_id.'/ver"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>';
            }
            $html .= '</div></div>';
        }
        return $html;
    }

    public function disapproved_ots(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'worker']);

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

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where('clients.razon_social', 'like', '%' .$searchValue . '%')->where('ots.enabled', 1)->count();

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
            $ot_status = \DB::table('status_ot')
                  ->join('status', 'status_ot.status_id', '=', 'status.id')
                  ->where('status_ot.ot_id', '=', $ot->id)
                  ->select('status_ot.status_id', 'status.id', 'status.name')
                  ->get();
            $ot_status_arr = array_column($ot_status->toArray(), "status_id");
            if (in_array(7, $ot_status_arr) && in_array(10, $ot_status_arr)) {

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
                <a href="/ordenes/'.$ot->id.'/editar" class="btn btn-sm btn-warning"><i class="fal fa-edit"></i></a>
                <button type="button" class="btn btn-sm btn-danger btn-mdelete" data-otid="'.$ot->id.'" data-toggle="modal" data-target="#modalDelOT"><i class="fal fa-trash"></i></button>
                '. self::getStatusHtml($status_data, $ot);

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
            "iTotalRecords" => $totalRecordswithFilter,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $ots_array
        );

        echo json_encode($response);
        exit;
    }

    public function disabled_ots(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'worker']);

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

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where('clients.razon_social', 'like', '%' .$searchValue . '%')->where('ots.enabled', 2)->count();

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
            $ot_status = \DB::table('status_ot')
                  ->join('status', 'status_ot.status_id', '=', 'status.id')
                  ->where('status_ot.ot_id', '=', $ot->id)
                  ->select('status_ot.status_id', 'status.id', 'status.name')
                  ->get();
            $ot_status_arr = array_column($ot_status->toArray(), "status_id");

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
                <a href="/ordenes/'.$ot->id.'/editar" class="btn btn-sm btn-warning"><i class="fal fa-edit"></i></a>
                <button type="button" class="btn btn-sm btn-danger btn-mdelete" data-otid="'.$ot->id.'" data-toggle="modal" data-target="#modalDelOT"><i class="fal fa-trash"></i></button>
                '. self::getStatusHtml($status_data, $ot);

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


        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordswithFilter,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $ots_array
        );

        echo json_encode($response);
        exit;
    }

    protected function getOTStatus(Ot $ot)
    {
        $statuses = \DB::table('status_ot')
                  ->join('status', 'status_ot.status_id', '=', 'status.id')
                  ->where('status_ot.ot_id', '=', $ot->id)
                  ->select('status_ot.status_id', 'status.id', 'status.name')
                  //->latest('status_ot.id')
                  //->first();
                  ->get();

        $rdi = Rdi::where('enabled', 1)
                ->where('ot_id', $ot->id)
                ->select('id as rdi_id')
                ->first();

        $meval = MechanicalEvaluation::where('ot_id', $ot->id)
                ->select('mechanical_evaluations.id as meval_id', 'mechanical_evaluations.approved')
                ->first();

        $eeval = ElectricalEvaluation::where('ot_id', $ot->id)
                ->select('electrical_evaluations.id as eeval_id', 'electrical_evaluations.approved')
                ->first();

        $cost_card = CostCard::where('ot_id', $ot->id)
                ->select('cost_cards.id as cc_id')
                ->first();

        /*$work_shop = WorkShop::where('ot_id', $ot->id)
                ->select('id as ws_id')
                ->first();*/

        $ee_approved = '';
        $me_approved = '';
        $status['status'] = $statuses;
        $status['rdi'] = $rdi;
        if($meval) {
            $status['meval'] = $meval;
            $me_status = $meval ? $meval->approved : -1;
            $text_mestatus = '';
            if($me_status == 0) {
                $text_mestatus = 'Por aprobar';
            } else if($me_status == 1) {
                $text_mestatus = 'Aprobada';
            } else if($me_status == 2) {
                $text_mestatus = 'Desaprobada';
            }
            $me_approved = '<span class="d-block text-muted">('.$text_mestatus.')</span>';
        } else {
            $status['meval'] = '';
        }
        if($eeval) {
            $status['eeval'] = $eeval;
            $ee_status = $eeval ? $eeval->approved : -1;
            $text_eestatus = '';
            if($ee_status == 0) {
                $text_eestatus = 'Por aprobar';
            } else if($ee_status == 1) {
                $text_eestatus = 'Aprobada';
            } else if($ee_status == 2) {
                $text_eestatus = 'Desaprobada';
            }
            $ee_approved = '<span class="d-block text-muted">('.$text_eestatus.')</span>';
        } else {
            $status['eeval'] = '';
        }
        $status['cost_card'] = $cost_card;
        $status['html'] = '';

        if ($statuses) {
            foreach ($statuses as $key => $item) {
                if($item->status_id == 2) {
                  $status['html'] = '<span class="d-inline-block"><span class="badge badge-secondary px-2 py-1 w-100">'.$item->name.'</span>'.$me_approved.'</span>';
                } else if($item->status_id == 3) {
                  $status['html'] = '<span class="d-inline-block"><span class="badge badge-secondary px-2 py-1 w-100">'.$item->name.'</span>'.$ee_approved.'</span>';
                } else if($item->status_id == 4) {
                  $status['html'] = '<span class="badge badge-primary px-2 py-1 w-100">'.$item->name.'</span>';
                } else if($item->status_id == 5 || $item->status_id == 8) {
                  $status['html'] = '<span class="badge badge-danger px-2 py-1 w-100">'.$item->name.'</span>';
                } else if($item->status_id == 6 || $item->status_id == 9 || $item->status_id == 11) {
                    $status['html'] = '<span class="badge badge-success px-2 py-1 w-100">'.$item->name.'</span>';
                    if($item->status_id == 11) {
                        $status['fecha_entrega'] = $ot->fecha_entrega;
                    }
                } else {
                  $status['html'] = '<span class="badge badge-secondary px-2 py-1 w-100">'.$item->name.'</span>';
                }
            }
        }
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
        $request->user()->authorizeRoles(['client']);
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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);
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

        $status = Status::where('id', 1)->first();
        if ($status) {
            \DB::table('status_ot')->insert([
                'status_id' => $status->id,
                'ot_id' => $ot->id,
            ]);
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
        $request->user()->authorizeRoles(['client']);
        
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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

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
        $request->user()->authorizeRoles(['client']);

        $ordenes = Ot::where('enabled', 1)->get();
        return view('procesovirtual.index', compact('ordenes'));
    }

    public function generateOTDate(Request $request, $id)
    {
        $ot = Ot::findOrFail($id);
        if ($ot->fecha_entrega != null) {
            return response()->json(['data'=>'Ya se generó la fecha de entrega: ' . $ot->fecha_entrega,'success'=>false]);
        }

        $status = Status::where('id', 11)->first();
        if ($status) {
            \DB::table('status_ot')->insert([
                'status_id' => $status->id,
                'ot_id' => $id,
            ]);

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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception']);

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
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $ot = Ot::findOrFail($id);
        $ot->enabled = 2;
        $ot->save();

        return response()->json(['data'=>json_encode($ot), 'success'=>true]);
    }

    public function enabling_ot(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'worker']);

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
        $request->user()->authorizeRoles(['superadmin', 'admin', 'mechanical']);

        $ot_gallery = OtGallery::findOrFail($image_id);
        $ot_gallery->enabled = 0;
        $ot_gallery->save();

        return response()->json(['data'=>json_encode($ot_gallery), 'success'=>true]);
    }
}
