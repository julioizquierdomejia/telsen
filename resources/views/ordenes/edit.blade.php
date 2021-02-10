@extends('layouts.app', ['title' => 'Editar "O.T. ' . zerosatleft($orden->code, 3)])
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
            <div class="col-md-5 form-group">
              <label class="col-form-label">Número de Orden</label>
              <input type="text" class="form-control" disabled="" placeholder="Company" value="0T-{{zerosatleft($orden->code, 3)}}" name="id">
            </div>
            <div class="col-md-4 form-group">
              <label class="col-form-label">Fecha de creación <span class="text-danger">(*)</span></label>
              <input type="text" class="form-control" value="{{date('d-m-Y', strtotime($orden->created_at))}}" disabled="">
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label">Vendedor</label>
              <input type="text" name="guia_cliente" class="form-control @error('guia_cliente') is-invalid @enderror" placeholder="Ingrese Vendedor" value="{{old('guia_cliente', $orden->guia_cliente)}}">
              @error('guia_cliente')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-8 col-md-7 form-group">
              <label class="col-form-label" for="selectRuc">Razón Social</label>
              <select class="form-control dropdown2 @error('client_id') is-invalid @enderror" name="client_id" id="selectRuc">
                <option>Ingresa Razón Social</option>
                @foreach($clientes as $cliente)
                <option data-rs="{{ $cliente->ruc }}" data-dir="{{ $cliente->direccion }}" data-contacto="{{$cliente->telefono_contacto}}" data-celular="{{$cliente->celular}}" data-type="{{$cliente->client_type}}" value="{{$cliente->id}}" @if(old('client_id', $orden->client_id) == $cliente->id) selected="" @endif>{{ $cliente->razon_social }}</option>
                @endforeach
              </select>
              @error('client_id')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-4 col-md-2 form-group">
              <label class="col-form-label">Tipo Cliente</label>
              <input type="text" class="form-control tipocliente" placeholder="" value="" disabled="" name="name">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label text-primary" for="selectPriority">Prioridad</label>
              <select style="width: 100%" name="priority" class="form-control @error('priority') is-invalid @enderror dropdown2" id="selectPriority">
                <option value="0" {{$orden->priority == 0 ? 'selected' : ''}}>Normal</option>
                <option value="1" {{$orden->priority == 1 ? 'selected' : ''}}>Alta</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
              <label class="col-form-label">Direccion</label>
              <input type="text" class="form-control direccion" placeholder="" value="" disabled="" name="address">
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label">Telefono de contacto</label>
              <input type="text" class="form-control telefono_contacto" placeholder="" value="" disabled="" name="phone">
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label">Celular</label>
              <input type="text" class="form-control celular" placeholder="" value="" disabled="" name="celular">
            </div>
          </div>
          <h5 class="second-title text-danger py-2">Datos del Motor</h5>
          <div class="row">
            <div class="col-md-12 form-group">
              <label class="col-form-label">Descripción del motor</label>
              <input type="text" class="form-control @error('descripcion_motor') is-invalid @enderror" placeholder="Ingrese descripción" value="{{$orden->descripcion_motor}}" name="descripcion_motor">
            </div>
          </div>
          <div class="row">
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Código</label>
              <input type="text" class="form-control @error('codigo_motor') is-invalid @enderror" name="codigo_motor" placeholder="Ingrese código del motor" value="{{old('codigo_motor', $orden->codigo_motor)}}">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Marca</label>
              <!-- <input type="text" class="form-control @error('fecha_creacion') is-invalid @enderror" placeholder="Ingrese Marca" value="" name="marca"> -->
              <select name="marca_id" class="form-control @error('marca_id') is-invalid @enderror dropdown2" id="selectMarca" value="{{$orden->marca_id}}">
                <option value="">Selecciona la marca</option>
                @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" @if($orden->marca_id == $marca->id) selected="" @endif>{{ $marca->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label" for="solped">Solped</label>
              <input type="text" min="1" class="form-control @error('solped') is-invalid @enderror" placeholder="Solped" value="{{old('solped', $orden->solped)}}" id="solped" name="solped">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Modelo</label>
              <select name="modelo_id" class="form-control @error('modelo_id') is-invalid @enderror dropdown2" id="selectModelo">
                <option value="">Selecciona el modelo</option>
                @foreach($modelos as $modelo)
                <option value="{{ $modelo->id }}" @if($orden->modelo_id == $modelo->id) selected="" @endif>{{ $modelo->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-3 form-group">
              <label class="col-form-label">Numero de potencia</label>
              <input type="text" class="form-control @error('numero_potencia') is-invalid @enderror" placeholder="Número de potencia" value="{{old('numero_potencia', $orden->numero_potencia)}}" name="numero_potencia">
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label">Medida de potencia</label>
              <input type="text" class="form-control @error('medida_potencia') is-invalid @enderror" placeholder="Medida de medida_potencia" value="{{old('medida_potencia', $orden->medida_potencia)}}" name="medida_potencia">
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label">Voltaje</label>
              <input type="text" class="form-control @error('voltaje') is-invalid @enderror" placeholder="Voltaje" value="{{old('voltaje', $orden->voltaje)}}" name="voltaje">
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label">Velocidad</label>
              <input type="text" class="form-control @error('velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{old('velocidad', $orden->velocidad)}}" name="velocidad">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label" for="selectEstado">Estado</label>
              <select style="width: 100%" name="enabled" class="form-control @error('enabled') is-invalid @enderror dropdown2" id="selectEstado">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Actualizar Orden de Trabajo</button>
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
var $this = $(this), val = $this.val(), selected = $this.find('option:selected');
if (!val) {
$('.razon_social').val("");
$('.direccion').val("");
$('.telefono').val("");
$('.celular').val("");
$('.tipocliente').val("");
$('.telefono_contacto').val("");
return;
}
$('.razon_social').val(selected.data('rs'));
$('.direccion').val(selected.data('dir'));
$('.telefono').val(selected.data('tel'));
$('.celular').val(selected.data('celular'));
$('.telefono_contacto').val(selected.data('contacto'));
$('.tipocliente').val(selected.data('type'));
/*$.ajax({
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
});*/
})

$('#selectRuc').trigger('change');
})
</script>
@endsection