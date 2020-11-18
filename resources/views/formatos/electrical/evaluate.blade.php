@extends('layouts.app', ['title' => 'Evaluación Eléctrica'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <form class="form-group" method="POST" action="{{route('formatos.electrical.store', ['id' => $ot->id])}}" enctype="multipart/form-data">
      @csrf
      <div class="card form-card">
        <div class="card-header">
          <h4 class="card-title">Evaluación Eléctrica</h4>
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
              <!-- <input type="text" class="form-control @error('fecha_creacion') is-invalid @enderror" placeholder="Ingrese Marca" value="" name="marca"> -->
              <select style="width: 100%" name="marca_id" class="form-control @error('marca_id') is-invalid @enderror dropdown2" id="selectMarca">
                <option value="">Selecciona la marca</option>
                @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{old('marca_id', $ot->marca_id) == $marca->id ? 'selected' : ''}}>{{ $marca->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Solped</label>
              <input type="text" min="1" class="form-control @error('solped') is-invalid @enderror" placeholder="Solped" value="{{old('solped', $ot->solped)}}" name="solped">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Modelo</label>
              <!-- <input type="number" min="1" class="form-control @error('modelo_id') is-invalid @enderror" placeholder="Ingrese Modelo" value="" name="modelo"> -->
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
              <label class="col-form-label">Numero de potencia</label>
              <input type="text" class="form-control @error('numero_potencia') is-invalid @enderror" placeholder="Número de potencia" value="{{old('numero_potencia', $ot->numero_potencia)}}" name="numero_potencia">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Medida de potencia</label>
              <input type="text" class="form-control @error('medida_potencia') is-invalid @enderror" placeholder="Medida de medida_potencia" value="{{old('medida_potencia', $ot->medida_potencia)}}" name="medida_potencia">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Voltaje</label>
              <input type="number" min="1" class="form-control @error('voltaje') is-invalid @enderror" placeholder="Voltaje" value="{{old('voltaje', $ot->voltaje)}}" name="voltaje">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Velocidad</label>
              <input type="number" min="1" class="form-control @error('velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{old('velocidad', $ot->velocidad)}}" name="velocidad">
            </div>
          </div>
          <h4 class="second-title text-danger py-2">Características del Equipo</h4>
          <div class="row pt-3">
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">OT:</label>
              <input type="text" readonly="" class="form-control" value="OT-{{zerosatleft($ot->id, 3)}}">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Fecha:</label>
              <input type="date" class="form-control" disabled="" value="{{date('Y-m-d')}}">
            </div>
            <!-- <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Solped:</label>
              <input type="text" class="form-control @error('eq_solped') is-invalid @enderror" placeholder="Solped" value="{{old('eq_solped')}}" name="eq_solped">
            </div> -->
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Recepcionado por:</label>
              <input type="text" class="form-control @error('eq_recepcionado_por') is-invalid @enderror" placeholder="Recepcionado por" value="{{old('eq_recepcionado_por')}}" name="eq_recepcionado_por">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Potencia</label>
              <input type="text" class="form-control @error('eq_potencia') is-invalid @enderror" placeholder="Potencia" value="{{old('eq_potencia')}}" name="eq_potencia">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Conex:</label>
              <input type="text" class="form-control @error('eq_conex') is-invalid @enderror" placeholder="Conex" value="{{old('eq_conex')}}" name="eq_conex">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Mod:</label>
              <input type="text" class="form-control @error('eq_mod') is-invalid @enderror" placeholder="Mod" value="{{old('eq_mod')}}" name="eq_mod">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Voltaje:</label>
              <input type="text" class="form-control @error('eq_voltaje') is-invalid @enderror" placeholder="Voltaje" value="{{old('eq_voltaje')}}" name="eq_voltaje">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">N° salida</label>
              <input type="number" min="1" class="form-control @error('eq_n_salida') is-invalid @enderror" placeholder="N° salida" value="{{old('eq_n_salida')}}" name="eq_n_salida">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Tipo:</label>
              <input type="text" class="form-control @error('eq_tipo') is-invalid @enderror" placeholder="Tipo" value="{{old('eq_tipo')}}" name="eq_tipo">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Amperaje:</label>
              <input type="text" class="form-control @error('eq_amperaje') is-invalid @enderror" placeholder="Amperaje" value="{{old('eq_amperaje')}}" name="eq_amperaje">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rod.l.a:</label>
              <input type="text" class="form-control @error('eq_rodla') is-invalid @enderror" placeholder="Rod.l.a" value="{{old('eq_rodla')}}" name="eq_rodla">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">N° equipo:</label>
              <input type="text" class="form-control @error('eq_nro_equipo') is-invalid @enderror" placeholder="N° equipo" value="{{old('eq_nro_equipo')}}" name="eq_nro_equipo">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Velocidad:</label>
              <input type="text" class="form-control @error('eq_velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{old('eq_velocidad')}}" name="eq_velocidad">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rod.l.o.a:</label>
              <input type="text" class="form-control @error('eq_rodloa') is-invalid @enderror" placeholder="Rod.l.o.a" value="{{old('eq_rodloa')}}" name="eq_rodloa">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Frame:</label>
              <input type="text" class="form-control @error('eq_frame') is-invalid @enderror" placeholder="Frame" value="{{old('eq_frame')}}" name="eq_frame">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Frecuencia:</label>
              <input type="text" class="form-control @error('eq_frecuencia') is-invalid @enderror" placeholder="Frecuencia" value="{{old('eq_frecuencia')}}" name="eq_frecuencia">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Lub:</label>
              <input type="text" class="form-control @error('eq_lub') is-invalid @enderror" placeholder="Lub" value="{{old('eq_lub')}}" name="eq_lub">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">F.S</label>
              <input type="text" class="form-control @error('eq_fs') is-invalid @enderror" placeholder="F.S" value="{{old('eq_fs')}}" name="eq_fs">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Encl</label>
              <input type="text" class="form-control @error('eq_encl') is-invalid @enderror" placeholder="Encl" value="{{old('eq_encl')}}" name="eq_encl">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Cos o:</label>
              <input type="text" class="form-control @error('eq_cos_o') is-invalid @enderror" placeholder="Cos o" value="{{old('eq_cos_o')}}" name="eq_cos_o">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Aisl. Clase:</label>
              <input type="text" class="form-control @error('eq_aisl_clase') is-invalid @enderror" placeholder="Aisl. Clase" value="{{old('eq_aisl_clase')}}" name="eq_aisl_clase">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ef:</label>
              <input type="text" class="form-control @error('eq_ef') is-invalid @enderror" placeholder="Ef" value="{{old('eq_ef')}}" name="eq_ef">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Cod:</label>
              <input type="text" class="form-control @error('eq_cod') is-invalid @enderror" placeholder="Cod" value="{{old('eq_cod')}}" name="eq_cod">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Diseño NEMA:</label>
              <input type="text" class="form-control @error('eq_diseno_nema') is-invalid @enderror" placeholder="Diseño NEMA" value="{{old('eq_diseno_nema')}}" name="eq_diseno_nema">
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
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Marca:</label>
              <input type="text" class="form-control @error('char_marca') is-invalid @enderror" placeholder="Marca" value="{{old('char_marca')}}" name="char_marca">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Potencia:</label>
              <input type="text" class="form-control @error('char_potencia') is-invalid @enderror" placeholder="Potencia" value="{{old('char_potencia')}}" name="char_potencia">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Escudos:</label>
              <input type="text" class="form-control @error('char_escudos') is-invalid @enderror" placeholder="Escudos" value="{{old('char_escudos')}}" name="char_escudos">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Mod</label>
              <input type="text" class="form-control @error('char_mod') is-invalid @enderror" placeholder="Mod" value="{{old('char_mod')}}" name="char_mod">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Voltaje:</label>
              <input type="text" class="form-control @error('char_voltaje') is-invalid @enderror" placeholder="Voltaje" value="{{old('char_voltaje')}}" name="char_voltaje">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ejes</label>
              <input type="text" class="form-control @error('char_ejes') is-invalid @enderror" placeholder="Ejes" value="{{old('char_ejes')}}" name="char_ejes">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Amperaje:</label>
              <input type="text" class="form-control @error('char_amperaje') is-invalid @enderror" placeholder="Amperaje" value="{{old('char_amperaje')}}" name="char_amperaje">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Funda:</label>
              <input type="text" class="form-control @error('char_funda') is-invalid @enderror" placeholder="Funda" value="{{old('char_funda')}}" name="char_funda">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Frame:</label>
              <input type="text" class="form-control @error('char_frame') is-invalid @enderror" placeholder="Frame" value="{{old('char_frame')}}" name="char_frame">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Velocidad:</label>
              <input type="text" class="form-control @error('char_velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{old('char_velocidad')}}" name="char_velocidad">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Acople:</label>
              <input type="text" class="form-control @error('char_acople') is-invalid @enderror" placeholder="Acople" value="{{old('char_acople')}}" name="char_acople">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">F.S:</label>
              <input type="text" class="form-control @error('char_fs') is-invalid @enderror" placeholder="F.S" value="{{old('char_fs')}}" name="char_fs">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Encl:</label>
              <input type="text" class="form-control @error('char_encl') is-invalid @enderror" placeholder="Encl" value="{{old('char_encl')}}" name="char_encl">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Peso:</label>
              <input type="text" class="form-control @error('char_peso') is-invalid @enderror" placeholder="Peso" value="{{old('char_peso')}}" name="char_peso">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Frecuencia:</label>
              <input type="text" class="form-control @error('char_frecuencia') is-invalid @enderror" placeholder="Frecuencia" value="{{old('char_frecuencia')}}" name="char_frecuencia">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Otros:</label>
              <input type="text" class="form-control @error('char_otros') is-invalid @enderror" placeholder="Otros" value="{{old('char_otros')}}" name="char_otros">
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
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Placa caract. Orig:</label>
              <input type="text" class="form-control @error('rec_placa_caract_orig') is-invalid @enderror" placeholder="Placa caract. Orig" value="{{old('rec_placa_caract_orig')}}" name="rec_placa_caract_orig">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Escudos:</label>
              <input type="text" class="form-control @error('rec_escudos') is-invalid @enderror" placeholder="Escudos" value="{{old('rec_escudos')}}" name="rec_escudos">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ventilador:</label>
              <input type="text" class="form-control @error('rec_ventilador') is-invalid @enderror" placeholder="Ventilador" value="{{old('rec_ventilador')}}" name="rec_ventilador">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Caja de Conexión:</label>
              <input type="text" class="form-control @error('rec_caja_conexion') is-invalid @enderror" placeholder="Caja de Conexión" value="{{old('rec_caja_conexion')}}" name="rec_caja_conexion">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ejes:</label>
              <input type="text" class="form-control @error('rec_ejes') is-invalid @enderror" placeholder="Ejes" value="{{old('rec_ejes')}}" name="rec_ejes">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Acople:</label>
              <input type="text" class="form-control @error('rec_acople') is-invalid @enderror" placeholder="Acople" value="{{old('rec_acople')}}" name="rec_acople">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Bornera:</label>
              <input type="text" class="form-control @error('rec_bornera') is-invalid @enderror" placeholder="Bornera" value="{{old('rec_bornera')}}" name="rec_bornera">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Funda:</label>
              <input type="text" class="form-control @error('rec_funda') is-invalid @enderror" placeholder="Funda" value="{{old('rec_funda')}}" name="rec_funda">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Chaveta:</label>
              <input type="text" class="form-control @error('rec_chaveta') is-invalid @enderror" placeholder="Chaveta" value="{{old('rec_chaveta')}}" name="rec_chaveta">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Otros:</label>
              <input type="text" class="form-control @error('rec_otros') is-invalid @enderror" placeholder="Otros" value="{{old('rec_otros')}}" name="rec_otros">
            </div>
            <div class="col-12">
              <label class="col-form-label">Detalles:</label>
              <input type="text" class="form-control @error('rec_detalles') is-invalid @enderror" placeholder="Detalles" value="{{old('rec_detalles')}}" name="rec_detalles">
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
                  <input type="text" class="form-control @error('testin_motor_aisl_m') is-invalid @enderror" placeholder="Aisl.(M)" value="{{old('testin_motor_aisl_m')}}" name="testin_motor_aisl_m">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">N° salidas:</label>
                  <input type="number" min="1" class="form-control @error('testin_motor_nro_salidas') is-invalid @enderror" placeholder="N° salidas" value="{{old('testin_motor_nro_salidas')}}" name="testin_motor_nro_salidas">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Conexión:</label>
                  <input type="text" class="form-control @error('testin_motor_conexion') is-invalid @enderror" placeholder="Conexión" value="{{old('testin_motor_conexion')}}" name="testin_motor_conexion">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Volt(v):</label>
                  <input type="text" class="form-control @error('testin_motor_volt_v') is-invalid @enderror" placeholder="Volt(v)" value="{{old('testin_motor_volt_v')}}" name="testin_motor_volt_v">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Amp(A):</label>
                  <input type="text" class="form-control @error('testin_motor_amp_a') is-invalid @enderror" placeholder="Amp(A)" value="{{old('testin_motor_amp_a')}}" name="testin_motor_amp_a">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">RPM:</label>
                  <input type="number" min="1" class="form-control @error('testin_motor_rpm') is-invalid @enderror" placeholder="RPM" value="{{old('testin_motor_rpm')}}" name="testin_motor_rpm">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Frec.(HZ):</label>
                  <input type="text" class="form-control @error('testin_motor_frec_hz') is-invalid @enderror" placeholder="Frec.(HZ)" value="{{old('testin_motor_frec_hz')}}" name="testin_motor_frec_hz">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h4 class="second-title text-danger py-2">Pruebas del estator/rotor</h4>
              <div class="row pt-3">
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Aisl.(M):</label>
                  <input type="text" class="form-control @error('testin_er_aisl_m') is-invalid @enderror" placeholder="Aisl.(M)" value="{{old('testin_er_aisl_m')}}" name="testin_er_aisl_m">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">N° salidas:</label>
                  <input type="number" min="1" class="form-control @error('testin_er_nro_salidas') is-invalid @enderror" placeholder="N° salidas" value="{{old('testin_er_nro_salidas')}}" name="testin_er_nro_salidas">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Conexión:</label>
                  <input type="text" class="form-control @error('testin_er_conexion') is-invalid @enderror" placeholder="Conexión" value="{{old('testin_er_conexion')}}" name="testin_er_conexion">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Volt(v):</label>
                  <input type="text" class="form-control @error('testin_er_volt_v') is-invalid @enderror" placeholder="Volt(v)" value="{{old('testin_er_volt_v')}}" name="testin_er_volt_v">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Amp(A):</label>
                  <input type="text" class="form-control @error('testin_er_amp_a') is-invalid @enderror" placeholder="Amp(A)" value="{{old('testin_er_amp_a')}}" name="testin_er_amp_a">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">N° polos:</label>
                  <input type="number" min="1" class="form-control @error('testin_er_nro_polos') is-invalid @enderror" placeholder="N° polos" value="{{old('testin_er_nro_polos')}}" name="testin_er_nro_polos">
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
          <table class="table table-separate text-center table-numbering mb-0" id="table-tap">
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
              <tr>
                <td class="cell-counter"><span class="number"></span></td>
                <td><input type="text" class="form-control" name="uv1" value=""></td>
                <td><input type="text" class="form-control" name="uv2" value=""></td>
                <td><input type="text" class="form-control" name="vu1" value=""></td>
                <td><input type="text" class="form-control" name="vu2" value=""></td>
                <td><input type="text" class="form-control" name="wu1" value=""></td>
                <td><input type="text" class="form-control" name="wu2" value=""></td>
              </tr>
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
          <input type="hidden" class="form-control" value="{{old('tran_tap')}}" name="tran_tap">
          <hr class="mt-0">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Aisl.(M):</label>
              <input type="text" class="form-control @error('tran_aisl_m') is-invalid @enderror" placeholder="Aisl.(M)" value="{{old('tran_aisl_m')}}" name="tran_aisl_m">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">N° salidas:</label>
              <input type="number" min="1" class="form-control @error('tran_nro_salidas') is-invalid @enderror" placeholder="N° salidas" value="{{old('tran_nro_salidas')}}" name="tran_nro_salidas">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Conexión:</label>
              <input type="text" class="form-control @error('tran_conexion') is-invalid @enderror" placeholder="Conexión" value="{{old('tran_conexion')}}" name="tran_conexion">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Volt(V):</label>
              <input type="text" class="form-control @error('tran_volt_v') is-invalid @enderror" placeholder="Volt(V)" value="{{old('tran_volt_v')}}" name="tran_volt_v">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Amp(A):</label>
              <input type="text" class="form-control @error('tran_amp_a') is-invalid @enderror" placeholder="Amp(A)" value="{{old('tran_amp_a')}}" name="tran_amp_a">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">N° polos:</label>
              <input type="text" class="form-control @error('tran_nro_polos') is-invalid @enderror" placeholder="N° polos" value="{{old('tran_nro_polos')}}" name="tran_nro_polos">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Aisl.(M): A.T.masa:</label>
              <input type="text" class="form-control @error('tran_aisl_m_at_masa') is-invalid @enderror" placeholder="Aisl.(M): A.T.masa" value="{{old('tran_aisl_m_at_masa')}}" name="tran_aisl_m_at_masa">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">S.T masa:</label>
              <input type="text" class="form-control @error('tran_st_masa') is-invalid @enderror" placeholder="N° S.T masa" value="{{old('tran_st_masa')}}" name="tran_st_masa">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">E.T-A.T:</label>
              <input type="text" class="form-control @error('tran_et_at') is-invalid @enderror" placeholder="E.T-A.T" value="{{old('tran_et_at')}}" name="tran_et_at">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Grupo conex:</label>
              <input type="text" class="form-control @error('tran_grupo_conex') is-invalid @enderror" placeholder="Grupo conex" value="{{old('tran_grupo_conex')}}" name="tran_grupo_conex">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Polaridad:</label>
              <input type="text" class="form-control @error('tran_polaridad') is-invalid @enderror" placeholder="N° Polaridad" value="{{old('tran_polaridad')}}" name="tran_polaridad">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Relac. Transf:</label>
              <input type="text" class="form-control @error('tran_relac_transf') is-invalid @enderror" placeholder="N° Relac. Transf" value="{{old('tran_relac_transf')}}" name="tran_relac_transf">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">o.t.p:</label>
              <input type="text" class="form-control @error('tran_otp') is-invalid @enderror" placeholder="o.t.p" value="{{old('tran_otp')}}" name="tran_otp">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Tec:</label>
              <input type="text" class="form-control @error('tran_tec') is-invalid @enderror" placeholder="Tec" value="{{old('tran_tec')}}" name="tran_tec">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Amp:</label>
              <input type="text" class="form-control @error('tran_amp') is-invalid @enderror" placeholder="Amp" value="{{old('tran_amp')}}"  name="tran_amp">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rig. Diel. Aceite:</label>
              <input type="text" class="form-control @error('tran_rig_diel_aceite') is-invalid @enderror" placeholder="Rig. Diel. Aceite" value="{{old('tran_rig_diel_aceite')}}" name="tran_rig_diel_aceite">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">R.u.v:</label>
              <input type="text" class="form-control @error('tran_ruv') is-invalid @enderror" placeholder="R.u.v" value="{{old('tran_ruv')}}" name="tran_ruv">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rv-w:</label>
              <input type="text" class="form-control @error('tran_rv_w') is-invalid @enderror" placeholder="Rv-w" value="{{old('tran_rv_w')}}" name="tran_rv_w">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rw-u:</label>
              <input type="text" class="form-control @error('tran_rw_u') is-invalid @enderror" placeholder="Rw-u" value="{{old('tran_rw_u')}}" name="tran_rw_u">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ru-v:</label>
              <input type="text" class="form-control @error('tran_ru_v') is-invalid @enderror" placeholder="Ru-v" value="{{old('tran_ru_v')}}" name="tran_ru_v">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Rv-u:</label>
              <input type="text" class="form-control @error('tran_rv_u') is-invalid @enderror" placeholder="Rv-u" value="{{old('tran_rv_u')}}" name="tran_rv_u">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ww:</label>
              <input type="text" class="form-control @error('tran_ww') is-invalid @enderror" placeholder="Ww" value="{{old('tran_ww')}}" name="tran_ww">
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
@endsection
@section('javascript')
<script>
$(document).ready(function () {
function createJSON() {
var json = '{';
var otArr = [];
var tbl2 = $('#table-tap tbody tr').each(function(i) {
x = $(this).children();
var itArr = [];
x.each(function() {
  var el = $(this).find('.form-control');
if (el.length) {
itArr.push('"' + el.attr('name')+ '":"' + el.val() + '"');
}
});
otArr.push('"' + i + '": {' + itArr.join(',') + '}');
})
json += otArr.join(",") + '}'
$('input[name=tran_tap]').val(json);
return json;
}
$(document).on('keyup', '#table-tap .form-control', function () {
createJSON();
})
$(document).on('click', '.card .btn-clear', function () {
$('#table-tap .form-control').val('');
})
$('.btn-add-row').click(function () {
var row = '<tr><td class="cell-counter"><span class="number"></span></td><td><input type="text" class="form-control" value=""></td><td><input type="text" class="form-control" value=""></td><td><input type="text" class="form-control" value=""></td><td><input type="text" class="form-control" value=""></td><td><input type="text" class="form-control" value=""></td><td><input type="text" class="form-control" value=""></td></tr>';
$('#table-tap tbody').append(row);
createJSON();
})
$('.btn-remove-row').click(function () {
var row_index = $('#table-tap tbody tr').length;
if (row_index > 1) {
$('#table-tap tbody tr:nth-child('+row_index+')').remove();
}
createJSON();
})
})
</script>
@endsection