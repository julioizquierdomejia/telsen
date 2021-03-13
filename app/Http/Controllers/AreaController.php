<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Service;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        $areas = Area::all();
        return view('areas.index', compact('areas'));
    }

    public function list(Request $request)
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

        $totalRecords = Area::count();

        $totalRecordswithFilter = Area::select('count(*) as allcount')
                ->where(function($query) use ($searchValue) {
                    $query->where('name', 'like', '%'.$searchValue.'%');
                })
                ->count();

        $records = Area::skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('name', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)
                    ->get();

        $rows_array = [];

        foreach ($records as $key => $area) {
            $in_monitor = $area->in_monitor ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-secondary">No</span>';
            $enabled = $area->enabled ? '<span class="badge badge-success d-block">Activo</span>' : '<span class="badge badge-secondary d-block">Inactivo</span>';
            $tools = '<a href="'.route('areas.edit', $area) .'" class="btn btn-warning"><i class="fal fa-edit"></i></a>
                <a href="" class="btn btn-danger"><i class="fal fa-minus-circle"></i></a>';

            $rows_array[] = array(
              "id" => $area->id,
              "name" => $area->name,
              "in_monitor" => $in_monitor,
              "enabled" => $enabled,
              "tools" => $tools
            );
        };

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $rows_array
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
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        return view('areas.create');
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
            'name'       => 'string|required|unique:areas',
            'enabled'    => 'boolean',
            'in_monitor' => 'sometimes|boolean',
        );
        $this->validate($request, $rules);

        $area = new Area();
        
        $area->name = $request->input('name');
        $area->enabled = $request->has('enabled');

        $area->save();

        activitylog('areas', 'store', null, $area->toArray());

        $areas = Area::where('enabled', 1)->get();
        return redirect('areas')->with('areas');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $area = Area::findOrFail($id);

        return view('areas.show', compact('area'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        $areas = Area::where('enabled', 1)->get();
        $services = Service::where('enabled', 1)
                ->where('area_id', $id)
                ->get();
        $area = Area::findOrFail($id);
        return view('areas.edit', compact('area', 'areas', 'services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required|string|unique:areas,name,'.$id,
            'in_monitor' => 'sometimes|boolean',
            'enabled'    => 'boolean',
        );
        $this->validate($request, $rules);

        // update
        $area = Area::findOrFail($id);
        $original_data = $area->toArray();

        $area->name       = $request->get('name');
        $area->enabled    = $request->get('enabled');
        $area->save();

        activitylog('areas', 'update', $original_data, $area->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated area!');
        return redirect('areas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Area $area)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
