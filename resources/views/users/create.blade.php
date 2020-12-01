@extends('layouts.app', ['title' => 'Crear Usuario'])
@section('css')
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <h5 class="h5">Crear Usuario</h5>
    <form class="form-group" method="POST" action="{{route('users.store')}}" enctype="multipart/form-data">
      @csrf
      <div class="card form-card h-100">
        <div class="card-body">
          <div class="row">
            <div class="form-group col-12 col-md-4">
              <label class="col-form-label" for="inputname">Nombre</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre" value="{{old('name', $user->name)}}" name='name' id="inputname">
              @error('name')
                <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="form-group col-12 col-md-4">
              <label class="col-form-label" for="inputlastname">Apellidos Materno</label>
              <input type="text" class="form-control @error('lastname') is-invalid @enderror" placeholder="Apellidos Materno" value="{{old('lastname', $user->lastname)}}" name='lastname' id="inputlastname">
              @error('lastname')
                <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="form-group col-12 col-md-4">
              <label class="col-form-label" for="inputmlastname">Apellidos Paterno</label>
              <input type="text" class="form-control @error('mlastname') is-invalid @enderror" placeholder="Apellidos Paterno" value="{{old('mlastname', $user->mlastname)}}" name='mlastname' id="inputmlastname">
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
              <input type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="Email" value="{{old('phone', $user->phone)}}" name='phone' id="inputphone">
              @error('phone')
                <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="form-group col-12 col-md-4">
              <label class="col-form-label" for="inputpassword">Contraseña</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Email" value="{{old('password', $user->password)}}" name='password' id="inputpassword">
              @error('password')
                <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>
      </div>
      <div class="buttons text-center">
        <button class="btn btn-primary" type="submit">Registrar Taller</button>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" tabindex="-1" id="modalPersonal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Personal <span></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <ul class="list-group" style="max-height: 380px;max-height: calc(100vh - 240px); overflow-y: auto">
            @foreach ($users as $user)
            <li type="button" data-userid="{{$user->id}}" data-areaid="{{$user->area_id}}" class="list-group-item list-group-item-action" style="display: none;"><span class="align-middle personal">{{$user->name .' '.$user->last_name.' '.$user->mother_last_name}} {{-- - {{$user->area}} --}}</span> <span class="badge badge-dark align-middle">Seleccionar</span></li>
            @endforeach
          </ul>
        </div>
        <div class="modal-footer">
          <div class="update ml-auto mr-auto">
            <button type="button" id="btnPersonal" disabled="" class="btn btn-primary btn-round px-md-5" data-dismiss="modal">Confirmar personal</button>
          </div>
        </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $('.btn-personal').click(function () {
    var btn = $(this), area_id = btn.data('areaid');
    $('#modalPersonal .modal-title span').text(" de "+btn.data('area'));
    $('#modalPersonal .list-group-item').hide();
    $('#modalPersonal .list-group-item[data-areaid="'+area_id+'"]').show();
  })

  $('#modalPersonal .list-group-item').click(function () {
    $('#modalPersonal .list-group-item').removeClass('active');
    $(this).addClass('active');
    $('#btnPersonal').prop('disabled', false);
  })

  $('#btnPersonal').click(function () {
    var item = $('#modalPersonal .list-group-item.active'),
        userid = item.data('userid'),
        areaid = item.data('areaid'),
        personal = item.find('.personal').text();
        console.log(userid)
        console.log(areaid)
    $('.form-card[data-id="'+areaid+'"] .personal_name').val(personal);
    $('.form-card[data-id="'+areaid+'"] .user_id').val(userid);
  })

  $('#modalPersonal').on('show.bs.modal', function () {
    $('#modalPersonal .list-group-item.active').removeClass('active');
    $('#btnPersonal').prop('disabled', true);
  })
</script>
@endsection