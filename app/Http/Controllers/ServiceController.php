<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        /*$services = Service::join('areas', 'areas.id', '=', 'services.area_id')
                    ->select('services.*', 'areas.name as area')->get();*/
        return view('servicios.index'
            /*, compact('services')*/
        );
    }

    public function services_list(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
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

        $totalRecords = Service::join('areas', 'areas.id', '=', 'services.area_id')
            ->select('services.*', 'areas.name as area')->get()->count();
        $totalRecordswithFilter = Service::join('areas', 'areas.id', '=', 'services.area_id')
            ->where(function($query) use ($searchValue) {
                $query->where('services.name', 'like', '%'.$searchValue.'%')
                    ->orWhere('areas.name', 'like', '%'.$searchValue.'%');
            })
            ->select('services.*', 'areas.name as area')->get();

        $records = Service::join('areas', 'areas.id', '=', 'services.area_id')
            ->skip($start)
            ->take($rowperpage)
            ->where(function($query) use ($searchValue) {
                $query->where('services.name', 'like', '%'.$searchValue.'%')
                    ->orWhere('areas.name', 'like', '%'.$searchValue.'%');
            })
            ->orderBy($columnName, $columnSortOrder)
            ->select('services.*', 'areas.name as area')
            ->get();

        $items_array = [];

        foreach ($records as $key => $item) {
            $status = $item->enabled == 1 ? '<span class="badge badge-success px-3 py-1">Activo</span>' : '<span class="badge badge-secondary px-3 py-1">Inactivo</span>';

            $tools = '<a href="/servicios/'.$item->id.'/editar" class="btn btn-warning"><i class="fal fa-edit"></i></a> '. ($item->enabled == 1 ? '<button class="btn btn-danger btn-changestatus" data-toggle="modal" data-target="#modalServices" data-status="0" type="button" data-id="'.$item->id.'"><i class="fal fa-minus-circle"></i></button>' : '<button class="btn btn-primary btn-changestatus" data-toggle="modal" data-target="#modalServices" data-status="1" type="button" data-id="'.$item->id.'"><i class="fal fa-trash-restore"></i></button>');

            $items_array[] = array(
              "id" => $item->id,
              "name" => $item->name,
              "area" => $item->area,
              "status" => $status,
              "tools" => $tools
            );
        };

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $items_array
        );

        echo json_encode($response);
        exit;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $areas = Area::where('enabled', 1)->where('has_services', 1)->get();
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        return view('servicios.create', compact('areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rules = array(
            'name'       => ['string', 'required', Rule::unique('services')
                                    ->where('name', $request->input('name'))
                                    ->where('area_id', $request->input('area_id'))],
            'area_id'      => 'integer|required',
            'enabled'      => 'boolean',
        );
        
        $this->validate($request, $rules);

        $service = new Service();
        
        $service->name = $request->input('name');
        $service->area_id = $request->input('area_id');
        $service->enabled = $request->has('enabled');

        $service->save();

        $ajax = $request->input('ajax');

        activitylog('services', 'store', null, $service->toArray());

        if ($ajax) {
            $services = Service::where('enabled', 1)
                        ->where('area_id', $service->area_id)
                        ->get();
            return $services;
        }
        $services = Service::where('enabled', 1)->get();
        return redirect('servicios')->with('services');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $service = Client::findOrFail($id);

        return view('servicios.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $areas = Area::where('enabled', 1)->where('has_services', 1)->get();
        $service = Service::findOrFail($id);
        return view('servicios.edit', compact('service', 'areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required|string|unique:services,name,'.$id,
            'area_id'      => 'integer|required',
            'enabled'      => 'boolean',
        );
        $this->validate($request, $rules);

        $service = Service::where('area_id', '<>', 1) // No area cliente
                    ->findOrFail($id);
        $original_data = $service->toArray();

        $service->name    = $request->get('name');
        $service->area_id = $request->get('area_id');
        $service->enabled = $request->get('enabled');
        $service->save();

        activitylog('services', 'update', $original_data, $service->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated service!');
        return redirect('servicios');
    }

    public function filterareas(Request $request)
    {
        //$request->user()->authorizeRoles(['superadmin', 'admin', 'supervisor', 'tarjeta_de_costo', 'evaluador', 'aprobador_de_evaluaciones']);

        $id = $request->input('id');
        $services = Service::where('area_id', $id)
                ->where('enabled', 1)
                ->select('services.id', 'services.name')
                ->get();
        if ($services) {
            return response()->json(['data'=>json_encode($services),'success'=>true]);
        }
        return response()->json(['success'=>false]);
    }

    public function changeStatus(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rules = array(
            'status'      => 'required|in:0,1',
        );
        $this->validate($request, $rules);

        $status = $request->input('status');

        $service = Service::findOrFail($id);
        $service->enabled = $status;
        $service->save();

        return response()->json(['success'=>true, 'data'=>json_encode($service)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $service = Service::findOrFail($id);
        $service->enabled = 0;
        $service->save();
    }
}
