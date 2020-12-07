@extends('layouts.app', ['title' => 'Crear Taller'])
@section('css')
@endsection
@section('content')
@php
$role_names = validateActionbyRole();
$admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
$supervisor = in_array("supervisor", $role_names);
var_dump(Auth::user()->toArray());
@endphp
<div class="row">
  <div class="col-md-12">
    <h5 class="h5">Taller para OT-{{zerosatleft($ot->id, 3)}}</h5>
    <form class="form-group" method="POST" action="{{route('workshop.store', $ot)}}" enctype="multipart/form-data">
      @csrf
      <div class="row">
      @foreach($services as $service_key => $service_item)
      @php
      $first = reset($service_item);
      @endphp
      <div class="col-12 col-sm-6 mb-4">
      <div class="card form-card h-100" data-id="{{$first['area_id']}}">
        <div class="card-header">
          <h5 class="card-title">{{$first['area']}}</h5>
        </div>
        <div class="card-body">
          <div class="bg-light px-3 py-2 h-100 d-flex flex-column">
          <h5 class="small text-dark">Servicios</h5>
          <ul class="list-group mb-3">
            @foreach($service_item as $service)
            <li class="list-group-item">
              <h6 class="subtitle mb-1">{{$service['service']}}</h6>
              {{-- <p class="mb-0">Subtotal: <span class="badge badge-secondary badge-pill px-3">{{number_format($service['subtotal'], 2)}}</span></p> --}}
            </li>
            @endforeach
          </ul>
          <div class="mt-auto text-center form-control @error("data.$service_key.user_id") is-invalid @enderror" style="height: auto; margin-top: 0">
              <label class="col-form-label mb-0">Personal asignado:</label>
              <input class="form-control personal_name" name="personal_name_{{$service_key}}" value="{{old("personal_name_$service_key")}}" readonly="" type="text" placeholder="No asignado">
              <input class="form-control user_id d-none" type="text" name="data[{{$service_key}}][user_id]" value="">
              <input class="form-control d-none" type="text" name="data[{{$service_key}}][area_id]" value="{{$first['area_id']}}">

              <button type="button" class="btn btn-primary btn-sm btn-personal" data-area="{{$first['area']}}" data-areaid="{{$first['area_id']}}" data-toggle="modal" data-target="#modalPersonal">Asignar Personal</button>
            </div>
          </div>
        </div>
      </div>
      </div>
      @endforeach
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