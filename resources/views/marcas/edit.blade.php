@extends('layouts.app', ['title' => 'Marcas | '. $marca->name])

@section('content')
<div class="row">
  <div class="col-md-12">
    <form class="card card-user form-card" method="POST" action="{{route('marcas.edit', ['marca' => $marca->id])}}" enctype="multipart/form-data">
      <div class="card-header">
        <h5 class="card-title d-flex align-items-center">
          <span class="pl-2">Editar marca <strong>{{$marca->name}}</strong></span>
          <div class="custom-control custom-switch ml-auto @error('enabled') is-invalid @enderror"  style="font-size: 12px;text-transform: none;font-weight: 500;">
          <input type="checkbox" class="custom-control-input" id="enabled" value="1" {{old('enabled', $marca->enabled) == 1 ? 'checked': ''}} name="enabled">
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
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="" value="{{$marca->name}}" name="name">
                @error('name')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-12 form-group">
                <label class="col-form-label">Descripción</label>
                <textarea class="form-control @error('description') is-invalid @enderror" placeholder="" name="description">{{$marca->description}}</textarea>
            </div>
          </div>

          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Actualizar</button>
            </div>
          </div>
      </div>
    </form>
  </div>
</div>

@endsection