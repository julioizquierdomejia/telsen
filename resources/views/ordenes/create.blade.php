@extends('layouts.app', ['title' => 'Crear Orden'])

@section('css')

@endsection

@section('content')

<div class="row">
  
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Crear Orden de Trabajo</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="/ordenes" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label class="col-form-label">Número de Orden</label>
                <input type="text" class="form-control" disabled="" placeholder="Company" value="0T - {{$ot_numero}}" name="id">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-form-label">Fecha de creación <span class="text-danger">(*)</span></label>
                <input type="date" class="form-control @error('fecha_creacion') is-invalid @enderror" placeholder="" name="fecha_creacion" value="{{date('Y-m-d')}}" required>
                <input type="hidden" name="user_id" class="form-control mb-2" value="{{ Auth::user()->id }}">
                @error('fecha_creacion')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Vendedor</label>
                <input type="text" name="guia_cliente" class="form-control @error('guia_cliente') is-invalid @enderror" placeholder="Ingrese Vendedor" value="">
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
                  <option value="">Ingresa RUC</option>
                  @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}">{{ $cliente->ruc }}</option>
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
          <h5 class="text-danger mt-4">Datos del Motor</h5>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-form-label">Descripción del motor</label>
                <input type="text" class="form-control @error('descripcion_motor') is-invalid @enderror" placeholder="Ingrese descripción" value="" name="descripcion_motor">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-form-label">Código</label>
                <input type="text" class="form-control @error('codigo_motor') is-invalid @enderror" name="codigo_motor" placeholder="Ingrese código del motor" value="">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-form-label">Marca</label>
                <!-- <input type="text" class="form-control @error('fecha_creacion') is-invalid @enderror" placeholder="Ingrese Marca" value="" name="marca"> -->
                <select name="marca_id" class="form-control @error('marca_id') is-invalid @enderror dropdown2" id="selectMarca">
                  <option value="">Selecciona la marca</option>
                  @foreach($marcas as $marca)
                    <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-4 ">
              <div class="form-group">
                <label class="col-form-label">Modelo</label>
                <!-- <input type="number" class="form-control @error('modelo_id') is-invalid @enderror" placeholder="Ingrese Modelo" value="" name="modelo"> -->
                <select name="modelo_id" class="form-control @error('modelo_id') is-invalid @enderror dropdown2" id="selectModelo">
                  <option value="">Selecciona el modelo</option>
                  @foreach($modelos as $modelo)
                    <option value="{{ $modelo->id }}">{{ $modelo->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Numero de potencia</label>
                <input type="text" class="form-control @error('numero_potencia') is-invalid @enderror" placeholder="Número de potencia" value="" name="numero_potencia">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Medida de potencia</label>
                <input type="text" class="form-control @error('medida_potencia') is-invalid @enderror" placeholder="Medida de medida_potencia" value="" name="medida_potencia">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Voltaje</label>
                <input type="number" class="form-control @error('voltaje') is-invalid @enderror" placeholder="Voltaje" value="" name="voltaje">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Velocidad</label>
                <input type="number" class="form-control @error('velocidad') is-invalid @enderror" placeholder="Velocidad" value="" name="velocidad">
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
<script type="text/javascript">
  $(document).ready(function(){
    $('#selectRuc').change(function () {
      var val = $(this).val();
      if (!val) {
        $('.razon_social').val("");
        $('.direccion').val("");
        $('.telefono').val("");
        $('.celular').val("");
        $('.telefono_contacto').val("");
        return;
      }
      $.ajax({
        url: "/clientes/"+val+"/ver",
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
  })
  </script>
@endsection
