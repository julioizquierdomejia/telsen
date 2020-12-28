@php
  $ot_code = zerosatleft($formato->ot_code, 3);
@endphp
@extends('layouts.app', ['title' => 'Evaluación Eléctrica de OT N° '.$ot_code])
@section('content')
@php
$statuses = array_column($ot_status->toArray(), "name");
$status_last = $ot_status->last();

$role_names = validateActionbyRole();
$admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
$evaluador = in_array("evaluador", $role_names);
$aprobador = in_array("aprobador_de_evaluaciones", $role_names);

$reception_list = [
  array (
    'name' => 'Placa Caract Orig',
    'alias' => 'placa_caract_orig',
  ),
  array (
    'name' => 'Escudos',
    'alias' => 'escudos',
  ),
  array (
    'name' => 'Ventilador',
    'alias' => 'ventilador',
  ),
  array (
    'name' => 'Caja de Conexión',
    'alias' => 'caja_conexion'
  ),
  array (
    'name' => 'Ejes',
    'alias' => 'ejes',
  ),
  array (
    'name' => 'Acople',
    'alias' => 'acople',
  ),
  array (
    'name' => 'Bornera',
    'alias' => 'bornera',
  ),
  array (
    'name' => 'Fundas',
    'alias' => 'funda',
  ),
  array (
    'name' => 'Chaveta',
    'alias' => 'chaveta',
  ),
  array (
    'name' => 'Cancamo',
    'alias' => 'cancamo',
  ),
  array (
    'name' => 'Base',
    'alias' => 'base',
  )
];
@endphp
<div class="row">
  <div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title d-flex align-items-center justify-content-between">
          <span>Evaluación Eléctrica</span>
          <span class="card-title-buttons">
          @if($admin || $evaluador)
            @if(!in_array('ee_approved', $statuses) && !in_array('ee_disapproved', $statuses))
            <a class="btn btn-orange btn-round" href="{{route('formatos.electrical.edit', $formato->id)}}">Editar <i class="fa fa-edit"></i></a>
            @endif
          @endif
          @if ($admin || $aprobador)
            @if(in_array('ee_approved', $statuses))
            <button type="button" class="btn btn-success mt-0">Aprobada</button>
            @elseif(in_array('ee_disapproved', $statuses))
            <button type="button" class="btn btn-danger mt-0">Desaprobada</button>
            @else
            <button type="button" class="btn btn-primary mt-0" data-toggle="modal" data-target="#modalAprobar">Aprobar</button>
            @endif
          @endif
          </span>
        </h4>
        @if($maded_by)
        <p class="mb-0 mt-2 py-2 bg-light row mx-0 justify-content-between">
          <span class="col-auto">Hecho por: {{ $maded_by->{'name'} }}</span>
          @if($approved_by)
            <span class="col-auto">{{in_array('ee_approved', $statuses) ? 'Aprobado por:' : 'Desaprobado por:'}} {{ $approved_by->{'name'} }}</span>
            @endif
        </p>
        @endif
      </div>
      <div class="card-body pb-3 pt-0">
        <h5 class="text-danger mt-4">Datos del Motor</h5>
        <div class="row">
          <div class="col-md-12 mb-2">
            <label class="c-label">Descripción del motor</label>
            <p class="mb-1">{{$formato->descripcion_motor ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="c-label">Código</label>
            <p class="mb-1">{{$formato->codigo_motor ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="c-label">Marca</label>
            <p class="mb-1">{{$formato->marca ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="c-label">Solped</label>
            <p class="mb-1">{{$formato->solped ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="c-label">Modelo</label>
            <p class="mb-1">{{$formato->modelo ?? '-'}}</p>
          </div>
        </div>
        
        <div class="row">
          <div class="col-6 col-md-3 mb-2">
            <label class="c-label">Numero de potencia</label>
            <p class="mb-1">{{$formato->numero_potencia ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="c-label">Medida de potencia</label>
            <p class="mb-1">{{$formato->medida_potencia ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="c-label">Voltaje</label>
            <p class="mb-1">{{$formato->ot_voltaje ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="c-label">Velocidad</label>
            <p class="mb-1">{{$formato->ot_velocidad ?? '-'}}</p>
          </div>
        </div>
        <h4 class="second-title text-danger py-2">Características del Equipo</h4>
        <div class="row pt-3">
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Recepcionado por:</label>
            <p class="mb-1">{{$formato->recepcionado_por ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Potencia</label>
            <p class="mb-1">{{$formato->potencia ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Conex:</label>
            <p class="mb-1">{{$formato->conex ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Mod:</label>
            <p class="mb-1">{{$formato->mod ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Voltaje:</label>
            <p class="mb-1">{{$formato->voltaje ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">N° salida</label>
            <p class="mb-1">{{$formato->nro_salida ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Tipo:</label>
            <p class="mb-1">{{$formato->tipo ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Amperaje:</label>
            <p class="mb-1">{{$formato->amperaje ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Rod.l.a:</label>
            <p class="mb-1">{{$formato->rodla ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">N° equipo:</label>
            <p class="mb-1">{{$formato->nro_equipo ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Velocidad:</label>
            <p class="mb-1">{{$formato->velocidad ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Rod.l.o.a:</label>
            <p class="mb-1">{{$formato->rodloa ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Frame:</label>
            <p class="mb-1">{{$formato->frame ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Frecuencia:</label>
            <p class="mb-1">{{$formato->frecuencia ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Lub:</label>
            <p class="mb-1">{{$formato->lub ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">F.S</label>
            <p class="mb-1">{{$formato->fs ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Encl</label>
            <p class="mb-1">{{$formato->encl ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">LF</label>
            <p class="mb-1">{{$formato->lf ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Cos o:</label>
            <p class="mb-1">{{$formato->cos_o ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Aisl. Clase:</label>
            <p class="mb-1">{{$formato->aisl_clase ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Ef:</label>
            <p class="mb-1">{{$formato->ef ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Cod:</label>
            <p class="mb-1">{{$formato->cod ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Diseño NEMA:</label>
            <p class="mb-1">{{$formato->diseno_nema ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">IP:</label>
            <p class="mb-1">{{$formato->ip ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Peso:</label>
            <p class="mb-1">{{$formato->peso ?? '-'}}</p>
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
            <p class="mb-1">{{$formato->char_marca ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Potencia:</label>
            <p class="mb-1">{{$formato->char_potencia ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Escudos:</label>
            <p class="mb-1">{{$formato->char_escudos ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Mod</label>
            <p class="mb-1">{{$formato->char_mod ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Voltaje:</label>
            <p class="mb-1">{{$formato->char_voltaje ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Ejes</label>
            <p class="mb-1">{{$formato->char_ejes ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Amperaje:</label>
            <p class="mb-1">{{$formato->char_amperaje ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Funda:</label>
            <p class="mb-1">{{$formato->char_funda ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Frame:</label>
            <p class="mb-1">{{$formato->char_frame ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Velocidad:</label>
            <p class="mb-1">{{$formato->char_velocidad ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Acople:</label>
            <p class="mb-1">{{$formato->char_acople ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">F.S:</label>
            <p class="mb-1">{{$formato->char_fs ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Encl:</label>
            <p class="mb-1">{{$formato->char_encl ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Peso:</label>
            <p class="mb-1">{{$formato->char_peso ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Frecuencia:</label>
            <p class="mb-1">{{$formato->char_frecuencia ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Otros:</label>
            <p class="mb-1">{{$formato->char_otros ?? '-'}}</p>
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
          @foreach($reception_list as $r_key => $item)
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">{{ $item['name'] }}:</label>
            <p class="mb-1"><span class="badge align-middle mr-2 px-3 py-1{{$formato->{'rec_'.$item['alias'].'_has'} == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->{'rec_'.$item['alias'].'_has'} == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{ $formato->{'rec_'.$item['alias'] } ?? '-'}}</span></p>
          </div>
          @endforeach
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Otros:</label>
            <p class="mb-1">{{$formato->rec_otros ?? '-'}}</p>
          </div>
          <div class="col-12">
            <label class="c-label">Detalles:</label>
            <p class="mb-1">{{$formato->rec_detalles ?? '-'}}</p>
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
                <p class="mb-1">{{$formato->motor_aisl_m ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">N° salidas:</label>
                <p class="mb-1">{{$formato->motor_nro_salidas ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">Conexión:</label>
                <p class="mb-1">{{$formato->motor_conexion ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">Volt(v):</label>
                <p class="mb-1">{{$formato->motor_volt_v ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">Amp(A):</label>
                <p class="mb-1">{{$formato->motor_amp_a ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">RPM:</label>
                <p class="mb-1">{{$formato->motor_rpm ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">Frec.(HZ):</label>
                <p class="mb-1">{{$formato->motor_frec_hz ?? '-'}}</p>
              </div>

              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">Bajo de alistamiento:</label>
                <p class="mb-1">{{$formato->bajo_alistamiento ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">Directo a masa:</label>
                <p class="mb-1">{{$formato->directo_masa ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">Mayor 100mΩ:</label>
                <p class="mb-1">{{$formato->mayor_cienm ?? '-'}}</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <h4 class="second-title text-danger py-2">Pruebas del estator/rotor</h4>
            <div class="row pt-3">
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">Aisl.(M):</label>
                <p class="mb-1">{{$formato->er_aisl_m ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">N° salidas:</label>
                <p class="mb-1">{{$formato->er_nro_salidas ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">Conexión:</label>
                <p class="mb-1">{{$formato->er_conexion ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">Volt(v):</label>
                <p class="mb-1">{{$formato->er_volt_v ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">Amp(A):</label>
                <p class="mb-1">{{$formato->er_amp_a ?? '-'}}</p>
              </div>
              <div class="col-sm-6 col-md-4 mb-2">
                <label class="c-label">N° polos:</label>
                <p class="mb-1">{{$formato->er_nro_polos ?? '-'}}</p>
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
        @if ($taps = $formato->taps)
        <div class="table-responsive">
          <table class="table table-tap table-separate text-center table-numbering mb-0" id="table-tap">
            <thead>
              <tr>
                <th class="text-center py-1" colspan="7">Tap</th>
              </tr>
              <tr>
                <th class="py-1">N°</th>
                <th class="py-1">U-V</th>
                <th class="py-1">U-V</th>
                <th class="py-1">V-U</th>
                <th class="py-1">V-U</th>
                <th class="py-1">W-U</th>
                <th class="py-1">W-U</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($taps as $tap)
              <tr>
                <td class="cell-counter"><span class="number"></span></td>
                <td><p class="mb-0">{{$tap->uv1 ?? '-'}}</p></td>
                <td><p class="mb-0">{{$tap->uv2 ?? '-'}}</p></td>
                <td><p class="mb-0">{{$tap->vu1 ?? '-'}}</p></td>
                <td><p class="mb-0">{{$tap->vu2 ?? '-'}}</p></td>
                <td><p class="mb-0">{{$tap->wu1 ?? '-'}}</p></td>
                <td><p class="mb-0">{{$tap->wu2 ?? '-'}}</p></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
        <hr class="mt-0">
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Aisl.(M):</label>
            <p class="mb-1">{{$formato->tran_aisl_m}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">N° salidas:</label>
            <p class="mb-1">{{$formato->tran_nro_salidas ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Conexión:</label>
            <p class="mb-1">{{$formato->tran_conexion ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Volt(V):</label>
            <p class="mb-1">{{$formato->tran_volt_v ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Amp(A):</label>
            <p class="mb-1">{{$formato->tran_amp_a ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">N° polos:</label>
            <p class="mb-1">{{$formato->tran_nro_polos ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Aisl.(M): A.T.masa:</label>
            <p class="mb-1">{{$formato->tran_aisl_m_at_masa ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">S.T masa:</label>
            <p class="mb-1">{{$formato->tran_st_masa ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">E.T-A.T:</label>
            <p class="mb-1">{{$formato->tran_et_at ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Grupo conex:</label>
            <p class="mb-1">{{$formato->tran_grupo_conex ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Polaridad:</label>
            <p class="mb-1">{{$formato->tran_polaridad ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Relac. Transf:</label>
            <p class="mb-1">{{$formato->tran_relac_transf ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">o.t.p:</label>
            <p class="mb-1">{{$formato->tran_otp ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Tec:</label>
            <p class="mb-1">{{$formato->tran_tec ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Amp:</label>
            <p class="mb-1">{{$formato->tran_amp ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Rig. Diel. Aceite:</label>
            <p class="mb-1">{{$formato->tran_rig_diel_aceite ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">R.u.v:</label>
            <p class="mb-1">{{$formato->tran_ruv ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Rv-w:</label>
            <p class="mb-1">{{$formato->tran_rv_w ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Rw-u:</label>
            <p class="mb-1">{{$formato->tran_rw_u ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Ru-v:</label>
            <p class="mb-1">{{$formato->tran_ru_v ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Rv-u:</label>
            <p class="mb-1">{{$formato->tran_rv_u ?? '-'}}</p>
          </div>
          <div class="col-12 col-sm-6 col-md-3 mb-2">
            <label class="c-label">Ww:</label>
            <p class="mb-1">{{$formato->tran_ww ?? '-'}}</p>
          </div>
        </div>
        <div class="table-responsive">
              <table class="table table-separate text-center table-numbering mb-0 @error('works') is-invalid @enderror" id="table-works">
                <thead>
                  <tr>
                    <th class="text-center py-1" colspan="7">Trabajos</th>
                  </tr>
                  <tr>
                  <th class="text-center py-1">Item</th>
                  <th class="text-center py-1">Área</th>
                  <th class="text-center py-1">Tarea</th>
                  <th class="text-center py-1">Descripción</th>
                  <th class="text-center py-1">Medidas</th>
                  <th class="text-center py-1">Cantidad</th>
                  <th class="text-center py-1">Personal</th>
                </tr>
                </thead>
                <tbody>
                  @if($works->count())
                  @foreach($works as $key => $work)
                  <tr>
                    <td class="cell-counter"><span class="number"></span></td>
                  <td><span class="form-control mt-0 h-100">{{$work->area}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$work->service}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$work->description}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$work->medidas}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$work->qty}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$work->personal}}</span></td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td class="text-center" colspan="7">No se agregaron trabajos</td>
                  </tr>
                  @endif
                </tbody>
              </table>
              </div>
      </div>
    </div>
    <div class="card form-card">
      <div class="card-header">
        <h4 class="second-title text-danger py-2">Galería</h4>
      </div>
      <div class="card-body">
          <div class="gallery">
            @if($gallery->count())
            <ul class="row list-unstyled">
            @foreach($gallery as $file)
            <li class="gallery-item col-12 col-md-4 col-xl-3 py-2">
              <img class="btn p-0" data-toggle="modal" data-target="#galleryModal" src="{{ asset("uploads/ots/$formato->ot_id/electrical/$file->name") }}" width="250">
            </li>
            @endforeach
            </ul>
            @else
            <p class="text-center">No se agregaron imágenes.</p>
            @endif
          </div>
      </div>
    </div>
  </div>
</div>
@if(!in_array('ee_approved', $statuses) || !in_array('ee_disapproved', $statuses))
<div class="modal fade" tabindex="-1" id="modalAprobar">
    <div class="modal-dialog confirmar_eval">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Aprobar Evaluación Eléctrica</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
            <p class="text-center my-3">¿Confirma aprobación de evaluación eléctrica  para OT-{{$ot_code}}?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-primary btn-sm px-md-5" data-action="1">Aprobar</button>
          <button type="button" class="btn btn-secondary btn-sm px-md-5" data-action="2">No Aprobar</button>
        </div>
    </div>
  </div>
</div>
@endif
<div class="modal fade" tabindex="-1" id="galleryModal">
    <div class="modal-dialog modal-lg" style="max-height: calc(100vh - 40px)">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Galería</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body h-100 text-center">
            <img class="image img-fluid" src="" width="600" style="width: auto;">
        </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $(document).ready(function () {
    $('.confirmar_eval .btn').click(function () {
      var action = $(this).data('action');
      $.ajax({
          type: "post",
          url: "{{route('formatos.electrical.approve', $formato->ot_id)}}",
          data: {
            _token: '{{csrf_token()}}',
            action: action
          },
          beforeSend: function (data) {
            
          },
          success: function (response) {
            if(response.success) {
              $('#modalAprobar').modal('hide');
              setTimeout(function () {
                location.reload();
              }, 200)
            } else if(response.data) {
              $('.confirmar_eval .btn').attr('disabled', true);
            }
          },
          error: function (request, status, error) {
            var data = jQuery.parseJSON(request.responseText);
            console.log(data);
          }
      });
    })

    $('#galleryModal').on('show.bs.modal', function (event) {
      $('#galleryModal .modal-body .image').attr('src', $(event.relatedTarget).attr('src'))
    })
  })
</script>
@endsection