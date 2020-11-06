@extends('layouts.app', ['title' => 'Crear servicio'])

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Crear Servicio</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="/servicios" enctype="multipart/form-data">
          @csrf
          <div class="row">
          	<div class="col-md-12 form-group">
                <label class="col-form-label">Nombre</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="" value="" name='name' id="inputname">
          			@error('name')
          				<p class="error-message text-danger">{{ $message }}</p>
          			@enderror
            </div>

            <div class="col-md-6 form-group">
                <label class="col-form-label" for="selectArea">Area</label>
                <select class="form-control dropdown2 @error('area_id') is-invalid @enderror" name="area_id" id="selectArea">
                  <option value="">Ingresa Area</option>
                  @foreach($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->name }}</option>
                  @endforeach
                </select>
                @error('area_id')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-3 ml-md-auto form-group">
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