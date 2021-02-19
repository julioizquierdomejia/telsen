@extends('layouts.app_real', ['title' => 'Crear Orden'])
@section('css')
@endsection
@section('content')
<form class="card card-user form-card" method="POST" action="/ordenes" enctype="multipart/form-data">
  <div class="card-header">
    <h5 class="card-title d-flex align-items-center">
      <span class="pr-2">Crear Orden de Trabajo</span>
      <div class="custom-control custom-switch ml-auto @error('enabled') is-invalid @enderror" style="font-size: 12px;text-transform: none;font-weight: 500;">
      <input type="checkbox" class="custom-control-input" id="enabled" value="1" {{old('enabled') == 1 ? 'checked': ''}} name="enabled">
      <label class="custom-control-label text-dark" for="enabled">Activo</label>
    </div>
    </h5>
  </div>
  <div class="card-body">
      @csrf
      <div class="row">
        <div class="col-6 col-md-5 form-group">
          <label class="col-form-label">Número de Orden</label>
          <input type="text" class="form-control" disabled="" placeholder="Company" value="0T - {{$ot_numero}}" name="id">
        </div>
        <div class="col-6 col-md-4 form-group">
          <label class="col-form-label">Fecha de creación <span class="text-danger">(*)</span></label>
          <input type="date" class="form-control" value="{{date('Y-m-d')}}" disabled="">
          <input type="hidden" name="user_id" class="form-control mb-2" value="{{ Auth::user()->id }}">
          @error('fecha_creacion')
          <p class="error-message text-danger">{{ $message }}</p>
          @enderror
        </div>
        <div class="col-6 col-md-3 form-group">
          <label class="col-form-label">Vendedor</label>
          <input type="text" name="guia_cliente" class="form-control @error('guia_cliente') is-invalid @enderror" placeholder="Ingrese Vendedor" value="{{old('guia_cliente')}}">
          @error('guia_cliente')
          <p class="error-message text-danger">{{ $message }}</p>
          @enderror
        </div>
        <div class="col-6 col-md-7 form-group">
          <label class="col-form-label" for="selectRuc">Razón Social</label>
          <select style="width: 100%" class="form-control dropdown2 @error('client_id') is-invalid @enderror" name="client_id" id="selectRuc">
            <option value="">Ingresa Razón Social</option>
            @foreach($clientes as $cliente)
            <option data-rs="{{ $cliente->ruc }}" data-dir="{{ $cliente->direccion }}" data-contacto="{{$cliente->telefono_contacto}}" data-celular="{{$cliente->celular}}" data-type="{{$cliente->client_type}}" value="{{ $cliente->id }}" {{old('client_id') == $cliente->id ? 'selected' : ''}}>{{ $cliente->ruc .' - '.$cliente->razon_social }}</option>
            @endforeach
          </select>
          @error('client_id')
          <p class="error-message text-danger">{{ $message }}</p>
          @enderror
        </div>
        {{-- <div class="col-md-6 form-group">
          <label class="col-form-label">Razon social</label>
          <input type="text" class="form-control razon_social" placeholder="" value="" disabled="" name="name">
        </div> --}}
        <div class="col-4 col-md-2 form-group">
          <label class="col-form-label">Tipo Cliente</label>
          <input type="text" class="form-control tipocliente" placeholder="" value="" disabled="" name="address">
        </div>
        <div class="col-6 col-md-3 form-group bg-danger" style="box-shadow: 0 7px 0px 0 #e3342f;">
          <label class="col-form-label text-primary" for="selectPriority">Prioridad</label>
          <select style="width: 100%" name="priority" class="form-control @error('priority') is-invalid @enderror dropdown2" id="selectPriority">
            <option value="0">Normal</option>
            <option value="1">Alta</option>
          </select>
        </div>
        <div class="col-md-6 form-group">
          <label class="col-form-label">Dirección</label>
          <input type="text" class="form-control direccion" placeholder="" value="" disabled="" name="address">
        </div>
        <div class="col-6 col-md-3 form-group">
          <label class="col-form-label">Telefono de contacto</label>
          <input type="text" class="form-control telefono_contacto" placeholder="" value="" disabled="" name="phone">
        </div>
        <div class="col-6 col-md-3 form-group">
          <label class="col-form-label">Celular</label>
          <input type="text" class="form-control celular" placeholder="" value="" disabled="" name="celular">
        </div>
      </div>
      <h5 class="text-danger mt-4">Datos del Motor</h5>
      <div class="row">
        <div class="col-md-12 form-group">
          <label class="col-form-label" for="descripcion_motor">Descripción del motor</label>
          <input type="text" class="form-control @error('descripcion_motor') is-invalid @enderror" id="descripcion_motor" placeholder="Ingrese descripción" value="{{old('descripcion_motor')}}" name="descripcion_motor">
        </div>
        <div class="col-6 col-md-3 form-group">
          <label class="col-form-label" for="codigo_motor">Código</label>
          <input type="text" class="form-control @error('codigo_motor') is-invalid @enderror" id="codigo_motor" name="codigo_motor" placeholder="Ingrese código del motor" value="{{old('codigo_motor')}}">
        </div>
        <div class="col-6 col-md-3 form-group">
          <label class="col-form-label" for="selectMarca">Marca</label>
          <!-- <input type="text" class="form-control @error('fecha_creacion') is-invalid @enderror" placeholder="Ingrese Marca" value="" name="marca"> -->
          <select style="width: 100%" name="marca_id" class="form-control @error('marca_id') is-invalid @enderror dropdown2" id="selectMarca">
            <option value="">Selecciona la marca</option>
            @foreach($marcas as $marca)
            <option value="{{ $marca->id }}" {{old('marca_id') == $marca->id ? 'selected' : ''}}>{{ $marca->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-6 col-md-3 form-group">
          <label class="col-form-label" for="solped">Solped</label>
          <input type="text" min="1" class="form-control @error('solped') is-invalid @enderror" placeholder="Solped" value="{{old('solped')}}" id="solped" name="solped">
        </div>
        <div class="col-6 col-md-3 form-group">
          <label class="col-form-label" for="selectModelo">Modelo</label>
          <!-- <input type="text" class="form-control @error('modelo_id') is-invalid @enderror" placeholder="Ingrese Modelo" value="" name="modelo"> -->
          <select style="width: 100%" name="modelo_id" class="form-control @error('modelo_id') is-invalid @enderror dropdown2" id="selectModelo">
            <option value="">Selecciona el modelo</option>
            @foreach($modelos as $modelo)
            <option value="{{ $modelo->id }}" {{old('modelo_id') == $modelo->id ? 'selected' : ''}}>{{ $modelo->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      
      <div class="row">
        <div class="col-6 col-md-3 form-group">
          <label class="col-form-label" for="numero_potencia">Potencia</label>
          <input type="text" class="form-control @error('numero_potencia') is-invalid @enderror" placeholder="Potencia" value="{{old('numero_potencia')}}" id="numero_potencia" name="numero_potencia">
        </div>
        <div class="col-6 col-md-3 form-group">
          <label class="col-form-label" for="medida_potencia">Unidad de medida (hp/kw)</label>
          <input type="text" class="form-control @error('medida_potencia') is-invalid @enderror" placeholder="Unidad de medida (hp/kw)" value="{{old('medida_potencia')}}" id="medida_potencia" name="medida_potencia">
        </div>
        <div class="col-6 col-md-3 form-group">
          <label class="col-form-label" for="voltaje">Voltaje</label>
          <input type="text" class="form-control @error('voltaje') is-invalid @enderror" placeholder="Voltaje" value="{{old('voltaje')}}" id="voltaje" name="voltaje">
        </div>
        <div class="col-6 col-md-3 form-group">
          <label class="col-form-label" for="velocidad">Velocidad</label>
          <input type="text" class="form-control @error('velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{old('velocidad')}}" id="velocidad" name="velocidad">
        </div>
      </div>
      <div class="row">
        <div class="update ml-auto mr-auto">
          <button type="submit" class="btn btn-primary btn-round">Crear Orden de Trabajo</button>
        </div>
      </div>
  </div>
</form>
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
})
</script>
@endsection