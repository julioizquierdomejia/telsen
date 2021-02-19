@extends('layouts.app_real', ['title' => 'Editar Perfil'])
@section('content')
@php
  $is_current = auth()->id() == $user->id;
  $edit_route = $is_current ? route('users.perfil') : route('users.edit', $user->id)
@endphp
<form class="card form-card h-100" method="POST" action="{{$edit_route}}" enctype="multipart/form-data">
  @csrf
    <div class="card-header">
    <h5 class="card-title d-flex align-items-center">
      <span class="pl-2">
        @if ($is_current)
        Hola, {{$user->data->name}}
        @else
        Perfil de {{$user->data->name}}
        @endif
      </span>
      @if ($user->id != Auth::id() && $is_admin)
      <div class="custom-control custom-switch ml-auto @error('enabled') is-invalid @enderror"  style="font-size: 12px;text-transform: none;font-weight: 500;">
        <input type="checkbox" class="custom-control-input" id="enabled" value="1" {{old('enabled') == 1 ? 'checked': ''}} name="enabled">
        <label class="custom-control-label text-dark" for="enabled">Activo</label>
        @error('enabled')
          <p class="error-message text-danger">{{ $message }}</p>
        @enderror
      </div>
      @endif
    </h5>
  </div>
    <div class="card-body">
      <div class="row">
        <div class="form-group col-12 col-md-4">
          <label class="col-form-label" for="inputname">Nombre</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre" value="{{old('name', $user->data->name)}}" name='name' id="inputname">
          @error('name')
            <p class="error-message text-danger">{{ $message }}</p>
          @enderror
        </div>
        <div class="form-group col-12 col-md-4">
          <label class="col-form-label" for="inputlastname">Apellidos Materno</label>
          <input type="text" class="form-control @error('lastname') is-invalid @enderror" placeholder="Apellidos Materno" value="{{old('lastname', $user->data->last_name)}}" name='lastname' id="inputlastname">
          @error('lastname')
            <p class="error-message text-danger">{{ $message }}</p>
          @enderror
        </div>
        <div class="form-group col-12 col-md-4">
          <label class="col-form-label" for="inputmlastname">Apellidos Paterno</label>
          <input type="text" class="form-control @error('mlastname') is-invalid @enderror" placeholder="Apellidos Paterno" value="{{old('mlastname', $user->data->mother_last_name)}}" name='mlastname' id="inputmlastname">
          @error('mlastname')
            <p class="error-message text-danger">{{ $message }}</p>
          @enderror
        </div>
        <div class="form-group col-12 col-md-4">
          <label class="col-form-label" for="inputemail">Email</label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email', $user->email)}}" name='email' id="inputemail">
          @error('email')
            <p class="error-message text-danger">{{ $message }}</p>
          @enderror
        </div>
        <div class="form-group col-12 col-md-4">
          <label class="col-form-label" for="inputphone">Teléfono</label>
          <input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Email" value="{{old('phone', $user->data->user_phone)}}" name='phone' id="inputphone">
          @error('phone')
            <p class="error-message text-danger">{{ $message }}</p>
          @enderror
        </div>
        <div class="form-group col-12 col-md-4">
          <label class="col-form-label" for="inputpassword">Contraseña</label>
          <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Email" value="{{ old('password') }}" name='password' id="inputpassword">
          @error('password')
            <p class="error-message text-danger">{{ $message }}</p>
          @enderror
        </div>
        <div class="form-group col-md-6">
          @php
            $userRoles = array_column($user->roles->toArray(), 'id');
          @endphp
          <label class="col-form-label" for="selectRol">Roles</label>
          @if (!$is_current)
          <ul class="form-check-list list-inline m-0 form-control h-auto">
            @foreach($roles as $key => $role)
            @php
              $isChecked = in_array($role->id, $userRoles);
            @endphp
            <li class="form-check" id="role_{{$key}}">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input align-middle" value="{{$role->id}}" {{in_array($role->id, old('roles', [])) || $isChecked ? 'checked' : ''}} name="roles[]"><span class="align-middle @if ($isChecked) badge badge-primary @endif">{{$role->description}}</span>
              </label>
            </li>
            @endforeach
          </ul>
          @else
          <ul class="form-check-list list-inline m-0 form-control h-auto">
            @foreach($user->roles as $key => $role)
            <li class="check-item">
              <label class="form-check-label">
                <span class="badge badge-primary">{{$role->description}}</span>
              </label>
            </li>
            @endforeach
          </ul>
          @endif
          @error('roles')
            <p class="error-message text-danger">{{ $message }}</p>
          @enderror
        </div>
        <div class="form-group col-md-4">
          <label class="col-form-label" for="selectArea">Area</label>
          <select name="area_id" class="form-control dropdown2 @error('area_id') is-invalid @enderror" id="selectArea" data-placeholder="Selecciona el area">
            <option value="">Selecciona el area</option>
            @foreach($areas as $key => $area)
            <option value="{{ $area->id }}" {{old('area_id', $user->data->area_id) == $area->id ? 'selected' : ''}}>{{ $area->name }}</option>
            @endforeach
          </select>
          @error('area_id')
            <p class="error-message text-danger">{{ $message }}</p>
          @enderror
          {{-- <label class="col-label d-block" for="selectArea">Area</label>
        <span class="badge badge-primary px-2 py-1">{{$user->area}}</span> --}}
        </div>
      </div>
    </div>
  <div class="buttons text-center">
    <button class="btn btn-primary" type="submit">Enviar</button>
  </div>
</form>
@endsection