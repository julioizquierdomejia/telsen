@extends('layouts.app', ['title' => 'Crear Rotor Code Pt 2'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Crear Código</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="/rotorcoderpt2" enctype="multipart/form-data">
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
                <textarea class="form-control @error('asiento') is-invalid @enderror" placeholder="" name="asiento">{{old('asiento')}}</textarea>
        				@error('asiento')
        					<p class="error-message text-danger">{{ $message }}</p>
        				@enderror
            </div>
            <div class="col-md-12 form-group">
                <label class="col-form-label">Alojamiento</label>
                <textarea class="form-control @error('alojamiento') is-invalid @enderror" placeholder="" name="alojamiento">{{old('alojamiento')}}</textarea>
                @error('alojamiento')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label">Estado</label>
              <select name="enabled" class="form-control @error('enabled') is-invalid @enderror dropdown2" id="selectEstado">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
          </div>

          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Enviar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection