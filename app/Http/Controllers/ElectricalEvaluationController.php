<?php

namespace App\Http\Controllers;

use App\Models\ElectricalEvaluation;
use App\Models\ElectricalEvaluationCharacteristic;
use App\Models\ElectricalEvaluationReception;
use App\Models\ElectricalEvaluationTestIn;
use App\Models\ElectricalEvaluationTransformer;
use App\Models\Ot;
use App\Models\MotorBrand;
use App\Models\MotorModel;
use App\Models\Status;
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

        $ot = Ot::where('enabled', 1)->where('id', $id)->firstOrFail();
        $marcas = MotorBrand::where('enabled', 1)->get();
        $modelos = MotorModel::where('enabled', 1)->get();

        return view('formatos.electrical.evaluate', compact('ot', 'marcas', 'modelos'));
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
            'eq_potencia' => 'required',
            'eq_conex' => 'required',
            'eq_voltaje' => 'required',

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

            'eq_nro_salida' => 'string|nullable',
            'eq_tipo' => 'string|nullable',
            'eq_amperaje' => 'required|string',
            'eq_rodla' => 'string|nullable',
            'eq_nro_equipo' => 'string|nullable',
            'eq_velocidad' => 'required|string',
            'eq_rodloa' => 'string|nullable',
            'eq_frame' => 'string|nullable',
            'eq_frecuencia' => 'required|string',
            'eq_lub' => 'string|nullable',
            'eq_fs' => 'string|nullable',
            'eq_encl' => 'string|nullable',
            'eq_cos_o' => 'string|nullable',
            'eq_aisl_clase' => 'string|nullable',
            'eq_ef' => 'string|nullable',
            'eq_cod' => 'string|nullable',
            'eq_diseno_nema' => 'string|nullable',

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

            'testin_motor_aisl_m' => 'string|nullable',
            'testin_motor_nro_salidas' => 'string|nullable',
            'testin_motor_conexion' => 'string|nullable',
            'testin_motor_volt_v' => 'string|nullable',
            'testin_motor_amp_a' => 'string|nullable',
            'testin_motor_rpm' => 'string|nullable',
            'testin_motor_frec_hz' => 'string|nullable',
            'testin_er_aisl_m' => 'string|nullable',
            'testin_er_nro_salidas' => 'string|nullable',
            'testin_er_conexion' => 'string|nullable',
            'testin_er_volt_v' => 'string|nullable',
            'testin_er_amp_a' => 'string|nullable',
            'testin_er_nro_polos' => 'string|nullable',

            'tran_tap' => 'string|nullable',
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
        $ot->voltaje = $request->get('voltaje');
        $ot->velocidad = $request->get('velocidad');
        $ot->save();

        $eleval = new ElectricalEvaluation();
        $eleval->ot_id = $id;
        //$eleval->solped = $request->input('eq_solped');
        $eleval->recepcionado_por = $request->input('eq_recepcionado_por');
        $eleval->potencia = $request->input('eq_potencia');
        $eleval->conex = $request->input('eq_conex');
        $eleval->mod = $request->input('eq_mod');
        $eleval->voltaje = $request->input('eq_voltaje');
        $eleval->nro_salida = $request->input('eq_nro_salida');
        $eleval->tipo = $request->input('eq_tipo');
        $eleval->amperaje = $request->input('eq_amperaje');
        $eleval->rodla = $request->input('eq_rodla');
        $eleval->nro_equipo = $request->input('eq_nro_equipo');
        $eleval->velocidad = $request->input('eq_velocidad');
        $eleval->rodloa = $request->input('eq_rodloa');
        $eleval->frame = $request->input('eq_frame');
        $eleval->frecuencia = $request->input('eq_frecuencia');
        $eleval->lub = $request->input('eq_lub');
        $eleval->fs = $request->input('eq_fs');
        $eleval->encl = $request->input('eq_encl');
        $eleval->cos_o = $request->input('eq_cos_o');
        $eleval->aisl_clase = $request->input('eq_aisl_clase');
        $eleval->ef = $request->input('eq_ef');
        $eleval->cod = $request->input('eq_cod');
        $eleval->diseno_nema = $request->input('eq_diseno_nema');
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
        $eltestineval->er_aisl_m = $request->input('testin_er_aisl_m');
        $eltestineval->er_nro_salidas = $request->input('testin_er_nro_salidas');
        $eltestineval->er_conexion = $request->input('testin_er_conexion');
        $eltestineval->er_volt_v = $request->input('testin_er_volt_v');
        $eltestineval->er_amp_a = $request->input('testin_er_amp_a');
        $eltestineval->er_nro_polos = $request->input('testin_er_nro_polos');
        $eltestineval->save();

        $eltraneval = new ElectricalEvaluationTransformer();
        $eltraneval->eel_id = $eleval['id'];
        $eltraneval->tap = $request->input('tran_tap');
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

    public function format_show(Request $request, $ot_id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin', 'electrical']);

        $formato = ElectricalEvaluation::
                    join('ots', 'ots.id', '=', 'electrical_evaluations.ot_id')
                    ->join('motor_brands', 'motor_brands.id', '=', 'ots.marca_id')
                    ->join('motor_models', 'motor_models.id', '=', 'ots.marca_id')
                    ->join('electrical_evaluations as ev', 'ev.ot_id', '=', 'ots.id')
                    ->join('eval_electrical_transformer as eet', 'eet.eel_id', '=', 'ev.id')
                    ->select('electrical_evaluations.*', 'ots.descripcion_motor', 'ots.codigo_motor', 'ots.numero_potencia', 'ots.medida_potencia', 'ots.voltaje', 'ots.velocidad', 'ots.solped', 'motor_brands.name as marca', 'motor_models.name as modelo', 'eet.tap')
                    ->where('ev.ot_id', $ot_id)->firstOrFail();

        return view('formatos.electrical.show', compact('formato'));
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

        $formato = ElectricalEvaluation::findOrFail($id);
        return view('formatos.electrical.edit', compact('formato'));
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
            'ot_id' => 'required',
            'eq_potencia' => 'required',
            'eq_conex' => 'required',
            'eq_voltaje' => 'required',

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

            'eq_nro_salida' => 'string|nullable',
            'eq_tipo' => 'string|nullable',
            'eq_amperaje' => 'required|string',
            'eq_rodla' => 'string|nullable',
            'eq_nro_equipo' => 'string|nullable',
            'eq_velocidad' => 'required|string',
            'eq_rodloa' => 'string|nullable',
            'eq_frame' => 'string|nullable',
            'eq_frecuencia' => 'required|string',
            'eq_lub' => 'string|nullable',
            'eq_fs' => 'string|nullable',
            'eq_encl' => 'string|nullable',
            'eq_cos_o' => 'string|nullable',
            'eq_aisl_clase' => 'string|nullable',
            'eq_ef' => 'string|nullable',
            'eq_cod' => 'string|nullable',
            'eq_diseno_nema' => 'string|nullable',

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

            'testin_motor_aisl_m' => 'string|nullable',
            'testin_motor_nro_salidas' => 'string|nullable',
            'testin_motor_conexion' => 'string|nullable',
            'testin_motor_volt_v' => 'string|nullable',
            'testin_motor_amp_a' => 'string|nullable',
            'testin_motor_rpm' => 'string|nullable',
            'testin_motor_frec_hz' => 'string|nullable',
            'testin_er_aisl_m' => 'string|nullable',
            'testin_er_nro_salidas' => 'string|nullable',
            'testin_er_conexion' => 'string|nullable',
            'testin_er_volt_v' => 'string|nullable',
            'testin_er_amp_a' => 'string|nullable',
            'testin_er_nro_polos' => 'string|nullable',

            'tran_tap' => 'string|nullable',
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

        // update
        $meval = ElectricalEvaluation::findOrFail($id);

        $meval->ot_id = $request->input('ot_id');
        $meval->rpm = $request->input('rpm');
        $meval->hp_kw = $request->input('hp_kw');
        $meval->serie = $request->input('serie');
        //$meval->solped = $request->input('solped');
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
        $meval->works = $request->input('trabajos');

        $meval->save();

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
