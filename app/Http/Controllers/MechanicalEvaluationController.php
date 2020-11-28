<?php

namespace App\Http\Controllers;

use App\Models\MechanicalEvaluation;
use App\Models\MechanicalEvaluationWork;
use App\Models\OtGallery;
use App\Models\RotorCodRodajePt1;
use App\Models\RotorCodRodajePt2;
use App\Models\Ot;
use App\Models\Status;
use App\Models\Area;
use Illuminate\Http\Request;

class MechanicalEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'mechanical']);

        //$ots = Ot::join('status_ot', 'status_ot.ot_id', '=', 'status_ot.ot_id')
        $_ots = Ot::join('clients', 'clients.id', '=', 'ots.client_id')
                        ->select('ots.*', 'clients.razon_social')
                        ->where('ots.enabled', 1)
                        ->where('clients.enabled', 1)
                        //->where('status_ot.status_id', 1)
                        ->groupBy('ots.id')
                        ->get();

        $ots = [];
        foreach ($_ots as $key => $ot) {
            $ot_status = \DB::table('status_ot')->where('status_ot.ot_id', '=', $ot->id)->get();
            $array = [];
            foreach ($ot_status as $key => $status) {
                $array[] = $status->status_id;
            }
            if (!in_array(2, $array)) {
                $ots[] = $ot;
            }
        }
        return view('formatos.mechanical.index', compact('ots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function evaluate(Request $request, $ot_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'mechanical']);
        $formato = MechanicalEvaluation::where('mechanical_evaluations.ot_id', $ot_id)->first();
        if ($formato) {
            return redirect('formatos/mechanical/'.$formato->id.'ver');
        }
        $cod_rodaje_p1 = RotorCodRodajePt1::where('enabled', 1)->get();
        $cod_rodaje_p2 = RotorCodRodajePt2::where('enabled', 1)->get();
        $ot = Ot::where('ots.id', $ot_id)
            ->leftJoin('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
            ->join('clients', 'ots.client_id', '=', 'clients.id')
            ->select('ots.*', 'clients.razon_social', 'clients.client_type_id', 'motor_brands.name as marca')
            ->firstOrFail();
        if ($ot->client_type_id == 1) { //RDI
            $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '=', 5)->get();
        } else {
            $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '<>', 5)->get();
        }

        return view('formatos.mechanical.evaluate', compact('ot', 'areas', 'cod_rodaje_p1', 'cod_rodaje_p2'));
    }

    public function approve(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $action = $request->input('action');
        $eval = MechanicalEvaluation::findOrFail($id);
        $original_data = $eval->toArray();

        if ($action == 1) {
            $eval->approved = 1;
        } else /*if($action == 2)*/ {
            $eval->approved = 2;
        }
        $eval->save();

        activitylog('mechanical_evaluations_approve', 'update', $original_data, $eval->toArray());

        return response()->json(['data'=>json_encode($eval),'success'=>true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $ot_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'mechanical']);
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            //'ot_id' => 'required',

            'rpm' => 'required',
            'hp_kw' => 'required',

            'serie' => 'string|nullable',
            'maquina' => 'string|nullable',
            'placa_caract_orig' => 'string|nullable',
            'tapas' => 'string|nullable',
            'ventilador' => 'string|nullable',
            'caja_conexion' => 'string|nullable',
            'ejes' => 'string|nullable',
            'acople' => 'string|nullable',
            'bornera' => 'string|nullable',
            'fundas' => 'string|nullable',
            'chaveta' => 'string|nullable',
            'impro_seal' => 'string|nullable',
            'laberintos' => 'string|nullable',
            'estator' => 'string|nullable',
            //Sí/no
            'placa_caract_orig_has' => 'boolean|nullable',
            'tapas_has' => 'boolean|nullable',
            'ventilador_has' => 'boolean|nullable',
            'caja_conexion_has' => 'boolean|nullable',
            'ejes_has' => 'boolean|nullable',
            'acople_has' => 'boolean|nullable',
            'bornera_has' => 'boolean|nullable',
            'fundas_has' => 'boolean|nullable',
            'chaveta_has' => 'boolean|nullable',
            'impro_seal_has' => 'boolean|nullable',
            'laberintos_has' => 'boolean|nullable',
            'estator_has' => 'boolean|nullable',
            //
            'otros' => 'string|nullable',

            'slam_muelle_p1' => 'string|nullable',
            'slam_muelle_p2' => 'string|nullable',
            'resortes_contra_tapas' => 'string|nullable',
            'alineamiento_paquete' => 'string|nullable',

            'rotor_deplexion_eje' => 'string|nullable',
            'rotor_valor_balanceo' => 'string|nullable',
            'rotor_cod_rodaje_p1' => 'string|nullable',
            'rotor_cod_rodaje_p2' => 'string|nullable',
            'rotor_asiento_rodaje_p1' => 'string|nullable',
            'rotor_asiento_rodaje_p2' => 'string|nullable',
            'rotor_eje_zona_acople_p1' => 'string|nullable',
            'rotor_eje_zona_acople_p2' => 'string|nullable',
            'rotor_medida_chaveta_p1' => 'string|nullable',
            'rotor_medida_chaveta_p2' => 'string|nullable',
            'rotor_canal_chaveta_p1' => 'string|nullable',
            'rotor_canal_chaveta_p2' => 'string|nullable',

            'estator_alojamiento_rodaje_tapa_p10' => 'string|nullable',
            'estator_alojamiento_rodaje_tapa_p20' => 'string|nullable',
            'estator_pestana_tapa_p1' => 'string|nullable',
            'estator_pestana_tapa_p2' => 'string|nullable',

            'estator_contra_tapa_interna_p1' => 'string|nullable',
            'estator_contra_tapa_interna_p2' => 'string|nullable',
            'estator_contra_tapa_externa_p1' => 'string|nullable',
            'estator_contra_tapa_externa_p2' => 'string|nullable',
            'estator_ventilador_0' => 'string|nullable',
            'estator_alabes' => 'string|nullable',
            'estator_caja_conexion' => 'string|nullable',
            'estator_tapa_conexion' => 'string|nullable',

            'observaciones' => 'string|nullable',

            'works' => 'array|nullable',

            'files.*' => 'mimes:jpeg,jpg,png,gif|nullable'
        );

        $validator = $this->validate($request, $rules);

        // store
        $meval = new MechanicalEvaluation();

        //$meval->ot_id = $request->input('ot_id');
        $meval->ot_id = $ot_id;

        $meval->rpm = $request->input('rpm');
        $meval->hp_kw = $request->input('hp_kw');

        $meval->serie = $request->input('serie');
        $meval->maquina = $request->input('maquina');
        $meval->placa_caract_orig = $request->input('placa_caract_orig');
        $meval->tapas = $request->input('tapas');
        $meval->ventilador = $request->input('ventilador');
        $meval->caja_conexion = $request->input('caja_conexion');
        $meval->ejes = $request->input('ejes');
        $meval->acople = $request->input('acople');
        $meval->bornera = $request->input('bornera');
        $meval->fundas = $request->input('fundas');
        $meval->chaveta = $request->input('chaveta');
        $meval->impro_seal = $request->input('impro_seal');
        $meval->laberintos = $request->input('laberintos');
        $meval->estator = $request->input('estator');
        //
        $meval->placa_caract_orig_has = $request->input('placa_caract_orig_has') ?? 0;
        $meval->tapas_has = $request->input('tapas_has') ?? 0;
        $meval->ventilador_has = $request->input('ventilador_has') ?? 0;
        $meval->caja_conexion_has = $request->input('caja_conexion_has') ?? 0;
        $meval->ejes_has = $request->input('ejes_has') ?? 0;
        $meval->acople_has = $request->input('acople_has') ?? 0;
        $meval->bornera_has = $request->input('bornera_has') ?? 0;
        $meval->fundas_has = $request->input('fundas_has') ?? 0;
        $meval->chaveta_has = $request->input('chaveta_has') ?? 0;
        $meval->impro_seal_has = $request->input('impro_seal_has') ?? 0;
        $meval->laberintos_has = $request->input('laberintos_has') ?? 0;
        $meval->estator_has = $request->input('estator_has') ?? 0;
        //

        $meval->otros = $request->input('otros');
        $meval->slam_muelle_p1 = $request->input('slam_muelle_p1');
        $meval->slam_muelle_p2 = $request->input('slam_muelle_p2');
        $meval->resortes_contra_tapas = $request->input('resortes_contra_tapas');
        $meval->alineamiento_paquete = $request->input('alineamiento_paquete');

        $meval->rotor_deplexion_eje = $request->input('rotor_deplexion_eje');
        $meval->rotor_valor_balanceo = $request->input('rotor_valor_balanceo');
        $meval->rotor_cod_rodaje_p1 = $request->input('rotor_cod_rodaje_p1');
        $meval->rotor_cod_rodaje_p2 = $request->input('rotor_cod_rodaje_p2');
        $meval->rotor_asiento_rodaje_p1 = $request->input('rotor_asiento_rodaje_p1');
        $meval->rotor_asiento_rodaje_p2 = $request->input('rotor_asiento_rodaje_p2');
        $meval->rotor_eje_zona_acople_p1 = $request->input('rotor_eje_zona_acople_p1');
        $meval->rotor_eje_zona_acople_p2 = $request->input('rotor_eje_zona_acople_p2');
        $meval->rotor_medida_chaveta_p1 = $request->input('rotor_medida_chaveta_p1');
        $meval->rotor_medida_chaveta_p2 = $request->input('rotor_medida_chaveta_p2');
        $meval->rotor_canal_chaveta_p1 = $request->input('rotor_canal_chaveta_p1');
        $meval->rotor_canal_chaveta_p2 = $request->input('rotor_canal_chaveta_p2');

        $meval->estator_alojamiento_rodaje_tapa_p10 = $request->input('estator_alojamiento_rodaje_tapa_p10');
        $meval->estator_alojamiento_rodaje_tapa_p20 = $request->input('estator_alojamiento_rodaje_tapa_p20');
        $meval->estator_pestana_tapa_p1 = $request->input('estator_pestana_tapa_p1');
        $meval->estator_pestana_tapa_p2 = $request->input('estator_pestana_tapa_p2');

        $meval->estator_contra_tapa_interna_p1 = $request->input('estator_contra_tapa_interna_p1');
        $meval->estator_contra_tapa_interna_p2 = $request->input('estator_contra_tapa_interna_p2');
        $meval->estator_contra_tapa_externa_p1 = $request->input('estator_contra_tapa_externa_p1');
        $meval->estator_contra_tapa_externa_p2 = $request->input('estator_contra_tapa_externa_p2');
        $meval->estator_ventilador_0 = $request->input('estator_ventilador_0');
        $meval->estator_alabes = $request->input('estator_alabes');
        $meval->estator_caja_conexion = $request->input('estator_caja_conexion');
        $meval->estator_tapa_conexion = $request->input('estator_tapa_conexion');

        $meval->observaciones = $request->input('observaciones');

        $meval->save();

        //$meval->works = $request->input('works');
        $works = $request->input('works');
        $services = [];
        $date = \Carbon\Carbon::now()->toDateTimeString();
        foreach ($works as $key => $item) {
            if (isset($item['service_id'])) {
                $services[$key]['me_id'] = $meval->id;
                $services[$key]['service_id'] = isset($item['service_id']) ? $item['service_id'] : '';
                $services[$key]['description'] = isset($item['description']) ? $item['description'] : '';
                $services[$key]['medidas'] = isset($item['medidas']) ? $item['medidas'] : '';
                $services[$key]['qty'] = isset($item['qty']) ? $item['qty'] : '';
                $services[$key]['personal'] = isset($item['personal']) ? $item['personal'] : '';

                $services[$key]['created_at'] = $date;
                $services[$key]['updated_at'] = $date;

                MechanicalEvaluationWork::insert($services);
            }
        }

        $status = Status::where('id', 2)->first();
        if ($status) {
            \DB::table('status_ot')->insert([
                'status_id' => $status->id,
                'ot_id' => $ot_id,
            ]);
        }

        /*if ($request->file('files')) {
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $ext = $file->getClientOriginalExtension();
                $uniqueFileName = preg_replace('/\s+/', "-", str_replace(".".$ext, "", $file->getClientOriginalName()) .uniqid()) . ".".$ext;

                $image = new MechanicalGallery();
                $image->me_id = $meval->id;
                $image->name = $uniqueFileName;
                $image->save();

                $file->move(public_path("uploads/mechanical/$id"), $uniqueFileName);
            }
        }*/
        $files = json_decode($request->input('files'), true);
        foreach ($files as $key => $file) {
            $uniqueFileName = $file['name'];
            $imageUpload = new OtGallery();
            $imageUpload->name = $uniqueFileName;
            $imageUpload->ot_id = $ot_id;
            $imageUpload->eval_type = "mechanical";
            $imageUpload->save();
            //$file->move(public_path("uploads/mechanical/$id"), $uniqueFileName);
        }

        activitylog('mechanical_evaluations', 'store', null, json_encode($meval->toArray()));

        // redirect
        \Session::flash('message', 'Successfully updated formato!');
        return redirect('formatos/mechanical');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MechanicalEvaluation  $mechanicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'mechanical']);

        $formato = MechanicalEvaluation::findOrFail($id);
        $works = MechanicalEvaluationWork::where('me_id', $formato->id)->first();

        return view('formatos.mechanical.show', compact('formato', 'works'));
    }
    
    public function format_show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'mechanical']);

        $formato = MechanicalEvaluation::findOrFail($id);
        $works = MechanicalEvaluationWork::where('me_id', $formato->id)
                ->leftJoin('services', 'services.id', '=', 'mechanical_evaluation_works.service_id')
                ->leftJoin('areas', 'areas.id', '=', 'services.area_id')
                ->select(
                    'mechanical_evaluation_works.id',
                    'mechanical_evaluation_works.description',
                    'mechanical_evaluation_works.medidas',
                    'mechanical_evaluation_works.qty',
                    'mechanical_evaluation_works.personal',
                    'services.name as service',
                    'areas.name as area',
                    'services.area_id'
                )
                ->get();
        $gallery = OtGallery::where('ot_id', $formato->ot_id)
                    ->where('eval_type', 'mechanical')->get();

        $approved_by = \DB::table('logs')->where('section', 'mechanical_evaluations_approve')
                        ->join('users', 'users.id', '=', 'logs.user_id')
                        ->join('user_data', 'users.id', '=', 'user_data.user_id')
                        ->where('data', 'like', '%"ot_id":'. $formato->ot_id . '%')
                        ->select('logs.*', 'users.email', 'user_data.name')
                        ->first();
        $maded_by = \DB::table('logs')
                        ->join('users', 'users.id', '=', 'logs.user_id')
                        ->join('user_data', 'users.id', '=', 'user_data.user_id')
                        ->where('logs.section', 'mechanical_evaluations')
                        ->where('logs.action', 'store')
                        ->where('logs.data', 'like', '%"eel_id":'. $formato->id . '%')
                        ->select('logs.*', 'user_data.name')
                        ->first();

        return view('formatos.mechanical.show', compact('formato', 'works', 'gallery', 'approved_by', 'maded_by'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MechanicalEvaluation  $mechanicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'mechanical']);

        $formato = MechanicalEvaluation::findOrFail($id);
        $ot = Ot::where('ots.id', $formato->ot_id)
            ->join('clients', 'ots.client_id', '=', 'clients.id')
            ->select('ots.*', 'clients.razon_social', 'clients.client_type_id')
            ->firstOrFail();
        if ($ot->client_type_id == 1) { //RDI
            $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '=', 5)->get();
        } else {
            $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '<>', 5)->get();
        }
        $cod_rodaje_p1 = RotorCodRodajePt1::where('enabled', 1)->get();
        $cod_rodaje_p2 = RotorCodRodajePt2::where('enabled', 1)->get();
        $gallery = OtGallery::where('ot_id', $formato->ot_id)
                    ->where('eval_type', 'mechanical')->get();

        $works = MechanicalEvaluationWork::where('me_id', $formato->id)
                ->join('services', 'services.id', '=', 'mechanical_evaluation_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->select(
                    'mechanical_evaluation_works.id',
                    'mechanical_evaluation_works.description',
                    'mechanical_evaluation_works.medidas',
                    'mechanical_evaluation_works.qty',
                    'mechanical_evaluation_works.personal',
                    'services.name as service',
                    'services.id as service_id',
                    'areas.name as area',
                    'services.area_id'
                )
                ->get();

        return view('formatos.mechanical.edit', compact('formato', 'ot', 'areas', 'works', 'gallery', 'cod_rodaje_p1', 'cod_rodaje_p2'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MechanicalEvaluation  $mechanicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'mechanical']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation

        $rules = array(
            'rpm' => 'required',
            'hp_kw' => 'required',

            'serie' => 'string|nullable',
            'maquina' => 'string|nullable',
            'placa_caract_orig' => 'string|nullable',
            'tapas' => 'string|nullable',
            'ventilador' => 'string|nullable',
            'caja_conexion' => 'string|nullable',
            'ejes' => 'string|nullable',
            'acople' => 'string|nullable',
            'bornera' => 'string|nullable',
            'fundas' => 'string|nullable',
            'chaveta' => 'string|nullable',
            'impro_seal' => 'string|nullable',
            'laberintos' => 'string|nullable',
            'estator' => 'string|nullable',
            //Sí/no
            'placa_caract_orig_has' => 'boolean|nullable',
            'tapas_has' => 'boolean|nullable',
            'ventilador_has' => 'boolean|nullable',
            'caja_conexion_has' => 'boolean|nullable',
            'ejes_has' => 'boolean|nullable',
            'acople_has' => 'boolean|nullable',
            'bornera_has' => 'boolean|nullable',
            'fundas_has' => 'boolean|nullable',
            'chaveta_has' => 'boolean|nullable',
            'impro_seal_has' => 'boolean|nullable',
            'laberintos_has' => 'boolean|nullable',
            'estator_has' => 'boolean|nullable',
            //

            'otros' => 'string|nullable',
            'slam_muelle_p1' => 'string|nullable',
            'slam_muelle_p2' => 'string|nullable',
            'resortes_contra_tapas' => 'string|nullable',
            'alineamiento_paquete' => 'string|nullable',

            'rotor_deplexion_eje' => 'string|nullable',
            'rotor_valor_balanceo' => 'string|nullable',
            'rotor_cod_rodaje_p1' => 'string|nullable',
            'rotor_cod_rodaje_p2' => 'string|nullable',
            'rotor_asiento_rodaje_p1' => 'string|nullable',
            'rotor_asiento_rodaje_p2' => 'string|nullable',
            'rotor_eje_zona_acople_p1' => 'string|nullable',
            'rotor_eje_zona_acople_p2' => 'string|nullable',
            'rotor_medida_chaveta_p1' => 'string|nullable',
            'rotor_medida_chaveta_p2' => 'string|nullable',
            'rotor_canal_chaveta_p1' => 'string|nullable',
            'rotor_canal_chaveta_p2' => 'string|nullable',

            'estator_alojamiento_rodaje_tapa_p10' => 'string|nullable',
            'estator_alojamiento_rodaje_tapa_p20' => 'string|nullable',
            'estator_pestana_tapa_p1' => 'string|nullable',
            'estator_pestana_tapa_p2' => 'string|nullable',

            'estator_contra_tapa_interna_p1' => 'string|nullable',
            'estator_contra_tapa_interna_p2' => 'string|nullable',
            'estator_contra_tapa_externa_p1' => 'string|nullable',
            'estator_contra_tapa_externa_p2' => 'string|nullable',
            'estator_ventilador_0' => 'string|nullable',
            'estator_alabes' => 'string|nullable',
            'estator_caja_conexion' => 'string|nullable',
            'estator_tapa_conexion' => 'string|nullable',

            'observaciones' => 'string|nullable',

            'works' => 'array|nullable',

            //'files.*' => 'mimes:jpeg,jpg,png,gif|nullable',
            'files' => 'nullable'
        );

        $validator = $this->validate($request, $rules);

        // update
        $meval = MechanicalEvaluation::find($id);
        $original_data = $meval->toArray();

        $meval->rpm = $request->input('rpm');
        $meval->hp_kw = $request->input('hp_kw');

        $meval->serie = $request->input('serie');
        $meval->maquina = $request->input('maquina');
        $meval->placa_caract_orig = $request->input('placa_caract_orig');
        $meval->tapas = $request->input('tapas');
        $meval->ventilador = $request->input('ventilador');
        $meval->caja_conexion = $request->input('caja_conexion');
        $meval->ejes = $request->input('ejes');
        $meval->acople = $request->input('acople');
        $meval->bornera = $request->input('bornera');
        $meval->fundas = $request->input('fundas');
        $meval->chaveta = $request->input('chaveta');
        $meval->impro_seal = $request->input('impro_seal');
        $meval->laberintos = $request->input('laberintos');
        $meval->estator = $request->input('estator');
        //
        $meval->placa_caract_orig_has = $request->input('placa_caract_orig_has') ?? 0;
        $meval->tapas_has = $request->input('tapas_has') ?? 0;
        $meval->ventilador_has = $request->input('ventilador_has') ?? 0;
        $meval->caja_conexion_has = $request->input('caja_conexion_has') ?? 0;
        $meval->ejes_has = $request->input('ejes_has') ?? 0;
        $meval->acople_has = $request->input('acople_has') ?? 0;
        $meval->bornera_has = $request->input('bornera_has') ?? 0;
        $meval->fundas_has = $request->input('fundas_has') ?? 0;
        $meval->chaveta_has = $request->input('chaveta_has') ?? 0;
        $meval->impro_seal_has = $request->input('impro_seal_has') ?? 0;
        $meval->laberintos_has = $request->input('laberintos_has') ?? 0;
        $meval->estator_has = $request->input('estator_has') ?? 0;
        //

        $meval->otros = $request->input('otros');

        $meval->slam_muelle_p1 = $request->input('slam_muelle_p1');
        $meval->slam_muelle_p2 = $request->input('slam_muelle_p2');
        $meval->resortes_contra_tapas = $request->input('resortes_contra_tapas');
        $meval->alineamiento_paquete = $request->input('alineamiento_paquete');

        $meval->rotor_deplexion_eje = $request->input('rotor_deplexion_eje');
        $meval->rotor_valor_balanceo = $request->input('rotor_valor_balanceo');
        $meval->rotor_cod_rodaje_p1 = $request->input('rotor_cod_rodaje_p1');
        $meval->rotor_cod_rodaje_p2 = $request->input('rotor_cod_rodaje_p2');
        $meval->rotor_asiento_rodaje_p1 = $request->input('rotor_asiento_rodaje_p1');
        $meval->rotor_asiento_rodaje_p2 = $request->input('rotor_asiento_rodaje_p2');
        $meval->rotor_eje_zona_acople_p1 = $request->input('rotor_eje_zona_acople_p1');
        $meval->rotor_eje_zona_acople_p2 = $request->input('rotor_eje_zona_acople_p2');
        $meval->rotor_medida_chaveta_p1 = $request->input('rotor_medida_chaveta_p1');
        $meval->rotor_medida_chaveta_p2 = $request->input('rotor_medida_chaveta_p2');
        $meval->rotor_canal_chaveta_p1 = $request->input('rotor_canal_chaveta_p1');
        $meval->rotor_canal_chaveta_p2 = $request->input('rotor_canal_chaveta_p2');

        $meval->estator_alojamiento_rodaje_tapa_p10 = $request->input('estator_alojamiento_rodaje_tapa_p10');
        $meval->estator_alojamiento_rodaje_tapa_p20 = $request->input('estator_alojamiento_rodaje_tapa_p20');
        $meval->estator_pestana_tapa_p1 = $request->input('estator_pestana_tapa_p1');
        $meval->estator_pestana_tapa_p2 = $request->input('estator_pestana_tapa_p2');

        $meval->estator_contra_tapa_interna_p1 = $request->input('estator_contra_tapa_interna_p1');
        $meval->estator_contra_tapa_interna_p2 = $request->input('estator_contra_tapa_interna_p2');
        $meval->estator_contra_tapa_externa_p1 = $request->input('estator_contra_tapa_externa_p1');
        $meval->estator_contra_tapa_externa_p2 = $request->input('estator_contra_tapa_externa_p2');
        $meval->estator_ventilador_0 = $request->input('estator_ventilador_0');
        $meval->estator_alabes = $request->input('estator_alabes');
        $meval->estator_caja_conexion = $request->input('estator_caja_conexion');
        $meval->estator_tapa_conexion = $request->input('estator_tapa_conexion');

        $meval->observaciones = $request->input('observaciones');

        $meval->save();

        $works = $request->input('works');
        //$work_ids = array_column($works, 'id');
        //$update_works = MechanicalEvaluationWork::where('me_id', $meval->id)->delete();
        $services = [];
        $date = \Carbon\Carbon::now()->toDateTimeString();
        foreach ($works as $key => $item) {
            if (isset($item['id'])) {
                $work = MechanicalEvaluationWork::find($item['id']);
                if (isset($item['status']) && $item['status'] == 0) {
                    $work->delete();
                } else {
                    $work->me_id = $meval->id;
                    $work->service_id = isset($item['service_id']) ? $item['service_id'] : '';
                    $work->description = isset($item['description']) ? $item['description'] : '';
                    $work->medidas = isset($item['medidas']) ? $item['medidas'] : '';
                    $work->qty = isset($item['qty']) ? $item['qty'] : '';
                    $work->personal = isset($item['personal']) ? $item['personal'] : '';
                    $work->updated_at = $date;
                    $work->save();
                }
            } else {
                $services[$key]['me_id'] = $meval->id;
                $services[$key]['service_id'] = isset($item['service_id']) ? $item['service_id'] : '';
                $services[$key]['description'] = isset($item['description']) ? $item['description'] : '';
                $services[$key]['medidas'] = isset($item['medidas']) ? $item['medidas'] : '';
                $services[$key]['qty'] = isset($item['qty']) ? $item['qty'] : '';
                $services[$key]['personal'] = isset($item['personal']) ? $item['personal'] : '';
                $services[$key]['created_at'] = $date;
                $services[$key]['updated_at'] = $date;
                MechanicalEvaluationWork::insert($services);
            }
        }

        /*if ($request->file('files')) {
            $files = $request->file('files');
            foreach ($files as $key => $file) {
                $ext = $file->getClientOriginalExtension();
                $uniqueFileName = preg_replace('/\s+/', "-", str_replace(".".$ext, "", $file->getClientOriginalName()) .uniqid()) . ".".$ext;

                $image = new MechanicalGallery();
                $image->me_id = $eleval->id;
                $image->name = $uniqueFileName;
                $image->save();

                $file->move(public_path("uploads/mechanical/$id"), $uniqueFileName);
            }
        }*/

        activitylog('mechanical_evaluations', 'store', $original_data, $meval->toArray());

        \Session::flash('message', 'Successfully updated formato!');
        return redirect('formatos/mechanical');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MechanicalEvaluation  $mechanicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MechanicalEvaluation $mechanicalEvaluation)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'mechanical']);
    }
}
