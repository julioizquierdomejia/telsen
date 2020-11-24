@extends('layouts.app', ['title' => 'Editar Evaluación Eléctrica'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <form class="form-group" method="POST" action="{{route('formatos.electrical.edit', $formato->id)}}" enctype="multipart/form-data">
      @csrf
      <div class="card form-card">
        <div class="card-header">
          <h4 class="card-title">Editar Evaluación Eléctrica N° {{$formato->id}}</h4>
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
              <label class="col-form-label">Potencia</label>
              <input type="text" class="form-control @error('numero_potencia') is-invalid @enderror" placeholder="Potencia" value="{{old('numero_potencia', $ot->numero_potencia)}}" name="numero_potencia">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Unidad de medida (hp/kw)</label>
              <input type="text" class="form-control @error('medida_potencia') is-invalid @enderror" placeholder="Unidad de medida (hp/kw)" value="{{old('medida_potencia', $ot->medida_potencia)}}" name="medida_potencia">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Voltaje</label>
              <input type="number" min="1" class="form-control @error('ot_voltaje') is-invalid @enderror" placeholder="Voltaje" value="{{old('ot_voltaje', $ot->voltaje)}}" name="ot_voltaje">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Velocidad</label>
              <input type="number" min="1" class="form-control @error('ot_velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{old('ot_velocidad', $ot->velocidad)}}" name="ot_velocidad">
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
              <input type="number" min="1" class="form-control @error('nro_salida') is-invalid @enderror" placeholder="N° salida" value="{{old('nro_salida', $formato->nro_salida)}}" name="nro_salida">
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
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Marca:</label>
              <input type="text" class="form-control @error('char_marca') is-invalid @enderror" placeholder="Marca" value="{{old('char_marca', $formato->char_marca)}}" name="char_marca">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Potencia:</label>
              <input type="text" class="form-control @error('char_potencia') is-invalid @enderror" placeholder="Potencia" value="{{old('char_potencia', $formato->char_potencia)}}" name="char_potencia">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Escudos:</label>
              <input type="text" class="form-control @error('char_escudos') is-invalid @enderror" placeholder="Escudos" value="{{old('char_escudos', $formato->char_escudos)}}" name="char_escudos">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Mod</label>
              <input type="text" class="form-control @error('char_mod') is-invalid @enderror" placeholder="Mod" value="{{old('char_mod', $formato->char_mod)}}" name="char_mod">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Voltaje:</label>
              <input type="text" class="form-control @error('char_voltaje') is-invalid @enderror" placeholder="Voltaje" value="{{old('char_voltaje', $formato->char_voltaje)}}" name="char_voltaje">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ejes</label>
              <input type="text" class="form-control @error('char_ejes') is-invalid @enderror" placeholder="Ejes" value="{{old('char_ejes', $formato->char_ejes)}}" name="char_ejes">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Amperaje:</label>
              <input type="text" class="form-control @error('char_amperaje') is-invalid @enderror" placeholder="Amperaje" value="{{old('char_amperaje', $formato->char_amperaje)}}" name="char_amperaje">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Funda:</label>
              <input type="text" class="form-control @error('char_funda') is-invalid @enderror" placeholder="Funda" value="{{old('char_funda', $formato->char_funda)}}" name="char_funda">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Frame:</label>
              <input type="text" class="form-control @error('char_frame') is-invalid @enderror" placeholder="Frame" value="{{old('char_frame', $formato->char_frame)}}" name="char_frame">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Velocidad:</label>
              <input type="text" class="form-control @error('char_velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{old('char_velocidad', $formato->char_velocidad)}}" name="char_velocidad">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Acople:</label>
              <input type="text" class="form-control @error('char_acople') is-invalid @enderror" placeholder="Acople" value="{{old('char_acople', $formato->char_acople)}}" name="char_acople">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">F.S:</label>
              <input type="text" class="form-control @error('char_fs') is-invalid @enderror" placeholder="F.S" value="{{old('char_fs', $formato->char_fs)}}" name="char_fs">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Encl:</label>
              <input type="text" class="form-control @error('char_encl') is-invalid @enderror" placeholder="Encl" value="{{old('char_encl', $formato->char_encl)}}" name="char_encl">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Peso:</label>
              <input type="text" class="form-control @error('char_peso') is-invalid @enderror" placeholder="Peso" value="{{old('char_peso', $formato->char_peso)}}" name="char_peso">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Frecuencia:</label>
              <input type="text" class="form-control @error('char_frecuencia') is-invalid @enderror" placeholder="Frecuencia" value="{{old('char_frecuencia', $formato->char_frecuencia)}}" name="char_frecuencia">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
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
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Placa caract. Orig:</label>
              <div class="d-flex">
              <ul class="form-check-list list-inline mb-0 col-7 @error('rec_placa_caract_orig_has') is-invalid @enderror">
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="1" name="rec_placa_caract_orig_has" {{old('rec_placa_caract_orig_has', $formato->rec_placa_caract_orig_has) == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                  </label>
                </li>
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="0" name="rec_placa_caract_orig_has" {{old('rec_placa_caract_orig_has', $formato->rec_placa_caract_orig_has) == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                  </label>
                </li>
              </ul>
              <input type="text" class="form-control col-5 @error('rec_placa_caract_orig') is-invalid @enderror" placeholder="Placa caract. Orig" value="{{old('rec_placa_caract_orig', $formato->rec_placa_caract_orig)}}" name="rec_placa_caract_orig">
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Escudos:</label>
              <div class="d-flex">
              <ul class="form-check-list list-inline mb-0 col-7 @error('rec_escudos_has') is-invalid @enderror">
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="1" {{old('rec_escudos_has', $formato->rec_escudos_has) == "1" ? 'checked' : ''}} name="rec_escudos_has"><span class="align-middle">Sí</span>
                  </label>
                </li>
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="0" {{old('rec_escudos_has', $formato->rec_escudos_has) == "0" ? 'checked' : ''}} name="rec_escudos_has"><span class="align-middle">No</span>
                  </label>
                </li>
              </ul>
              <input type="text" class="form-control @error('rec_escudos') is-invalid @enderror" placeholder="Escudos" value="{{old('rec_escudos', $formato->rec_escudos)}}" name="rec_escudos">
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ventilador:</label>
              <div class="d-flex">
              <ul class="form-check-list list-inline mb-0 col-7 @error('rec_ventilador_has') is-invalid @enderror">
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="1" {{old('rec_ventilador_has', $formato->rec_ventilador_has) == "1" ? 'checked' : ''}} name="rec_ventilador_has"><span class="align-middle">Sí</span>
                  </label>
                </li>
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="0" {{old('rec_ventilador_has', $formato->rec_ventilador_has) == "0" ? 'checked' : ''}} name="rec_ventilador_has"><span class="align-middle">No</span>
                  </label>
                </li>
              </ul>
              <input type="text" class="form-control @error('rec_ventilador') is-invalid @enderror" placeholder="Ventilador" value="{{old('rec_ventilador', $formato->rec_ventilador)}}" name="rec_ventilador">
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Caja de Conexión:</label>
              <div class="d-flex">
              <ul class="form-check-list list-inline mb-0 col-7 @error('rec_caja_conexion_has') is-invalid @enderror">
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="1" {{old('rec_caja_conexion_has', $formato->rec_caja_conexion_has) == "1" ? 'checked' : ''}} name="rec_caja_conexion_has"><span class="align-middle">Sí</span>
                  </label>
                </li>
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="0" {{old('rec_caja_conexion_has', $formato->rec_caja_conexion_has) == "0" ? 'checked' : ''}} name="rec_caja_conexion_has"><span class="align-middle">No</span>
                  </label>
                </li>
              </ul>
              <input type="text" class="form-control @error('rec_caja_conexion') is-invalid @enderror" placeholder="Caja de Conexión" value="{{old('rec_caja_conexion', $formato->rec_caja_conexion)}}" name="rec_caja_conexion">
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Ejes:</label>
              <div class="d-flex">
              <ul class="form-check-list list-inline mb-0 col-7 @error('rec_ejes_has') is-invalid @enderror">
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="1" {{old('rec_ejes_has', $formato->rec_ejes_has) == "1" ? 'checked' : ''}} name="rec_ejes_has"><span class="align-middle">Sí</span>
                  </label>
                </li>
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="0" {{old('rec_ejes_has', $formato->rec_ejes_has) == "0" ? 'checked' : ''}} name="rec_ejes_has"><span class="align-middle">No</span>
                  </label>
                </li>
              </ul>
              <input type="text" class="form-control @error('rec_ejes') is-invalid @enderror" placeholder="Ejes" value="{{old('rec_ejes', $formato->rec_ejes)}}" name="rec_ejes">
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Acople:</label>
              <div class="d-flex">
              <ul class="form-check-list list-inline mb-0 col-7 @error('rec_acople_has') is-invalid @enderror">
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="1" {{old('rec_acople_has', $formato->rec_acople_has) == "1" ? 'checked' : ''}} name="rec_acople_has"><span class="align-middle">Sí</span>
                  </label>
                </li>
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="0" {{old('rec_acople_has', $formato->rec_acople_has) == "0" ? 'checked' : ''}} name="rec_acople_has"><span class="align-middle">No</span>
                  </label>
                </li>
              </ul>
              <input type="text" class="form-control @error('rec_acople') is-invalid @enderror" placeholder="Acople" value="{{old('rec_acople', $formato->rec_acople)}}" name="rec_acople">
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Bornera:</label>
              <div class="d-flex">
              <ul class="form-check-list list-inline mb-0 col-7 @error('rec_bornera_has') is-invalid @enderror">
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="1" {{old('rec_bornera_has', $formato->rec_bornera_has) == "1" ? 'checked' : ''}} name="rec_bornera_has"><span class="align-middle">Sí</span>
                  </label>
                </li>
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="0" {{old('rec_bornera_has', $formato->rec_bornera_has) == "0" ? 'checked' : ''}} name="rec_bornera_has"><span class="align-middle">No</span>
                  </label>
                </li>
              </ul>
              <input type="text" class="form-control @error('rec_bornera') is-invalid @enderror" placeholder="Bornera" value="{{old('rec_bornera', $formato->rec_bornera)}}" name="rec_bornera">
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Funda:</label>
              <div class="d-flex">
              <ul class="form-check-list list-inline mb-0 col-7 @error('rec_funda_has') is-invalid @enderror">
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="1" {{old('rec_funda_has', $formato->rec_funda_has) == "1" ? 'checked' : ''}} name="rec_funda_has"><span class="align-middle">Sí</span>
                  </label>
                </li>
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="0" {{old('rec_funda_has', $formato->rec_funda_has) == "0" ? 'checked' : ''}} name="rec_funda_has"><span class="align-middle">No</span>
                  </label>
                </li>
              </ul>
              <input type="text" class="form-control @error('rec_funda') is-invalid @enderror" placeholder="Funda" value="{{old('rec_funda', $formato->rec_funda)}}" name="rec_funda">
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Chaveta:</label>
              <div class="d-flex">
              <ul class="form-check-list list-inline mb-0 col-7 @error('rec_chaveta_has') is-invalid @enderror">
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="1" {{old('rec_chaveta_has', $formato->rec_chaveta_has) == "1" ? 'checked' : ''}} name="rec_chaveta_has"><span class="align-middle">Sí</span>
                  </label>
                </li>
                <li class="form-check-inline">
                  <label class="form-check-label">
                    <input type="radio" class="form-check-input align-middle" value="0" {{old('rec_chaveta_has', $formato->rec_chaveta_has) == "0" ? 'checked' : ''}} name="rec_chaveta_has"><span class="align-middle">No</span>
                  </label>
                </li>
              </ul>
              <input type="text" class="form-control @error('rec_chaveta') is-invalid @enderror" placeholder="Chaveta" value="{{old('rec_chaveta', $formato->rec_chaveta)}}" name="rec_chaveta">
              </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
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
                  <input type="number" min="1" class="form-control @error('testin_motor_nro_salidas') is-invalid @enderror" placeholder="N° salidas" value="{{old('testin_motor_nro_salidas', $formato->testin_motor_nro_salidas)}}" name="testin_motor_nro_salidas">
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
                  <input type="number" min="1" class="form-control @error('testin_motor_rpm') is-invalid @enderror" placeholder="RPM" value="{{old('testin_motor_rpm', $formato->testin_motor_rpm)}}" name="testin_motor_rpm">
                </div>
                <div class="col-sm-6 col-md-4 form-group">
                  <label class="col-form-label">Frec.(HZ):</label>
                  <input type="text" class="form-control @error('testin_motor_frec_hz') is-invalid @enderror" placeholder="Frec.(HZ)" value="{{old('testin_motor_frec_hz', $formato->testin_motor_frec_hz)}}" name="testin_motor_frec_hz">
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
                  <input type="number" min="1" class="form-control @error('testin_er_nro_salidas') is-invalid @enderror" placeholder="N° salidas" value="{{old('testin_er_nro_salidas', $formato->testin_er_nro_salidas)}}" name="testin_er_nro_salidas">
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
                  <input type="number" min="1" class="form-control @error('testin_er_nro_polos') is-invalid @enderror" placeholder="N° polos" value="{{old('testin_er_nro_polos', $formato->testin_er_nro_polos)}}" name="testin_er_nro_polos">
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
              @if($tran_tap = json_decode($formato->tran_tap, true))
              @foreach($tran_tap as $key => $tap)
              <tr>
                <td class="cell-counter"><span class="number"></span></td>
                <td><input type="text" class="form-control" name="uv1" value="{{$tap['uv1'] ?? ''}}"></td>
                <td><input type="text" class="form-control" name="uv2" value="{{$tap['uv2'] ?? ''}}"></td>
                <td><input type="text" class="form-control" name="vu1" value="{{$tap['vu1'] ?? ''}}"></td>
                <td><input type="text" class="form-control" name="vu2" value="{{$tap['vu2'] ?? ''}}"></td>
                <td><input type="text" class="form-control" name="wu1" value="{{$tap['wu1'] ?? ''}}"></td>
                <td><input type="text" class="form-control" name="wu2" value="{{$tap['wu2'] ?? ''}}"></td>
              </tr>
              @endforeach
              @else
              <tr>
                <td class="cell-counter"><span class="number"></span></td>
                <td><input type="text" class="form-control" name="uv1" value=""></td>
                <td><input type="text" class="form-control" name="uv2" value=""></td>
                <td><input type="text" class="form-control" name="vu1" value=""></td>
                <td><input type="text" class="form-control" name="vu2" value=""></td>
                <td><input type="text" class="form-control" name="wu1" value=""></td>
                <td><input type="text" class="form-control" name="wu2" value=""></td>
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
          <input type="hidden" class="form-control" value="{{old('tran_tap', $formato->tran_tap)}}" name="tran_tap">
          <hr class="mt-0">
          <div class="row">
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">Aisl.(M):</label>
              <input type="text" class="form-control @error('tran_aisl_m') is-invalid @enderror" placeholder="Aisl.(M)" value="{{old('tran_aisl_m', $formato->tran_aisl_m)}}" name="tran_aisl_m">
            </div>
            <div class="col-12 col-sm-6 col-md-3 form-group">
              <label class="col-form-label">N° salidas:</label>
              <input type="number" min="1" class="form-control @error('tran_nro_salidas') is-invalid @enderror" placeholder="N° salidas" value="{{old('tran_nro_salidas', $formato->tran_nro_salidas)}}" name="tran_nro_salidas">
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
$(document).ready(function() {
  function createJSON() {
    var json = '{';
    var otArr = [];
    var tbl2 = $('#table-tap tbody tr').each(function(i) {
      x = $(this).children();
      var itArr = [];
      x.each(function() {
        var el = $(this).find('.form-control');
        if (el.length) {
          itArr.push('"' + el.attr('name') + '":"' + el.val() + '"');
        }
      });
      otArr.push('"' + i + '": {' + itArr.join(',') + '}');
    })
    json += otArr.join(",") + '}'
    $('input[name=tran_tap]').val(json);
    return json;
  }
  $(document).on('keyup', '#table-tap .form-control', function() {
    createJSON();
  })
  $(document).on('click', '.card .btn-clear', function() {
    $('#table-tap .form-control').val('');
  })
  $('.btn-add-row').click(function() {
    var row = '<tr><td class="cell-counter"><span class="number"></span></td><td><input type="text" class="form-control" name="uv1" value=""></td><td><input type="text" class="form-control" name="uv2" value=""></td><td><input type="text" class="form-control" name="vu1" value=""></td><td><input type="text" class="form-control" name="vu2" value=""></td><td><input type="text" class="form-control" name="wu1" value=""></td><td><input type="text" class="form-control" name="wu2" value=""></td></tr>';
    $('#table-tap tbody').append(row);
    createJSON();
  })
  $('.btn-remove-row').click(function() {
    var row_index = $('#table-tap tbody tr').length;
    if (row_index > 1) {
      $('#table-tap tbody tr:nth-child(' + row_index + ')').remove();
    }
    createJSON();
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