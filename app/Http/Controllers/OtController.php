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

        $ots_array = [];

        $ots = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->where('ots.enabled', 1)->get();

        foreach ($ots as $key => $ot) {
            $ot_status = \DB::table('status_ot')
                  ->join('status', 'status_ot.status_id', '=', 'status.id')
                  ->where('status_ot.ot_id', '=', $ot->id)
                  ->select('status_ot.status_id', 'status.id', 'status.name')
                  ->get();
            $ot_status_arr = array_column($ot_status->toArray(), "status_id");
            if (!in_array(7, $ot_status_arr) && !in_array(10, $ot_status_arr)) {
                $ots_array[] = $ot;
            }
        }

        if ($ots_array) {
            return response()->json(['data'=>json_encode($ots_array), 'success'=>true]);
        }
        return response()->json(['data'=>[], 'success'=>false]);
    }

    public function disapproved_ots(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception', 'worker']);

        $ots_array = [];

        $ots = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->where('ots.enabled', 1)->get();

        foreach ($ots as $key => $ot) {
            $ot_status = \DB::table('status_ot')
                  ->join('status', 'status_ot.status_id', '=', 'status.id')
                  ->where('status_ot.ot_id', '=', $ot->id)
                  ->select('status_ot.status_id', 'status.id', 'status.name')
                  ->get();
            $ot_status_arr = array_column($ot_status->toArray(), "status_id");
            if (in_array(7, $ot_status_arr) || in_array(10, $ot_status_arr)) {
                $ots_array[] = $ot;
            }
        }

        if ($ots_array) {
            return response()->json(['data'=>json_encode($ots_array), 'success'=>true]);
        }
        return response()->json(['data'=>[], 'success'=>false]);
    }

    public function disabled_ots(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception', 'worker']);

        $ots = Ot::join('clients', 'ots.client_id', '=', 'clients.id')
                    ->join('client_types', 'client_types.id', '=', 'clients.client_type_id')
                    ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'client_types.name as client_type')
                    ->where('ots.enabled', 2)->get();

        return response()->json(['data'=>json_encode($ots), 'success'=>true]);
    }

    public function getOTStatus(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'reception', 'worker']);

        $ot_status = \DB::table('status_ot')
                  ->join('status', 'status_ot.status_id', '=', 'status.id')
                  ->where('status_ot.ot_id', '=', $id)
                  ->select('status_ot.status_id', 'status.id', 'status.name')
                  //->latest('status_ot.id')
                  //->first();
                  ->get();

        $rdi = Rdi::where('enabled', 1)
                ->where('ot_id', $id)
                ->select('id as rdi_id')
                ->first();

        $meval = MechanicalEvaluation::where('ot_id', $id)
                ->select('mechanical_evaluations.id as meval_id')
                ->first();

        $eeval = ElectricalEvaluation::where('ot_id', $id)
                ->select('electrical_evaluations.id as eeval_id')
                ->first();

        $cost_card = CostCard::where('ot_id', $id)
                ->select('cost_cards.id as cc_id')
                ->first();

        /*$work_shop = WorkShop::where('ot_id', $id)
                ->select('id as ws_id')
                ->first();*/

        return response()->json([
            'status' => json_encode($ot_status),
            'rdi' => json_encode($rdi),
            'meval' => json_encode($meval),
            'eeval' => json_encode($eeval),
            'cost_card' => json_encode($cost_card),
            //'work_shop' => json_encode($work_shop),
            'success' => true
        ]);
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
