@extends('layouts.app', ['title' => 'Servicios | '. $service->name])

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Editar service <strong>{{$service->name}}</strong></h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="{{route('services.edit', ['servicio' => $service->id])}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-form-label">Nombre</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="" value="{{$service->name}}" name="name">
              </div>
                @error('name')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-3 form-group">
              <label class="col-form-label">Estado</label>
              <select name="enabled" class="form-control @error('enabled') is-invalid @enderror dropdown2" id="selectEstado">
                <option value="1" {{$service->enabled == 1 ? 'selected': ''}}>Activo</option>
                <option value="0" {{$service->enabled == 0 ? 'selected': ''}}>Inactivo</option>
              </select>
            </div>
            
          </div>
          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Actualizar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection