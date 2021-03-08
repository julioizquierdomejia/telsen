@php
  $ot_code = zerosatleft($formato->ot_code, 3);
@endphp
@extends('layouts.app_real', ['title' => 'Evaluación Mecánica de OT N° '.$ot_code])
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dropzone/dropzone.min.css') }}" />
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
        <h5 class="card-title d-flex align-items-center justify-content-between">
          <span>Editar Evaluación Mecánica</span>
          <button class="btn btn-light btnAddComment" data-otid="{{$formato->ot_id}}" data-otcode="{{$ot_code}}" type="button"><i class="fa fa-comments"></i></button>
        </h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="{{route('formatos.mechanical.edit', ['id' => $formato->id])}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">Cliente</label>
              <input type="text" class="form-control" readonly="" value="{{$ot->razon_social}}">
            </div>
            <div class="col-6 col-md-3 mb-2">
              <label class="col-form-label">OT</label>
              <input type="text" class="form-control" readonly="" value="OT-{{$ot_code}}">
            </div>
            <div class="col-6 col-md-3 mb-2">
              <label class="col-form-label">Fecha de creación</label>
              <input type="date" class="form-control" disabled="" value="{{date('Y-m-d', strtotime($formato->created_at))}}">
            </div>
            </div>
            <hr>
            <div class="row">
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">Máquina</label>
              <input type="text" class="form-control @error('maquina') is-invalid @enderror" placeholder="Máquina" value="{{old('maquina', $formato->maquina)}}" name="maquina">
              @error('maquina')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">RPM</label>
              <input type="text" class="form-control @error('rpm') is-invalid @enderror" placeholder="RPM" value="{{old('rpm', $formato->rpm)}}" name="rpm">
              @error('rpm')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">Marca</label>
              <input type="text" class="form-control" readonly="" placeholder="Marca" value="{{$ot->marca ? $ot->marca->name : ''}}">
            </div>
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">HP/KW</label>
              <input type="text" class="form-control @error('hp_kw') is-invalid @enderror" placeholder="HP/KW" value="{{old('hp_kw', $formato->hp_kw)}}" name="hp_kw">
              @error('hp_kw')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">Operario</label>{{-- pidieron cambiar serie por operario --}}
              <input type="text" class="form-control @error('serie') is-invalid @enderror" placeholder="Serie" value="{{old('serie', $formato->serie)}}" name="serie">
              @error('serie')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-6 mb-2">
              <label class="col-form-label">Solped</label>
              <input type="text" class="form-control" readonly="" placeholder="Solped" value="{{$ot->solped}}">
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
                        <input type="radio" class="form-check-input mr-0 align-middle" value="1" name="{{$item['alias']}}_has" {{old($item['alias'].'_has', $formato->{$item['alias'].'_has'}) == "1" ? 'checked' : ''}} id="ec{{$r_key}}0"><span class="align-middle"> Sí</span>
                      </label>
                    </li>
                    <li class="form-check-inline mx-0 mx-1">
                      <label class="form-check-label mb-0">
                        <input type="radio" class="form-check-input mr-0 align-middle" value="0" name="{{$item['alias']}}_has" {{old($item['alias'].'_has', $formato->{$item['alias'].'_has'}) == "0" ? 'checked' : ''}} id="ec{{$r_key}}1"><span class="align-middle"> No</span>
                      </label>
                    </li>
                  </ul>
                  </div>
                  </div>
                <div class="col-12 col-md-5">
                <input type="text" class="form-control mt-0 @error($item['alias']) is-invalid @enderror" placeholder="{{$item['name']}}" value="{{old($item['alias'], $formato->{$item['alias']})}}" name="{{$item['alias']}}">
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
              <label class="col-form-label">Slam (muelle) p1</label>
              <input type="text" class="form-control @error('slam_muelle_p1') is-invalid @enderror" placeholder="Slam (muelle) p1" value="{{old('slam_muelle_p1', $formato->slam_muelle_p1)}}" name="slam_muelle_p1">
              @error('slam_muelle_p1')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-12 mb-2">
              <label class="col-form-label">Slam (muelle) p2</label>
              <input type="text" class="form-control @error('slam_muelle_p2') is-invalid @enderror" placeholder="Slam (muelle) p2" value="{{old('slam_muelle_p2', $formato->slam_muelle_p2)}}" name="slam_muelle_p2">
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
              <input type="text" class="form-control @error('resortes_contra_tapas') is-invalid @enderror" placeholder="Resortes contra tapas" value="{{old('resortes_contra_tapas', $formato->resortes_contra_tapas)}}" name="resortes_contra_tapas">
              @error('resortes_contra_tapas')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-12 mb-2">
              <label class="col-form-label">Alieneamiento paquete</label>
              <input type="text" class="form-control @error('alineamiento_paquete') is-invalid @enderror" placeholder="Alieneamiento paquete" value="{{old('alineamiento_paquete', $formato->alineamiento_paquete)}}" name="alineamiento_paquete">
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
              <label class="col-form-label">Deplexion eje</label>
              <input type="text" class="form-control @error('rotor_deplexion_eje') is-invalid @enderror" placeholder="Deplexion eje" value="{{old('rotor_deplexion_eje', $formato->rotor_deplexion_eje)}}" name="rotor_deplexion_eje">
              @error('rotor_deplexion_eje')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 mb-2">
              <label class="col-form-label">Valor balanceo</label>
              <input type="text" class="form-control @error('rotor_valor_balanceo') is-invalid @enderror" placeholder="Valor balanceo" value="{{old('rotor_valor_balanceo', $formato->rotor_valor_balanceo)}}" name="rotor_valor_balanceo">
              @error('rotor_valor_balanceo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-12">
              <div class="row">
                <div class="col-12 col-md-6 mb-2">
                <label class="col-form-label">Cod rodaje Pto 1</label>
                <select class="dropdown2 form-control" name="rotor_cod_rodaje_p1" style="width: 100%">
                      <option value="">Seleccionar código</option>
                      @foreach($cod_rodaje_p1 as $item)
                      <option value="{{$item->id}}" {{$formato->rotor_cod_rodaje_p1 == $item->id ? 'selected' : ''}} data-asiento="{{$item->asiento_rodaje}}" data-alojamiento="{{$item->alojamiento_rodaje}}" {{ old('rotor_cod_rodaje_p1', $item['item']) == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                      @endforeach
                    </select>
                @error('rotor_cod_rodaje_p1')
                <p class="error-message text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="col-12 col-md-3 mb-2">
                <label class="col-form-label">Asiento rodaje Pto 1 Ø</label>
                <input type="text" class="form-control @error('rotor_asiento_rodaje_p1') is-invalid @enderror" placeholder="Asiento rodaje p1" value="{{old('rotor_asiento_rodaje_p1', $formato->rotor_asiento_rodaje_p1)}}" name="rotor_asiento_rodaje_p1">
                @error('rotor_asiento_rodaje_p1')
                <p class="error-message text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="col-12 col-md-3"><input class="form-control mt-2 asiento-rodaje-pto1" placeholder="Ø" value="Ø" disabled=""></div>
              </div>
            </div>
            <div class="col-12">
              <div class="row">
                <div class="col-12 col-md-6 mb-2">
              <label class="col-form-label">Cod rodaje Pto 2</label>
              <select class="dropdown2 form-control" name="rotor_cod_rodaje_p2" style="width: 100%">
                      <option value="">Seleccionar código</option>
                      @foreach($cod_rodaje_p2 as $item)
                      <option value="{{$item->id}}" {{$formato->rotor_cod_rodaje_p2 == $item->id ? 'selected' : ''}} data-asiento="{{$item->asiento_rodaje}}" data-alojamiento="{{$item->alojamiento_rodaje}}" {{ old('rotor_cod_rodaje_p2', $item['item']) == $item->id ? 'selected' : '' }}>{{$item->name}}</option>
                      @endforeach
                    </select>
              @error('rotor_cod_rodaje_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-12 col-md-3 mb-2">
              <label class="col-form-label">Asiento rodaje Pto 2 Ø</label>
              <input type="text" class="form-control @error('rotor_asiento_rodaje_p2') is-invalid @enderror" placeholder="Asiento rodaje Pto 2" value="{{old('rotor_asiento_rodaje_p2', $formato->rotor_asiento_rodaje_p2)}}" name="rotor_asiento_rodaje_p2">
              @error('rotor_asiento_rodaje_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-12 col-md-3"><input class="form-control mt-2 asiento-rodaje-pto2" placeholder="Ø" value="Ø" disabled=""></div>
              </div>
            </div>
            <div class="col-6 col-sm-6 col-lg-6 mb-2">
              <label class="col-form-label">Eje zona acople Pto 1</label>
              <input type="text" class="form-control @error('rotor_eje_zona_acople_p1') is-invalid @enderror" placeholder="Eje zona acople Pto 1" value="{{old('rotor_eje_zona_acople_p1', $formato->rotor_eje_zona_acople_p1)}}" name="rotor_eje_zona_acople_p1">
              @error('rotor_eje_zona_acople_p1')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-6 mb-2">
              <label class="col-form-label">Asiento de Ventilador Ø:</label>
              <input type="text" class="form-control @error('rotor_eje_zona_acople_p2') is-invalid @enderror" placeholder="Asiento de Ventilador 2" value="{{old('rotor_eje_zona_acople_p2', $formato->rotor_eje_zona_acople_p2)}}" name="rotor_eje_zona_acople_p2">
              @error('rotor_eje_zona_acople_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-12 col-md-6">
              <div class="row">
                <div class="col-12 mb-2">
                <label class="col-form-label">Canal chaveta Pto 1</label>
                <input type="text" class="form-control @error('rotor_canal_chaveta_p1') is-invalid @enderror" placeholder="Canal chaveta Pto 1" value="{{old('rotor_canal_chaveta_p1', $formato->rotor_canal_chaveta_p1)}}" name="rotor_canal_chaveta_p1">
                @error('rotor_medida_chaveta_p1')
                <p class="error-message text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="col-12 mb-2">
                <label class="col-form-label">Canal chaveta Pto 2</label>
                <input type="text" class="form-control @error('rotor_canal_chaveta_p2') is-invalid @enderror" placeholder="Canal chaveta Pto 2" value="{{old('rotor_canal_chaveta_p2', $formato->rotor_canal_chaveta_p2)}}" name="rotor_canal_chaveta_p2">
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
                <input type="text" class="form-control @error('rotor_medida_chaveta_p1') is-invalid @enderror" placeholder="Medida chaveta Pto 1" value="{{old('rotor_medida_chaveta_p1', $formato->rotor_medida_chaveta_p1)}}" name="rotor_medida_chaveta_p1">
                @error('rotor_medida_chaveta_p1')
                <p class="error-message text-danger">{{ $message }}</p>
                @enderror
              </div>
              <div class="col-12 mb-2">
                <label class="col-form-label">Medida chaveta Pto 2</label>
                <input type="text" class="form-control @error('rotor_medida_chaveta_p2') is-invalid @enderror" placeholder="Medida chaveta Pto 2" value="{{old('rotor_medida_chaveta_p2', $formato->rotor_medida_chaveta_p2)}}" name="rotor_medida_chaveta_p2">
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
                <div class="col-12 col-md-6 mb-2">
                  <label class="col-form-label">Alojamiento rodaje tapa Pto 1Ø</label>
                  <input type="text" class="form-control @error('estator_alojamiento_rodaje_tapa_p10') is-invalid @enderror" placeholder="Alojamiento rodaje tapa p1Ø" value="{{old('estator_alojamiento_rodaje_tapa_p10', $formato->estator_alojamiento_rodaje_tapa_p10)}}" name="estator_alojamiento_rodaje_tapa_p10">
                  @error('estator_alojamiento_rodaje_tapa_p10')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <input type="text" class="form-control mt-2 alojamiento-tapa-pto1" placeholder="Ø" value="Ø" disabled="">
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <label class="col-form-label">Alojamiento rodaje tapa Pto 2Ø</label>
                  <input type="text" class="form-control @error('estator_alojamiento_rodaje_tapa_p20') is-invalid @enderror" placeholder="Alojamiento rodaje tapa p2Ø" value="{{old('estator_alojamiento_rodaje_tapa_p20', $formato->estator_alojamiento_rodaje_tapa_p20)}}" name="estator_alojamiento_rodaje_tapa_p20">
                  @error('estator_alojamiento_rodaje_tapa_p20')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 col-md-6 mb-2">
                  <input type="text" class="form-control mt-2 alojamiento-tapa-pto2" placeholder="Ø" value="Ø" disabled="">
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="row">
                <div class="col-12 mb-2">
                  <label class="col-form-label">Pestana tapa Pto 1</label>
                  <input type="text" class="form-control @error('estator_pestana_tapa_p1') is-invalid @enderror" placeholder="Pestana tapa Pto 1" value="{{old('estator_pestana_tapa_p1', $formato->estator_pestana_tapa_p1)}}" name="estator_pestana_tapa_p1">
                  @error('estator_pestana_tapa_p1')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 mb-2">
                  <label class="col-form-label">Pestana tapa Pto 2</label>
                  <input type="text" class="form-control @error('estator_pestana_tapa_p2') is-invalid @enderror" placeholder="Pestana tapa Pto 2" value="{{old('estator_pestana_tapa_p2', $formato->estator_pestana_tapa_p2)}}" name="estator_pestana_tapa_p2">
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
                  <input type="text" class="form-control @error('estator_contra_tapa_interna_p1') is-invalid @enderror" placeholder="Contra tapa interna Pto 1" value="{{old('estator_contra_tapa_interna_p1', $formato->estator_contra_tapa_interna_p1)}}" name="estator_contra_tapa_interna_p1">
                  @error('estator_contra_tapa_interna_p1')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 mb-2">
                  <label class="col-form-label">Contra tapa interna Pto 2</label>
                  <input type="text" class="form-control @error('estator_contra_tapa_interna_p2') is-invalid @enderror" placeholder="Contra tapa interna Pto 2" value="{{old('estator_contra_tapa_interna_p2', $formato->estator_contra_tapa_interna_p2)}}" name="estator_contra_tapa_interna_p2">
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
                  <input type="text" class="form-control @error('estator_contra_tapa_externa_p1') is-invalid @enderror" placeholder="Contra tapa externa Pto 1" value="{{old('estator_contra_tapa_externa_p1', $formato->estator_contra_tapa_externa_p1)}}" name="estator_contra_tapa_externa_p1">
                  @error('estator_contra_tapa_externa_p1')
                  <p class="error-message text-danger">{{ $message }}</p>
                  @enderror
                </div>
                <div class="col-12 mb-2">
                  <label class="col-form-label">Contra tapa externa Pto 2</label>
                  <input type="text" class="form-control @error('estator_contra_tapa_externa_p2') is-invalid @enderror" placeholder="Contra tapa externa Pto 2" value="{{old('estator_contra_tapa_externa_p2', $formato->estator_contra_tapa_externa_p2)}}" name="estator_contra_tapa_externa_p2">
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
              <input type="text" class="form-control @error('estator_ventilador_0') is-invalid @enderror" placeholder="Ventilador" value="{{old('estator_ventilador_0', $formato->estator_ventilador_0)}}" name="estator_ventilador_0">
              @error('estator_ventilador_0')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 mb-2">
              <label class="col-form-label">Alabes</label>
              <input type="text" class="form-control @error('estator_alabes') is-invalid @enderror" placeholder="Alabes" value="{{old('estator_alabes', $formato->estator_alabes)}}" name="estator_alabes">
              @error('estator_alabes')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 mb-2">
              <label class="col-form-label">Caja de conexión</label>
              <input type="text" class="form-control @error('estator_caja_conexion') is-invalid @enderror" placeholder="Caja de conexión" value="{{old('estator_caja_conexion', $formato->estator_caja_conexion)}}" name="estator_caja_conexion">
              @error('estator_caja_conexion')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 mb-2">
              <label class="col-form-label">Tapa de caja de Conexión</label>
              <input type="text" class="form-control @error('estator_tapa_conexion') is-invalid @enderror" placeholder="Tapa de caja de Conexión" value="{{old('estator_tapa_conexion', $formato->estator_tapa_conexion)}}" name="estator_tapa_conexion">
              @error('estator_tapa_conexion')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <hr>
            <div class="works-section mb-2">
              <h4 class="h6 text-center mb-0"><strong>Trabajos</strong></h4>
              <div class="table-responsive">
              <table class="table table-tap table-separate text-center table-numbering mb-0 @error('works') is-invalid @enderror" id="table-works">
                <thead>
                  <tr>
                  <th class="text-center py-1">Item</th>
                  <th class="text-center py-1">Área</th>
                  <th class="text-center py-1">Tarea</th>
                  <th class="text-center py-1">Descripción</th>
                  <th class="text-center py-1">Medidas</th>
                  <th class="text-center py-1">Cantidad</th>
                  <th class="text-center py-1">Personal</th>
                  <th class="text-center py-1"></th>
                </tr>
                </thead>
                <tbody>
                  @if($old_works = old('works'))
                  @foreach($old_works as $key => $item)
                  <tr>
                    <td class="cell-counter">
                      <span class="number"></span>
                      <input type="hidden" name="works[{{$key}}][id]" value="{{old('works.'.$key.'.id')}}">
                      <input type="hidden" name="works[{{$key}}][type]" value="mechanical">
                      <input class="work_status" type="hidden" name="works[{{$key}}][status]" value="{{old('works.'.$key.'.status')}}">
                    </td>
                    <td>
                      <select class="dropdown2 form-control select-area" name="works[{{$key}}][area]" style="width: 100%">
                        <option value="">Seleccionar area</option>
                        @foreach($areas as $area)
                        <option value="{{$area->id}}" {{ old('works.'.$key.'.area') == $area->id ? 'selected' : '' }}>{{$area->name}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="dropdown2 form-control select-service" data-value="{{old('works.'.$key.'.service_id')}}" name="works[{{$key}}][service_id]" style="width: 100%"  disabled="">
                        <option value="">Seleccionar servicio</option>
                      </select>
                    </td>
                    <td width="120">
                      <input type="text" class="form-control mt-0 @error("works.".$key.".description") is-invalid @enderror" placeholder="Descripción" value="{{old('works.'.$key.'.description')}}" name="works[{{$key}}][description]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.".$key.".medidas") is-invalid @enderror" placeholder="Medida" value="{{old('works.'.$key.'.medidas')}}" name="works[{{$key}}][medidas]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.".$key.".qty") is-invalid @enderror" placeholder="Cantidad" value="{{old('works.'.$key.'.qty')}}" name="works[{{$key}}][qty]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.".$key.".personal") is-invalid @enderror" placeholder="Personal" value="{{old('works.'.$key.'.personal')}}" name="works[{{$key}}][personal]">
                    </td>
                    <td>
                      <button class="btn btn-secondary btn-remove-row btn-sm my-1" data-table="works" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                    </td>
                  </tr>
                  @endforeach
                  @elseif($works->count())
                  @foreach($works as $key => $item)
                  <tr>
                    <td class="cell-counter">
                      <span class="number"></span>
                      <input type="hidden" name="works[{{$key}}][id]" value="{{$item['id']}}">
                      <input type="hidden" name="works[{{$key}}][type]" value="mechanical">
                      <input class="work_status" type="hidden" name="works[{{$key}}][status]" value="1">
                    </td>
                    <td>
                      <select class="dropdown2 form-control select-area" name="works[{{$key}}][area]" style="width: 100%">
                        <option value="">Seleccionar area</option>
                        @foreach($areas as $area)
                        <option value="{{$area->id}}" {{ $item['area_id'] == $area->id ? 'selected' : '' }}>{{$area->name}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="dropdown2 form-control select-service" data-value="{{ $item['service_id'] }}" name="works[{{$key}}][service_id]" style="width: 100%"  disabled="">
                        <option value="">Seleccionar servicio</option>
                      </select>
                    </td>
                    <td width="120">
                      <input type="text" class="form-control mt-0 @error("works.".$key.".description") is-invalid @enderror" placeholder="Descripción" value="{{$item['description']}}" name="works[{{$key}}][description]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.".$key.".medidas") is-invalid @enderror" placeholder="Medida" value="{{ $item['medidas'] }}" name="works[{{$key}}][medidas]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.".$key.".qty") is-invalid @enderror" placeholder="Cantidad" value="{{ $item['qty'] }}" name="works[{{$key}}][qty]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.".$key.".personal") is-invalid @enderror" placeholder="Personal" value="{{$item['personal']}}" name="works[{{$key}}][personal]">
                    </td>
                    <td>
                      <button class="btn btn-secondary btn-remove-row btn-sm my-1" data-table="works" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td class="cell-counter"><span class="number"></span></td>
                    <td>
                      <input type="hidden" name="works[0][type]" value="mechanical">
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
                      <input type="text" class="form-control mt-0 @error("works.0.description") is-invalid @enderror" placeholder="Descripción" value="{{old('works.0.description')}}" name="works[0][description]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.0.medidas") is-invalid @enderror" placeholder="Medida" value="{{old('works.0.medidas')}}" name="works[0][medidas]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.0.qty") is-invalid @enderror" placeholder="Cantidad" value="{{old('works.0.qty')}}" name="works[0][qty]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.0.personal") is-invalid @enderror" placeholder="Personal" value="{{old('works.0.personal')}}" name="works[0][personal]">
                    </td>
                    <td>
                      <button class="btn btn-secondary btn-remove-row btn-sm my-1" data-table="works" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                    </td>
                  </tr>
                  @endif
                </tbody>
              </table>
              </div>
              <div class="buttons text-center">
                  <button class="btn btn-dark btn-add-row btn-sm my-1" data-table="works" data-work_type="mechanical" type="button">Agregar fila <i class="far ml-1 fa-plus"></i></button>
                  <button class="btn btn-secondary btn-clear btn-sm my-1" data-table="works" type="button">Limpiar <i class="far ml-1 fa-eraser"></i></button>
              </div>
            </div>
            <div class="addworks-section mb-2">
              <h4 class="h6 text-center mb-0"><strong>Trabajos Adicionales</strong></h4>
              <div class="table-responsive">
              <table class="table table-tap table-separate text-center table-numbering mb-0 @error('additional_works') is-invalid @enderror" id="table-additional_works">
                <thead>
                  <tr>
                  <th class="text-center py-1">Item</th>
                  <th class="text-center py-1">Área</th>
                  <th class="text-center py-1">Tarea</th>
                  <th class="text-center py-1">Descripción</th>
                  <th class="text-center py-1">Medidas</th>
                  <th class="text-center py-1">Cantidad</th>
                  <th class="text-center py-1">Personal</th>
                  <th class="text-center py-1"></th>
                </tr>
                </thead>
                <tbody>
                  @if($additional_old_works = old('additional_works'))
                  @foreach($additional_old_works as $key => $item)
                  <tr>
                    <td class="cell-counter">
                      <span class="number"></span>
                      <input type="hidden" name="additional_works[{{$key}}][id]" value="{{old('additional_works.'.$key.'.id')}}">
                      <input type="hidden" name="additional_works[{{$key}}][type]" value="mechanical">
                      <input class="work_status" type="hidden" name="additional_works[{{$key}}][status]" value="{{old('additional_works.'.$key.'.status')}}">
                    </td>
                    <td>
                      <select class="dropdown2 form-control select-area" name="additional_works[{{$key}}][area]" style="width: 100%">
                        <option value="">Seleccionar area</option>
                        @foreach($areas as $area)
                        <option value="{{$area->id}}" {{ old('additional_works.'.$key.'.area') == $area->id ? 'selected' : '' }}>{{$area->name}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="dropdown2 form-control select-service" data-value="{{old('additional_works.'.$key.'.service_id')}}" name="additional_works[{{$key}}][service_id]" style="width: 100%"  disabled="">
                        <option value="">Seleccionar servicio</option>
                      </select>
                    </td>
                    <td width="120">
                      <input type="text" class="form-control mt-0 @error("additional_works.".$key.".description") is-invalid @enderror" placeholder="Descripción" value="{{old('additional_works.'.$key.'.description')}}" name="additional_works[{{$key}}][description]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("additional_works.".$key.".medidas") is-invalid @enderror" placeholder="Medida" value="{{old('additional_works.'.$key.'.medidas')}}" name="additional_works[{{$key}}][medidas]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("additional_works.".$key.".qty") is-invalid @enderror" placeholder="Cantidad" value="{{old('additional_works.'.$key.'.qty')}}" name="additional_works[{{$key}}][qty]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("additional_works.".$key.".personal") is-invalid @enderror" placeholder="Personal" value="{{old('additional_works.'.$key.'.personal')}}" name="additional_works[{{$key}}][personal]">
                    </td>
                    <td>
                      <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                    </td>
                  </tr>
                  @endforeach
                  @elseif($additional_works->count())
                  @foreach($additional_works as $key => $item)
                  <tr>
                    <td class="cell-counter">
                      <span class="number"></span>
                      <input type="hidden" name="additional_works[{{$key}}][id]" value="{{$item['id']}}">
                      <input type="hidden" name="additional_works[{{$key}}][type]" value="add_mechanical">
                      <input class="work_status" type="hidden" name="additional_works[{{$key}}][status]" value="1">
                    </td>
                    <td>
                      <select class="dropdown2 form-control select-area" name="additional_works[{{$key}}][area]" style="width: 100%">
                        <option value="">Seleccionar area</option>
                        @foreach($areas as $area)
                        <option value="{{$area->id}}" {{ $item['area_id'] == $area->id ? 'selected' : '' }}>{{$area->name}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="dropdown2 form-control select-service" data-value="{{ $item['service_id'] }}" name="additional_works[{{$key}}][service_id]" style="width: 100%"  disabled="">
                        <option value="">Seleccionar servicio</option>
                      </select>
                    </td>
                    <td width="120">
                      <input type="text" class="form-control mt-0 @error("additional_works.".$key.".description") is-invalid @enderror" placeholder="Descripción" value="{{$item['description']}}" name="additional_works[{{$key}}][description]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("additional_works.".$key.".medidas") is-invalid @enderror" placeholder="Medida" value="{{ $item['medidas'] }}" name="additional_works[{{$key}}][medidas]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("additional_works.".$key.".qty") is-invalid @enderror" placeholder="Cantidad" value="{{ $item['qty'] }}" name="additional_works[{{$key}}][qty]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("additional_works.".$key.".personal") is-invalid @enderror" placeholder="Personal" value="{{$item['personal']}}" name="additional_works[{{$key}}][personal]">
                    </td>
                    <td>
                      <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                    </td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td class="cell-counter"><span class="number"></span></td>
                    <td>
                      <input type="hidden" name="additional_works[0][type]" value="mechanical">
                      <select class="dropdown2 form-control select-area" name="additional_works[0][area]" style="width: 100%">
                        <option value="">Seleccionar area</option>
                        @foreach($areas as $area)
                        <option value="{{$area->id}}">{{$area->name}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="dropdown2 form-control select-service" name="additional_works[0][service_id]" style="width: 100%"  disabled="">
                        <option value="">Seleccionar servicio</option>
                      </select>
                    </td>
                    <td width="120">
                      <input type="text" class="form-control mt-0 @error("additional_works.0.description") is-invalid @enderror" placeholder="Descripción" value="{{old('additional_works.0.description')}}" name="additional_works[0][description]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("additional_works.0.medidas") is-invalid @enderror" placeholder="Medida" value="{{old('additional_works.0.medidas')}}" name="additional_works[0][medidas]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("additional_works.0.qty") is-invalid @enderror" placeholder="Cantidad" value="{{old('additional_works.0.qty')}}" name="additional_works[0][qty]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("additional_works.0.personal") is-invalid @enderror" placeholder="Personal" value="{{old('additional_works.0.personal')}}" name="additional_works[0][personal]">
                    </td>
                    <td>
                      <button class="btn btn-secondary btn-remove-row btn-sm my-1" data-table="additional_works" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                    </td>
                  </tr>
                  @endif
                </tbody>
              </table>
              </div>
              <div class="buttons text-center">
                  <button class="btn btn-dark btn-add-row btn-sm my-1" data-table="additional_works" data-work_type="add_mechanical" type="button">Agregar fila <i class="far ml-1 fa-plus"></i></button>
                  <button class="btn btn-secondary btn-clear btn-sm my-1" data-table="additional_works" type="button">Limpiar <i class="far ml-1 fa-eraser"></i></button>
              </div>
            </div>
            <div class="obs mb-2">
              <label class="col-form-label">Observaciones</label>
              <textarea class="form-control @error('observaciones') is-invalid @enderror" placeholder="" name="observaciones" rows="6">{{old('observaciones', $formato->observaciones)}}</textarea>
              @error('observaciones')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="gallery pt-3">
              <h6>Galería</h6>
              @if($gallery->count())
              <ul class="row list-unstyled text-center">
              @foreach($gallery as $file)
              <li class="gallery-item col-12 col-md-4 col-xl-3" id="image-{{$file->id}}">
                <img class="btn p-0" data-toggle="modal" data-target="#galleryModal" src="{{ asset("uploads/ots/$formato->ot_id/mechanical/$file->file") }}">
                <p class="mb-0">{{$file->name}}</p>
                <button class="btn btn-danger btn-sm mt-0 btn-idelete" data-id="{{$file->id}}" type="button" data-toggle="modal" data-target="#modalDelImage">Quitar imagen</button>
              </li>
              @endforeach
              </ul>
              @else
              <p class="text-center">No hay imágenes.</p>
              @endif
            </div>
            <div class="upload-gallery">
              <label for="dZUpload">Galería</label>
              <input class="form-control images d-none" type="text" name="files" value="{{old('files')}}">
              <div id="dZUpload" class="dropzone">
                <div class="dz-default dz-message">Sube aquí tus imágenes</div>
              </div>
            </div>
            {{-- <div class="files">
              <label class="col-label">Imágenes</label>
              <input type="file" name="files[]" multiple="" id="evalImages">
            </div> --}}
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
            <img class="image img-fluid" src="" width="600">
        </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" id="modalDelImage">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar Imagen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p class="text my-3 body-title">¿Seguro desea eliminar la Imagen?</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancelar</button>
        <button class="btn btn-primary btn-delete-confirm" type="button" data-id=""><i class="fal fa-trash"></i> Eliminar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script src="{{ asset('assets/dropzone/dropzone.min.js') }}"></script>
<script>
  Dropzone.autoDiscover = false;
$(document).ready(function () {
  var myDrop = new Dropzone("#dZUpload", {
      url: "{{route('gallery.store')}}",
      addRemoveLinks: true,
      maxFilesize: 2000,
      timeout: 180000,
      acceptedFiles: 'image/*',
      //autoProcessQueue: false,
      params: {
        _token: '{{csrf_token()}}',
        eval_type: 'mechanical',
        ot_id: {{$ot->id}}
      },
      renameFile: function (file) {
          let newName = new Date().getTime() + '_' + file.name;
          return newName;
      },
      success: function (file, response) {
          var imgName = response;
          file.previewElement.classList.add("dz-success");
          createImageJSON(myDrop.files);
      },
      removedfile: function(file) {
        createImageJSON(myDrop.files);
          file.previewElement.remove();
      },
      error: function (file, response) {
          file.previewElement.classList.add("dz-error");
      }
  });
  myDrop.on("addedfile", function(file) {
    caption = file.caption == undefined ? "" : file.caption;
    file._captionLabel = Dropzone.createElement("<p>Leyenda:</p>");
    file._captionBox = Dropzone.createElement("<textarea class='caption form-control' id='"+file.upload.uuid+"' type='text' name='caption' class='dropzone_caption'>"+caption+"</textarea>");
    file.previewElement.appendChild(file._captionLabel);
    file.previewElement.appendChild(file._captionBox);

    $(file._captionBox).on('keyup', function (event) {
      var json = $.parseJSON($('.images').val());
      var text = $(this).val();
      if(Object.keys(json).length) {
        $.each(json, function (id, item) {
          if(item.uuid == file.upload.uuid) {
            //json[id].name = text;
            if(text.length) {
              json[id].name = text;
            }
          }
        })
        $('.images').val(JSON.stringify(json));
      }
    })
  });
  function createImageJSON(files) {
    var json = '{';
    var otArr = [];
    $.each(files, function(id, item) {
      console.log(item)
      otArr.push('"' + id + '": {' + 
        '"uuid":"' + item.upload.uuid +
        '", "file":"' + item.upload.filename +
        '", "name":"' + item.upload.filename +
        '", "type":"' + item.type + 
        '", "status":"' + item.status + 
        '", "url":"' + item.url + 
        '"}');
    });
    json += otArr.join(",") + '}'
    $('.images').val(json)
    return json;
  }

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
              if(service.data('value')) {
                service.find('option[value='+service.data('value')+']').prop('selected', true);
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

$(document).on('click', '.btn-delete-confirm', function() {
    var $this = $(this), id = $this.data('id');
      $.ajax({
        type: "POST",
        url: "/ordenes/"+id+"/quitarimagen",
        data: {
          _token: '{{csrf_token()}}'
        },
        complete: function () {
          $('#modalDelImage').modal('hide');
        },
        beforeSend: function() {
          $this.attr('disabled', true);
        },
        success: function(response) {
          $this.attr('disabled', false);
          if (response.success) {
            $('#image-'+id).remove();
          }
        },
        error: function(request, status, error) {
          $this.attr('disabled', false);
        }
      });
  })

  $(document).on("click", ".btn-idelete", function(event) {
    console.log($(this).data('id'))
      $('.btn-delete-confirm').data('id', $(this).data('id'));
  })

$(document).on('click', '.card .btn-clear', function () {
  var table = $(this).data('table');
  $('#table-'+table+' .form-control').val('');
})

$('.btn-add-row').click(function () {
  var table = $(this).data('table'),
      work_type = $(this).data('work_type');
  var row_index = $('#table-'+table+' tbody tr').length;
  var row = `<tr>
    <td class="cell-counter">
      <span class="number"></span>
      <input class="work_status" type="hidden" name="`+table+`[`+row_index+`][status]" value="1">
    </td>
    <td>
      <input type="hidden" name="`+table+`[` + row_index + `][type]" value="` + work_type + `">
      <select class="dropdown2 form-control select-area" name="`+table+`[`+row_index+`][area]" style="width: 100%">
        <option value="">Seleccionar area</option>
        @foreach($areas as $area)
        <option value="{{$area->id}}">{{$area->name}}</option>
        @endforeach
      </select>
    </td>
    <td>
      <select class="dropdown2 form-control select-service" name="`+table+`[`+row_index+`][service_id]" style="width: 100%"  disabled="">
        <option value="">Seleccionar servicio</option>
      </select>
    </td>
    <td width="120">
      <input type="text" class="form-control mt-0" placeholder="Descripción" value="" name="`+table+`[`+row_index+`][description]">
    </td>
    <td width="100">
      <input type="text" class="form-control mt-0" placeholder="Medida" value="" name="`+table+`[`+row_index+`][medidas]">
    </td>
    <td width="100">
      <input type="text" class="form-control mt-0" placeholder="Cantidad" value="" name="`+table+`[`+row_index+`][qty]">
    </td>
    <td width="100">
      <input type="text" class="form-control mt-0" placeholder="Personal" value="" name="`+table+`[`+row_index+`][personal]">
    </td>
    <td>
      <button class="btn btn-secondary btn-remove-row btn-sm my-1" data-table="`+table+`" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
    </td>
  </tr>`;
$('#table-'+table+' tbody').append(row);
$('#table-'+table+' .dropdown2').select2();
//createJSON();
})
$(document).on('click', '.btn-remove-row', function() {
  var table = $(this).data('table');
  var row_index = $('#table-'+table+' tbody tr').length;
  if (row_index > 1) {
    $(this).parents('tr').addClass('d-none').find('.work_status').val(0);
  }
})

$('.btn-yes').click(function () {
  $('input[type="radio"][value="1"]').prop('checked', true);
})
$('.btn-no').click(function () {
  $('input[type="radio"][value="0"]').prop('checked', true);
})

$('.select-area').trigger('change');

asiento1 = $('[name=rotor_cod_rodaje_p1] option:selected').data('asiento');
alojamiento1 = $('[name=rotor_cod_rodaje_p1] option:selected').data('alojamiento');
asiento2 = $('[name=rotor_cod_rodaje_p2] option:selected').data('asiento');
alojamiento2 = $('[name=rotor_cod_rodaje_p2] option:selected').data('alojamiento');
$('.asiento-rodaje-pto1').val(asiento1);
$('.alojamiento-tapa-pto1').val(alojamiento1);
$('.asiento-rodaje-pto2').val(asiento2);
$('.alojamiento-tapa-pto2').val(alojamiento2);

$('[name=rotor_cod_rodaje_p1]').change(function () {
  var $this = $(this), asiento = $this.find('option:selected').data('asiento'), alojamiento = $this.find('option:selected').data('alojamiento');

  $('[name=rotor_asiento_rodaje_p1]').val(asiento ? asiento : '');
  $('.asiento-rodaje-pto1').val(asiento ? asiento : 'Ø');
  $('[name=estator_alojamiento_rodaje_tapa_p10]').val(alojamiento ? alojamiento : '');
  $('.alojamiento-tapa-pto1').val(alojamiento ? alojamiento : '');
})

$('[name=rotor_cod_rodaje_p2]').change(function () {
  var $this = $(this), asiento = $this.find('option:selected').data('asiento'), alojamiento = $this.find('option:selected').data('alojamiento');

  $('[name=rotor_asiento_rodaje_p2]').val(asiento ? asiento : '');
  $('.asiento-rodaje-pto2').val(asiento ? asiento : 'Ø');
  $('[name=estator_alojamiento_rodaje_tapa_p20]').val(alojamiento ? alojamiento : '');
  $('.alojamiento-tapa-pto2').val(alojamiento ? alojamiento : '');
})

$('#galleryModal').on('show.bs.modal', function (event) {
      $('#galleryModal .modal-body .image').attr('src', $(event.relatedTarget).attr('src'))
    })
})
</script>
@endsection