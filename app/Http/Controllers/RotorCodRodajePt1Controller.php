<?php

namespace App\Http\Controllers;

use App\Models\RotorCodRodajePt1;
use Illuminate\Http\Request;

class RotorCodRodajePt1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        //$codes = RotorCodRodajePt1::where('enabled', 1)->get();
        return view('rotorcoderpt.1.index'
            //, compact('codes')
        );
    }

    public function list(Request $request)
    {
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

        $totalRecords = RotorCodRodajePt1::select('count(*) as allcount')
                ->where('enabled', 1)->count();
        $totalRecordswithFilter = RotorCodRodajePt1::select('count(*) as allcount')
                ->where(function($query) use ($searchValue) {
                    $query->where('asiento_rodaje', 'like', '%'.$searchValue.'%')
                    ->orWhere('alojamiento_rodaje', 'like', '%'.$searchValue.'%')
                        ;
                })
                ->where('enabled', 1)
                ->count();

        $records = RotorCodRodajePt1::select('*')
                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('asiento_rodaje', 'like', '%'.$searchValue.'%')
                        ->orWhere('alojamiento_rodaje', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)

                    ->where('enabled', 1)->get();

        $items_array = [];

        foreach ($records as $key => $item) {
            $status = $item->enabled == 1 ? '<span class="badge badge-success py-2 px-3">Activo</span>' : '<span class="badge badge-danger py-2 px-3">Inactivo</span>';
            $tools = '<a href="/rotorcoderodajept/1/'.$item->id.'/editar" class="btn btn-warning"><i class="fal fa-edit"></i></a>';

            $items_array[] = array(
              "id" => $item->id,
              "asiento_rodaje" => $item->asiento_rodaje,
              "alojamiento_rodaje" => $item->alojamiento_rodaje,
              "enabled" => $status,
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
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        return view('rotorcoderpt.1.create');
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

        $rules = [
            'name' => 'required',
            'asiento_rodaje' => 'string|required',
            'alojamiento_rodaje' => 'string|required',
            'enabled' => 'boolean',
        ];

        $this->validate($request, $rules);

        //creamos una variable que es un objeto de nuesta instancia de nuestro modelo
        $rotor_cod = new RotorCodRodajePt1();
        
        $rotor_cod->name = $request->input('name');
        $rotor_cod->asiento_rodaje = $request->input('asiento_rodaje');
        $rotor_cod->alojamiento_rodaje = $request->input('alojamiento_rodaje');
        $rotor_cod->enabled = $request->input('enabled');

        $rotor_cod->save();

        activitylog('rotorcoderpt1', 'store', null, $rotor_cod->toArray());

        return redirect('rotorcoderpt1');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $code
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $cods = RotorCodRodajePt1::where('enabled', 1)->findOrFail($id);
        return $cods;

        //return view('codees.show', compact('codee'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $code
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $code = RotorCodRodajePt1::where('enabled', 1)->findOrFail($id);
        return view('rotorcoderpt.1.edit', compact('code'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rules = array(
            'name' => 'required',
            'asiento_rodaje' => 'string|required',
            'alojamiento_rodaje' => 'string|required',
            'enabled' => 'boolean',
        );
        $this->validate($request, $rules);

        // update
        $rotor_cod = RotorCodRodajePt1::find($id);
        $original_data = $rotor_cod->toArray();
        
        $rotor_cod->name = $request->input('name');
        $rotor_cod->asiento_rodaje = $request->input('asiento_rodaje');
        $rotor_cod->alojamiento_rodaje = $request->input('alojamiento_rodaje');
        $rotor_cod->enabled = $request->input('enabled');

        $rotor_cod->save();

        activitylog('rotorcoderpt1', 'update', $original_data, $rotor_cod->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated model!');
        return redirect('rotorcoderodajept/1');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Client $code)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
