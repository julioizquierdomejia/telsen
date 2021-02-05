<?php

namespace App\Http\Controllers;

use App\Models\Workshop;
use App\Models\Ot;
use App\Models\Status;
use App\Models\Service;
use App\Models\Rdi;
use App\Models\RdiServiceCost;
//use App\Models\OtWorkReason;
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

    public function services_list_old(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'worker']);

        $work_reasons = WorkStatus::
                          where('code', '<>', 'start')
                        ->where('code', '<>', 'end')
                        ->where('code', '<>', 'continue')
                        ->where('code', '<>', 'restart')
                        ->where('code', '<>', 'approved')
                        ->where('code', '<>', 'disapproved')
                        ->get();
        $area_id = \Auth::user()->data->area->id;

        $roles = validateActionbyRole();
        //Cuando no hay usuarios de un area no se lista las tareas de dicha area
        if (in_array("superadmin", $roles) || in_array("admin", $roles)) {
            $services = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                ->join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select('ots.created_at', 'ot_works.comments', 'ot_works.id', 'areas.name as area', 'services.id as service_id' ,'services.name as service', 'ots.code', 'ots.id as ot_id', \DB::raw('CONCAT(ots.numero_potencia, " ",ots.medida_potencia) AS potencia'))
                ->get();
        } else {
            if (in_array("supervisor", $roles)) {
                $services = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                    ->join('services', 'services.id', '=', 'ot_works.service_id')
                    ->join('areas', 'areas.id', '=', 'services.area_id')
                    ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                    ->select('ots.created_at', 'ot_works.comments', 'ot_works.id', 'areas.name as area', 'services.id as service_id' ,'services.name as service', 'ots.code', 'ots.id as ot_id', \DB::raw('CONCAT(ots.numero_potencia, " ",ots.medida_potencia) AS potencia'))
                    ->where('user_data.area_id', $area_id)

                    ->whereDoesntHave('work_logs', function ($query) {
                        $query->where("work_logs.type", "=", 'end')
                        ->where("work_logs.type", "=", 'disapproved');
                    })

                    ->get();
            } else {
                $user_id = \Auth::id();

                $services = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                    ->join('services', 'services.id', '=', 'ot_works.service_id')
                    ->join('areas', 'areas.id', '=', 'services.area_id')
                    ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                    ->select('ots.created_at', 'ot_works.comments', 'ot_works.id', 'areas.name as area', 'services.id as service_id' ,'services.name as service', 'ots.code', 'ots.id as ot_id', \DB::raw('CONCAT(ots.numero_potencia, " ",ots.medida_potencia) AS potencia'))
                    ->where('workshops.user_id', $user_id)
                    //->where('user_data.area_id', $area_id)

                    /*
                    ->whereDoesntHave('ot_work_status', function ($query) {
                        $query->where("ot_work_status.work_status_id", "=", 1); //No mostrar los aprobados
                    })
                    ->whereHas('work_logs', function ($query) {
                        $query->where("work_logs.type", "=", 'restart');
                    })*/
                    ->whereDoesntHave('work_logs', function ($query) {
                        $query->where("work_logs.type", "=", 'end')
                        ->where("work_logs.type", "=", 'disapproved');
                    })

                    ->get();
            }
        }

        $ots = array_unique(array_column($services->toArray(), 'ot_id'));

        return view('talleres.servicesold', compact('services', 'work_reasons', 'roles', 'ots')
        );
    }

    public function tasks(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'worker']);

        $roles = validateActionbyRole();
        $single_role = count($roles) == 1;

        $work_reasons = WorkStatus::
                          where('code', '<>', 'start')
                        ->where('code', '<>', 'end')
                        ->where('code', '<>', 'continue')
                        ->where('code', '<>', 'restart')
                        ->where('code', '<>', 'approved')
                        ->where('code', '<>', 'disapproved')
                        ->get();
        $allowed_user = in_array('superadmin', $roles) || in_array('supervisor', $roles) && $single_role;

        return view('talleres.services', compact('work_reasons', 'roles', 'allowed_user'));
    }

    public function services_list(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'worker']);

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

        $area_id = \Auth::user()->data->area->id;
        $roles = validateActionbyRole();
        $single_role = count($roles) == 1;
        $allowed_user = in_array('superadmin', $roles) || in_array('supervisor', $roles) && $single_role;

        //Cuando no hay usuarios de un area no se lista las tareas de dicha area
        if (in_array("superadmin", $roles) || in_array("admin", $roles)) {
            $totalRecords = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                ->join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select('count(*) as allcount')
                ->count();

            $totalRecordswithFilter = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                ->join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select('count(*) as allcount')
                ->where(function($query) use ($searchValue) {
                    $query->where('numero_potencia', 'like', '%'.$searchValue.'%')
                        ->orWhere('services.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%')
                        ->orWhere('areas.name', 'like', '%'.$searchValue.'%');
                })
                ->count();

            $records = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                ->join('services', 'services.id', '=', 'ot_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                ->select('ots.created_at', 'ot_works.comments', 'ot_works.id', 'areas.name as area', 'services.id as service_id' ,'services.name as service', 'ots.code', 'ots.id as ot_id', \DB::raw('CONCAT(ots.numero_potencia, " ",ots.medida_potencia) AS potencia'))
                ->skip($start)
                ->take($rowperpage)
                ->where(function($query) use ($searchValue) {
                    $query->where('numero_potencia', 'like', '%'.$searchValue.'%')
                        ->orWhere('services.name', 'like', '%'.$searchValue.'%')
                        ->orWhere('ots.code', 'like', '%'.$searchValue.'%')
                        ->orWhere('areas.name', 'like', '%'.$searchValue.'%');
                })
                ->orderBy($columnName, $columnSortOrder)
                ->get();
        } else {
            if (in_array("supervisor", $roles)) {
                $totalRecords = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                    ->join('services', 'services.id', '=', 'ot_works.service_id')
                    ->join('areas', 'areas.id', '=', 'services.area_id')
                    ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                    ->select('count(*) as allcount')
                    ->where('user_data.area_id', $area_id)
                    ->count();

                $totalRecordswithFilter = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                    ->join('services', 'services.id', '=', 'ot_works.service_id')
                    ->join('areas', 'areas.id', '=', 'services.area_id')
                    ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                    ->select('count(*) as allcount')
                    ->where('user_data.area_id', $area_id)
                    ->where(function($query) use ($searchValue) {
                        $query->where('numero_potencia', 'like', '%'.$searchValue.'%')
                            ->orWhere('services.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%')
                            ->orWhere('areas.name', 'like', '%'.$searchValue.'%');
                    })
                    ->count();

                $records = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                    ->join('services', 'services.id', '=', 'ot_works.service_id')
                    ->join('areas', 'areas.id', '=', 'services.area_id')
                    ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                    ->select('ots.created_at', 'ot_works.comments', 'ot_works.id', 'areas.name as area', 'services.id as service_id' ,'services.name as service', 'ots.code', 'ots.id as ot_id', \DB::raw('CONCAT(ots.numero_potencia, " ",ots.medida_potencia) AS potencia'))
                    ->skip($start)
                    ->take($rowperpage)
                    ->where('user_data.area_id', $area_id)
                    ->where(function($query) use ($searchValue) {
                        $query->where('numero_potencia', 'like', '%'.$searchValue.'%')
                            ->orWhere('services.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%')
                            ->orWhere('areas.name', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)
                    ->get();
            } else {
                $user_id = \Auth::id();

                $totalRecords = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                    ->join('services', 'services.id', '=', 'ot_works.service_id')
                    ->join('areas', 'areas.id', '=', 'services.area_id')
                    ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                    ->select('count(*) as allcount')
                    ->where('workshops.user_id', $user_id)
                    ->count();

                $totalRecordswithFilter = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                    ->join('services', 'services.id', '=', 'ot_works.service_id')
                    ->join('areas', 'areas.id', '=', 'services.area_id')
                    ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                    ->select('count(*) as allcount')
                    ->where('workshops.user_id', $user_id)
                    ->where(function($query) use ($searchValue) {
                        $query->where('numero_potencia', 'like', '%'.$searchValue.'%')
                            ->orWhere('services.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%')
                            ->orWhere('areas.name', 'like', '%'.$searchValue.'%');
                    })
                    ->count();

                $records = OtWork::leftJoin('workshops', 'ot_works.id', '=', 'workshops.ot_work_id')
                    ->join('services', 'services.id', '=', 'ot_works.service_id')
                    ->join('areas', 'areas.id', '=', 'services.area_id')
                    ->leftJoin('user_data', 'user_data.user_id', '=', 'workshops.user_id')
                    ->join('ots', 'ots.id', '=', 'ot_works.ot_id')
                    ->select('ots.created_at', 'ot_works.comments', 'ot_works.id', 'areas.name as area', 'services.id as service_id' ,'services.name as service', 'ots.code', 'ots.id as ot_id', \DB::raw('CONCAT(ots.numero_potencia, " ",ots.medida_potencia) AS potencia'))
                    ->skip($start)
                    ->take($rowperpage)
                    ->where('workshops.user_id', $user_id)
                    ->where(function($query) use ($searchValue) {
                        $query->where('numero_potencia', 'like', '%'.$searchValue.'%')
                            ->orWhere('services.name', 'like', '%'.$searchValue.'%')
                            ->orWhere('ots.code', 'like', '%'.$searchValue.'%')
                            ->orWhere('areas.name', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)
                    ->get();
            }
        }

        //$ots = array_unique(array_column($services->toArray(), 'ot_id'));

        $records_array = [];
        foreach ($records as $key => $row) {
            $created_at = date('d-m-Y', strtotime($row->created_at));
            $row_code = 'OT-'.zerosatleft($row->code, 3);
            $potencia = $row->potencia;

            $logs = $row->work_logs;
            $wl_count = $logs->count();
            $status_code = $wl_count ? $logs->first()->status->code : null;
            $status = $wl_count ? $logs->first()->status->name : null;
            //$work_type = $wl_count ? $logs->first()->status->type : '';

            $html_tools = '<button class="btn btn-primary btn-sm btn-tasks" data-id="'.$row->id.'">Actividades <i class="far fa-tasks ml-2"></i></button>

                <div class="text-center row-details" data-id="'.$row->id.'" style="display: none;">
                    <div class="cell-details px-3" style="border-left: 10px solid #efefef;border-right: 10px solid #efefef;background-color: #f9f9f9;margin-top: -6px;">
                        <div class="t-details text-white px-2 py-3 mb-3 row">
                          <div class="history bg-dark py-3 col-12 col-md-8 col-xl-10">
                            <h5 class="h6 px-3">Historial</h5>
                            <ul class="works-list text-left list-inline mb-0 text-info" style="max-height: 160px;overflow-y: auto;">';
                                if ($wl_count) {
                                    foreach ($logs as $key => $worklog) {
                                    $html_tools .= '<li class="item"><span>'.($worklog->status->name ?? '-').'</span>
                                      <span> | '. date('d-m-Y h:i a', strtotime($worklog->created_at)) .'</span>
                                      <hr class="my-1" style="border-top-color: #444">
                                    </li>';
                                    }
                                } else {
                                    $html_tools .= '<li class="text-muted my-2">No hay historial aún</li>';
                                }
                            $html_tools .= '</ul>
                            <hr style="border-top-color: #2b2b2b">
                            <div class="history-footer">
                              <label class="text-white">Comentarios:</label>
                              <textarea class="form-control mt-0 comments" data-otwork="'.$row->id.'" name="comments">'.$row->comments.'</textarea>
                              <p class="mb-0 comments-msg text-success" style="display: none;"><span class="font-weight-light"><i class="fa fa-check"></i> Se guardó.</span></p>
                            </div>
                            <hr style="border-top-color: #2b2b2b">
                            <div class="additional">
                              <label class="text-white" data-toggle="collapse" data-target="#collapsetable'.$row->id.'">Información adicional:</label>
                              <div class="table-wrapper mb-3 collapse show">';
                                  $service = Service::where('id', $row->service_id)->first();
                                  $tables = $service->tables;
                                foreach ($tables as $table) {
                                    $html_tools .= '<form class="parent-table" id="parentTb'.$table->id.'" action="/worklog/update-data" method="POST">
                                    <div class="table-responsive" style="overflow-y:hidden">
                                    <table class="table text-white" id="infotable'.$table->id.'">';
                                        $cols_head_html = ''; $cols_html = '';
                                        $cols = $table->cols;
                                        $cols_count = $cols->count();
                                        $table_rows = $table->rows_quantity;
                                        $counter = -1;
                                        foreach ($cols as $col) {
                                            $cols_head_html .= '<th>'.$col->col_name.'</th>';
                                        }
                                        for ($i = 0; $i < $table_rows; $i++) {
                                            $cols_html .= '<tr>';
                                            foreach ($cols as $ckey => $col) {
                                                $data = $col->data->where('row', $i)->where('col_id', $col->id)->where('ot_work_id', $row->id)->first();
                                                $counter++;
                                                $cols_html .= '<td>
                                                <input class="form-control frm-col mt-0" type="text" hidden="" name="coldata['.$counter.'][id]" value="'.(isset($data->id) ? $data->id : '').'">
                                                <input class="form-control frm-col mt-0" type="text" hidden="" name="coldata['.$counter.'][work_add_info_id]" value="'.$col->work_add_info_id.'">
                                                <input class="form-control frm-col mt-0" type="text" hidden="" name="coldata['.$counter.'][row]" value="'.$i.'">
                                                <input class="form-control frm-col mt-0" type="text" hidden="" name="coldata['.$counter.'][col_id]" value="'.$col->id.'">
                                                <input class="form-control frm-col mt-0" type="text" hidden="" name="coldata['.$counter.'][ot_work_id]" value="'.$row->id.'">
                                                <input class="form-control frm-col mt-0" type="text" name="coldata['.$counter.'][content]" value="'.(isset($data->content) ? $data->content : '').'">
                                            </td>';
                                            }
                                            $cols_html .= '</tr>';
                                        }
                                        $html_tools .= '<thead>
                                      <tr style="background-color: #3d496f;"><th colspan="'.$cols_count.'">'.$table->name.'</th></tr>
                                      <tr style="background-color: #3d496f;">'.$cols_head_html.'</tr>
                                    </thead>
                                    <tbody>'. $cols_html .'</tbody>
                                    <tfoot>
                                      <tr>
                                        <td colspan="'.$cols_count.'"><p class="mb-0 coldata-msg text-success" style="display: none;"><span class="font-weight-light"><i class="fa fa-check"></i> Se guardó.</span></p></td>
                                      </tr>
                                    </tfoot>
                                  </table>
                                  </div>
                                </form>';
                                }
                            $html_tools .= '</div>
                            </div>
                            </div>
                            <div class="work-buttons py-3 col-12 col-md-4 col-xl-2 text-dark">';
                            if ($wl_count == 0) {
                                $html_tools .= '<button class="btn btn-success my-1 btn-action" data-type="start" data-work_id="'.$row->id.'" type="button" data-toggle="modal" data-target="#modalReason">Empezar <i class="far fa-play ml-2"></i></button>';
                            } else {
                                if($status_code == 'start' || $status_code == 'continue' || $status_code == 'restart') {
                                    $html_tools .= '<button class="btn btn-pause btn-warning my-1 btn-action" data-type="pause" data-work_id="'.$row->id.'" type="button" data-toggle="modal" data-target="#modalReason">Pausar <i class="far fa-pause ml-2"></i></button>
                                    <button class="btn btn-danger my-1 btn-action" data-type="end" data-work_id="'.$row->id.'" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>';
                                } elseif($status_code == 'pause') {
                                    $html_tools .= '<button class="btn btn-primary my-1 btn-action" data-type="continue" data-work_id="'.$row->id.'" type="button" data-toggle="modal" data-target="#modalReason">Continuar <i class="far fa-play ml-2"></i></button>
                                    <button class="btn btn-danger my-1 btn-action" data-type="end" data-work_id="'.$row->id.'" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>';
                                } elseif($status_code == 'end') {
                                    if ($allowed_user) {
                                        $html_tools .= '<button class="btn btn-action btn-primary my-1" data-work_id="'.$row->id.'" type="button" data-toggle="modal" data-target="#modalApprove">Aprobar <i class="far fa-check ml-2"></i></button>';
                                    } else {
                                        $html_tools .= '<span class="badge badge-light d-block py-1 my-1">En proceso.</span>';
                                    }
                                } elseif($status_code == 'approved' || $status_code == 'disapproved') {
                                    if ($status_code == 'approved') {
                                        $html_tools .= '<span class="badge badge-success d-block py-1 my-1">Aprobada</span>';
                                    } elseif($status_code == 'disapproved') {
                                        $html_tools .= '<span class="badge badge-secondary d-block py-1 my-1">Desaprobada</span>
                                        <button class="btn btn-danger my-1 btn-action" data-type="restart" data-work_id="'.$row->id.'" type="button" data-toggle="modal" data-target="#modalReason">Reiniciar <i class="far fa-play ml-2"></i></button>';
                                    }
                                    $html_tools .= 'Finalizó la tarea.';
                                }
                            }
                            $html_tools .= '</div>
                        </div>
                      </div>
                  </div>
              ';

            $records_array[] = array(
                "created_at" => $created_at,
                "id" => $row_code,
                "numero_potencia" => $potencia ? $potencia : '-',
                "area" => $row->area,
                "service" => $row->service,
                "status" => $wl_count ? '<span class="badge badge-info d-block py-1">'.$status.'</span>' : '-',
                "tools" => $html_tools
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $records_array
        );

        echo json_encode($response);
        exit;
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

        $roles = validateActionbyRole();

        $ot = Ot::join('clients', 'clients.id', '=', 'ots.client_id')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->join('electrical_evaluations', 'electrical_evaluations.ot_id', '=', 'ots.id')
                ->join('mechanical_evaluations', 'mechanical_evaluations.ot_id', '=', 'ots.id')
                ->select('ots.*', 'clients.razon_social', 'clients.ruc', 'electrical_evaluations.nro_equipo', 'electrical_evaluations.frecuencia', 'electrical_evaluations.conex', 'electrical_evaluations.frame', 'electrical_evaluations.amperaje', 'mechanical_evaluations.hp_kw', 'mechanical_evaluations.serie', 'mechanical_evaluations.rpm', 'mechanical_evaluations.placa_caract_orig',
                    'clients.client_type_id'
                )
                ->where('ots.enabled', 1)
                ->where('ots.id', $id)
                ->whereDoesntHave('statuses', function ($query) {
                    $query->where("status.name", "=", 'ot_closure');
                })
                ->firstOrFail();

        $users = User::join('user_data', 'user_data.user_id', 'users.id')
                ->join('areas', 'areas.id', 'user_data.area_id')
                ->select('users.id', 'user_data.name', 'user_data.last_name', 'user_data.mother_last_name', 'user_data.area_id','areas.name as area')
                ->where('users.enabled', 1)
                ->get()
                ;

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

        if (in_array('superadmin', $roles) || in_array('admin', $roles)) {
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
        } else {
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
                ->where('services.area_id', $user_area_id)
                ->get();
        }

        $services = [];
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
                ->join('clients', 'clients.id', '=', 'ots.client_id')
                ->select('cost_cards.*', 'ots.id as ot_code', 'clients.razon_social', 'ots.fecha_entrega')
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
            'status_id'      => 'required|exists:work_status,code',
            'work_id'      => 'required|integer|exists:ot_works,id',
        );
        $this->validate($request, $rules);

        $status_code = $request->input('status_id');
        $work_id = $request->input('work_id');

        $status = WorkStatus::where('code', $status_code)->first();
        $work_log_approved = WorkLog::where('work_id', $work_id)
                    ->orderBy('id', 'desc')
                    ->where('type', 'approved')
                    ->first();
        //Si esta aprobada la tarea ya no cambia de estado
        if ($work_log_approved == null) {
            $work_log = new WorkLog();
            $work_log->work_id = $work_id;
            $work_log->user_id = \Auth::id();
            //$work_log->type = $status_code;
            $work_log->status_id = $status->id;
            $work_log->save();

            if ($status_code == 'approved') {
                $ot_work = OtWork::find($work_id);
                $ot_work->approved = 1;
                $ot_work->save();
            }

            return response()->json(['data'=>json_encode($work_log), 'success'=>true]);
        }

        return response()->json(['data'=>[], 'success'=>false]);
    }
}
