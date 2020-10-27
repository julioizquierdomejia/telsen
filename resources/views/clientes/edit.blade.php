@extends('layouts.app', ['title' => 'Editar '. $cliente->razon_social])

@section('content')

<div class="row">
  
  <div class="col-md-12">
    <div class="card card-user">
      <div class="card-header">
        <h5 class="card-title">Editar Cliente <strong>{{$cliente->razon_social}}</strong></h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="{{route('clientes.edit', ['client' => $cliente->id])}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
          	<div class="col-md-3">
              <div class="form-group">
                <label>RUC del cliente</label>
                <input type="text" class="form-control @error('ruc') is-invalid @enderror" placeholder="" value="{{$cliente->ruc}}" name='ruc' id="inputruc">
              </div>
          			@error('ruc')
          				<p class="error-message text-danger">{{ $message }}</p>
          			@enderror
            </div>


            <div class="col-md-8">
              <div class="form-group">
                <label>Razon social</label>
                <input type="text" class="form-control @error('razon_social') is-invalid @enderror" placeholder="" value="{{$cliente->razon_social}}" name="razon_social">
              </div>
        				@error('razon_social')
        					<p class="error-message text-danger">{{ $message }}</p>
        				@enderror
            </div>
          </div>
          <div class="row">
          	<div class="col-md-6">
              <div class="form-group">
                <label>Direccion</label>
                <input type="text" class="form-control @error('direccion') is-invalid @enderror" placeholder="" value="{{$cliente->direccion}}" name="direccion">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Telefono de contacto</label>
                <input type="text" class="form-control @error('telefono') is-invalid @enderror" placeholder="" value="{{$cliente->telefono}}" name="telefono">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Celular</label>
                <input type="text" class="form-control @error('celular') is-invalid @enderror" placeholder="" value="{{$cliente->celular}}" name="celular">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Persona de Contacto</label>
                <input type="text" class="form-control @error('contacto') is-invalid @enderror" placeholder="" value="{{$cliente->contacto}}" name="contacto">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Teléfono de contacto</label>
                <input type="text" class="form-control @error('telefono_contacto') is-invalid @enderror" placeholder="" value="{{$cliente->telefono_contacto}}" name="telefono_contacto">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" class="form-control @error('correo') is-invalid @enderror" placeholder="" value="{{$cliente->correo}}" name="correo">
              </div>
              @error('correo')
					<p class="error-message text-danger">{{ $message }}</p>
				@enderror
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Información</label>
                <input type="text" class="form-control @error('info') is-iinfonvalid @enderror" placeholder="" value="{{$cliente->info}}" name="info">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Actualizar Cliente</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection