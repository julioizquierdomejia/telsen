@extends('layouts.app', ['title' => 'Editar Rotor Code Pt 1'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Editar Código</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="{{route('rotorcoderpt1.edit', ['id' => $code->id])}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="col-form-label">Nombre</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="" value="{{old('name', $code->name)}}" name='name' id="inputname">
                @error('name')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-12 form-group">
                <label class="col-form-label">Asiento</label>
                <input type="text" class="form-control @error('asiento_rodaje') is-invalid @enderror" placeholder="" name="asiento_rodaje" value="{{old('asiento_rodaje', $code->asiento_rodaje)}}">
                @error('asiento_rodaje')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-12 form-group">
                <label class="col-form-label">Alojamiento</label>
                <input class="form-control @error('alojamiento_rodaje') is-invalid @enderror" placeholder="" name="alojamiento_rodaje" value="{{old('alojamiento_rodaje', $code->alojamiento_rodaje)}}">
                @error('alojamiento_rodaje')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label">Estado</label>
              <select name="enabled" class="form-control @error('enabled') is-invalid @enderror dropdown2" id="selectEstado">
                <option value="1" {{old('enabled', $code->enabled) == 1 ? 'selected' : ''}}>Activo</option>
                <option value="0" {{old('enabled', $code->enabled) == 0 ? 'selected' : ''}}>Inactivo</option>
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