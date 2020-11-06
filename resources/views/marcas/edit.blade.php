@extends('layouts.app', ['title' => 'Marcas | '. $marca->name])

@section('content')

<div class="row">
  
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Editar marca <strong>{{$marca->name}}</strong></h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="{{route('marcas.edit', ['marca' => $marca->id])}}" enctype="multipart/form-data">
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
                <textarea class="form-control @error('description') is-invalid @enderror" placeholder="" value="{{$marca->description}}" name="description"></textarea>
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label">Estado</label>
              <select name="enabled" class="form-control @error('enabled') is-invalid @enderror dropdown2" id="selectEstado">
                <option value="1" {{$marca->enabled == 1 ? 'selected': ''}}>Activo</option>
                <option value="0" {{$marca->enabled == 0 ? 'selected': ''}}>Inactivo</option>
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