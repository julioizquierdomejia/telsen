<?php

namespace App\Http\Controllers;

use App\Models\MechanicalEvaluation;
use App\Models\Ot;
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
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $formatos = Ot::join('status_ot', 'status_ot.ot_id', '=', 'status_ot.ot_id')
                        ->join('clients', 'clients.id', '=', 'ots.client_id')
                        ->select('ots.*', 'clients.razon_social')
                        ->where('ots.enabled', 1)
                        ->where('clients.enabled', 1)
                        ->where('status_ot.status_id', 1)
                        ->groupBy('ots.id')
                        ->get();
        return view('formatos.mechanical.index', compact('formatos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $ots = Ot::where('enabled', 1)->get();

        return view('formatos.mechanical.create', compact('ots'));
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

        $meval = new MechanicalEvaluation();
        
        $meval->client_id = $request->input('client_id');
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
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $formato = Client::findOrFail($id);

        return view('formatos.mechanical.show', compact('formato'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MechanicalEvaluation  $mechanicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);

        $modelo = MechanicalEvaluation::findOrFail($id);
        return view('formatos.mechanical.edit', compact('modelo'));
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
        $request->user()->authorizeRoles(['superadmin', 'admin']);
        
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'description'      => 'required',
            'enabled'      => 'boolean',
        );

        $rules = array(
            'client_id' => 'required',
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
            return redirect('formato/mechanical/' . $id . '/editar')
                ->withErrors($validator);
        } else {
            // store
            $meval = MechanicalEvaluation::find($id);

            $meval->client_id = $request->input('client_id');
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
            return redirect('formato/mechanical');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MechanicalEvaluation  $mechanicalEvaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MechanicalEvaluation $mechanicalEvaluation)
    {
        $request->user()->authorizeRoles(['superadmin', 'admin']);
    }
}
