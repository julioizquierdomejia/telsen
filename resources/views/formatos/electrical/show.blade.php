@extends('layouts.app', ['title' => 'Ver Evaluación Eléctrica'])
@section('content')
@php $data = $formato->toArray() @endphp
<div class="row">
     <div class="col-md-12">
      <div class="card form-card">
        <div class="card-header">
          <h4 class="card-title">Evaluación Eléctrica</h4>
        </div>
        <div class="card-body pb-3 pt-0">
          <h5 class="text-danger mt-4">Datos del Motor</h5>
          <div class="row">
            <div class="col-md-12 mb-2">
              <label class="c-label">Descripción del motor</label>
              <p class="mb-1">{{$formato->descripcion_motor}}</p>
            </div>
            <div class="col-6 col-md-3 mb-2">
              <label class="c-label">Código</label>
              <p class="mb-1">{{$formato->codigo_motor}}</p>
            </div>
            <div class="col-6 col-md-3 mb-2">
              <label class="c-label">Marca</label>
              <p class="mb-1">{{$formato->marca}}</p>
            </div>
            <div class="col-6 col-md-3 mb-2">
              <label class="c-label">Solped</label>
              <p class="mb-1">{{$formato->solped}}</p>
            </div>
            <div class="col-6 col-md-3 mb-2">
              <label class="c-label">Modelo</label>
              <p class="mb-1">{{$formato->modelo}}</p>
            </div>
          </div>
          
          <div class="row">
            <div class="col-6 col-md-3 mb-2">
              <label class="c-label">Numero de potencia</label>
              <p class="mb-1">{{$formato->numero_potencia}}</p>
            </div>
            <div class="col-6 col-md-3 mb-2">
              <label class="c-label">Medida de potencia</label>
              <p class="mb-1">{{$formato->medida_potencia}}</p>
            </div>
            <div class="col-6 col-md-3 mb-2">
              <label class="c-label">Voltaje</label>
              <p class="mb-1">{{$formato->voltaje}}</p>
            </div>
            <div class="col-6 col-md-3 mb-2">
              <label class="c-label">Velocidad</label>
              <p class="mb-1">{{$formato->velocidad}}</p>
            </div>
          </div>
          <h4 class="second-title text-danger py-2">Características del Equipo</h4>
          <div class="row pt-3">
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Recepcionado por:</label>
              <p class="mb-1">{{$formato->eq_recepcionado_por}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Potencia</label>
              <p class="mb-1">{{$formato->eq_potencia}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Conex:</label>
              <p class="mb-1">{{$formato->eq_conex}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Mod:</label>
              <p class="mb-1">{{$formato->eq_mod}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Voltaje:</label>
              <p class="mb-1">{{$formato->eq_voltaje}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">N° salida</label>
              <p class="mb-1">{{$formato->eq_n_salida}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Tipo:</label>
              <p class="mb-1">{{$formato->eq_tipo}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Amperaje:</label>
              <p class="mb-1">{{$formato->eq_amperaje}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Rod.l.a:</label>
              <p class="mb-1">{{$formato->eq_rodla}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">N° equipo:</label>
              <p class="mb-1">{{$formato->eq_nro_equipo}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Velocidad:</label>
              <p class="mb-1">{{$formato->eq_velocidad}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Rod.l.o.a:</label>
              <p class="mb-1">{{$formato->eq_rodloa}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Frame:</label>
              <p class="mb-1">{{$formato->eq_frame}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Frecuencia:</label>
              <p class="mb-1">{{$formato->eq_frecuencia}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Lub:</label>
              <p class="mb-1">{{$formato->eq_lub}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">F.S</label>
              <p class="mb-1">{{$formato->eq_fs}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Encl</label>
              <p class="mb-1">{{$formato->eq_encl}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Cos o:</label>
              <p class="mb-1">{{$formato->eq_cos_o}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Aisl. Clase:</label>
              <p class="mb-1">{{$formato->eq_aisl_clase}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Ef:</label>
              <p class="mb-1">{{$formato->eq_ef}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Cod:</label>
              <p class="mb-1">{{$formato->eq_cod}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Diseño NEMA:</label>
              <p class="mb-1">{{$formato->eq_diseno_nema}}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card form-card">
        <div class="card-header">
          <h4 class="second-title text-danger py-2">Características del redactor/bomba/ventilador u otros</h4>
        </div>
        <div class="card-body pb-3">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Marca:</label>
              <p class="mb-1">{{$formato->char_marca}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Potencia:</label>
              <p class="mb-1">{{$formato->char_potencia}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Escudos:</label>
              <p class="mb-1">{{$formato->char_escudos}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Mod</label>
              <p class="mb-1">{{$formato->char_mod}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Voltaje:</label>
              <p class="mb-1">{{$formato->char_voltaje}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Ejes</label>
              <p class="mb-1">{{$formato->char_ejes}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Amperaje:</label>
              <p class="mb-1">{{$formato->char_amperaje}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Funda:</label>
              <p class="mb-1">{{$formato->char_funda}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Frame:</label>
              <p class="mb-1">{{$formato->char_frame}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Velocidad:</label>
              <p class="mb-1">{{$formato->char_velocidad}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Acople:</label>
              <p class="mb-1">{{$formato->char_acople}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">F.S:</label>
              <p class="mb-1">{{$formato->char_fs}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Encl:</label>
              <p class="mb-1">{{$formato->char_encl}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Peso:</label>
              <p class="mb-1">{{$formato->char_peso}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Frecuencia:</label>
              <p class="mb-1">{{$formato->char_frecuencia}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Otros:</label>
              <p class="mb-1">{{$formato->char_otros}}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card form-card">
        <div class="card-header">
          <h4 class="second-title text-danger py-2">Estado en recepción</h4>
        </div>
        <div class="card-body pb-3">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Placa caract. Orig:</label>
              <p class="mb-1">{{$formato->rec_placa_caract_orig}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Escudos:</label>
              <p class="mb-1">{{$formato->rec_escudos}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Ventilador:</label>
              <p class="mb-1">{{$formato->rec_ventilador}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Caja de Conexión:</label>
              <p class="mb-1">{{$formato->rec_caja_conexion}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Ejes:</label>
              <p class="mb-1">{{$formato->rec_ejes}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Acople:</label>
              <p class="mb-1">{{$formato->rec_acople}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Bornera:</label>
              <p class="mb-1">{{$formato->rec_bornera}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Funda:</label>
              <p class="mb-1">{{$formato->rec_funda}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Chaveta:</label>
              <p class="mb-1">{{$formato->rec_chaveta}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Otros:</label>
              <p class="mb-1">{{$formato->rec_otros}}</p>
            </div>
            <div class="col-12">
              <label class="c-label">Detalles:</label>
              <p class="mb-1">{{$formato->rec_detalles}}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="card form-card">
        <div class="card-header">
          <h4 class="second-title text-danger py-2">Pruebas de Ingreso</h4>
        </div>
        <div class="card-body pb-3">
          <div class="row">
            <div class="col-md-6">
              <h4 class="second-title text-danger py-2">Motor</h4>
              <div class="row pt-3">
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">Aisl.(M):</label>
                  <p class="mb-1">{{$formato->testin_motor_aisl_m}}</p>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">N° salidas:</label>
                  <p class="mb-1">{{$formato->testin_motor_nro_salidas}}</p>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">Conexión:</label>
                  <p class="mb-1">{{$formato->testin_motor_conexion}}</p>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">Volt(v):</label>
                  <p class="mb-1">{{$formato->testin_motor_volt_v}}</p>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">Amp(A):</label>
                  <p class="mb-1">{{$formato->testin_motor_amp_a}}</p>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">RPM:</label>
                  <p class="mb-1">{{$formato->testin_motor_rpm}}</p>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">Frec.(HZ):</label>
                  <p class="mb-1">{{$formato->testin_motor_frec_hz}}</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="second-title text-danger py-2">Pruebas del estator/rotor</h4>
              <div class="row pt-3">
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">Aisl.(M):</label>
                  <p class="mb-1">{{$formato->motor_er_aisl_m}}</p>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">N° salidas:</label>
                  <p class="mb-1">{{$formato->motor_nro_salidas}}</p>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">Conexión:</label>
                  <p class="mb-1">{{$formato->motor_er_conexion}}</p>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">Volt(v):</label>
                  <p class="mb-1">{{$formato->motor_er_volt_v}}</p>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">Amp(A):</label>
                  <p class="mb-1">{{$formato->motor_er_amp_a}}</p>
                </div>
                <div class="col-sm-6 col-md-4 mb-2">
                  <label class="c-label">N° polos:</label>
                  <p class="mb-1">{{$formato->motor_er_nro_polos}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card form-card">
        <div class="card-header">
          <h4 class="second-title text-danger py-2">Transformador</h4>
        </div>
        <div class="card-body pb-3 pt-0">
          <hr>
          @if ($formato->tap)
          	@php
          	var_dump(json_decode(htmlspecialchars($formato->tap), true));
          	$tap_html = '';
          	$tap = json_decode(htmlspecialchars($formato->tap), true);
          	/*$tap_count = count((array)$tap);
          	for ($i=0; $i < $tap_count; $i++) { 
	            var_dump($tap[$i]);
	        }*/
          	@endphp
          @endif
          @php
          	
          @endphp
          <p class="mb-1">{{ $tap_html }}</p>
          <hr class="mt-0">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Aisl.(M):</label>
              <p class="mb-1">{{$formato->tran_aisl_m}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">N° salidas:</label>
              <p class="mb-1">{{$formato->nro_salidas}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Conexión:</label>
              <p class="mb-1">{{$formato->tran_conexion}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Volt(V):</label>
              <p class="mb-1">{{$formato->tran_volt_v}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Amp(A):</label>
              <p class="mb-1">{{$formato->tran_amp_a}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">N° polos:</label>
              <p class="mb-1">{{$formato->tran_nro_polos}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Aisl.(M): A.T.masa:</label>
              <p class="mb-1">{{$formato->tran_aisl_m_at_masa}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">S.T masa:</label>
              <p class="mb-1">{{$formato->tran_st_masa}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">E.T-A.T:</label>
              <p class="mb-1">{{$formato->tran_et_at}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Grupo conex:</label>
              <p class="mb-1">{{$formato->tran_grupo_conex}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Polaridad:</label>
              <p class="mb-1">{{$formato->tran_polaridad}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Relac. Transf:</label>
              <p class="mb-1">{{$formato->tran_relac_transf}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">o.t.p:</label>
              <p class="mb-1">{{$formato->tran_otp}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Tec:</label>
              <p class="mb-1">{{$formato->tran_tec}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Amp:</label>
              <p class="mb-1">{{$formato->tran_amp}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Rig. Diel. Aceite:</label>
              <p class="mb-1">{{$formato->tran_rig_diel_aceite}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">R.u.v:</label>
              <p class="mb-1">{{$formato->tran_ruv}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Rv-w:</label>
              <p class="mb-1">{{$formato->tran_rv_w}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Rw-u:</label>
              <p class="mb-1">{{$formato->tran_rw_u}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Ru-v:</label>
              <p class="mb-1">{{$formato->tran_ru_v}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Rv-u:</label>
              <p class="mb-1">{{$formato->tran_rv_u}}</p>
            </div>
            <div class="col-12 col-sm-6 col-md-3 mb-2">
              <label class="c-label">Ww:</label>
              <p class="mb-1">{{$formato->tran_ww}}</p>
            </div>
          </div>
        </div>
      </div>
     </div>
</div>
@endsection