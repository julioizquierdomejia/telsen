@extends('layouts.app', ['title' => 'Crear Usuario'])
@section('css')
@endsection
@section('content')
<form class="card card-user form-card" method="POST" action="{{route('users.store')}}" enctype="multipart/form-data">
  <div class="card-header">
    <h5 class="card-title d-flex align-items-center">
      <span class="pl-2">Crear Usuario</span>
      <div class="custom-control custom-switch ml-auto @error('enabled') is-invalid @enderror"  style="font-size: 12px;text-transform: none;font-weight: 500;">
        <input type="checkbox" class="custom-control-input" id="enabled" value="1" {{old('enabled') == 1 ? 'checked': ''}} name="enabled">
        <label class="custom-control-label text-dark" for="enabled">Activo</label>
        @error('enabled')
          <p class="error-message text-danger">{{ $message }}</p>
        @enderror
      </div>
    </h5>
  </div>
    @csrf
    <div class="card-body">
        <div class="row">
          <div class="form-group col-12 col-md-4">
            <label class="col-form-label" for="inputname">Nombre</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre" value="{{old('name')}}" name='name' id="inputname">
            @error('name')
              <p class="error-message text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-12 col-md-4">
            <label class="col-form-label" for="inputlastname">Apellidos Paterno</label>
            <input type="text" class="form-control @error('lastname') is-invalid @enderror" placeholder="Apellidos Paterno" value="{{old('lastname')}}" name='lastname' id="inputlastname">
            @error('lastname')
              <p class="error-message text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-12 col-md-4">
            <label class="col-form-label" for="inputmlastname">Apellidos Materno</label>
            <input type="text" class="form-control @error('mlastname') is-invalid @enderror" placeholder="Apellidos Materno" value="{{old('mlastname')}}" name='mlastname' id="inputmlastname">
            @error('mlastname')
              <p class="error-message text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-12 col-md-4">
            <label class="col-form-label" for="inputemail">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}" name='email' id="inputemail">
            @error('email')
              <p class="error-message text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-12 col-md-4">
            <label class="col-form-label" for="inputphone">Teléfono</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Email" value="{{old('phone')}}" name='phone' id="inputphone">
            @error('phone')
              <p class="error-message text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-12 col-md-4">
            <label class="col-form-label" for="inputpassword">Contraseña</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Email" value="{{old('password')}}" name='password' id="inputpassword">
            @error('password')
              <p class="error-message text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-6">
            <label class="col-form-label" for="selectRol">Roles</label>
            <ul class="form-check-list list-inline m-0 form-control h-auto @error('roles') is-invalid @enderror">
              @foreach($roles as $key => $role)
              <li class="form-check" id="role_{{$key}}">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" value="{{$role->id}}" {{in_array($role->id, old('roles', [])) ? 'checked' : ''}} name="roles[]"><span class="align-middle">{{$role->description}}</span>
                </label>
              </li>
              @endforeach
            </ul>
            @error('roles')
              <p class="error-message text-danger">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-6">
            <label class="col-form-label" for="selectArea">Area</label>
            <select name="area_id" class="form-control dropdown2 @error('area_id') is-invalid @enderror" id="selectArea" data-placeholder="Selecciona el area">
              <option value="">Selecciona el area</option>
              @foreach($areas as $key => $area)
              <option value="{{ $area->id }}" {{old('area_id') == $area->id ? 'selected' : ''}}>{{ $area->name }}</option>
              @endforeach
            </select>
            @error('area_id')
              <p class="error-message text-danger">{{ $message }}</p>
            @enderror
          </div>
        </div>
    </div>
    <div class="buttons text-center">
      <button class="btn btn-primary" type="submit">Enviar</button>
    </div>
</form>
@endsection
@section('javascript')
<script>
  /*$('#selectRol').on('change', function (event) {
    var $this = $(this),
        val = $this.val();
    if(val == 1) {
      $('#selectArea').prop('disabled', true);
      $('#selectArea option[value=1]').prop('selected', '');
    } else {
      $('#selectArea').prop('disabled', false);
    }
  })*/
</script>
@endsection