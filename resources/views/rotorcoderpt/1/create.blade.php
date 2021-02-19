@extends('layouts.app', ['title' => 'Crear Rotor Code Pt 1'])
@section('content')
<form class="card card-user form-card" method="POST" action="/rotorcoderodajept/1" enctype="multipart/form-data">
  <div class="card-header">
    <h5 class="card-title d-flex align-items-center">
      <span class="pl">Crear Código</span>
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
      	<div class="col-md-12 form-group">
            <label class="col-form-label">Nombre</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="" value="{{old('name')}}" name='name' id="inputname">
      			@error('name')
      				<p class="error-message text-danger">{{ $message }}</p>
      			@enderror
        </div>

        <div class="col-md-12 form-group">
            <label class="col-form-label">Asiento</label>
            <input class="form-control @error('asiento_rodaje') is-invalid @enderror" placeholder="" name="asiento_rodaje" value="{{old('asiento_rodaje')}}">
    				@error('asiento_rodaje')
    					<p class="error-message text-danger">{{ $message }}</p>
    				@enderror
        </div>
        <div class="col-md-12 form-group">
            <label class="col-form-label">Alojamiento</label>
            <input class="form-control @error('alojamiento_rodaje') is-invalid @enderror" placeholder="" name="alojamiento_rodaje" value="{{old('alojamiento_rodaje')}}">
            @error('alojamiento_rodaje')
              <p class="error-message text-danger">{{ $message }}</p>
            @enderror
        </div>
      </div>

      <div class="row">
        <div class="update ml-auto mr-auto">
          <button type="submit" class="btn btn-primary btn-round">Enviar</button>
        </div>
      </div>
  </div>
</form>
@endsection