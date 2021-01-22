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
        //$request->user()->authorizeRoles(['superadmin', 'admin', 'evaluador', 'crear_ot', 'aprobador_de_evaluaciones', 'tarjeta_de_costo', 'cotizador_tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);
        
        //Listar OTs
        $ordenes = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->where('ots.enabled', 1)->get();

        return view('ordenes.index', compact('ordenes'));
    }

    public function enabled_ots(Request $request)
    {
        //$request->user()->authorizeRoles(['superadmin', 'admin', 'evaluador', 'crear_ot', 'aprobador_de_evaluaciones', 'tarjeta_de_costo', 'cotizador_tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo', 'rdi']);

        $role_names = validateActionbyRole();
        $admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
        $evaluador = in_array("evaluador", $role_names) || in_array("aprobador_de_evaluaciones", $role_names);
        $tarjeta_costo = in_array("tarjeta_de_costo", $role_names) || in_array("aprobador_cotizacion_tarjeta_de_costo", $role_names);
        $rdi = in_array("rdi", $role_names) || in_array("aprobador_rdi", $role_names);

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
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_disapproved');
                    $query->orWhere("status.name", "=", 'me_disapproved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_disapproved');
                    $query->orWhere("status.name", "=", 'rdi_disapproved');
                })
                ->where('ots.enabled', 1)
                ->count();
        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_disapproved');
                    $query->orWhere("status.name", "=", 'me_disapproved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_disapproved');
                    $query->orWhere("status.name", "=", 'rdi_disapproved');
                })
                ->where('ots.enabled', 1)
                ->count();

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'ee_disapproved');
                        $query->orWhere("status.name", "=", 'me_disapproved');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'cc_disapproved');
                        $query->orWhere("status.name", "=", 'rdi_disapproved');
                    })

                    ->where('ots.enabled', 1)->get();

        $ots_array = [];

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, $admin, $tarjeta_costo, $evaluador, $rdi);
            //$ot_code = 'OT-'.zerosatleft($ot->id, 3);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>'.
            ($admin ? ' <a href="/ordenes/'.$ot->id.'/editar" class="btn btn-sm btn-warning"><i class="fal fa-edit"></i></a> <button type="button" class="btn btn-sm btn-danger btn-mdelete" data-otid="'.$ot->id.'" data-toggle="modal" data-target="#modalDelOT"><i class="fal fa-trash"></i></button>' : ' ')
            . $status_data['eval'];

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia :   '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

        $totalRecords = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_disapproved')
                        ->orWhere("status.name", "=", 'rdi_disapproved')
                        ->orWhere("status.name", "=", 'ee_disapproved')
                        ->orWhere("status.name", "=", 'me_disapproved');
                })
                ->where('ots.enabled', 1)->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                })
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_disapproved')
                        ->orWhere("status.name", "=", 'rdi_disapproved')
                        ->orWhere("status.name", "=", 'ee_disapproved')
                        ->orWhere("status.name", "=", 'me_disapproved');
                })
                ->where('ots.enabled', 1)->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_disapproved')
                        ->orWhere("status.name", "=", 'rdi_disapproved')
                        ->orWhere("status.name", "=", 'ee_disapproved')
                        ->orWhere("status.name", "=", 'me_disapproved');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            //$ot_code = 'OT-'.zerosatleft($ot->id, 3);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
            <button type="button" class="btn btn-sm btn-primary btn-mdelete" data-otid="'.$ot->id.'" data-toggle="modal" data-target="#modalDelOT"><i class="fal fa-trash"></i></button>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia :   '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

        $totalRecords = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where('ots.enabled', 0)->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                })
                ->where('ots.enabled', 0)->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->where('ots.enabled', 0)->get();

        $counter = $start;

        foreach ($records as $key => $ot) {
            $counter++;
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            //$ot_code = 'OT-'.zerosatleft($ot->id, 3);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<button data-href="/ordenes/'. $ot->id .'/activar" class="btn btn-sm btn-primary btn-enablingot"><i class="far fa-trash-restore"></i> Restaurar</button>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia :   '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

    public function pending_eval_ots(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'aprobador_de_evaluaciones']);

        return view('ordenes.pending');
    }

    public function list_eval_pending(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'aprobador_de_evaluaciones']);

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
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_approved')
                        ->orWhere("status.name", "=", 'me_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_disapproved');
                    $query->orWhere("status.name", "=", 'me_disapproved');
                })
                ->where('ots.enabled', 1)
                ->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_approved')
                          ->orWhere("status.name", "=", 'me_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_disapproved');
                    $query->orWhere("status.name", "=", 'me_disapproved');
                })
                ->where('ots.enabled', 1)
                ->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'ee_approved')
                            ->orWhere("status.name", "=", 'me_approved');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'ee_disapproved');
                        $query->orWhere("status.name", "=", 'me_disapproved');
                    })
                    ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            //$ot_code = 'OT-'.zerosatleft($ot->id, 3);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia :   '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

    public function pending_cc_ots(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'cotizador_tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);

        return view('costos.pending');
    }

    // OT solo con tarjeta de costo, sin cotizacion y sin aprobacion
    public function list_cc_pending(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'cotizador_tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);

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
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_waiting');
                })
                ->where('ots.enabled', 1)
                ->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                })

                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_waiting');
                })
                ->where('ots.enabled', 1)
                ->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'cc');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'cc_waiting');
                    })
                    ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            //$ot_code = 'OT-'.zerosatleft($ot->id, 3);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia : '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

    public function cc_ots(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'cotizador_tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);

        return view('cotizaciones.index');
    }

    // OT con tarjeta de costo, con cotizacion y sin aprobacion
    public function list_cc_waiting(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'cotizador_tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);

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

                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_waiting');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_approved');
                })
                ->where('ots.enabled', 1)
                ->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                })

                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_waiting');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_approved');
                })
                ->where('ots.enabled', 1)
                ->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'cc_waiting');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'cc_approved');
                    })
                    ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            //$ot_code = 'OT-'.zerosatleft($ot->id, 3);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia : '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

    // OT con tarjeta de costo, con cotizacion y con aprobacion
    public function list_cc_approved(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'cotizador_tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);

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
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_approved');
                })
                ->where('ots.enabled', 1)
                ->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                })
                ->where('ots.enabled', 1)

                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_approved');
                })
                ->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'cc_approved');
                    })
                    ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            //$ot_code = 'OT-'.zerosatleft($ot->id, 3);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia : '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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
    public function rdi_list(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'aprobador_rdi']);

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
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_approved');
                })
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'me_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'rdi_waiting');
                })
                ->where('ots.enabled', 1)->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                })
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_approved');
                })
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'me_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'rdi_waiting');
                })
                ->where('ots.enabled', 1)->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'ee_approved');
                    })
                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'me_approved');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'cc');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'rdi_waiting');
                    })
                    ->orderBy($columnName, $columnSortOrder)
                    ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="rdi/'.$ot->id.'/calcular" class="btn btn-warning" title="Calcular"><i class="fal fa-money-check-alt"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia :   '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

    public function cc_list(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'tarjeta_de_costo', 'cotizador_tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);

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
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_approved');
                })
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'me_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc');
                })
                ->where('ots.enabled', 1)->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                })
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee_approved');
                })
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'me_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc');
                })
                ->where('ots.enabled', 1)->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'ee_approved');
                    })
                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'me_approved');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'cc');
                    })
                    ->orderBy($columnName, $columnSortOrder)
                    ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/tarjeta-costo/'.$ot->id.'/calcular" class="btn btn-warning" title="Calcular"><i class="fal fa-money-check-alt"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia :   '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

    // OT rdi y sin aprobacion
    public function list_rdi_waiting(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'aprobador_rdi']);

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
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_waiting');
                })
                ->where('ots.enabled', 1)
                ->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                ->where('ots.enabled', 1)

                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_waiting');
                })

                ->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'rdi_waiting');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'rdi_approved');
                        $query->orWhere("status.name", "=", 'rdi_disapproved');
                    })
                    ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            //$ot_code = 'OT-'.zerosatleft($ot->id, 3);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia : '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
        };

        $totalRecords = count($ots_array);
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $ots_array
        );

        echo json_encode($response);
        exit;
    }
    // OT con rdi y con aprobacion
    public function list_rdi_approved(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'aprobador_rdi']);

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
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_approved');
                })
                ->where('ots.enabled', 1)
                ->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                })
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_approved');
                })
                ->where('ots.enabled', 1)
                ->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'rdi_approved');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'delivery_generated');
                    })
                    ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            //$ot_code = 'OT-'.zerosatleft($ot->id, 3);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia : '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

    // Vista de OTs con/sin fecha de entrega
    public function delivery_date(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'fecha_de_entrega']);
        
        return view('fechaentrega.index');
    }

    // OT sin fecha de entrega
    public function list_delivery_pending(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'fecha_de_entrega']);

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
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'rdi_approved');
                    $query->orWhere("status.name", "=", 'cc_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'delivery_generated');
                })
                ->where('ots.enabled', 1)
                ->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'rdi_approved');
                    $query->orWhere("status.name", "=", 'cc_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'delivery_generated');
                })
                ->where('ots.enabled', 1)
                ->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                ->skip($start)
                ->take($rowperpage)
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                ->orderBy($columnName, $columnSortOrder)

                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'rdi_approved');
                    $query->orWhere("status.name", "=", 'cc_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'delivery_generated');
                })
                ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            //$ot_code = 'OT-'.zerosatleft($ot->id, 3);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia : '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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
    // OT con fecha de entrega
    public function list_delivery_generated(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'fecha_de_entrega']);

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
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_approved');
                })
                ->where('ots.enabled', 1)
                ->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                ->where('ots.enabled', 1)

                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_approved');
                })
                ->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'delivery_generated');
                    })
                    ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, true, true, true, true);
            //$ot_code = 'OT-'.zerosatleft($ot->id, 3);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia : '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

    //Eval. Electrica
    public function ee_list(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'evaluador', 'aprobador_de_evaluaciones']);
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
                ->where('ots.enabled', 1)
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee');
                })
                ->count();
        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                })
                ->where('ots.enabled', 1)
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ee');
                })
                ->count();

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'ee');
                    })

                    ->where('ots.enabled', 1)->get();

        $ots_array = [];

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/formatos/electrical/'.$ot->id.'/evaluar" class="btn btn-orange btn-sm">Evaluar <i class="fal fa-edit ml-2"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia :   '-',
              "tools" => $tools
            );
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
    //Eval. Mecánica
    public function me_list(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'evaluador', 'aprobador_de_evaluaciones']);
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
                ->where('ots.enabled', 1)
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'me');
                })
                ->count();
        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                ->where('ots.enabled', 1)
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'me');
                })
                ->count();

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'me');
                    })

                    ->where('ots.enabled', 1)->get();

        $ots_array = [];

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/formatos/mechanical/'.$ot->id.'/evaluar" class="btn btn-orange btn-sm">Evaluar <i class="fal fa-edit ml-2"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia :   '-',
              "tools" => $tools
            );
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

    //Talleres
    public function list_workshop(Request $request)
    {
        //$request->user()->authorizeRoles(['superadmin', 'admin']);

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
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'delivery_generated');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ot_closure');
                })
                ->where('ots.enabled', 1)
                ->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                ->where('ots.enabled', 1)

                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'delivery_generated');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ot_closure');
                })
                ->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'delivery_generated');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'ot_closure');
                    })
                    ->where('ots.enabled', 1)->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/talleres/'.$ot->id.'/asignar" class="btn btn-sm btn-primary">Ver tareas <i class="fal fa-eye"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia : '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

    // Vista de OTs con/sin fecha de entrega
    public function closure(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);
        
        return view('cierre.index');
    }

    public function closure_view(Request $request, $ot_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);

        $ot = Ot::join('clients', 'clients.id', '=', 'ots.client_id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'client_types.id as tipo_cliente_id', 'client_types.name as tipo_cliente')
                ->findOrFail($ot_id);
        $gallery = OtGallery::where('ot_id', $ot->id)
                    ->where('enabled', 1)
                    ->where('eval_type', '=', 'closure')->get();
        
        return view('cierre.show', compact('ot', 'gallery'));
    }

    // OT pendientes de cierre
    public function list_pendingclosure(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);

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
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ot_closure');
                })
                /*->whereHas('works', function ($query) {
                    $query->where("ot_works.approved", "=", 1);
                })*/
                ->where('ots.enabled', 1)
                ->with('works')
                ->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })

                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'cc_approved');
                })
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ot_closure');
                })
                /*->whereHas('works', function ($query) {
                    $query->where("ot_works.approved", "=", 1);
                })*/
                ->where('ots.enabled', 1)
                ->with('works')
                ->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'delivery_generated');
                    })
                    ->whereDoesntHave('statuses', function ($query) {
                        $query->where("status.name", "=", 'ot_closure');
                    })
                    /*->whereHas('works', function ($query) {
                        $query->where("ot_works.approved", "=", 1);
                    })*/
                    ->where('ots.enabled', 1)
                    ->with('works')
                    ->get();

        foreach ($records as $key => $ot) {
            $works = $ot->works;
            if ($works->count()) {
                $cols = $works->toArray();
                $cols_approved = array_column($cols, 'approved');
                //Todos los trabajos tienen que estar aprobados
                $all_approved = array_unique($cols_approved) === array(1);
                if (!$all_approved) {
                    $totalRecords> 0 ? $totalRecords-- : $totalRecords;
                    $totalRecordswithFilter> 0 ? $totalRecordswithFilter-- : $totalRecordswithFilter;
                    continue;
                }
            }
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/cierre" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia : '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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
    public function list_closure(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor']);

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
                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'ot_closure');
                })
                ->where('ots.enabled', 1)
                ->with('works')
                ->count();

        $totalRecordswithFilter = Ot::select('count(*) as allcount')
                ->join('clients', 'ots.client_id', '=', 'clients.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })

                ->whereHas('statuses', function ($query) {
                    $query->where("status.name", "=", 'ot_closure');
                })
                ->where('ots.enabled', 1)
                ->with('works')
                ->count();

        $ots_array = [];

        $records = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->whereHas('statuses', function ($query) {
                        $query->where("status.name", "=", 'ot_closure');
                    })
                    ->where('ots.enabled', 1)
                    ->with('works')
                    ->get();

        foreach ($records as $key => $ot) {
            $created_at = date('d-m-Y', strtotime($ot->created_at));
            $status_data = self::getOTStatus($ot, false, false, false, false);
            $ot_code = 'OT-'.zerosatleft($ot->code, 3);
            $status = $status_data['html'];
            $client = $ot->razon_social ."</span>".(($ot->client_type_id == 1) ? '<span class="badge badge-success px-2 py-1 ml-1 align-middle">'.$ot->client_type.'</span>' : '<span class="badge badge-danger px-2 py-1 ml-1">'.$ot->client_type.'</span>');
            $potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
            $tools = '<a href="/ordenes/'.$ot->id.'/cierre" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>';

            $ots_array[] = array(
              "created_at" => $created_at,
              "id" => $ot_code,
              "status" => $status,
              "razon_social" => $client,
              "codigo_motor" => $ot->codigo_motor,
              "numero_potencia" => $potencia ? $potencia : '-',
              "fecha_entrega" => $status_data['fecha_entrega'],
              "tools" => $tools
            );
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

    public function getOTStatus(Ot $ot, $role_admin, $role_cc, $role_eval, $role_rdi)
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
        $status['fecha_entrega'] = '-';

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
                        $fecha_entrega = '';
                        if($ot->fecha_entrega) {
                            $start = strtotime($ot->fecha_entrega);
                            $end   = strtotime(date('d-m-Y'));
                            $remaining_days = $start - $end;
                            $fecha = date('d-m-Y', $start);
                            if ($remaining_days == 0) {
                                $fecha_entrega = '<span class="badge badge-warning px-2 py-1 w-100">'.$fecha.'</span><span class="text-nowrap text-muted">hoy</span>';
                            } else if($remaining_days > 0) {
                                $days  = date('d', $remaining_days);
                                $fecha_entrega = '<span class="badge badge-danger px-2 py-1 w-100">'.$fecha.'</span><span class="text-nowrap">quedan ' .$days . ' día(s)</span>';
                            } else {
                                $fecha_entrega .= '<span class="badge badge-success px-2 py-1 w-100">'.$fecha.'</span><span class="text-nowrap text-muted">pasado</span>';
                            }
                        }
                        $status['fecha_entrega'] = $fecha_entrega;
                    }
                } else {
                  $status['html'] = '<span class="badge badge-secondary px-2 py-1 w-100">'.$item->description.'</span>';
                }
            }
        }

        $eval_html = "";
        if (($role_admin && ($cost_card || $rdi || $meval || $eeval)) ||
            ($role_cc && $cost_card) ||
            ($role_rdi && $rdi) ||
            ($role_eval && ($eeval || $meval))
        ) {
            $eval_html = ' <div class="dropdown d-inline-block dropleft">
            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" title="Ver Evaluaciones" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-check"></i></button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            if($cost_card && ($role_admin || $role_cc)) {
              $eval_html .= '<a class="dropdown-item" href="/tarjeta-costo/'.$ot->id.'/ver"><i class="fas fa-money-check-alt pr-2"></i> Ver Tarjeta de Costo</a>';
            }
            if($rdi && ($role_admin || $role_rdi)) {
            $eval_html .= '<a class="dropdown-item" href="/rdi/'.$rdi->id.'/ver"><i class="fas fa-money-check-alt pr-2"></i> Ver RDI</a>';
            }
            if($meval && ($role_admin || $role_eval)) {
            $eval_html .= '<a class="dropdown-item" href="/formatos/mechanical/'.$meval->id.'/ver"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>';
            }
            if($eeval && ($role_admin || $role_eval)) {
            $eval_html .= '<a class="dropdown-item" href="/formatos/electrical/'.$eeval->id.'/ver"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>';
            }
            $eval_html .= '</div></div>';
        }
        $status['eval'] = $eval_html;

        return $status;
    }

    public function list(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'client']);
        //Listar OTs
        $ordenes = Ot::select('ots.*')
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
        $totalOts = Ot::select('code')->orderBy('id', 'desc')->first();
        if (empty($totalOts->code) === false) {
            $ot_numero = $totalOts->code + 1;
        } else {
            $ot_numero = env('OT_CODE') + 1;
        }

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

        $totalOts = Ot::select('code')->orderBy('id', 'desc')->first();
        if (empty($totalOts->code) === false) {
            $ot_numero = $totalOts->code + 1;
        } else {
            $ot_numero = env('OT_CODE') + 1;
        }
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
        $ot->code = $ot_numero;
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
        
        $orden = Ot::where('ots.enabled', 1)
                    ->findOrFail($id);

        $ordenes = Ot::where('ots.id', '<>', $id)
                    ->where('ots.enabled', 1)
                    ->get();

        return view('procesovirtual.show', compact('orden', 'ordenes'));
    }

    public function ot_show(Request $request, $id)
    {
        //$request->user()->authorizeRoles(['superadmin', 'admin', 'evaluador', 'aprobador_de_evaluaciones', 'crear_ot', 'tarjeta_de_costo', 'cotizador_tarjeta_de_costo', 'aprobador_cotizacion_tarjeta_de_costo']);

        /*$validate_ot = Ot::where('ots.enabled', 1)->where('ots.id', $id)
                    ->join('clients', 'clients.id', '=', 'ots.client_id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('client_types.id')->firstOrFail();
                    dd($validate_ot);*/
            $ot = Ot::
                join('clients', 'clients.id', '=', 'ots.client_id')
                ->leftJoin('cost_cards', 'cost_cards.ot_id', '=', 'ots.id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'client_types.id as tipo_cliente_id', 'client_types.name as tipo_cliente', 'cost_cards.cotizacion')
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
        $ot->enabled = 0;
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

    public function closure_ot(Request $request)
    {
        $rules = array(
            'ot_id' => 'required|exists:ots,id',
            'accept' => 'required|in:0,1'
        );
        $this->validate($request, $rules);

        $ot_id = $request->get('ot_id');

        $status = Status::where('name', 'ot_closure')->first();
        if ($status) {
            $gallery = OtGallery::where('ot_id', $ot_id)
                    ->where('enabled', 1)
                    ->where('eval_type', '=', 'closure')->exists();
            if (!$gallery) {
                return redirect()->back()->withErrors(['No se registró ningún documento.']);
            }

            $st_exits = StatusOt::where('ot_id', '=', $ot_id)
                            ->where('status_id', '=', $status->id)
                            ->exists();
            if (!$st_exits) {
                $status_ot = new StatusOt();
                $status_ot->status_id = $status->id;
                $status_ot->ot_id = $ot_id;
                $status_ot->save();
            }
            activitylog('ot_ot_closure', 'store', null, $status_ot->toArray());
        }

        return redirect()->back();
    }

    public function galleryStore(Request $request)
    {
        $rules = array(
            'file' => 'mimes:jpeg,jpg,png,gif,pdf|required|max:10000', // max 10000kb
            'ot_id' => 'sometimes|exists:ots,id',
        );
        $this->validate($request, $rules);

        $image = $request->file('file');
        $eval_type = $request->input('eval_type');
        $ot_id = $request->input('ot_id');

        $avatarName = $image->getClientOriginalName();
        $ext = $image->getClientOriginalExtension();
        $url = 'uploads/ots/'.$ot_id.'/'.$eval_type;
        //$image->move(public_path($url), $avatarName);

        if (DIRECTORY_SEPARATOR === '/') {
            $dir = env('FILES_PATH') ? env('FILES_PATH').$url : public_path($url);
            // unix, linux, mac
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $image->move($dir, $avatarName);
        } else {
            $image->move(public_path($url), $avatarName);
        }
        
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
        if($eval_type == 'closure') {
            $imageUpload = new OtGallery();
            $imageUpload->name = $avatarName;
            $imageUpload->ot_id = $ot_id;
            $imageUpload->eval_type = $eval_type;
            $imageUpload->save();

            $status = Status::where('name', 'pending_closure')->first();
            if ($status) {
                $st_exits = StatusOt::where('ot_id', '=', $ot_id)
                            ->where('status_id', '=', $status->id)
                            ->exists();
                if (!$st_exits) {
                    $status_ot = new StatusOt();
                    $status_ot->status_id = $status->id;
                    $status_ot->ot_id = $ot_id;
                    $status_ot->save();

                    activitylog('ot_pending_closure', 'store', null, $status_ot->toArray());
                }
            }
        }
        return response()->json(['name'=>$avatarName, 'url' => $url .'/'.$avatarName, 'success'=>true]);
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
