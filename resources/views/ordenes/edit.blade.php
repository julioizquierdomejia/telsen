@extends('layouts.app', ['title' => 'Editar "O.T. ' . sprintf('%05d', $orden->id) .' | '. $orden->marca["name"] . '"' ])

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')

<div class="row">
  
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Editar Orden de Trabajo</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="{{route('ordenes.edit', ['orden' => $orden->id])}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label class="col-form-label">Número de Orden</label>
                <input type="text" class="form-control" disabled="" placeholder="Company" value="0T - {{$orden->id}}" name="id">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-form-label">Fecha de creación <span class="text-danger">(*)</span></label>
                <input type="date" class="form-control @error('fecha_creacion') is-invalid @enderror" placeholder="" name="fecha_creacion" value="{{$orden->fecha_creacion}}" required>
                <input type="hidden" name="user_id" class="form-control mb-2" value="{{ Auth::user()->id }}">
                @error('fecha_creacion')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Vendedor</label>
                <input type="text" name="guia_cliente" class="form-control @error('guia_cliente') is-invalid @enderror" placeholder="Ingrese Vendedor" value="{{$orden->guia_cliente}}">
                @error('guia_cliente')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-form-label" for="selectRuc">Ingrese RUC</label>
                <select class="form-control dropdown2 @error('client_id') is-invalid @enderror" name="client_id" id="selectRuc">
                  <option>Ingresa RUC</option>
                  @foreach($clientes as $cliente)
                    <option value="{{$cliente->id}}" @if($orden->client_id == $cliente->id) selected="" @endif>{{ $cliente->ruc }}</option>
                  @endforeach
                </select>
                @error('client_id')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label class="col-form-label">Razon social</label>
                <input type="text" class="form-control razon_social" placeholder="" value="" disabled="" name="name">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="col-form-label">Direccion</label>
                <input type="text" class="form-control direccion" placeholder="" value="" disabled="" name="address">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Telefono de contacto</label>
                <input type="text" class="form-control telefono_contacto" placeholder="" value="" disabled="" name="phone">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Celular</label>
                <input type="text" class="form-control celular" placeholder="" value="" disabled="" name="celular">
              </div>
            </div>
          </div>
          <h5 class="second-title text-danger py-2">Datos del Motor</h5>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-form-label">Descripción del motor</label>
                <input type="text" class="form-control @error('descripcion_motor') is-invalid @enderror" placeholder="Ingrese descripción" value="{{$orden->descripcion_motor}}" name="descripcion_motor">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-form-label">Código</label>
                <input type="text" class="form-control @error('codigo_motor') is-invalid @enderror" name="codigo_motor" placeholder="Ingrese código del motor" value="{{$orden->codigo_motor}}">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-form-label">Marca</label>
                <!-- <input type="text" class="form-control @error('fecha_creacion') is-invalid @enderror" placeholder="Ingrese Marca" value="" name="marca"> -->
                <select name="marca_id" class="form-control @error('marca_id') is-invalid @enderror dropdown2" id="selectMarca" value="{{$orden->marca_id}}">
                  <option>Selecciona la marca</option>
                  @foreach($marcas as $marca)
                    <option value="{{ $marca->id }}" @if($orden->marca_id == $marca->id) selected="" @endif>{{ $marca->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4 ">
              <div class="form-group">
                <label class="col-form-label">Modelo</label>
                <!-- <input type="number" class="form-control @error('modelo_id') is-invalid @enderror" placeholder="Ingrese Modelo" value="" name="modelo"> -->
                <?php 
                ?>
                <select name="modelo_id" class="form-control @error('modelo_id') is-invalid @enderror dropdown2" id="selectModelo">
                  <option>Selecciona el modelo</option>
                  @foreach($modelos as $modelo)
                    <option value="{{ $modelo->id }}" @if($orden->modelo_id == $modelo->id) selected="" @endif>{{ $modelo->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Numero de potencia</label>
                <input type="text" class="form-control @error('numero_potencia') is-invalid @enderror" placeholder="Número de potencia" value="{{$orden->numero_potencia}}" name="numero_potencia">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Medida de potencia</label>
                <input type="text" class="form-control @error('medida_potencia') is-invalid @enderror" placeholder="Medida de medida_potencia" value="{{$orden->medida_potencia}}" name="medida_potencia">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Voltaje</label>
                <input type="number" class="form-control @error('voltaje') is-invalid @enderror" placeholder="Voltaje" value="{{$orden->voltaje}}" name="voltaje">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Velocidad</label>
                <input type="number" class="form-control @error('velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{$orden->velocidad}}" name="velocidad">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Crear Orden de Trabajo</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection


@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.dropdown2').select2();

    $.ajax({
        url: "/clientes/<?= $orden->client_id ?>/ver",
        data: {},
        type: 'GET',
        beforeSend: function () {
        },
        complete: function () {
        },
        success: function (response) {
            $('.razon_social').val(response.razon_social);
            $('.direccion').val(response.direccion);
            $('.telefono').val(response.telefono);
            $('.celular').val(response.celular);
            $('.telefono_contacto').val(response.telefono_contacto);
        },
        error: function (request, status, error) { // if error occured

        }
    });
  })
  </script>
@endsection
