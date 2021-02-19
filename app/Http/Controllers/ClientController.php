<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientType;
use App\Models\User;
use App\Models\UserData;
use App\Models\UserArea;
use App\Models\Role;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        return view('clientes.index');
    }

    public function list(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

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

        $totalRecords = Client::join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->select('clients.*', 'client_types.id as client_type_id', 'client_types.name as client_type')
                ->count();

        $totalRecordswithFilter = Client::select('count(*) as allcount')
                ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->where(function($query) use ($searchValue) {
                    $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                        ->orWhere('clients.ruc', 'like', '%'.$searchValue.'%')
                        ->orWhere('client_types.name', 'like', '%'.$searchValue.'%');
                })
                ->count();

        $records = Client::join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                ->select('clients.*', 'client_types.id as client_type_id', 'client_types.name as client_type')

                    ->skip($start)
                    ->take($rowperpage)
                    ->where(function($query) use ($searchValue) {
                        $query->where('clients.razon_social', 'like', '%'.$searchValue.'%')
                            ->orWhere('clients.ruc', 'like', '%'.$searchValue.'%')
                            ->orWhere('client_types.name', 'like', '%'.$searchValue.'%');
                    })
                    ->orderBy($columnName, $columnSortOrder)
                    ->get();

        $rows_array = [];

        foreach ($records as $key => $client) {
            if($client->client_type_id == 1) {
                $client_type = '<span class="badge badge-primary px-2 py-1 w-100">'.$client->client_type.'</span>';
            } else {
                $client_type = '<span class="badge badge-secondary px-2 py-1 w-100">'.$client->client_type.'</span>';
            }
            $enabled = ($client->enabled == 1 ? '<span class="badge badge-success d-block">Activo</span>' : '<span class="badge badge-secondary d-block">Inactivo</span>');
            $tools = '<a href="'.route('clientes.edit', $client).'" class="btn btn-warning"><i class="fal fa-edit"></i></a>
                        <a href="" class="btn btn-danger"><i class="fal fa-minus-circle"></i></a>';

            $rows_array[] = array(
              "id" => $client->id,
              "ruc" => $client->ruc,
              "razon_social" => $client->razon_social,
              "client_type" => $client_type,
              "celular" => $client->celular,
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
        $client_types = ClientType::where('enabled', 1)->get();

        return view('clientes.create', compact('client_types'));
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
            'ruc' => 'required|min:8|unique:clients',
            'razon_social' => 'required',
            'enabled' => 'boolean',
            'client_type_id' => 'integer|required',
            'email' => 'required|email|unique:clients|unique:users',
        ];

        $messages = [
            'ruc.required' => 'Agrega el número del cliente.',
        ];

        $this->validate($request, $rules);

        //creamos una variable que es un objeto de nuesta instancia de nuestro modelo
        $client = new Client();
        
        $client->ruc = $request->input('ruc');
        $client->razon_social = $request->input('razon_social');
        $client->direccion = $request->input('direccion');
        $client->telefono = $request->input('telefono');
        $client->celular = $request->input('celular');
        $client->contacto = $request->input('contacto');
        $client->telefono_contacto = $request->input('telefono_contacto');
        $client->email = $request->input('email');
        $client->info = $request->input('info');
        $client->client_type_id = $request->input('client_type_id');
        $client->enabled = $request->has('enabled');

        $client->save();

        //Agregamos client como usuario
        $role_user = Role::where('name', 'client')->first();
        if ($role_user) {
            $user = new User();
            $user->email = $client->email;
            $user->password = bcrypt('123456');
            $user->enabled = 1;
            $user->save();

            $user_data = new UserData();
            $user_data->user_id = $user->id;
            $user_data->name = $client->razon_social;
            $user_data->last_name = $client->razon_social;
            $user_data->mother_last_name = $client->razon_social;
            $user_data->user_phone = $client->celular;
            $user_data->area_id = 6; //Clientes
            $user_data->save();

            //vamos a relacionar roles con usuarios
            $user->roles()->attach($role_user);
        }

        activitylog('ots', 'store', null, $client->toArray());


        //$clientes = Client::all();
        return redirect('clientes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $cliente = Client::join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('clients.*', 'client_types.name')
                    ->where('clients.enabled', 1)
                    ->findOrFail($id);
        return $cliente;

        //return view('clientes.show', compact('cliente'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $client_types = ClientType::where('enabled', 1)->get();
        $cliente = Client::findOrFail($id);
        return view('clientes.edit', compact('cliente', 'client_types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $rules = array(
            'ruc' => 'required|min:8|unique:clients,ruc,'.$id,
            'razon_social' => 'required',
            'client_type_id' => 'integer|required',
            'enabled' => 'boolean',
            'correo' => 'required|email|unique:clients,email,'.$id,
        );
        $this->validate($request, $rules);

        // update
        $client = Client::find($id);
        $original_data = $client->toArray();
    
        $client->ruc = $request->input('ruc');
        $client->razon_social = $request->input('razon_social');
        $client->direccion = $request->input('direccion');
        $client->telefono = $request->input('telefono');
        $client->celular = $request->input('celular');
        $client->contacto = $request->input('contacto');
        $client->telefono_contacto = $request->input('telefono_contacto');
        $client->email = $request->input('correo');
        $client->info = $request->input('info');
        $client->client_type_id = $request->input('client_type_id');
        $client->enabled = $request->has('enabled');
        $client->save();

        activitylog('clients', 'update', $original_data, $client->toArray());

        // redirect
        \Session::flash('message', 'Successfully updated model!');
        return redirect('clientes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Client $client)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
