@extends('layouts.app', ['title' => 'Registrar Cliente'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <form class="card card-user form-card" method="POST" action="/clientes" enctype="multipart/form-data">
      <div class="card-header">
        <h5 class="card-title d-flex align-items-center">
          <span class="pr-2">Registrar Cliente</span>
          <div class="custom-control custom-switch ml-auto @error('enabled') is-invalid @enderror"  style="font-size: 12px;text-transform: none;font-weight: 500;">
          <input type="checkbox" class="custom-control-input" id="enabled" value="1" {{old('enabled') == 1 ? 'checked': ''}} name="enabled">
          <label class="custom-control-label text-dark" for="enabled">Activo</label>
          @error('enabled')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
        </div>
        </h5>
      </div>
      <div class="card-body">
          @csrf
          <div class="row">
            <div class="col-md-3 form-group">
                <label class="col-form-label">RUC del cliente</label>
                <input type="text" class="form-control @error('ruc') is-invalid @enderror" placeholder="Ingrese Ruc del cliente" value="{{ old('ruc') }}" name='ruc' id="inputruc">
              @error('ruc')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-9 form-group">
                <label class="col-form-label">Razon social</label>
                <input type="text" class="form-control @error('razon_social') is-invalid @enderror" placeholder="Ingrese Razon Social" value="{{ old('razon_social') }}" name="razon_social">
              @error('razon_social')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-form-label">Direccion</label>
                <input type="text" class="form-control @error('direccion') is-invalid @enderror" placeholder="Ingrese la dirección" value="{{ old('direccion') }}" name="direccion">
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label">Telefono de contacto</label>
                <input type="text" class="form-control @error('telefono') is-invalid @enderror" placeholder="" value="{{ old('telefono') }}" name="telefono">
            </div>
            <div class="col-md-3 form-group">
              <div class="">
                <label class="col-form-label">Celular</label>
                <input type="text" class="form-control @error('celular') is-invalid @enderror" placeholder="" value="{{ old('celular') }}" name="celular">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-3 form-group">
                <label class="col-form-label">Persona de Contacto</label>
                <input type="text" class="form-control @error('contacto') is-invalid @enderror" placeholder="Ingrese Nombre de Contacto" value="{{ old('contacto') }}" name="contacto">
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label">Teléfono de contacto</label>
                <input type="text" class="form-control @error('telefono_contacto') is-invalid @enderror" placeholder="Ingrese Teléfono de contacto" value="{{ old('telefono_contacto') }}" name="telefono_contacto">
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label">Correo Electrónico</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Ingrese Correo Electrónico" value="{{ old('email') }}" name="email">
              @error('email')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label">Información</label>
                <input type="text" class="form-control @error('info') is-iinfonvalid @enderror" placeholder="Ingrese informacion" value="{{ old('info') }}" name="info">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label" for="selectTCliente">Ingrese Tipo Cliente</label>
              <select style="width: 100%" class="form-control dropdown2 @error('client_type_id') is-invalid @enderror" name="client_type_id" id="selectTCliente">
                <option value="">Ingresa Tipo Cliente</option>
                @foreach($client_types as $c_type)
                <option value="{{ $c_type->id }}" {{old('client_type_id') == $c_type->id ? 'selected' : ''}}>{{ $c_type->name }}</option>
                @endforeach
              </select>
              @error('client_type_id')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Crear Cliente</button>
            </div>
          </div>
      </div>
    </form>
  </div>
</div>
@endsection