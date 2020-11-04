<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
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
        
        $clientes = Client::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        return view('clientes.create');
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
            'correo' => 'required|email|unique:clients',
        ];

        $messages = [
            'ruc.required' => 'Agrega el número del cliente.',
        ];

        $this->validate($request, $rules);

        //creamos una variable que es un objeto de nuesta instancia de nuestro modelo
        $cliente = new Client();
        
        $cliente->ruc = $request->input('ruc');
        $cliente->razon_social = $request->input('razon_social');
        $cliente->direccion = $request->input('direccion');
        $cliente->telefono = $request->input('telefono');
        $cliente->celular = $request->input('celular');
        $cliente->contacto = $request->input('contacto');
        $cliente->telefono_contacto = $request->input('telefono_contacto');
        $cliente->correo = $request->input('correo');
        $cliente->info = $request->input('info');
        $cliente->enabled = $request->input('enabled');

        $cliente->save();

        //Agregamos cliente como usuario
        $role_user = Role::where('name', 'client')->first();
        if ($role_user) {
            $user = new User();
            $user->email = $cliente->correo;
            $user->password = bcrypt('123456');
            $user->status = 1;
            $user->save();

            //vamos a relacionar roles con usuarios
            $user->roles()->attach($role_user);
        }

        activitylog('ots', 'store', null, $cliente->toArray());


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
        //$cliente = Client::findOrFail($id);
        return Client::findOrFail($id);

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

        $cliente = Client::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
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
            'enabled' => 'boolean',
            'correo' => 'required|email|unique:clients,correo,'.$id,
        );
        $validator = \Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('clientes/' . $id . '/editar')
                ->withErrors($validator);
        } else {
            // store
            $client = Client::find($id);
            $original_data = $client->toArray();
        
            $client->ruc = $request->input('ruc');
            $client->razon_social = $request->input('razon_social');
            $client->direccion = $request->input('direccion');
            $client->telefono = $request->input('telefono');
            $client->celular = $request->input('celular');
            $client->contacto = $request->input('contacto');
            $client->telefono_contacto = $request->input('telefono_contacto');
            $client->correo = $request->input('correo');
            $client->info = $request->input('info');
            $client->enabled = $request->input('enabled');
            $client->save();

            activitylog('clients', 'update', $original_data, $client->toArray());

            // redirect
            \Session::flash('message', 'Successfully updated model!');
            return redirect('clientes');
        }
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
