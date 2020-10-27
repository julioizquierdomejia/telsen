@extends('layouts.app')

@section('content')

<div class="row">
  
  <div class="col-md-12">
    <div class="card card-user">
      <div class="card-header">
        <h5 class="card-title">Crear Modelo</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="/modelos" enctype="multipart/form-data">
          @csrf
          <div class="row">
          	<div class="col-md-12">
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="" value="" name='name' id="inputname">
              </div>
          			@error('name')
          				<p class="error-message text-danger">{{ $message }}</p>
          			@enderror
            </div>

            <div class="col-md-12">
              <div class="form-group">
                <label>Descripción</label>
                <textarea type="text" class="form-control @error('description') is-invalid @enderror" placeholder="" value="" name="description"></textarea>
              </div>
        				@error('description')
        					<p class="error-message text-danger">{{ $message }}</p>
        				@enderror
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