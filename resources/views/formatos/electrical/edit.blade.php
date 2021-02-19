@php
  $ot_code = zerosatleft($ot->code, 3);
@endphp
@extends('layouts.app_real', ['title' => 'Editar Evaluación Eléctrica de OT N° '.$ot_code ])
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dropzone/dropzone.min.css') }}" />
@php
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
    <form class="form-group" method="POST" action="{{route('formatos.electrical.edit', $formato->id)}}" enctype="multipart/form-data">
      @csrf
      <div class="card form-card">
        <div class="card-header">
          <h4 class="card-title">Editar Evaluación Eléctrica de OT N° {{$ot_code}}</h4>
        </div>
        <div class="card-body pb-3 pt-0">
          <h5 class="text-danger mt-4">Datos del Motor</h5>
          <div class="row">
            <div class="col-md-12 form-group">
              <label class="col-form-label">Descripción del motor</label>
              <input type="text" class="form-control @error('descripcion_motor') is-invalid @enderror" placeholder="Ingrese descripción" value="{{old('descripcion_motor', $ot->descripcion_motor)}}" name="descripcion_motor">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Código</label>
              <input type="text" class="form-control @error('codigo_motor') is-invalid @enderror" name="codigo_motor" placeholder="Ingrese código del motor" value="{{old('codigo_motor', $ot->codigo_motor)}}">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Marca</label>
              <select style="width: 100%" name="marca_id" class="form-control @error('marca_id') is-invalid @enderror dropdown2" id="selectMarca">
                <option value="">Selecciona la marca</option>
                @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{old('marca_id', $ot->marca_id) == $marca->id ? 'selected' : ''}}>{{ $marca->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Solped</label>
              <input type="text" class="form-control @error('solped') is-invalid @enderror" placeholder="Solped" value="{{old('solped', $ot->solped)}}" name="solped">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Modelo</label>
              <!-- <input type="text" class="form-control @error('modelo_id') is-invalid @enderror" placeholder="Ingrese Modelo" value="" name="modelo"> -->
              <select style="width: 100%" name="modelo_id" class="form-control @error('modelo_id') is-invalid @enderror dropdown2" id="selectModelo">
                <option value="">Selecciona el modelo</option>
                @foreach($modelos as $modelo)
                <option value="{{ $modelo->id }}" {{old('modelo_id', $ot->modelo_id) == $modelo->id ? 'selected' : ''}}>{{ $modelo->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          
          <div class="row">
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Potencia</label>
              <input type="text" class="form-control @error('numero_potencia') is-invalid @enderror" placeholder="Potencia" value="{{old('numero_potencia', $ot->numero_potencia)}}" name="numero_potencia">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Unidad de medida (hp/kw)</label>
              <input type="text" class="form-control @error('medida_potencia') is-invalid @enderror" placeholder="Unidad de medida (hp/kw)" value="{{old('medida_potencia', $ot->medida_potencia)}}" name="medida_potencia">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Voltaje</label>
              <input type="text" class="form-control @error('ot_voltaje') is-invalid @enderror" placeholder="Voltaje" value="{{old('ot_voltaje', $ot->voltaje)}}" name="ot_voltaje">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Velocidad</label>
              <input type="text" class="form-control @error('ot_velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{old('ot_velocidad', $ot->velocidad)}}" name="ot_velocidad">
            </div>
          </div>
          <h4 class="second-title text-danger py-2">Características del Equipo</h4>
          <div class="row pt-3">
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">OT:</label>
              <input type="text" readonly="" class="form-control" value="OT-{{$ot_code}}">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Fecha:</label>
              <input type="date" class="form-control" disabled="" value="{{date('d-m-Y', strtotime($formato->created_at))}}">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Recepcionado por:</label>
              <input type="text" class="form-control @error('recepcionado_por') is-invalid @enderror" placeholder="Recepcionado por" value="{{old('recepcionado_por', $formato->recepcionado_por)}}" name="recepcionado_por">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Potencia</label>
              <input type="text" class="form-control @error('potencia') is-invalid @enderror" placeholder="Potencia" value="{{old('potencia', $formato->potencia)}}" name="potencia">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Conex:</label>
              <input type="text" class="form-control @error('conex') is-invalid @enderror" placeholder="Conex" value="{{old('conex', $formato->conex)}}" name="conex">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Mod:</label>
              <input type="text" class="form-control @error('mod') is-invalid @enderror" placeholder="Mod" value="{{old('mod', $formato->mod)}}" name="mod">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Voltaje:</label>
              <input type="text" class="form-control @error('voltaje') is-invalid @enderror" placeholder="Voltaje" value="{{old('voltaje', $formato->voltaje)}}" name="voltaje">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">N° salida</label>
              <input type="text" class="form-control @error('nro_salida') is-invalid @enderror" placeholder="N° salida" value="{{old('nro_salida', $formato->nro_salida)}}" name="nro_salida">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Tipo:</label>
              <input type="text" class="form-control @error('tipo') is-invalid @enderror" placeholder="Tipo" value="{{old('tipo', $formato->tipo)}}" name="tipo">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Amperaje:</label>
              <input type="text" class="form-control @error('amperaje') is-invalid @enderror" placeholder="Amperaje" value="{{old('amperaje', $formato->amperaje)}}" name="amperaje">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rod.l.a:</label>
              <input type="text" class="form-control @error('rodla') is-invalid @enderror" placeholder="Rod.l.a" value="{{old('rodla', $formato->rodla)}}" name="rodla">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">N° equipo:</label>
              <input type="text" class="form-control @error('nro_equipo') is-invalid @enderror" placeholder="N° equipo" value="{{old('nro_equipo', $formato->nro_equipo)}}" name="nro_equipo">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Velocidad:</label>
              <input type="text" class="form-control @error('velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{old('velocidad', $formato->velocidad)}}" name="velocidad">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rod.l.o.a:</label>
              <input type="text" class="form-control @error('rodloa') is-invalid @enderror" placeholder="Rod.l.o.a" value="{{old('rodloa', $formato->rodloa)}}" name="rodloa">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Frame:</label>
              <input type="text" class="form-control @error('frame') is-invalid @enderror" placeholder="Frame" value="{{old('frame', $formato->frame)}}" name="frame">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Frecuencia:</label>
              <input type="text" class="form-control @error('frecuencia') is-invalid @enderror" placeholder="Frecuencia" value="{{old('frecuencia', $formato->frecuencia)}}" name="frecuencia">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Lub:</label>
              <input type="text" class="form-control @error('lub') is-invalid @enderror" placeholder="Lub" value="{{old('lub', $formato->lub)}}" name="lub">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">F.S</label>
              <input type="text" class="form-control @error('fs') is-invalid @enderror" placeholder="F.S" value="{{old('fs', $formato->fs)}}" name="fs">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Encl</label>
              <input type="text" class="form-control @error('encl') is-invalid @enderror" placeholder="Encl" value="{{old('encl', $formato->encl)}}" name="encl">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Cos o:</label>
              <input type="text" class="form-control @error('cos_o') is-invalid @enderror" placeholder="Cos o" value="{{old('cos_o', $formato->cos_o)}}" name="cos_o">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Aisl. Clase:</label>
              <input type="text" class="form-control @error('aisl_clase') is-invalid @enderror" placeholder="Aisl. Clase" value="{{old('aisl_clase', $formato->aisl_clase)}}" name="aisl_clase">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ef:</label>
              <input type="text" class="form-control @error('ef') is-invalid @enderror" placeholder="Ef" value="{{old('ef', $formato->ef)}}" name="ef">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Cod:</label>
              <input type="text" class="form-control @error('cod') is-invalid @enderror" placeholder="Cod" value="{{old('cod', $formato->cod)}}" name="cod">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Diseño NEMA:</label>
              <input type="text" class="form-control @error('diseno_nema') is-invalid @enderror" placeholder="Diseño NEMA" value="{{old('diseno_nema', $formato->diseno_nema)}}" name="diseno_nema">
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
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Marca:</label>
              <input type="text" class="form-control @error('char_marca') is-invalid @enderror" placeholder="Marca" value="{{old('char_marca', $formato->char_marca)}}" name="char_marca">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Potencia:</label>
              <input type="text" class="form-control @error('char_potencia') is-invalid @enderror" placeholder="Potencia" value="{{old('char_potencia', $formato->char_potencia)}}" name="char_potencia">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Escudos:</label>
              <input type="text" class="form-control @error('char_escudos') is-invalid @enderror" placeholder="Escudos" value="{{old('char_escudos', $formato->char_escudos)}}" name="char_escudos">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Mod</label>
              <input type="text" class="form-control @error('char_mod') is-invalid @enderror" placeholder="Mod" value="{{old('char_mod', $formato->char_mod)}}" name="char_mod">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Voltaje:</label>
              <input type="text" class="form-control @error('char_voltaje') is-invalid @enderror" placeholder="Voltaje" value="{{old('char_voltaje', $formato->char_voltaje)}}" name="char_voltaje">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Ejes</label>
              <input type="text" class="form-control @error('char_ejes') is-invalid @enderror" placeholder="Ejes" value="{{old('char_ejes', $formato->char_ejes)}}" name="char_ejes">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">N°</label>
              <input type="text" class="form-control @error('char_nro') is-invalid @enderror" placeholder="N°" value="{{old('char_nro', $formato->char_nro)}}" name="char_nro">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Amperaje:</label>
              <input type="text" class="form-control @error('char_amperaje') is-invalid @enderror" placeholder="Amperaje" value="{{old('char_amperaje', $formato->char_amperaje)}}" name="char_amperaje">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Funda:</label>
              <input type="text" class="form-control @error('char_funda') is-invalid @enderror" placeholder="Funda" value="{{old('char_funda', $formato->char_funda)}}" name="char_funda">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Frame:</label>
              <input type="text" class="form-control @error('char_frame') is-invalid @enderror" placeholder="Frame" value="{{old('char_frame', $formato->char_frame)}}" name="char_frame">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Velocidad:</label>
              <input type="text" class="form-control @error('char_velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{old('char_velocidad', $formato->char_velocidad)}}" name="char_velocidad">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Acople:</label>
              <input type="text" class="form-control @error('char_acople') is-invalid @enderror" placeholder="Acople" value="{{old('char_acople', $formato->char_acople)}}" name="char_acople">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">F.S:</label>
              <input type="text" class="form-control @error('char_fs') is-invalid @enderror" placeholder="F.S" value="{{old('char_fs', $formato->char_fs)}}" name="char_fs">
            </div>
            <div class="col-12 col-sm-6 col-md-2 form-group">
              <label class="col-form-label">Encl:</label>
              <input type="text" class="form-control @error('char_encl') is-invalid @enderror" placeholder="Encl" value="{{old('char_encl', $formato->char_encl)}}" name="char_encl">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Peso:</label>
              <input type="text" class="form-control @error('char_peso') is-invalid @enderror" placeholder="Peso" value="{{old('char_peso', $formato->char_peso)}}" name="char_peso">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Frecuencia:</label>
              <input type="text" class="form-control @error('char_frecuencia') is-invalid @enderror" placeholder="Frecuencia" value="{{old('char_frecuencia', $formato->char_frecuencia)}}" name="char_frecuencia">
            </div>
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Otros:</label>
              <input type="text" class="form-control @error('char_otros') is-invalid @enderror" placeholder="Otros" value="{{old('char_otros', $formato->char_otros)}}" name="char_otros">
            </div>
          </div>
        </div>
      </div>
      <div class="card form-card">
        <div class="card-header">
          <h4 class="second-title text-danger py-2 d-flex justify-content-between align-items-center"><span>Estado de recepción</span> <span><button type="button" class="btn btn-yes btn-success btn-sm my-0 px-3">Sí</button><button type="button" class="btn btn-no btn-sm btn-danger my-0 px-3">No</button></span></h4>
        </div>
        <div class="card-body pb-3">
          <div class="row">
            @foreach($reception_list as $r_key => $item)
            <div class="col-6 col-md-4 col-lg-4 mb-2">
              <div class="row align-items-center">
                <div class="col-12 col-md-7">
                  <div class="row">
                <label class="col-label mb-0 col-7 col-md-12">{{$item['name']}}</label>
                <ul class="form-check-list list-inline mb-0 col-5 col-md-12 @error('rec_'.$item['alias']) is-invalid @enderror">
                    <li class="form-check-inline mx-0">
                      <label class="form-check-label mb-0">
                        <input type="radio" class="form-check-input mr-0 align-middle" value="1" name="rec_{{$item['alias']}}_has" {{old('rec_'.$item['alias'].'_has', $formato->{'rec_'.$item['alias'].'_has'}) == "1" ? 'checked' : ''}} id="ec{{$r_key}}0"><span class="align-middle"> Sí</span>
                      </label>
                    </li>
                    <li class="form-check-inline mx-0 mx-1">
                      <label class="form-check-label mb-0">
                        <input type="radio" class="form-check-input mr-0 align-middle" value="0" name="rec_{{$item['alias']}}_has" {{old('rec_'.$item['alias'].'_has', $formato->{'rec_'.$item['alias'].'_has'}) == "0" ? 'checked' : ''}} id="ec{{$r_key}}1"><span class="align-middle"> No</span>
                      </label>
                    </li>
                  </ul>
                  </div>
                  </div>
                <div class="col-12 col-md-5">
                <input type="text" class="form-control mt-0 @error('rec_'.$item['alias']) is-invalid @enderror" placeholder="{{$item['name']}}" value="{{old('rec_'.$item['alias'], $formato->{'rec_'.$item['alias']})}}" name="rec_{{$item['alias']}}">
              </div>
              </div>
              @error($item['alias'])
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            @endforeach
            <div class="col-12 col-sm-6 col-md-4 form-group">
              <label class="col-form-label">Otros:</label>
              <input type="text" class="form-control @error('rec_otros') is-invalid @enderror" placeholder="Otros" value="{{old('rec_otros', $formato->rec_otros)}}" name="rec_otros">
            </div>
            <div class="col-12">
              <label class="col-form-label">Detalles:</label>
              <input type="text" class="form-control @error('rec_detalles') is-invalid @enderror" placeholder="Detalles" value="{{old('rec_detalles', $formato->rec_detalles)}}" name="rec_detalles">
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
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Aisl.(M):</label>
                  <input type="text" class="form-control @error('testin_motor_aisl_m') is-invalid @enderror" placeholder="Aisl.(M)" value="{{old('testin_motor_aisl_m', $formato->testin_motor_aisl_m)}}" name="testin_motor_aisl_m">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">N° salidas:</label>
                  <input type="text" class="form-control @error('testin_motor_nro_salidas') is-invalid @enderror" placeholder="N° salidas" value="{{old('testin_motor_nro_salidas', $formato->testin_motor_nro_salidas)}}" name="testin_motor_nro_salidas">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Conexión:</label>
                  <input type="text" class="form-control @error('testin_motor_conexion') is-invalid @enderror" placeholder="Conexión" value="{{old('testin_motor_conexion', $formato->testin_motor_conexion)}}" name="testin_motor_conexion">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Volt(v):</label>
                  <input type="text" class="form-control @error('testin_motor_volt_v') is-invalid @enderror" placeholder="Volt(v)" value="{{old('testin_motor_volt_v', $formato->testin_motor_volt_v)}}" name="testin_motor_volt_v">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Amp(A):</label>
                  <input type="text" class="form-control @error('testin_motor_amp_a') is-invalid @enderror" placeholder="Amp(A)" value="{{old('testin_motor_amp_a', $formato->testin_motor_amp_a)}}" name="testin_motor_amp_a">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">RPM:</label>
                  <input type="text" class="form-control @error('testin_motor_rpm') is-invalid @enderror" placeholder="RPM" value="{{old('testin_motor_rpm', $formato->testin_motor_rpm)}}" name="testin_motor_rpm">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Frec.(HZ):</label>
                  <input type="text" class="form-control @error('testin_motor_frec_hz') is-invalid @enderror" placeholder="Frec.(HZ)" value="{{old('testin_motor_frec_hz', $formato->testin_motor_frec_hz)}}" name="testin_motor_frec_hz">
                </div>

                <div class="col-sm-6 col-md-12 mb-2">
                  <label class="col-form-label">Directo a masa:</label>
                  <input type="text" class="form-control @error('testin_directo_masa') is-invalid @enderror" placeholder="Amp(A)" value="{{old('testin_directo_masa')}}" name="testin_directo_masa">
                </div>
                <div class="col-sm-6 col-md-12 mb-2">
                  <label class="col-form-label">Bajo de aislamiento:</label>
                  <input type="text" class="form-control @error('testin_bajo_alistamiento') is-invalid @enderror" placeholder="RPM" value="{{old('testin_bajo_alistamiento')}}" name="testin_bajo_alistamiento">
                </div>
                <div class="col-sm-6 col-md-12 mb-2">
                  <label class="col-form-label">Mayor a 100mΩ:</label>
                  <input type="text" class="form-control @error('testin_mayor_cienm') is-invalid @enderror" placeholder="Frec.(HZ)" value="{{old('testin_mayor_cienm')}}" name="testin_mayor_cienm">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="second-title text-danger py-2">Pruebas del estator/rotor</h4>
              <div class="row pt-3">
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Aisl.(M):</label>
                  <input type="text" class="form-control @error('testin_er_aisl_m') is-invalid @enderror" placeholder="Aisl.(M)" value="{{old('testin_er_aisl_m', $formato->testin_er_aisl_m)}}" name="testin_er_aisl_m">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">N° salidas:</label>
                  <input type="text" class="form-control @error('testin_er_nro_salidas') is-invalid @enderror" placeholder="N° salidas" value="{{old('testin_er_nro_salidas', $formato->testin_er_nro_salidas)}}" name="testin_er_nro_salidas">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Conexión:</label>
                  <input type="text" class="form-control @error('testin_er_conexion') is-invalid @enderror" placeholder="Conexión" value="{{old('testin_er_conexion', $formato->testin_er_conexion)}}" name="testin_er_conexion">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Volt(v):</label>
                  <input type="text" class="form-control @error('testin_er_volt_v') is-invalid @enderror" placeholder="Volt(v)" value="{{old('testin_er_volt_v', $formato->testin_er_volt_v)}}" name="testin_er_volt_v">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Amp(A):</label>
                  <input type="text" class="form-control @error('testin_er_amp_a') is-invalid @enderror" placeholder="Amp(A)" value="{{old('testin_er_amp_a', $formato->testin_er_amp_a)}}" name="testin_er_amp_a">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">N° polos:</label>
                  <input type="text" class="form-control @error('testin_er_nro_polos') is-invalid @enderror" placeholder="N° polos" value="{{old('testin_er_nro_polos', $formato->testin_er_nro_polos)}}" name="testin_er_nro_polos">
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
          <table class="table table-tap table-separate text-center table-numbering mb-0" id="table-tap">
            <thead>
              <tr>
                <th class="text-center py-1" colspan="8">Tap</th>
              </tr>
              <tr>
                <th class="py-1">N°</th>
                <th class="py-1">U-V</th>
                <th class="py-1">U-V</th>
                <th class="py-1">V-U</th>
                <th class="py-1">V-U</th>
                <th class="py-1">W-U</th>
                <th class="py-1">W-U</th>
                <th class="py-1"></th>
              </tr>
            </thead>
            <tbody>
              @if($tran_tap = $formato->taps)
              @foreach($tran_tap as $key => $tap)
              <tr>
                <td class="cell-counter">
                  <span class="number"></span>
                  <input type="hidden" name="tran_tap[{{$key}}][id]" value="{{old('tran_tap.'.$key.'.id', $tap['id'])}}">
                  <input class="tap_status" type="hidden" name="tran_tap[{{$key}}][status]" value="1">
                </td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[{{$key}}][uv1]" value="{{old('tran_tap.'.$key.'uv1', $tap['uv1'])}}"></td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[{{$key}}][uv2]" value="{{old('tran_tap.'.$key.'uv1', $tap['uv2'])}}"></td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[{{$key}}][vu1]" value="{{old('tran_tap.'.$key.'uv1', $tap['vu1'])}}"></td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[{{$key}}][vu2]" value="{{old('tran_tap.'.$key.'uv1', $tap['vu2'])}}"></td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[{{$key}}][wu1]" value="{{old('tran_tap.'.$key.'uv1', $tap['wu1'])}}"></td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[{{$key}}][wu2]" value="{{old('tran_tap.'.$key.'uv1', $tap['wu2'])}}"></td>
                <td>
                    <button class="btn btn-secondary btn-remove-tap-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                  </td>
              </tr>
              @endforeach
              @else
              <tr>
                <td class="cell-counter"><span class="number"></span></td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[0][uv1]" value=""></td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[0][uv2]" value=""></td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[0][vu1]" value=""></td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[0][vu2]" value=""></td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[0][wu1]" value=""></td>
                <td><input type="text" class="form-control mt-0" name="tran_tap[0][wu2]" value=""></td>
                <td>
                    <button class="btn btn-secondary btn-remove-tap-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                  </td>
              </tr>
              @endif
            </tbody>
            <tfoot class="buttons">
            <tr>
              <td class="p-0" colspan="7">
                <button class="btn btn-dark btn-add-tap-row btn-sm my-1" type="button">Agregar fila <i class="far ml-1 fa-plus"></i></button>
                <button class="btn btn-secondary btn-clear btn-sm my-1" type="button">Limpiar <i class="far ml-1 fa-eraser"></i></button>
              </td>
            </tr>
            </tfoot>
          </table>
          <hr class="mt-0">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Aisl.(M):</label>
              <input type="text" class="form-control @error('tran_aisl_m') is-invalid @enderror" placeholder="Aisl.(M)" value="{{old('tran_aisl_m', $formato->tran_aisl_m)}}" name="tran_aisl_m">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">N° salidas:</label>
              <input type="text" class="form-control @error('tran_nro_salidas') is-invalid @enderror" placeholder="N° salidas" value="{{old('tran_nro_salidas', $formato->tran_nro_salidas)}}" name="tran_nro_salidas">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Conexión:</label>
              <input type="text" class="form-control @error('tran_conexion') is-invalid @enderror" placeholder="Conexión" value="{{old('tran_conexion', $formato->tran_conexion)}}" name="tran_conexion">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Volt(V):</label>
              <input type="text" class="form-control @error('tran_volt_v') is-invalid @enderror" placeholder="Volt(V)" value="{{old('tran_volt_v', $formato->tran_volt_v)}}" name="tran_volt_v">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Amp(A):</label>
              <input type="text" class="form-control @error('tran_amp_a') is-invalid @enderror" placeholder="Amp(A)" value="{{old('tran_amp_a', $formato->tran_amp_a)}}" name="tran_amp_a">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">N° polos:</label>
              <input type="text" class="form-control @error('tran_nro_polos') is-invalid @enderror" placeholder="N° polos" value="{{old('tran_nro_polos', $formato->tran_nro_polos)}}" name="tran_nro_polos">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Aisl.(M): A.T.masa:</label>
              <input type="text" class="form-control @error('tran_aisl_m_at_masa') is-invalid @enderror" placeholder="Aisl.(M): A.T.masa" value="{{old('tran_aisl_m_at_masa', $formato->tran_aisl_m_at_masa)}}" name="tran_aisl_m_at_masa">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">S.T masa:</label>
              <input type="text" class="form-control @error('tran_st_masa') is-invalid @enderror" placeholder="N° S.T masa" value="{{old('tran_st_masa', $formato->tran_st_masa)}}" name="tran_st_masa">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">E.T-A.T:</label>
              <input type="text" class="form-control @error('tran_et_at') is-invalid @enderror" placeholder="E.T-A.T" value="{{old('tran_et_at', $formato->tran_et_at)}}" name="tran_et_at">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Grupo conex:</label>
              <input type="text" class="form-control @error('tran_grupo_conex') is-invalid @enderror" placeholder="Grupo conex" value="{{old('tran_grupo_conex', $formato->tran_grupo_conex)}}" name="tran_grupo_conex">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Polaridad:</label>
              <input type="text" class="form-control @error('tran_polaridad') is-invalid @enderror" placeholder="N° Polaridad" value="{{old('tran_polaridad', $formato->tran_polaridad)}}" name="tran_polaridad">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Relac. Transf:</label>
              <input type="text" class="form-control @error('tran_relac_transf') is-invalid @enderror" placeholder="N° Relac. Transf" value="{{old('tran_relac_transf', $formato->tran_relac_transf)}}" name="tran_relac_transf">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">o.t.p:</label>
              <input type="text" class="form-control @error('tran_otp') is-invalid @enderror" placeholder="o.t.p" value="{{old('tran_otp', $formato->tran_otp)}}" name="tran_otp">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Tec:</label>
              <input type="text" class="form-control @error('tran_tec') is-invalid @enderror" placeholder="Tec" value="{{old('tran_tec', $formato->tran_tec)}}" name="tran_tec">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Amp:</label>
              <input type="text" class="form-control @error('tran_amp') is-invalid @enderror" placeholder="Amp" value="{{old('tran_amp', $formato->tran_amp)}}"  name="tran_amp">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rig. Diel. Aceite:</label>
              <input type="text" class="form-control @error('tran_rig_diel_aceite') is-invalid @enderror" placeholder="Rig. Diel. Aceite" value="{{old('tran_rig_diel_aceite', $formato->tran_rig_diel_aceite)}}" name="tran_rig_diel_aceite">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">R.u.v:</label>
              <input type="text" class="form-control @error('tran_ruv') is-invalid @enderror" placeholder="R.u.v" value="{{old('tran_ruv', $formato->tran_ruv)}}" name="tran_ruv">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rv-w:</label>
              <input type="text" class="form-control @error('tran_rv_w') is-invalid @enderror" placeholder="Rv-w" value="{{old('tran_rv_w', $formato->tran_rv_w)}}" name="tran_rv_w">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rw-u:</label>
              <input type="text" class="form-control @error('tran_rw_u') is-invalid @enderror" placeholder="Rw-u" value="{{old('tran_rw_u', $formato->tran_rw_u)}}" name="tran_rw_u">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ru-v:</label>
              <input type="text" class="form-control @error('tran_ru_v') is-invalid @enderror" placeholder="Ru-v" value="{{old('tran_ru_v', $formato->tran_ru_v)}}" name="tran_ru_v">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rv-u:</label>
              <input type="text" class="form-control @error('tran_rv_u') is-invalid @enderror" placeholder="Rv-u" value="{{old('tran_rv_u', $formato->tran_rv_u)}}" name="tran_rv_u">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ww:</label>
              <input type="text" class="form-control @error('tran_ww') is-invalid @enderror" placeholder="Ww" value="{{old('tran_ww', $formato->tran_ww)}}" name="tran_ww">
            </div>
            <div class="col-md-12 form-group">
              <div class="tap-section mb-2">
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
                      <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                    </td>
                  </tr>
                  @endforeach
                  @elseif($works->count())
                  @foreach($works as $key => $item)
                  <tr>
                    <td class="cell-counter">
                      <span class="number"></span>
                      <input type="hidden" name="works[{{$key}}][id]" value="{{$item['id']}}">
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
                      <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                    </td>
                  </tr>
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
                      <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                    </td>
                  </tr>
                  @endif
                </tbody>
              </table>
              </div>
              <div class="buttons text-center">
                  <button class="btn btn-dark btn-add-row btn-sm my-1" type="button">Agregar fila <i class="far ml-1 fa-plus"></i></button>
                  <button class="btn btn-secondary btn-clear btn-sm my-1" type="button">Limpiar <i class="far ml-1 fa-eraser"></i></button>
              </div>
            </div>
              @error('works')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-12">
              <div class="gallery pt-3">
              <h6>Galería</h6>
              @if($gallery->count())
              <ul class="row list-unstyled text-center">
              @foreach($gallery as $file)
              <li class="gallery-item col-12 col-md-4 col-xl-3" id="image-{{$file->id}}">
                <img class="btn p-0" data-toggle="modal" data-target="#galleryModal" src="{{ asset("uploads/ots/$formato->ot_id/electrical/$file->name") }}">
                <button class="btn btn-danger btn-sm mt-0 btn-idelete" data-id="{{$file->id}}" type="button" data-toggle="modal" data-target="#modalDelImage">Quitar imagen</button>
              </li>
              @endforeach
              </ul>
              @else
              <p class="text-center bg-light py-3">No hay imágenes.</p>
              @endif
            </div>
            {{-- <div class="files">
              <label class="col-label">Imágenes</label>
              <input type="file" name="files[]" multiple="" id="evalImages">
            </div> --}}
            </div>
            <div class="col-12">
              <label for="dZUpload">Galería</label>
              <input class="form-control images d-none" type="text" name="files" value="{{old('files')}}">
              <div id="dZUpload" class="dropzone">
                <div class="dz-default dz-message">Sube aquí tus imágenes</div>
              </div>
            </div>
            <div class="col-12 text-center mt-4">
              <button type="submit" class="btn btn-primary btn-round">Enviar</button>
            </div>
          </div>
        </div>
      </div>
    </form>
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
            <img class="image img-fluid" src="" width="600" style="width: auto;">
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
$(document).ready(function() {
  var myDrop = new Dropzone("#dZUpload", {
    url: "{{route('gallery.store')}}",
    addRemoveLinks: true,
    maxFilesize: 2000,
    timeout: 180000,
    //autoProcessQueue: false,
    params: {
      _token: '{{csrf_token()}}',
      eval_type: 'electrical',
      ot_id: {{$ot->id}},
    },
    renameFile: function(file) {
      let newName = new Date().getTime() + '_' + file.name;
      return newName;
    },
    success: function(file, response) {
      var imgName = response;
      file.previewElement.classList.add("dz-success");
      createJSON(myDrop.files);
    },
    removedfile: function(file) {
      createJSON(myDrop.files);
      file.previewElement.remove();
    },
    error: function(file, response) {
      file.previewElement.classList.add("dz-error");
    }
  });

  function createJSON(files) {
    var json = '{';
    var otArr = [];
    $.each(files, function(id, item) {
      console.log(item)
      otArr.push('"' + id + '": {' +
        '"name":"' + item.upload.filename +
        '", "type":"' + item.type +
        '", "status":"' + item.status +
        '", "url":"' + item.url +
        '"}');
    });
    json += otArr.join(",") + '}'
    $('.images').val(json)
    return json;
  }

  $(document).on('change', '.select-area', function() {
    var $this = $(this),
      area = $this.val();
    var service = $(this).parents('tr').find('.select-service');
    if ($(this).val().length) {
      $.ajax({
        type: "GET",
        url: "/servicios/filterareas",
        data: {
          id: area,
          _token: '{{csrf_token()}}'
        },
        beforeSend: function() {
          service.attr('disabled', true);
        },
        success: function(response) {
          service.attr('disabled', false).focus();
          service.find('option').remove();
          if (response.success) {
            var services = $.parseJSON(response.data),
              s_length = services.length;
            if (services.length) {
              $.each(services, function(id, item) {
                service.append('<option value="' + item.id + '">' + item.name + '</option>');
              })
            }
            if (service.data('value')) {
              service.find('option[value=' + service.data('value') + ']').prop('selected', true);
            }
          }
        },
        error: function(request, status, error) {

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

  $(document).on('click', '.card .btn-clear', function() {
    $('#table-tap .form-control').val('');
  })
  $('.btn-add-tap-row').click(function() {
    var row_index = $('#table-tap tbody tr').length;
    var row = `<tr>
            <td class="cell-counter"><span class="number"></span></td>
            <td><input type="text" class="form-control mt-0" name="tran_tap[` + row_index + `][uv1]" value=""></td>
            <td><input type="text" class="form-control mt-0" name="tran_tap[` + row_index + `][uv2]" value=""></td>
            <td><input type="text" class="form-control mt-0" name="tran_tap[` + row_index + `][vu1]" value=""></td>
            <td><input type="text" class="form-control mt-0" name="tran_tap[` + row_index + `][vu2]" value=""></td>
            <td><input type="text" class="form-control mt-0" name="tran_tap[` + row_index + `][wu1]" value=""></td>
            <td><input type="text" class="form-control mt-0" name="tran_tap[` + row_index + `][wu2]" value=""></td>
            <td>
              <button class="btn btn-secondary btn-remove-tap-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
            </td>
          </tr>`;
    $('#table-tap tbody').append(row);
    //createJSON();
  })
  $('.btn-add-row').click(function() {
    var row_index = $('#table-works tbody tr').length;
    var row = `<tr>
    <td class="cell-counter"><span class="number"></span></td>
    <td>
      <select class="dropdown2 form-control select-area" name="works[` + row_index + `][area]" style="width: 100%">
        <option value="">Seleccionar area</option>
        @foreach($areas as $area)
        <option value="{{$area->id}}">{{$area->name}}</option>
        @endforeach
      </select>
    </td>
    <td>
      <select class="dropdown2 form-control select-service" name="works[` + row_index + `][service_id]" style="width: 100%"  disabled="">
        <option value="">Seleccionar servicio</option>
      </select>
    </td>
    <td width="120">
      <input type="text" class="form-control mt-0" placeholder="Descripción" value="" name="works[` + row_index + `][description]">
    </td>
    <td width="100">
      <input type="text" class="form-control mt-0" placeholder="Medida" value="" name="works[` + row_index + `][medidas]">
    </td>
    <td width="100">
      <input type="text" class="form-control mt-0" placeholder="Cantidad" value="" name="works[` + row_index + `][qty]">
    </td>
    <td width="100">
      <input type="text" class="form-control mt-0" placeholder="Personal" value="" name="works[` + row_index + `][personal]">
    </td>
    <td>
      <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
    </td>
  </tr>`;
    $('#table-works tbody').append(row);
    $('#table-works .dropdown2').select2();
    //createJSON();
  })
  $(document).on('click', '.btn-remove-tap-row', function() {
    var row_index = $('#table-tap tbody tr').length;
    if (row_index > 1) {
      //$(this).closest('tr').remove();
      $(this).parents('tr').addClass('d-none').find('.tap_status').val(0);
    }
    //createJSON();
  })
  $(document).on('click', '.btn-remove-row', function() {
    var row_index = $('#table-works tbody tr').length;
    if (row_index > 1) {
      $(this).parents('tr').addClass('d-none').find('.work_status').val(0);
    }
  })

  $('.btn-yes').click(function() {
    $('input[type="radio"][value="1"]').prop('checked', true);
  })
  $('.btn-no').click(function() {
    $('input[type="radio"][value="0"]').prop('checked', true);
  })

  $('.select-area').trigger('change');

  $('#galleryModal').on('show.bs.modal', function (event) {
      $('#galleryModal .modal-body .image').attr('src', $(event.relatedTarget).attr('src'))
    })
})
</script>
@endsection