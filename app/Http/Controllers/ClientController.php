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
    public function index()
    {
        //
        $clientes = Client::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
        $rules = [
            'ruc' => 'required|min:8|unique:clients',
            'razon_social' => 'required',
        ];

        $messages = [
            'ruc.required' => 'Agrega el nombre del estudiante.',
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


        $clientes = Client::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function edit($id)
    {
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
    public function update(Request $request, Client $client)
    {
        $data = [];
        $data['ruc'] = $request->get('ruc');
        $data['razon_social'] = $request->get('razon_social');
        $data['direccion'] = $request->get('direccion');
        $data['telefono'] = $request->get('telefono');
        $data['celular'] = $request->get('celular');
        $data['contacto'] = $request->get('contacto');
        $data['telefono_contacto'] = $request->get('telefono_contacto');
        $data['correo'] = $request->get('correo');
        $data['info'] = $request->get('info');

        $client->update($data);

        return redirect('clientes');

        

        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
