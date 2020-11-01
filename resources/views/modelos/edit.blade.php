@extends('layouts.app')

@section('content')

<div class="row">
  
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Editar modelo <strong>{{$modelo->name}}</strong></h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="{{route('modelos.edit', ['modelo' => $modelo->id])}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-form-label">Nombre</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="" value="{{$modelo->name}}" name="name">
              </div>
                @error('name')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label class="col-form-label">Descripción</label>
                <!-- <textarea class="form-control @error('description') is-invalid @enderror" placeholder="" value="{{$modelo->description}}" name="description"></textarea> -->
                <input type="text" class="form-control @error('description') is-invalid @enderror" placeholder="" value="{{$modelo->description}}" name="description">
              </div>
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