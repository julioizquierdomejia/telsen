<?php

namespace App\Http\Controllers;

use App\Models\ElectricalEvaluation;
use App\Models\ElectricalEvaluationCharacteristic;
use App\Models\ElectricalEvaluationReception;
use App\Models\ElectricalEvaluationTestIn;
use App\Models\ElectricalEvaluationTransformer;
use App\Models\Ot;
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
        $request->user()->authorizeRoles(['superadmin', 'admin']);

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
            $last = $ot_status->last();
            if ($last && $last->status_id == 1) {
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
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $ot = Ot::where('enabled', 1)->where('id', $id)->firstOrFail();

        return view('formatos.electrical.evaluate', compact('ot'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'ot_id' => 'required',
            'potencia' => 'required',
            'conex' => 'required',
            'voltaje' => 'required',
        );

        $validator = $this->validate($request, $rules);

        // store
        $eleval = new ElectricalEvaluation();
        $elcheval = new ElectricalEvaluationCharacteristic();
        $elreceval = new ElectricalEvaluationReception();
        $eltestineval = new ElectricalEvaluationTestIn();
        $eltraneval = new ElectricalEvaluationTransformer();

        //$eleval->ot_id = $eleval->input('ot_id');
        $eleval->solped = $request->input('solped');
        $eleval->recepcionado_por = $request->input('recepcionado_por');
        $eleval->marca = //$request->input('marca');
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
        $eleval->cos_o = $request->input('cos_o');
        $eleval->aisl_clase = $request->input('aisl_clase');
        $eleval->ef = $request->input('ef');
        $eleval->cod = $request->input('cod');
        $eleval->diseno_nema = $request->input('diseno_nema');
        $eleval->save();

        $elcheval->eel_id = $request->input('eel_id');
        $elcheval->marca = $request->input('marca');
        $elcheval->potencia = $request->input('potencia');
        $elcheval->escudos = $request->input('escudos');
        $elcheval->mod = $request->input('mod');
        $elcheval->voltaje = $request->input('voltaje');
        $elcheval->ejes = $request->input('ejes');
        $elcheval->nro = $request->input('nro');
        $elcheval->amperaje = $request->input('amperaje');
        $elcheval->funda = $request->input('funda');
        $elcheval->frame = $request->input('frame');
        $elcheval->velocidad = $request->input('velocidad');
        $elcheval->acople = $request->input('acople');
        $elcheval->fs = $request->input('fs');
        $elcheval->encl = $request->input('encl');
        $elcheval->peso = $request->input('peso');
        $elcheval->frecuencia = $request->input('frecuencia');
        $elcheval->otros = $request->input('otros');
        $elcheval->save();

        $elreceval->eel_id = $request->input('eel_id');
        $elreceval->placa_caract_orig = $request->input('placa_caract_orig');
        $elreceval->escudos = $request->input('escudos');
        $elreceval->ventilador = $request->input('ventilador');
        $elreceval->caja_conexion = $request->input('caja_conexion');
        $elreceval->ejes = $request->input('ejes');
        $elreceval->acople = $request->input('acople');
        $elreceval->bornera = $request->input('bornera');
        $elreceval->funda = $request->input('funda');
        $elreceval->chaveta = $request->input('chaveta');
        $elreceval->otros = $request->input('otros');
        $elreceval->detalles = $request->input('detalles');
        $elreceval->save();

        $eltestineval->eel_id = $request->input('eel_id');
        $eltestineval->motor = //$request->input('motor');
        $eltestineval->motor_aisl_m = $request->input('motor_aisl_m');
        $eltestineval->motor_nro_salidas = $request->input('motor_nro_salidas');
        $eltestineval->motor_conexion = $request->input('motor_conexion');
        $eltestineval->motor_volt_v = $request->input('motor_volt_v');
        $eltestineval->motor_amp_a = $request->input('motor_amp_a');
        $eltestineval->motor_rpm = $request->input('motor_rpm');
        $eltestineval->motor_frec_hz = $request->input('motor_frec_hz');
        $eltestineval->er_aisl_m = $request->input('er_aisl_m');
        $eltestineval->er_nro_salidas = $request->input('er_nro_salidas');
        $eltestineval->er_conexion = $request->input('er_conexion');
        $eltestineval->er_volt_v = $request->input('er_volt_v');
        $eltestineval->er_amp_a = $request->input('er_amp_a');
        $eltestineval->er_nro_polos = $request->input('er_nro_polos');
        $eltestineval->save();

        $eltraneval->eel_id = $request->input('eel_id');
        $eltraneval->tap = $request->input('tap');
        $eltraneval->aisl_m = $request->input('aisl_m');
        $eltraneval->nro_salidas = $request->input('nro_salidas');
        $eltraneval->conexion = $request->input('conexion');
        $eltraneval->volt_v = $request->input('volt_v');
        $eltraneval->amp_a = $request->input('amp_a');
        $eltraneval->nro_polos = $request->input('nro_polos');
        $eltraneval->aisl_m_at_masa = $request->input('aisl_m_at_masa');
        $eltraneval->st_masa = $request->input('st_masa');
        $eltraneval->et_at = $request->input('et_at');
        $eltraneval->grupo_conex = $request->input('grupo_conex');
        $eltraneval->polaridad = $request->input('polaridad');
        $eltraneval->relac_transf = $request->input('relac_transf');
        $eltraneval->otp = $request->input('otp');
        $eltraneval->tec = $request->input('tec');
        $eltraneval->amp = $request->input('amp');
        $eltraneval->rig_diel_aceite = $request->input('rig_diel_aceite');
        $eltraneval->ruv = $request->input('ruv');
        $eltraneval->rv_w = $request->input('rv_w');
        $eltraneval->rw_u = $request->input('rw_u');
        $eltraneval->ru_v = $request->input('ru_v');
        $eltraneval->rv_u = $request->input('rv_u');
        $eltraneval->ww = $request->input('ww');
        $eltraneval->save();

        $status = Status::where('id', 3)->first();
        if ($status) {
            \DB::table('status_ot')->insert([
                'status_id' => $status->id,
                'ot_id' => $eleval->id,
            ]);
        }

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
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $formato = Client::findOrFail($id);

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
        $request->user()->authorizeRoles(['superadmin', 'admin']);

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
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation

        $rules = array(
            'ot_id' => 'required',

            'rpm' => 'required',
            'hp_kw' => 'required',

            /*'serie' => 'required',
            'solped' => 'required',
            'placa_caract_orig' => 'required',
            'tapas' => 'required',
            'ventilador' => 'required',
            'caja_conexion' => 'required',
            'ejes' => 'required',
            'acople' => 'required',
            'bornera' => 'required',
            'fundas' => 'required',
            'chaveta' => 'required',
            'impro_seal' => 'required',
            'laberintos' => 'required',
            'estator' => 'required',

            'slam_muelle_p1' => 'required',
            'slam_muelle_p2' => 'required',
            'resortes_contra_tapas' => 'required',
            'alineamiento_paquete' => 'required',

            'rotor_deplexion_eje' => 'required',
            'rotor_valor_balanceo' => 'required',
            'rotor_cod_rodaje_p1' => 'required',
            'rotor_cod_rodaje_p2' => 'required',
            'rotor_asiento_rodaje_p1' => 'required',
            'rotor_asiento_rodaje_p2' => 'required',
            'rotor_eje_zona_acople_p1' => 'required',
            'rotor_eje_zona_acople_p2' => 'required',
            'rotor_medida_chaveta_p1' => 'required',
            'rotor_medida_chaveta_p2' => 'required',

            'estator_alojamiento_rodaje_tapa_p10' => 'required',
            'estator_alojamiento_rodaje_tapa_p20' => 'required',
            'estator_pestana_tapa_p1' => 'required',
            'estator_pestana_tapa_p2' => 'required',

            'estator_contra_tapa_interna_p1' => 'required',
            'estator_contra_tapa_interna_p2' => 'required',
            'estator_contra_tapa_externa_p1' => 'required',
            'estator_contra_tapa_externa_p2' => 'required',
            'estator_ventilador_0' => 'required',
            'estator_alabes' => 'required',
            'estator_caja_conexion' => 'required',
            'estator_tapa_conexion' => 'required',

            'observaciones' => 'required',

            'works' => 'required'*/
        );

        $validator = \Validator::make($request->all(), $rules);

        // process the login
        if ($validator->fails()) {
            return redirect('formatos/electrical/' . $id . '/editar')
                ->withErrors($validator);
        } else {
            // store
            $meval = ElectricalEvaluation::find($id);

            $meval->ot_id = $request->input('ot_id');

            $meval->rpm = $request->input('rpm');
            $meval->hp_kw = $request->input('hp_kw');

            $meval->serie = $request->input('serie');
            $meval->solped = $request->input('solped');
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

            $meval->works = $request->input('works');

            $meval->save();

            // redirect
            \Session::flash('message', 'Successfully updated formato!');
            return redirect('formatos/electrical');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ElectricalEvaluation  $electricalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ElectricalEvaluation $electricalEvaluation)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
