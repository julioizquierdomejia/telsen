<?php

namespace App\Http\Controllers;

use App\Models\ElectricalEvaluation;
use App\Models\ElectricalEvaluationWork;
use App\Models\ElectricalEvaluationCharacteristic;
use App\Models\ElectricalEvaluationReception;
use App\Models\ElectricalEvaluationTestIn;
use App\Models\ElectricalEvaluationTransformer;
use App\Models\Ot;
use App\Models\MotorBrand;
use App\Models\MotorModel;
use App\Models\Status;
use App\Models\Area;
use Illuminate\Http\Request;

class ElectricalEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'electrical']);

        //$ots = Ot::join('status_ot', 'status_ot.ot_id', '=', 'status_ot.ot_id')
        $_ots = Ot::join('clients', 'clients.id', '=', 'ots.client_id')
                        ->select('ots.*', 'clients.razon_social')
                        ->where('ots.enabled', '=', 1)
                        ->where('clients.enabled', '=', 1)
                        //->where('status_ot.status_id', '=', 1)
                        ->groupBy('ots.id')
                        ->get();

        $ots = [];
        foreach ($_ots as $key => $ot) {
            $ot_status = \DB::table('status_ot')->where('status_ot.ot_id', '=', $ot->id)->get();
            $array = [];
            foreach ($ot_status as $key => $status) {
                $array[] = $status->status_id;
            }
            if (!in_array(3, $array)) {
                $ots[] = $ot;
            }
        }
        return view('formatos.electrical.index', compact('ots'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function evaluate(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'electrical']);

        $formato = ElectricalEvaluation::where('ot_id', $id)->first();
        if ($formato) {
            return redirect('formatos/electrical');
        }

        $ot = Ot::where('ots.id', $id)
            ->join('clients', 'ots.client_id', '=', 'clients.id')
            ->select('ots.*', 'clients.razon_social', 'clients.client_type_id')
            ->firstOrFail();
        if ($ot->client_type_id == 1) { //RDI
            $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '=', 5)->get();
        } else {
            $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '<>', 5)->get();
        }
        $marcas = MotorBrand::where('enabled', 1)->get();
        $modelos = MotorModel::where('enabled', 1)->get();

        return view('formatos.electrical.evaluate', compact('ot', 'marcas', 'modelos', 'areas'));
    }

    public function approve(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $action = $request->input('action');

        if ($action == 1) {
            $eval = ElectricalEvaluation::findOrFail($id);
            $eval->approved = 1;
            $eval->save();
        } else /*if($action == 2)*/ {
            $eval = ElectricalEvaluation::findOrFail($id);
            $eval->approved = 2;
            $eval->save();
        }
        return response()->json(['data'=>json_encode($eval),'success'=>true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'electrical']);
        
        // validate
        $rules = array(
            //'ot_id' => 'required',
            'potencia' => 'required',
            'conex' => 'required',
            'voltaje' => 'required',
            'nro_salida' => 'string|nullable',
            'tipo' => 'string|nullable',
            'amperaje' => 'required|string',
            'rodla' => 'string|nullable',
            'nro_equipo' => 'string|nullable',
            'velocidad' => 'required|string',
            'rodloa' => 'string|nullable',
            'frame' => 'string|nullable',
            'frecuencia' => 'required|string',
            'lub' => 'string|nullable',
            'fs' => 'string|nullable',
            'encl' => 'string|nullable',
            'lf' => 'string|nullable',
            'cos_o' => 'string|nullable',
            'aisl_clase' => 'string|nullable',
            'ef' => 'string|nullable',
            'cod' => 'string|nullable',
            'diseno_nema' => 'string|nullable',
            'ip' => 'string|nullable',
            'peso' => 'string|nullable',

            //OT
            'descripcion_motor' => 'string',
            'codigo_motor' => 'string',
            'solped' => 'string',
            'marca_id' => 'integer',
            'modelo_id' => 'integer',
            'numero_potencia' => 'string',
            'medida_potencia' => 'string',
            'ot_voltaje' => 'string',
            'ot_velocidad' => 'string',

            'char_marca' => 'string|nullable',
            'char_potencia' => 'string|nullable',
            'char_escudos' => 'string|nullable',
            'char_mod' => 'string|nullable',
            'char_voltaje' => 'string|nullable',
            'char_ejes' => 'string|nullable',
            'char_nro' => 'string|nullable',
            'char_amperaje' => 'string|nullable',
            'char_funda' => 'string|nullable',
            'char_frame' => 'string|nullable',
            'char_velocidad' => 'string|nullable',
            'char_acople' => 'string|nullable',
            'char_fs' => 'string|nullable',
            'char_encl' => 'string|nullable',
            'char_peso' => 'string|nullable',
            'char_frecuencia' => 'string|nullable',
            'char_otros' => 'string|nullable',

            'rec_placa_caract_orig' => 'string|nullable',
            'rec_escudos' => 'string|nullable',
            'rec_ventilador' => 'string|nullable',
            'rec_caja_conexion' => 'string|nullable',
            'rec_ejes' => 'string|nullable',
            'rec_acople' => 'string|nullable',
            'rec_bornera' => 'string|nullable',
            'rec_funda' => 'string|nullable',
            'rec_chaveta' => 'string|nullable',
            'rec_cancamo' => 'string|nullable',
            'rec_base' => 'string|nullable',
            'rec_otros' => 'string|nullable',
            'rec_detalles' => 'string|nullable',
            //Botones sí/no
            'rec_placa_caract_orig_has' => 'boolean|nullable',
            'rec_escudos_has' => 'boolean|nullable',
            'rec_ventilador_has' => 'boolean|nullable',
            'rec_caja_conexion_has' => 'boolean|nullable',
            'rec_ejes_has' => 'boolean|nullable',
            'rec_acople_has' => 'boolean|nullable',
            'rec_bornera_has' => 'boolean|nullable',
            'rec_funda_has' => 'boolean|nullable',
            'rec_chaveta_has' => 'boolean|nullable',
            'rec_cancamo_has' => 'boolean|nullable',
            'rec_base_has' => 'boolean|nullable',

            'testin_motor_aisl_m' => 'string|nullable',
            'testin_motor_nro_salidas' => 'string|nullable',
            'testin_motor_conexion' => 'string|nullable',
            'testin_motor_volt_v' => 'string|nullable',
            'testin_motor_amp_a' => 'string|nullable',
            'testin_motor_rpm' => 'string|nullable',
            'testin_motor_frec_hz' => 'string|nullable',
            'testin_directo_masa' => 'string|nullable',
            'testin_bajo_alistamiento' => 'string|nullable',
            'testin_mayor_cienm' => 'string|nullable',
            'testin_er_aisl_m' => 'string|nullable',
            'testin_er_nro_salidas' => 'string|nullable',
            'testin_er_conexion' => 'string|nullable',
            'testin_er_volt_v' => 'string|nullable',
            'testin_er_amp_a' => 'string|nullable',
            'testin_er_nro_polos' => 'string|nullable',

            'tran_tap' => 'array|nullable',
            'tran_aisl_m' => 'string|nullable',
            'tran_nro_salidas' => 'string|nullable',
            'tran_conexion' => 'string|nullable',
            'tran_volt_v' => 'string|nullable',
            'tran_amp_a' => 'string|nullable',
            'tran_nro_polos' => 'string|nullable',
            'tran_aisl_m_at_masa' => 'string|nullable',
            'tran_st_masa' => 'string|nullable',
            'tran_et_at' => 'string|nullable',
            'tran_grupo_conex' => 'string|nullable',
            'tran_polaridad' => 'string|nullable',
            'tran_relac_transf' => 'string|nullable',
            'tran_otp' => 'string|nullable',
            'tran_tec' => 'string|nullable',
            'tran_amp' => 'string|nullable',
            'tran_rig_diel_aceite' => 'string|nullable',
            'tran_ruv' => 'string|nullable',
            'tran_rv_w' => 'string|nullable',
            'tran_rw_u' => 'string|nullable',
            'tran_ru_v' => 'string|nullable',
            'tran_rv_u' => 'string|nullable',
            'tran_ww' => 'string|nullable',
        );

        $tran_tap = json_encode($request->input('tran_tap'));

        $validator = $this->validate($request, $rules);

        // store
        $ot = Ot::find($id);
        $ot->solped = $request->get('solped');
        $ot->descripcion_motor = $request->get('descripcion_motor');
        $ot->codigo_motor = $request->get('codigo_motor');
        $ot->marca_id = $request->get('marca_id');
        $ot->modelo_id = $request->get('modelo_id');
        $ot->numero_potencia = $request->get('numero_potencia');
        $ot->medida_potencia = $request->get('medida_potencia');
        $ot->voltaje = $request->get('ot_voltaje');
        $ot->velocidad = $request->get('ot_velocidad');
        $ot->save();

        $eleval = new ElectricalEvaluation();
        $eleval->ot_id = $id;
        //$eleval->solped = $request->input('solped');
        $eleval->recepcionado_por = $request->input('recepcionado_por');
        $eleval->potencia = $request->input('potencia');
        $eleval->conex = $request->input('conex');
        $eleval->mod = $request->input('mod');
        $eleval->voltaje = $request->input('voltaje');
        $eleval->nro_salida = $request->input('nro_salida');
        $eleval->tipo = $request->input('tipo');
        $eleval->amperaje = $request->input('amperaje');
        $eleval->rodla = $request->input('rodla');
        $eleval->nro_equipo = $request->input('nro_equipo');
        $eleval->velocidad = $request->input('velocidad');
        $eleval->rodloa = $request->input('rodloa');
        $eleval->frame = $request->input('frame');
        $eleval->frecuencia = $request->input('frecuencia');
        $eleval->lub = $request->input('lub');
        $eleval->fs = $request->input('fs');
        $eleval->encl = $request->input('encl');
        $eleval->lf = $request->input('lf');
        $eleval->cos_o = $request->input('cos_o');
        $eleval->aisl_clase = $request->input('aisl_clase');
        $eleval->ef = $request->input('ef');
        $eleval->cod = $request->input('cod');
        $eleval->diseno_nema = $request->input('diseno_nema');
        $eleval->ip = $request->input('ip');
        $eleval->peso = $request->input('peso');
        $eleval->save();

        $elcheval = new ElectricalEvaluationCharacteristic();
        $elcheval->eel_id = $eleval['id'];
        $elcheval->marca = $request->input('char_marca');
        $elcheval->potencia = $request->input('char_potencia');
        $elcheval->escudos = $request->input('char_escudos');
        $elcheval->mod = $request->input('char_mod');
        $elcheval->voltaje = $request->input('char_voltaje');
        $elcheval->ejes = $request->input('char_ejes');
        $elcheval->nro = $request->input('char_nro');
        $elcheval->amperaje = $request->input('char_amperaje');
        $elcheval->funda = $request->input('char_funda');
        $elcheval->frame = $request->input('char_frame');
        $elcheval->velocidad = $request->input('char_velocidad');
        $elcheval->acople = $request->input('char_acople');
        $elcheval->fs = $request->input('char_fs');
        $elcheval->encl = $request->input('char_encl');
        $elcheval->peso = $request->input('char_peso');
        $elcheval->frecuencia = $request->input('char_frecuencia');
        $elcheval->otros = $request->input('char_otros');
        $elcheval->save();

        $elreceval = new ElectricalEvaluationReception();
        $elreceval->eel_id = $eleval['id'];
        $elreceval->placa_caract_orig = $request->input('rec_placa_caract_orig');
        $elreceval->escudos = $request->input('rec_escudos');
        $elreceval->ventilador = $request->input('rec_ventilador');
        $elreceval->caja_conexion = $request->input('rec_caja_conexion');
        $elreceval->ejes = $request->input('rec_ejes');
        $elreceval->acople = $request->input('rec_acople');
        $elreceval->bornera = $request->input('rec_bornera');
        $elreceval->funda = $request->input('rec_funda');
        $elreceval->chaveta = $request->input('rec_chaveta');
        $elreceval->cancamo = $request->input('rec_cancamo');
        $elreceval->base = $request->input('rec_base');
        //
        $elreceval->placa_caract_orig_has = $request->input('rec_placa_caract_orig_has') ?? 0;
        $elreceval->escudos_has = $request->input('rec_escudos_has') ?? 0;
        $elreceval->ventilador_has = $request->input('rec_ventilador_has') ?? 0;
        $elreceval->caja_conexion_has = $request->input('rec_caja_conexion_has') ?? 0;
        $elreceval->ejes_has = $request->input('rec_ejes_has') ?? 0;
        $elreceval->acople_has = $request->input('rec_acople_has') ?? 0;
        $elreceval->bornera_has = $request->input('rec_bornera_has') ?? 0;
        $elreceval->funda_has = $request->input('rec_funda_has') ?? 0;
        $elreceval->chaveta_has = $request->input('rec_chaveta_has') ?? 0;
        $elreceval->cancamo_has = $request->input('rec_cancamo_has') ?? 0;
        $elreceval->base_has = $request->input('rec_base_has') ?? 0;
        //
        $elreceval->otros = $request->input('rec_otros');
        $elreceval->detalles = $request->input('rec_detalles');
        $elreceval->save();

        $eltestineval = new ElectricalEvaluationTestIn();
        $eltestineval->eel_id = $eleval['id'];
        $eltestineval->motor_aisl_m = $request->input('testin_motor_aisl_m');
        $eltestineval->motor_nro_salidas = $request->input('testin_motor_nro_salidas');
        $eltestineval->motor_conexion = $request->input('testin_motor_conexion');
        $eltestineval->motor_volt_v = $request->input('testin_motor_volt_v');
        $eltestineval->motor_amp_a = $request->input('testin_motor_amp_a');
        $eltestineval->motor_rpm = $request->input('testin_motor_rpm');
        $eltestineval->motor_frec_hz = $request->input('testin_motor_frec_hz');
        $eltestineval->bajo_alistamiento = $request->input('testin_bajo_alistamiento');
        $eltestineval->directo_masa = $request->input('testin_directo_masa');
        $eltestineval->mayor_cienm = $request->input('testin_mayor_cienm');
        $eltestineval->er_aisl_m = $request->input('testin_er_aisl_m');
        $eltestineval->er_nro_salidas = $request->input('testin_er_nro_salidas');
        $eltestineval->er_conexion = $request->input('testin_er_conexion');
        $eltestineval->er_volt_v = $request->input('testin_er_volt_v');
        $eltestineval->er_amp_a = $request->input('testin_er_amp_a');
        $eltestineval->er_nro_polos = $request->input('testin_er_nro_polos');
        $eltestineval->save();

        $eltraneval = new ElectricalEvaluationTransformer();
        $eltraneval->eel_id = $eleval['id'];
        $eltraneval->tap = $tran_tap;
        $eltraneval->aisl_m = $request->input('tran_aisl_m');
        $eltraneval->nro_salidas = $request->input('tran_nro_salidas');
        $eltraneval->conexion = $request->input('tran_conexion');
        $eltraneval->volt_v = $request->input('tran_volt_v');
        $eltraneval->amp_a = $request->input('tran_amp_a');
        $eltraneval->nro_polos = $request->input('tran_nro_polos');
        $eltraneval->aisl_m_at_masa = $request->input('tran_aisl_m_at_masa');
        $eltraneval->st_masa = $request->input('tran_st_masa');
        $eltraneval->et_at = $request->input('tran_et_at');
        $eltraneval->grupo_conex = $request->input('tran_grupo_conex');
        $eltraneval->polaridad = $request->input('tran_polaridad');
        $eltraneval->relac_transf = $request->input('tran_relac_transf');
        $eltraneval->otp = $request->input('tran_otp');
        $eltraneval->tec = $request->input('tran_tec');
        $eltraneval->amp = $request->input('tran_amp');
        $eltraneval->rig_diel_aceite = $request->input('tran_rig_diel_aceite');
        $eltraneval->ruv = $request->input('tran_ruv');
        $eltraneval->rv_w = $request->input('tran_rv_w');
        $eltraneval->rw_u = $request->input('tran_rw_u');
        $eltraneval->ru_v = $request->input('tran_ru_v');
        $eltraneval->rv_u = $request->input('tran_rv_u');
        $eltraneval->ww = $request->input('tran_ww');
        $eltraneval->save();

        $works = $request->input('works');
        $services = [];
        $date = \Carbon\Carbon::now()->toDateTimeString();
        foreach ($works as $key => $item) {
            $services[$key]['me_id'] = $eleval->id;
            $services[$key]['service_id'] = isset($item['service_id']) ? $item['service_id'] : '';
            $services[$key]['description'] = isset($item['description']) ? $item['description'] : '';
            $services[$key]['medidas'] = isset($item['medidas']) ? $item['medidas'] : '';
            $services[$key]['qty'] = isset($item['qty']) ? $item['qty'] : '';
            $services[$key]['personal'] = isset($item['personal']) ? $item['personal'] : '';

            $services[$key]['created_at'] = $date;
            $services[$key]['updated_at'] = $date;
        }

        ElectricalEvaluationWork::insert($services);

        $status = Status::where('id', 3)->first();
        if ($status) {
            \DB::table('status_ot')->insert([
                'status_id' => $status->id,
                'ot_id' => $id,
            ]);
        }

        activitylog('eval. electrical', 'store', null, json_encode($eltraneval->toArray()));

        // redirect
        \Session::flash('message', 'Successfully updated formato!');
        return redirect('formatos/electrical');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ElectricalEvaluation  $electricalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'electrical']);

        $formato = ElectricalEvaluation::findOrFail($id);

        return view('formatos.electrical.show', compact('formato'));
    }

    public function format_show(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'electrical']);

        $formato = ElectricalEvaluation::
                    join('ots', 'ots.id', '=', 'electrical_evaluations.ot_id')
                    ->join('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                    ->join('motor_models', 'motor_models.id', '=', 'ots.marca_id')
                    ->join('eval_electrical_reception as eer', 'eer.eel_id', '=', 'electrical_evaluations.id')
                    ->join('eval_electrical_test_in as eetesting', 'eetesting.eel_id', '=', 'electrical_evaluations.id')
                    ->join('eval_electrical_characteristics as eechar', 'eechar.eel_id', '=', 'electrical_evaluations.id')
                    ->join('eval_electrical_transformer as eet', 'eet.eel_id', '=', 'electrical_evaluations.id')
                    ->select(
                        'electrical_evaluations.*',

                        'ots.descripcion_motor',
                        'ots.codigo_motor',
                        'ots.numero_potencia',
                        'ots.medida_potencia',
                        'ots.voltaje as ot_voltaje',
                        'ots.velocidad as ot_velocidad',
                        'ots.solped',

                        'motor_brands.name as marca',
                        'motor_models.name as modelo',

                        'eer.placa_caract_orig as rec_placa_caract_orig',
                        'eer.escudos as rec_escudos',
                        'eer.ventilador as rec_ventilador',
                        'eer.caja_conexion as rec_caja_conexion',
                        'eer.ejes as rec_ejes',
                        'eer.acople as rec_acople',
                        'eer.bornera as rec_bornera',
                        'eer.funda as rec_funda',
                        'eer.chaveta as rec_chaveta',
                        'eer.placa_caract_orig_has as rec_placa_caract_orig_has',
                        'eer.escudos_has as rec_escudos_has',
                        'eer.ventilador_has as rec_ventilador_has',
                        'eer.caja_conexion_has as rec_caja_conexion_has',
                        'eer.ejes_has as rec_ejes_has',
                        'eer.acople_has as rec_acople_has',
                        'eer.bornera_has as rec_bornera_has',
                        'eer.funda_has as rec_funda_has',
                        'eer.chaveta_has as rec_chaveta_has',
                        'eer.otros as rec_otros',
                        'eer.detalles as rec_detalles',

                        'eetesting.motor_aisl_m',
                        'eetesting.motor_nro_salidas',
                        'eetesting.motor_conexion',
                        'eetesting.motor_volt_v',
                        'eetesting.motor_amp_a',
                        'eetesting.motor_rpm',
                        'eetesting.motor_frec_hz',
                        'eetesting.bajo_alistamiento',
                        'eetesting.directo_masa',
                        'eetesting.mayor_cienm',
                        'eetesting.er_aisl_m',
                        'eetesting.er_nro_salidas',
                        'eetesting.er_conexion',
                        'eetesting.er_volt_v',
                        'eetesting.er_amp_a',
                        'eetesting.er_nro_polos',

                        'eet.tap as tran_tap',
                        'eet.aisl_m as tran_aisl_m',
                        'eet.nro_salidas as tran_nro_salidas',
                        'eet.conexion as tran_conexion',
                        'eet.volt_v as tran_volt_v',
                        'eet.amp_a as tran_amp_a',
                        'eet.nro_polos as tran_nro_polos',
                        'eet.aisl_m_at_masa as tran_aisl_m_at_masa',
                        'eet.st_masa as tran_st_masa',
                        'eet.et_at as tran_et_at',
                        'eet.grupo_conex as tran_grupo_conex',
                        'eet.polaridad as tran_polaridad',
                        'eet.relac_transf as tran_relac_transf',
                        'eet.otp as tran_otp',
                        'eet.tec as tran_tec',
                        'eet.amp as tran_amp',
                        'eet.rig_diel_aceite as tran_rig_diel_aceite',
                        'eet.ruv as tran_ruv',
                        'eet.rv_w as tran_rv_w',
                        'eet.rw_u as tran_rw_u',
                        'eet.ru_v as tran_ru_v',
                        'eet.rv_u as tran_rv_u',
                        'eet.ww as tran_ww',

                        'eechar.marca as char_marca',
                        'eechar.potencia as char_potencia',
                        'eechar.escudos as char_escudos',
                        'eechar.mod as char_mod',
                        'eechar.voltaje as char_voltaje',
                        'eechar.ejes as char_ejes',
                        'eechar.nro as char_nro',
                        'eechar.amperaje as char_amperaje',
                        'eechar.funda as char_funda',
                        'eechar.frame as char_frame',
                        'eechar.velocidad as char_velocidad',
                        'eechar.acople as char_acople',
                        'eechar.fs as char_fs',
                        'eechar.encl as char_encl',
                        'eechar.peso as char_peso',
                        'eechar.frecuencia as char_frecuencia',
                        'eechar.otros as char_otros'
                )
                    //->where('electrical_evaluations.ot_id', $ot_id)
                    ->findOrFail($id);

        $works = ElectricalEvaluationWork::where('me_id', $formato->id)
                ->join('services', 'services.id', '=', 'electrical_evaluation_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->select(
                    'electrical_evaluation_works.id',
                    'electrical_evaluation_works.description',
                    'electrical_evaluation_works.medidas',
                    'electrical_evaluation_works.qty',
                    'electrical_evaluation_works.personal',
                    'services.name as service',
                    'services.id as service_id',
                    'areas.name as area',
                    'areas.id as area_id'
                )
                ->get();

        return view('formatos.electrical.show', compact('formato', 'works'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ElectricalEvaluation  $electricalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'electrical']);

        $formato = ElectricalEvaluation::
                    join('ots', 'ots.id', '=', 'electrical_evaluations.ot_id')
                    ->join('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                    ->join('motor_models', 'motor_models.id', '=', 'ots.marca_id')
                    ->join('eval_electrical_reception as eer', 'eer.eel_id', '=', 'electrical_evaluations.id')
                    ->join('eval_electrical_test_in as eetesting', 'eetesting.eel_id', '=', 'electrical_evaluations.id')
                    ->join('eval_electrical_characteristics as eechar', 'eechar.eel_id', '=', 'electrical_evaluations.id')
                    ->join('eval_electrical_transformer as eet', 'eet.eel_id', '=', 'electrical_evaluations.id')
                    ->select(
                        'electrical_evaluations.*',

                        'ots.descripcion_motor',
                        'ots.codigo_motor',
                        'ots.numero_potencia',
                        'ots.medida_potencia',
                        'ots.voltaje as ot_voltaje',
                        'ots.velocidad as ot_velocidad',
                        'ots.solped',

                        'motor_brands.name as marca',
                        'motor_models.name as modelo',

                        'eer.placa_caract_orig as rec_placa_caract_orig',
                        'eer.escudos as rec_escudos',
                        'eer.ventilador as rec_ventilador',
                        'eer.caja_conexion as rec_caja_conexion',
                        'eer.ejes as rec_ejes',
                        'eer.acople as rec_acople',
                        'eer.bornera as rec_bornera',
                        'eer.funda as rec_funda',
                        'eer.chaveta as rec_chaveta',
                        'eer.placa_caract_orig_has as rec_placa_caract_orig_has',
                        'eer.escudos_has as rec_escudos_has',
                        'eer.ventilador_has as rec_ventilador_has',
                        'eer.caja_conexion_has as rec_caja_conexion_has',
                        'eer.ejes_has as rec_ejes_has',
                        'eer.acople_has as rec_acople_has',
                        'eer.bornera_has as rec_bornera_has',
                        'eer.funda_has as rec_funda_has',
                        'eer.chaveta_has as rec_chaveta_has',
                        'eer.otros as rec_otros',
                        'eer.detalles as rec_detalles',

                        'eetesting.motor_aisl_m as testin_motor_aisl_m',
                        'eetesting.motor_nro_salidas as testin_motor_nro_salidas',
                        'eetesting.motor_conexion as testin_motor_conexion',
                        'eetesting.motor_volt_v as testin_motor_volt_v',
                        'eetesting.motor_amp_a as testin_motor_amp_a',
                        'eetesting.motor_rpm as testin_motor_rpm',
                        'eetesting.motor_frec_hz as testin_motor_frec_hz',
                        'eetesting.bajo_alistamiento as testin_bajo_alistamiento',
                        'eetesting.directo_masa as testin_directo_masa',
                        'eetesting.mayor_cienm as testin_mayor_cienm',
                        'eetesting.er_aisl_m as testin_er_aisl_m',
                        'eetesting.er_nro_salidas as testin_er_nro_salidas',
                        'eetesting.er_conexion as testin_er_conexion',
                        'eetesting.er_volt_v as testin_er_volt_v',
                        'eetesting.er_amp_a as testin_er_amp_a',
                        'eetesting.er_nro_polos as testin_er_nro_polos',

                        'eet.tap as tran_tap',
                        'eet.aisl_m as tran_aisl_m',
                        'eet.nro_salidas as tran_nro_salidas',
                        'eet.conexion as tran_conexion',
                        'eet.volt_v as tran_volt_v',
                        'eet.amp_a as tran_amp_a',
                        'eet.nro_polos as tran_nro_polos',
                        'eet.aisl_m_at_masa as tran_aisl_m_at_masa',
                        'eet.st_masa as tran_st_masa',
                        'eet.et_at as tran_et_at',
                        'eet.grupo_conex as tran_grupo_conex',
                        'eet.polaridad as tran_polaridad',
                        'eet.relac_transf as tran_relac_transf',
                        'eet.otp as tran_otp',
                        'eet.tec as tran_tec',
                        'eet.amp as tran_amp',
                        'eet.rig_diel_aceite as tran_rig_diel_aceite',
                        'eet.ruv as tran_ruv',
                        'eet.rv_w as tran_rv_w',
                        'eet.rw_u as tran_rw_u',
                        'eet.ru_v as tran_ru_v',
                        'eet.rv_u as tran_rv_u',
                        'eet.ww as tran_ww',

                        'eechar.marca as char_marca',
                        'eechar.potencia as char_potencia',
                        'eechar.escudos as char_escudos',
                        'eechar.mod as char_mod',
                        'eechar.voltaje as char_voltaje',
                        'eechar.ejes as char_ejes',
                        'eechar.nro as char_nro',
                        'eechar.amperaje as char_amperaje',
                        'eechar.funda as char_funda',
                        'eechar.frame as char_frame',
                        'eechar.velocidad as char_velocidad',
                        'eechar.acople as char_acople',
                        'eechar.fs as char_fs',
                        'eechar.encl as char_encl',
                        'eechar.peso as char_peso',
                        'eechar.frecuencia as char_frecuencia',
                        'eechar.otros as char_otros'
                )
                    ->where('electrical_evaluations.id', $id)->firstOrFail();
        $ot = Ot::where('ots.id', $formato->ot_id)
            ->join('clients', 'ots.client_id', '=', 'clients.id')
            ->select('ots.*', 'clients.razon_social', 'clients.client_type_id')
            ->firstOrFail();
        if ($ot->client_type_id == 1) { //RDI
            $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '=', 5)->get();
        } else {
            $areas = Area::where('enabled', 1)->where('has_services', 1)->where('id', '<>', 5)->get();
        }
        $marcas = MotorBrand::where('enabled', 1)->get();
        $modelos = MotorModel::where('enabled', 1)->get();

        $works = ElectricalEvaluationWork::where('me_id', $formato->id)
                ->join('services', 'services.id', '=', 'electrical_evaluation_works.service_id')
                ->join('areas', 'areas.id', '=', 'services.area_id')
                ->select(
                    'electrical_evaluation_works.id',
                    'electrical_evaluation_works.description',
                    'electrical_evaluation_works.medidas',
                    'electrical_evaluation_works.qty',
                    'electrical_evaluation_works.personal',
                    'services.name as service',
                    'services.id as service_id',
                    'areas.name as area',
                    'areas.id as area_id'
                )
                ->get();

        return view('formatos.electrical.edit', compact('formato', 'ot', 'marcas', 'modelos', 'areas', 'works'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ElectricalEvaluation  $electricalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'electrical']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            //'ot_id' => 'required',
            'potencia' => 'required',
            'conex' => 'required',
            'voltaje' => 'required',
            'nro_salida' => 'string|nullable',
            'tipo' => 'string|nullable',
            'amperaje' => 'required|string',
            'rodla' => 'string|nullable',
            'nro_equipo' => 'string|nullable',
            'velocidad' => 'required|string',
            'rodloa' => 'string|nullable',
            'frame' => 'string|nullable',
            'frecuencia' => 'required|string',
            'lub' => 'string|nullable',
            'fs' => 'string|nullable',
            'encl' => 'string|nullable',
            'lf' => 'string|nullable',
            'cos_o' => 'string|nullable',
            'aisl_clase' => 'string|nullable',
            'ef' => 'string|nullable',
            'cod' => 'string|nullable',
            'diseno_nema' => 'string|nullable',
            'ip' => 'string|nullable',
            'peso' => 'string|nullable',

            //OT
            'descripcion_motor' => 'string',
            'codigo_motor' => 'string',
            'solped' => 'string',
            'marca_id' => 'integer',
            'modelo_id' => 'integer',
            'numero_potencia' => 'string',
            'medida_potencia' => 'string',
            'voltaje' => 'string',
            'velocidad' => 'string',

            'char_marca' => 'string|nullable',
            'char_potencia' => 'string|nullable',
            'char_escudos' => 'string|nullable',
            'char_mod' => 'string|nullable',
            'char_voltaje' => 'string|nullable',
            'char_ejes' => 'string|nullable',
            'char_nro' => 'string|nullable',
            'char_amperaje' => 'string|nullable',
            'char_funda' => 'string|nullable',
            'char_frame' => 'string|nullable',
            'char_velocidad' => 'string|nullable',
            'char_acople' => 'string|nullable',
            'char_fs' => 'string|nullable',
            'char_encl' => 'string|nullable',
            'char_peso' => 'string|nullable',
            'char_frecuencia' => 'string|nullable',
            'char_otros' => 'string|nullable',

            'rec_placa_caract_orig' => 'string|nullable',
            'rec_escudos' => 'string|nullable',
            'rec_ventilador' => 'string|nullable',
            'rec_caja_conexion' => 'string|nullable',
            'rec_ejes' => 'string|nullable',
            'rec_acople' => 'string|nullable',
            'rec_bornera' => 'string|nullable',
            'rec_funda' => 'string|nullable',
            'rec_chaveta' => 'string|nullable',
            'rec_otros' => 'string|nullable',
            'rec_detalles' => 'string|nullable',
            //Botones sí/no
            'rec_placa_caract_orig_has' => 'boolean|nullable',
            'rec_escudos_has' => 'boolean|nullable',
            'rec_ventilador_has' => 'boolean|nullable',
            'rec_caja_conexion_has' => 'boolean|nullable',
            'rec_ejes_has' => 'boolean|nullable',
            'rec_acople_has' => 'boolean|nullable',
            'rec_bornera_has' => 'boolean|nullable',
            'rec_funda_has' => 'boolean|nullable',
            'rec_chaveta_has' => 'boolean|nullable',

            'testin_motor_aisl_m' => 'string|nullable',
            'testin_motor_nro_salidas' => 'string|nullable',
            'testin_motor_conexion' => 'string|nullable',
            'testin_motor_volt_v' => 'string|nullable',
            'testin_motor_amp_a' => 'string|nullable',
            'testin_motor_rpm' => 'string|nullable',
            'testin_motor_frec_hz' => 'string|nullable',
            'testin_directo_masa' => 'string|nullable',
            'testin_bajo_alistamiento' => 'string|nullable',
            'testin_mayor_cienm' => 'string|nullable',
            'testin_er_aisl_m' => 'string|nullable',
            'testin_er_nro_salidas' => 'string|nullable',
            'testin_er_conexion' => 'string|nullable',
            'testin_er_volt_v' => 'string|nullable',
            'testin_er_amp_a' => 'string|nullable',
            'testin_er_nro_polos' => 'string|nullable',

            'tran_tap' => 'array|nullable',
            'tran_aisl_m' => 'string|nullable',
            'tran_nro_salidas' => 'string|nullable',
            'tran_conexion' => 'string|nullable',
            'tran_volt_v' => 'string|nullable',
            'tran_amp_a' => 'string|nullable',
            'tran_nro_polos' => 'string|nullable',
            'tran_aisl_m_at_masa' => 'string|nullable',
            'tran_st_masa' => 'string|nullable',
            'tran_et_at' => 'string|nullable',
            'tran_grupo_conex' => 'string|nullable',
            'tran_polaridad' => 'string|nullable',
            'tran_relac_transf' => 'string|nullable',
            'tran_otp' => 'string|nullable',
            'tran_tec' => 'string|nullable',
            'tran_amp' => 'string|nullable',
            'tran_rig_diel_aceite' => 'string|nullable',
            'tran_ruv' => 'string|nullable',
            'tran_rv_w' => 'string|nullable',
            'tran_rw_u' => 'string|nullable',
            'tran_ru_v' => 'string|nullable',
            'tran_rv_u' => 'string|nullable',
            'tran_ww' => 'string|nullable',
        );

        $this->validate($request, $rules);

        $tran_tap = json_encode($request->input('tran_tap'));

        // update
        $eleval = ElectricalEvaluation::findOrFail($id);
        $eleval->recepcionado_por = $request->input('recepcionado_por');
        $eleval->potencia = $request->input('potencia');
        $eleval->conex = $request->input('conex');
        $eleval->mod = $request->input('mod');
        $eleval->voltaje = $request->input('voltaje');
        $eleval->nro_salida = $request->input('nro_salida');
        $eleval->tipo = $request->input('tipo');
        $eleval->amperaje = $request->input('amperaje');
        $eleval->rodla = $request->input('rodla');
        $eleval->nro_equipo = $request->input('nro_equipo');
        $eleval->velocidad = $request->input('velocidad');
        $eleval->rodloa = $request->input('rodloa');
        $eleval->frame = $request->input('frame');
        $eleval->frecuencia = $request->input('frecuencia');
        $eleval->lub = $request->input('lub');
        $eleval->fs = $request->input('fs');
        $eleval->encl = $request->input('encl');
        $eleval->lf = $request->input('lf');
        $eleval->cos_o = $request->input('cos_o');
        $eleval->aisl_clase = $request->input('aisl_clase');
        $eleval->ef = $request->input('ef');
        $eleval->cod = $request->input('cod');
        $eleval->diseno_nema = $request->input('diseno_nema');
        $eleval->ip = $request->input('ip');
        $eleval->peso = $request->input('peso');
        $eleval->save();

        $ot = Ot::find($eleval->ot_id);
        $ot->solped = $request->get('solped');
        $ot->descripcion_motor = $request->get('descripcion_motor');
        $ot->codigo_motor = $request->get('codigo_motor');
        $ot->marca_id = $request->get('marca_id');
        $ot->modelo_id = $request->get('modelo_id');
        $ot->numero_potencia = $request->get('numero_potencia');
        $ot->medida_potencia = $request->get('medida_potencia');
        $ot->voltaje = $request->get('ot_voltaje');
        $ot->velocidad = $request->get('ot_velocidad');
        $ot->save();
        $elcheval = ElectricalEvaluationCharacteristic::where('eel_id', $eleval->id)->first();
        $elcheval->marca = $request->input('char_marca');
        $elcheval->potencia = $request->input('char_potencia');
        $elcheval->escudos = $request->input('char_escudos');
        $elcheval->mod = $request->input('char_mod');
        $elcheval->voltaje = $request->input('char_voltaje');
        $elcheval->ejes = $request->input('char_ejes');
        $elcheval->nro = $request->input('char_nro');
        $elcheval->amperaje = $request->input('char_amperaje');
        $elcheval->funda = $request->input('char_funda');
        $elcheval->frame = $request->input('char_frame');
        $elcheval->velocidad = $request->input('char_velocidad');
        $elcheval->acople = $request->input('char_acople');
        $elcheval->fs = $request->input('char_fs');
        $elcheval->encl = $request->input('char_encl');
        $elcheval->peso = $request->input('char_peso');
        $elcheval->frecuencia = $request->input('char_frecuencia');
        $elcheval->otros = $request->input('char_otros');
        $elcheval->save();

        $elreceval = ElectricalEvaluationReception::where('eel_id', $eleval->id)->first();
        $elreceval->placa_caract_orig = $request->input('rec_placa_caract_orig');
        $elreceval->escudos = $request->input('rec_escudos');
        $elreceval->ventilador = $request->input('rec_ventilador');
        $elreceval->caja_conexion = $request->input('rec_caja_conexion');
        $elreceval->ejes = $request->input('rec_ejes');
        $elreceval->acople = $request->input('rec_acople');
        $elreceval->bornera = $request->input('rec_bornera');
        $elreceval->funda = $request->input('rec_funda');
        $elreceval->chaveta = $request->input('rec_chaveta');
        //
        $elreceval->placa_caract_orig_has = $request->input('rec_placa_caract_orig_has') ?? 0;
        $elreceval->escudos_has = $request->input('rec_escudos_has') ?? 0;
        $elreceval->ventilador_has = $request->input('rec_ventilador_has') ?? 0;
        $elreceval->caja_conexion_has = $request->input('rec_caja_conexion_has') ?? 0;
        $elreceval->ejes_has = $request->input('rec_ejes_has') ?? 0;
        $elreceval->acople_has = $request->input('rec_acople_has') ?? 0;
        $elreceval->bornera_has = $request->input('rec_bornera_has') ?? 0;
        $elreceval->funda_has = $request->input('rec_funda_has') ?? 0;
        $elreceval->chaveta_has = $request->input('rec_chaveta_has') ?? 0;
        //
        $elreceval->otros = $request->input('rec_otros');
        $elreceval->detalles = $request->input('rec_detalles');
        $elreceval->save();

        $eltestineval = ElectricalEvaluationTestIn::where('eel_id', $eleval->id)->first();
        $eltestineval->motor_aisl_m = $request->input('testin_motor_aisl_m');
        $eltestineval->motor_nro_salidas = $request->input('testin_motor_nro_salidas');
        $eltestineval->motor_conexion = $request->input('testin_motor_conexion');
        $eltestineval->motor_volt_v = $request->input('testin_motor_volt_v');
        $eltestineval->motor_amp_a = $request->input('testin_motor_amp_a');
        $eltestineval->motor_rpm = $request->input('testin_motor_rpm');
        $eltestineval->motor_frec_hz = $request->input('testin_motor_frec_hz');
        $eltestineval->bajo_alistamiento = $request->input('testin_bajo_alistamiento');
        $eltestineval->directo_masa = $request->input('testin_directo_masa');
        $eltestineval->mayor_cienm = $request->input('testin_mayor_cienm');
        $eltestineval->er_aisl_m = $request->input('testin_er_aisl_m');
        $eltestineval->er_nro_salidas = $request->input('testin_er_nro_salidas');
        $eltestineval->er_conexion = $request->input('testin_er_conexion');
        $eltestineval->er_volt_v = $request->input('testin_er_volt_v');
        $eltestineval->er_amp_a = $request->input('testin_er_amp_a');
        $eltestineval->er_nro_polos = $request->input('testin_er_nro_polos');
        $eltestineval->save();

        $eltraneval = ElectricalEvaluationTransformer::where('eel_id', $eleval->id)->first();
        $eltraneval->tap = $tran_tap;
        $eltraneval->aisl_m = $request->input('tran_aisl_m');
        $eltraneval->nro_salidas = $request->input('tran_nro_salidas');
        $eltraneval->conexion = $request->input('tran_conexion');
        $eltraneval->volt_v = $request->input('tran_volt_v');
        $eltraneval->amp_a = $request->input('tran_amp_a');
        $eltraneval->nro_polos = $request->input('tran_nro_polos');
        $eltraneval->aisl_m_at_masa = $request->input('tran_aisl_m_at_masa');
        $eltraneval->st_masa = $request->input('tran_st_masa');
        $eltraneval->et_at = $request->input('tran_et_at');
        $eltraneval->grupo_conex = $request->input('tran_grupo_conex');
        $eltraneval->polaridad = $request->input('tran_polaridad');
        $eltraneval->relac_transf = $request->input('tran_relac_transf');
        $eltraneval->otp = $request->input('tran_otp');
        $eltraneval->tec = $request->input('tran_tec');
        $eltraneval->amp = $request->input('tran_amp');
        $eltraneval->rig_diel_aceite = $request->input('tran_rig_diel_aceite');
        $eltraneval->ruv = $request->input('tran_ruv');
        $eltraneval->rv_w = $request->input('tran_rv_w');
        $eltraneval->rw_u = $request->input('tran_rw_u');
        $eltraneval->ru_v = $request->input('tran_ru_v');
        $eltraneval->rv_u = $request->input('tran_rv_u');
        $eltraneval->ww = $request->input('tran_ww');
        $eltraneval->save();

        $works = $request->input('works');
        //$work_ids = array_column($works, 'id');
        //$update_works = ElectricalEvaluationWork::where('me_id', $eleval->id)->delete();
        $services = [];
        $date = \Carbon\Carbon::now()->toDateTimeString();
        foreach ($works as $key => $item) {
            if (isset($item['id'])) {
                $work = ElectricalEvaluationWork::find($item['id']);
                if (isset($item['status']) && $item['status'] == 0) {
                    $work->delete();
                } else {
                    $work->me_id = $eleval->id;
                    $work->service_id = isset($item['service_id']) ? $item['service_id'] : '';
                    $work->description = isset($item['description']) ? $item['description'] : '';
                    $work->medidas = isset($item['medidas']) ? $item['medidas'] : '';
                    $work->qty = isset($item['qty']) ? $item['qty'] : '';
                    $work->personal = isset($item['personal']) ? $item['personal'] : '';
                    $work->updated_at = $date;
                    $work->save();
                }
            } else {
                $services[$key]['me_id'] = $eleval->id;
                $services[$key]['service_id'] = isset($item['service_id']) ? $item['service_id'] : '';
                $services[$key]['description'] = isset($item['description']) ? $item['description'] : '';
                $services[$key]['medidas'] = isset($item['medidas']) ? $item['medidas'] : '';
                $services[$key]['qty'] = isset($item['qty']) ? $item['qty'] : '';
                $services[$key]['personal'] = isset($item['personal']) ? $item['personal'] : '';
                $services[$key]['created_at'] = $date;
                $services[$key]['updated_at'] = $date;
                ElectricalEvaluationWork::insert($services);
            }
        }

        // redirect
        \Session::flash('message', 'Successfully updated formato!');
        return redirect('formatos/electrical');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ElectricalEvaluation  $electricalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ElectricalEvaluation $electricalEvaluation)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'electrical']);
    }
}
