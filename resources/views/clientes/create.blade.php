@extends('layouts.app', ['title' => 'Registrar Cliente'])

@section('content')

<div class="row">
  
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Registrar Cliente</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="/clientes" enctype="multipart/form-data">
          @csrf
          <div class="row">
          	<div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">RUC del cliente</label>
                <input type="text" class="form-control @error('ruc') is-invalid @enderror" placeholder="Ingrese Ruc del cliente" value="{{ old('ruc') }}" name='ruc' id="inputruc">
              </div>
			@error('ruc')
				<p class="error-message text-danger">{{ $message }}</p>
			@enderror
            </div>


            <div class="col-md-8">
              <div class="form-group">
                <label class="col-form-label">Razon social</label>
                <input type="text" class="form-control @error('razon_social') is-invalid @enderror" placeholder="Ingrese Razon Social" value="{{ old('razon_social') }}" name="razon_social">
              </div>
				@error('razon_social')
					<p class="error-message text-danger">{{ $message }}</p>
				@enderror
            </div>
          </div>
          <div class="row">
          	<div class="col-md-6">
              <div class="form-group">
                <label class="col-form-label">Direccion</label>
                <input type="text" class="form-control @error('direccion') is-invalid @enderror" placeholder="" value="{{ old('direccion') }}" name="direccion">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Telefono de contacto</label>
                <input type="text" class="form-control @error('telefono') is-invalid @enderror" placeholder="" value="{{ old('telefono') }}" name="telefono">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Celular</label>
                <input type="text" class="form-control @error('celular') is-invalid @enderror" placeholder="" value="{{ old('celular') }}" name="celular">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Persona de Contacto</label>
                <input type="text" class="form-control @error('contacto') is-invalid @enderror" placeholder="Ingrese Nombre de Contacto" value="{{ old('contacto') }}" name="contacto">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Teléfono de contacto</label>
                <input type="text" class="form-control @error('telefono_contacto') is-invalid @enderror" placeholder="Ingrese Teléfono de contacto" value="{{ old('telefono_contacto') }}" name="telefono_contacto">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Correo Electrónico</label>
                <input type="email" class="form-control @error('correo') is-invalid @enderror" placeholder="Ingrese Correo Electrónico" value="{{ old('correo') }}" name="correo">
              </div>
              @error('corre')
					<p class="error-message text-danger">{{ $message }}</p>
				@enderror
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label class="col-form-label">Información</label>
                <input type="text" class="form-control @error('info') is-iinfonvalid @enderror" placeholder="Ingrese informacion" value="{{ old('info') }}" name="info">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Crear Cliente</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection