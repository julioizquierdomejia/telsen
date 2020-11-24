@extends('layouts.app', ['title' => 'Evaluación Mecánica'])
@section('content')
@php
$reception_list = [
array (
'name' => 'Placa Caract Orig',
'alias' => 'placa_caract_orig',
),
array (
'name' => 'Tapas',
'alias' => 'tapas',
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
'alias' => 'fundas',
),
array (
'name' => 'Chaveta',
'alias' => 'chaveta',
),
array (
'name' => 'Impro-seal',
'alias' => 'impro_seal',
),
array (
'name' => 'Laberintos',
'alias' => 'laberintos',
),
array (
'name' => 'Estator',
'alias' => 'estator',
)
];
@endphp
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Evaluación Mecánica</h5>
      </div>
      <div class="card-body">
        <form class="mb-2" method="POST" action="{{route('formatos.mechanical.store', ['id' => $ot->id])}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">Cliente</label>
              <input type="text" class="form-control" readonly="" value="{{$ot->razon_social}}">
            </div>
            <div class="col-6 col-md-3 mb-2">
              <label class="col-form-label">OT</label>
              <input type="text" class="form-control" readonly="" value="OT-{{zerosatleft($ot->id, 3)}}">
            </div>
            <div class="col-6 col-md-3 mb-2">
              <label class="col-form-label">Fecha de creación</label>
              <input type="date" class="form-control" disabled="" value="{{date('Y-m-d')}}">
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">Máquina</label>
              <input type="text" class="form-control @error('maquina') is-invalid @enderror" placeholder="Máquina" value="{{old('maquina')}}" name="maquina">
              @error('maquina')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">RPM</label>
              <input type="text" class="form-control @error('rpm') is-invalid @enderror" placeholder="RPM" value="{{old('rpm')}}" name="rpm">
              @error('rpm')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">Marca</label>
              <input type="text" class="form-control" readonly="" placeholder="Marca" value="{{$ot->marca}}">
            </div>
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">HP/KW</label>
              <input type="text" class="form-control @error('hp_kw') is-invalid @enderror" placeholder="HP/KW" value="{{old('hp_kw')}}" name="hp_kw">
              @error('hp_kw')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">Serie</label>
              <input type="text" class="form-control @error('serie') is-invalid @enderror" placeholder="Serie" value="{{old('serie')}}" name="serie">
              @error('serie')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">Solped</label>
              <input type="text" class="form-control" readonly="" placeholder="Solped" value="{{$ot->solped ?? '-'}}">
            </div>
            <div class="col-12">
              <h4 class="second-title text-danger py-2 d-flex justify-content-between align-items-center"><span>Estado de recepción</span> <span><button type="button" class="btn btn-yes btn-success btn-sm my-0 px-3">Sí</button><button type="button" class="btn btn-no btn-sm btn-danger my-0 px-3">No</button></span></h4>
            </div>
            @foreach($reception_list as $r_key => $item)
            <div class="col-6 col-md-4 col-lg-4 mb-2">
              <div class="row align-items-center">
                <div class="col-12 col-md-7">
                  <div class="row">
                    <label class="col-label mb-0 col-7 col-md-12">{{$item['name']}}</label>
                    <ul class="form-check-list list-inline mb-0 col-5 col-md-12 @error($item['alias']) is-invalid @enderror">
                      <li class="form-check-inline mx-0">
                        <label class="form-check-label mb-0">
                          <input type="radio" class="form-check-input mr-0 align-middle" value="1" name="{{$item['alias']}}_has" {{old($item['alias'].'_has') == "1" ? 'checked' : ''}} id="ec{{$r_key}}0"><span class="align-middle"> Sí</span>
                        </label>
                      </li>
                      <li class="form-check-inline mx-0 mx-1">
                        <label class="form-check-label mb-0">
                          <input type="radio" class="form-check-input mr-0 align-middle" value="0" name="{{$item['alias']}}_has" {{old($item['alias'].'_has') == "0" ? 'checked' : ''}} id="ec{{$r_key}}1"><span class="align-middle"> No</span>
                        </label>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col-12 col-md-5">
                  <input type="text" class="form-control mt-0 @error($item['alias']) is-invalid @enderror" placeholder="{{$item['name']}}" value="{{old($item['alias'])}}" name="{{$item['alias']}}">
                </div>
              </div>
              @error($item['alias'])
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            @endforeach
            <div class="col-12 mb-2">
              <label class="col-form-label">Otros</label>
              <input type="text" class="form-control @error('otros') is-invalid @enderror" placeholder="Otros" value="{{old('otros')}}" name="otros">
              @error('otros')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="row">
                <div class="col-6 col-md-4 col-lg-12 mb-2">
                  <label class="col-form-label">Slam (muelle) Pto 1</label>
                  <input type="text" class="form-control @error('slam_muelle_p1') is-invalid @enderror" placeholder="Slam (muelle) Pto 1" value="{{old('slam_muelle_p1')}}" name="slam_muelle_p1">
                  @error('slam_muelle_p1')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-6 col-md-4 col-lg-12 mb-2">
                  <label class="col-form-label">Slam (muelle) Pto 2</label>
                  <input type="text" class="form-control @error('slam_muelle_p2') is-invalid @enderror" placeholder="Slam (muelle) Pto 2" value="{{old('slam_muelle_p2')}}" name="slam_muelle_p2">
                  @error('slam_muelle_p2')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="row">
                <div class="col-6 col-md-4 col-lg-12 mb-2">
                  <label class="col-form-label">Resortes contra tapas</label>
                  <input type="text" class="form-control @error('resortes_contra_tapas') is-invalid @enderror" placeholder="Resortes contra tapas" value="{{old('resortes_contra_tapas')}}" name="resortes_contra_tapas">
                  @error('resortes_contra_tapas')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-6 col-md-4 col-lg-12 mb-2">
                  <label class="col-form-label">Alieneamiento paquete</label>
                  <input type="text" class="form-control @error('alineamiento_paquete') is-invalid @enderror" placeholder="Alieneamiento paquete" value="{{old('alineamiento_paquete')}}" name="alineamiento_paquete">
                  @error('alineamiento_paquete')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <h4 class="second-title text-danger py-2">ROTOR:</h4>
            </div>
            <div class="col-6 col-sm-6 mb-2">
              <label class="col-form-label">Deplexión de eje</label>
              <input type="text" class="form-control @error('rotor_deplexion_eje') is-invalid @enderror" placeholder="Deplexión de eje" value="{{old('rotor_deplexion_eje')}}" name="rotor_deplexion_eje">
              @error('rotor_deplexion_eje')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 mb-2">
              <label class="col-form-label">Valor balanceo</label>
              <input type="text" class="form-control @error('rotor_valor_balanceo') is-invalid @enderror" placeholder="Valor balanceo" value="{{old('rotor_valor_balanceo')}}" name="rotor_valor_balanceo">
              @error('rotor_valor_balanceo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-12">
              <div class="row">
                <div class="col-12 col-md-6 mb-2">
                  <label class="col-form-label">Cod rodaje Pto 1</label>
                  <input type="text" class="form-control @error('rotor_cod_rodaje_p1') is-invalid @enderror" placeholder="Cod rodaje Pto 1" value="{{old('rotor_cod_rodaje_p1')}}" name="rotor_cod_rodaje_p1">
                  @error('rotor_cod_rodaje_p1')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <label class="col-form-label">Asiento rodaje Pto 1 Ø</label>
                  <input type="text" class="form-control @error('rotor_asiento_rodaje_p1') is-invalid @enderror" placeholder="Asiento rodaje p1" value="{{old('rotor_asiento_rodaje_p1')}}" name="rotor_asiento_rodaje_p1">
                  @error('rotor_asiento_rodaje_p1')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="row">
                <div class="col-12 col-md-6 mb-2">
                  <label class="col-form-label">Cod rodaje Pto 2</label>
                  <input type="text" class="form-control @error('rotor_cod_rodaje_p2') is-invalid @enderror" placeholder="Cod rodaje Pto 2" value="{{old('rotor_cod_rodaje_p2')}}" name="rotor_cod_rodaje_p2">
                  @error('rotor_cod_rodaje_p2')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <label class="col-form-label">Asiento rodaje Pto 2 Ø</label>
                  <input type="text" class="form-control @error('rotor_asiento_rodaje_p2') is-invalid @enderror" placeholder="Asiento rodaje Pto 2" value="{{old('rotor_asiento_rodaje_p2')}}" name="rotor_asiento_rodaje_p2">
                  @error('rotor_asiento_rodaje_p2')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-6 col-lg-6 mb-2">
              <label class="col-form-label">Eje zona acople Pto 1</label>
              <input type="text" class="form-control @error('rotor_eje_zona_acople_p1') is-invalid @enderror" placeholder="Eje zona acople Pto 1" value="{{old('rotor_eje_zona_acople_p1')}}" name="rotor_eje_zona_acople_p1">
              @error('rotor_eje_zona_acople_p1')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-6 mb-2">
              <label class="col-form-label">Asiento de Ventilador Ø:</label>
              <input type="text" class="form-control @error('rotor_eje_zona_acople_p2') is-invalid @enderror" placeholder="Asiento de Ventilador 2" value="{{old('rotor_eje_zona_acople_p2')}}" name="rotor_eje_zona_acople_p2">
              @error('rotor_eje_zona_acople_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-12 col-md-6">
              <div class="row">
                <div class="col-12 mb-2">
                  <label class="col-form-label">Canal chaveta Pto 1</label>
                  <input type="text" class="form-control @error('rotor_canal_chaveta_p1') is-invalid @enderror" placeholder="Canal chaveta Pto 1" value="{{old('rotor_canal_chaveta_p1')}}" name="rotor_canal_chaveta_p1">
                  @error('rotor_medida_chaveta_p1')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 mb-2">
                  <label class="col-form-label">Canal chaveta Pto 2</label>
                  <input type="text" class="form-control @error('rotor_canal_chaveta_p2') is-invalid @enderror" placeholder="Canal chaveta Pto 2" value="{{old('rotor_canal_chaveta_p2')}}" name="rotor_canal_chaveta_p2">
                  @error('rotor_canal_chaveta_p2')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="row">
                <div class="col-12 mb-2">
                  <label class="col-form-label">Medida chaveta Pto 1</label>
                  <input type="text" class="form-control @error('rotor_medida_chaveta_p1') is-invalid @enderror" placeholder="Medida chaveta Pto 1" value="{{old('rotor_medida_chaveta_p1')}}" name="rotor_medida_chaveta_p1">
                  @error('rotor_medida_chaveta_p1')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 mb-2">
                  <label class="col-form-label">Medida chaveta Pto 2</label>
                  <input type="text" class="form-control @error('rotor_medida_chaveta_p2') is-invalid @enderror" placeholder="Medida chaveta Pto 2" value="{{old('rotor_medida_chaveta_p2')}}" name="rotor_medida_chaveta_p2">
                  @error('rotor_medida_chaveta_p2')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12">
              <h4 class="second-title text-danger py-2">Estator</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6">
              <div class="row">
                <div class="col-12 mb-2">
                  <label class="col-form-label">Alojamiento rodaje tapa Pto 10</label>
                  <input type="text" class="form-control @error('estator_alojamiento_rodaje_tapa_p10') is-invalid @enderror" placeholder="Alojamiento rodaje tapa p10" value="{{old('estator_alojamiento_rodaje_tapa_p10')}}" name="estator_alojamiento_rodaje_tapa_p10">
                  @error('estator_alojamiento_rodaje_tapa_p10')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 mb-2">
                  <label class="col-form-label">Alojamiento rodaje tapa Pto 20</label>
                  <input type="text" class="form-control @error('estator_alojamiento_rodaje_tapa_p20') is-invalid @enderror" placeholder="Alojamiento rodaje tapa p20" value="{{old('estator_alojamiento_rodaje_tapa_p20')}}" name="estator_alojamiento_rodaje_tapa_p20">
                  @error('estator_alojamiento_rodaje_tapa_p20')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="row">
                <div class="col-12 mb-2">
                  <label class="col-form-label">Pestana tapa Pto 1</label>
                  <input type="text" class="form-control @error('estator_pestana_tapa_p1') is-invalid @enderror" placeholder="Pestana tapa Pto 1" value="{{old('estator_pestana_tapa_p1')}}" name="estator_pestana_tapa_p1">
                  @error('estator_pestana_tapa_p1')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 mb-2">
                  <label class="col-form-label">Pestana tapa Pto 2</label>
                  <input type="text" class="form-control @error('estator_pestana_tapa_p2') is-invalid @enderror" placeholder="Pestana tapa Pto 2" value="{{old('estator_pestana_tapa_p2')}}" name="estator_pestana_tapa_p2">
                  @error('estator_pestana_tapa_p2')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-6 col-sm-6 mb-2">
              <div class="row">
                <div class="col-12 mb-2">
                  <label class="col-form-label">Contra tapa interna Pto 1</label>
                  <input type="text" class="form-control @error('estator_contra_tapa_interna_p1') is-invalid @enderror" placeholder="Contra tapa interna Pto 1" value="{{old('estator_contra_tapa_interna_p1')}}" name="estator_contra_tapa_interna_p1">
                  @error('estator_contra_tapa_interna_p1')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 mb-2">
                  <label class="col-form-label">Contra tapa interna Pto 2</label>
                  <input type="text" class="form-control @error('estator_contra_tapa_interna_p2') is-invalid @enderror" placeholder="Contra tapa interna Pto 2" value="{{old('estator_contra_tapa_interna_p2')}}" name="estator_contra_tapa_interna_p2">
                  @error('estator_contra_tapa_interna_p2')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
            <div class="col-6 col-sm-6 mb-2">
              <div class="row">
                <div class="col-12 mb-2">
                  <label class="col-form-label">Contra tapa externa Pto 1</label>
                  <input type="text" class="form-control @error('estator_contra_tapa_externa_p1') is-invalid @enderror" placeholder="Contra tapa externa Pto 1" value="{{old('estator_contra_tapa_externa_p1')}}" name="estator_contra_tapa_externa_p1">
                  @error('estator_contra_tapa_externa_p1')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 mb-2">
                  <label class="col-form-label">Contra tapa externa Pto 2</label>
                  <input type="text" class="form-control @error('estator_contra_tapa_externa_p2') is-invalid @enderror" placeholder="Contra tapa externa Pto 2" value="{{old('estator_contra_tapa_externa_p2')}}" name="estator_contra_tapa_externa_p2">
                  @error('estator_contra_tapa_externa_p2')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
              </div>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-6 col-sm-6 mb-2">
              <label class="col-form-label">Ventilador Ø</label>
              <input type="text" class="form-control @error('estator_ventilador_0') is-invalid @enderror" placeholder="Ventilador" value="{{old('estator_ventilador_0')}}" name="estator_ventilador_0">
              @error('estator_ventilador_0')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 mb-2">
              <label class="col-form-label">Alabes</label>
              <input type="text" class="form-control @error('estator_alabes') is-invalid @enderror" placeholder="Alabes" value="{{old('estator_alabes')}}" name="estator_alabes">
              @error('estator_alabes')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 mb-2">
              <label class="col-form-label">Caja de conexión</label>
              <input type="text" class="form-control @error('estator_caja_conexion') is-invalid @enderror" placeholder="Caja de conexión" value="{{old('estator_caja_conexion')}}" name="estator_caja_conexion">
              @error('estator_caja_conexion')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 mb-2">
              <label class="col-form-label">Tapa de caja de Conexión</label>
              <input type="text" class="form-control @error('estator_tapa_conexion') is-invalid @enderror" placeholder="Tapa de caja de Conexión" value="{{old('estator_tapa_conexion')}}" name="estator_tapa_conexion">
              @error('estator_tapa_conexion')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <hr>
          <div class="tap-section mb-2">
            <div class="table-responsive">
            <table class="table table-separate text-center table-numbering mb-0 @error('works') is-invalid @enderror" id="table-tap">
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
                @if($works = old('works'))
                @php
                  var_dump($works)
                @endphp
                @foreach($works as $key => $item)
                {{-- <tr>
                  <td class="cell-counter"><span class="number"></span></td>
                  <td>
                    <select class="dropdown2 form-control select-area" name="works[{{$key}}][area]" style="width: 100%">
                      <option value="">Seleccionar area</option>
                      @foreach($areas as $area)
                      <option value="{{$area->id}}" {{ (old('works')[$key]['area']) == $area->id ? 'selected' : '' }}>{{$area->name}}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <select class="dropdown2 form-control select-service" name="works[{{$key}}][service_id]" style="width: 100%"  disabled="">
                      <option value="">Seleccionar servicio</option>
                    </select>
                  </td>
                  <td width="120">
                    <input type="text" class="form-control
                    @error("works[{{$key}}][description]") is-invalid @enderror"
                    placeholder="Descripción" value="{{old('works')[$key]['description']}}" name="works[{{$key}}][description]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control @error("works[{{$key}}][medidas]") is-invalid @enderror" placeholder="Medida" value="{{old('works')[$key]['medidas']}}" name="works[{{$key}}][medidas]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control @error("works[{{$key}}][qty]") is-invalid @enderror" placeholder="Cantidad" value="{{old('works')[$key]['qty']}}" name="works[{{$key}}][qty]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control @error("works[{{$key}}][personal]") is-invalid @enderror" placeholder="Personal" value="{{old('works')[$key]['personal']}}" name="works[{{$key}}][personal]">
                  </td>
                </tr> --}}
                @endforeach
                @else
                <tr>
                  <td class="cell-counter"><span class="number"></span></td>
                  <td>
                    <select class="dropdown2 form-control select-area" name="works[0][area]" style="width: 100%">
                      <option value="">Seleccionar area</option>
                      @foreach($areas as $area)
                      <option value="{{$area->id}}">{{$area->name}}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <select class="dropdown2 form-control select-service" name="works[0][service_id]" style="width: 100%"  disabled="">
                      <option value="">Seleccionar servicio</option>
                    </select>
                  </td>
                  <td width="120">
                    <input type="text" class="form-control @error("works[0][description]") is-invalid @enderror" placeholder="Descripción" value="{{old('works')[0]["description"]}}" name="works[0][description]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control @error("works[0][medidas]") is-invalid @enderror" placeholder="Medida" value="{{old('works')[0]["medidas"]}}" name="works[0][medidas]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control @error("works[0][qty]") is-invalid @enderror" placeholder="Cantidad" value="{{old('works')[0]["qty"]}}" name="works[0][qty]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control @error("works[0][personal]") is-invalid @enderror" placeholder="Personal" value="{{old('works')[0]["personal"]}}" name="works[0][personal]">
                  </td>
                </tr>
                @endif
              </tbody>
              <tfoot class="buttons">
              <tr>
                <td class="p-0" colspan="7">
                  <button class="btn btn-dark btn-add-row btn-sm my-1" type="button">Agregar fila <i class="far ml-1 fa-plus"></i></button>
                  <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button">Remover fila <i class="far ml-1 fa-trash"></i></button>
                  <button class="btn btn-secondary btn-clear btn-sm my-1" type="button">Limpiar <i class="far ml-1 fa-eraser"></i></button>
                </td>
              </tr>
              </tfoot>
            </table>
            </div>
            @error('works')
            <p class="error-message text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-2">
            <label class="col-form-label">Observaciones</label>
            <textarea class="form-control @error('observaciones') is-invalid @enderror" placeholder="" name="observaciones">{{old('observaciones')}}</textarea>
            @error('observaciones')
            <p class="error-message text-danger">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="row">
          <div class="update ml-auto mr-auto">
            <button type="submit" class="btn btn-primary btn-round">Enviar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
@endsection
@section('javascript')
<script>
$(document).ready(function () {
/*function createJSON() {
var json = '{';
var otArr = [];
var tbl2 = $('#table-tap tbody tr').each(function(i) {
x = $(this).children();
var itArr = [];
x.each(function() {
if ($(this).find('.form-control').length) {
itArr.push('"' + $(this).find('.form-control').val() + '"');
}
});
otArr.push('"' + i + '": [' + itArr.join(',') + ']');
})
json += otArr.join(",") + '}'
$('input[name=works]').val(json);
return json;
}
$(document).on('keyup', '#table-tap .form-control', function () {
createJSON();
})*/
$(document).on('change', '.select-area', function () {
var $this = $(this), area = $this.val();
var service = $(this).parents('tr').find('.select-service');
if($(this).val().length) {
$.ajax({
type: "GET",
url: "/servicios/filterareas",
data: {id: area, _token:'{{csrf_token()}}'},
beforeSend: function() {
service.attr('disabled', true);
},
success: function (response) {
service.attr('disabled', false).focus();
service.find('option').remove();
if (response.success) {
var services = $.parseJSON(response.data), s_length = services.length;
if (services.length) {
$.each(services, function (id, item) {
service.append('<option value="'+item.id+'">'+item.name+'</option>');
})
}
}
},
error: function (request, status, error) {

}
});
} else {
service.attr('disabled', true);
}
})
$(document).on('click', '.card .btn-clear', function () {
$('#table-tap .form-control').val('');
})
$('.btn-add-row').click(function () {
var row_index = $('#table-tap tbody tr').length;
var row = `<tr>
<td class="cell-counter"><span class="number"></span></td>
<td>
  <select class="dropdown2 form-control select-area" name="works[`+row_index+`][area]" style="width: 100%">
    <option value="">Seleccionar area</option>
    @foreach($areas as $area)
    <option value="{{$area->id}}">{{$area->name}}</option>
    @endforeach
  </select>
</td>
<td>
  <select class="dropdown2 form-control select-service" name="works[`+row_index+`][service_id]" style="width: 100%"  disabled="">
    <option value="">Seleccionar servicio</option>
  </select>
</td>
<td width="120">
  <input type="text" class="form-control" placeholder="Descripción" value="" name="works[`+row_index+`][description]">
</td>
<td width="100">
  <input type="text" class="form-control" placeholder="Medida" value="" name="works[`+row_index+`][medidas]">
</td>
<td width="100">
  <input type="text" class="form-control" placeholder="Cantidad" value="" name="works[`+row_index+`][qty]">
</td>
<td width="100">
  <input type="text" class="form-control" placeholder="Personal" value="" name="works[`+row_index+`][personal]">
</td>
</tr>`;
$('#table-tap tbody').append(row);
$('#table-tap .dropdown2').select2();
//createJSON();
})
$('.btn-remove-row').click(function () {
var row_index = $('#table-tap tbody tr').length;
if (row_index > 1) {
$('#table-tap tbody tr:nth-child('+row_index+')').remove();
}
//createJSON();
})
$('.btn-yes').click(function () {
$('input[type="radio"][value="1"]').prop('checked', true);
})
$('.btn-no').click(function () {
$('input[type="radio"][value="0"]').prop('checked', true);
})
})
</script>
@endsection