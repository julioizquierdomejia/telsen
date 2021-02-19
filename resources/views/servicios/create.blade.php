@extends('layouts.app_real', ['title' => 'Crear servicio'])

@section('content')
<form class="card card-user form-card" method="POST" action="/servicios" enctype="multipart/form-data">
  <div class="card-header">
    <h5 class="card-title">
      <span class="pl-2">Crear Servicio</span>
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
    </div>

    <div class="row">
      <div class="update ml-auto mr-auto">
        <button type="submit" class="btn btn-primary btn-round">Enviar</button>
      </div>
    </div>
  </div>
</form>
@endsection