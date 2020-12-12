@php
$ot_id = "OT-".zerosatleft($ot->code, 3);
@endphp
@extends('layouts.app', ['title' => 'Taller para OT-'.$ot_id])
@section('css')
@endsection
@section('content')
@php
$role_names = validateActionbyRole();
$admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
$supervisor = in_array("supervisor", $role_names);
$ot_date = date('d-m-Y', strtotime($ot->created_at));
$potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
@endphp
<div class="row">
  <div class="col-md-12">
    <h5 class="h5">Taller para {{$ot_id}}</h5>
    <form class="form-group" method="POST" action="{{route('workshop.store', $ot)}}" enctype="multipart/form-data">
      @csrf
      @foreach($services as $service_key => $service_item)
      @php
      $first = reset($service_item);
      @endphp
      @if ($admin || ($first['area_id'] == $user_area_id))
      <div class="card form-card h-100" data-id="{{$first['area_id']}}">
        <div class="card-header">
          <h5 class="card-title">{{$first['area']}}</h5>
        </div>
        <div class="card-body">
          <h5 class="small text-dark">Servicios</h5>
          <div class="table-responsive pb-0">
            <table class="table table-separate data-table mb-0">
              <thead class=" text-primary">
                {{-- <th class="text-nowrap px-2">ID</th> --}}
                <th class="text-nowrap px-2">Fecha OT</th>
                <th class="text-nowrap">N° de OT</th>
                <th>Potencia</th>
                <th class="text-nowrap">Servicio</th>
                <th class="text-nowrap">Descripción</th>
                <th class="text-center">Personal</th>
                <th class="text-center">Acciones</th>
              </thead>
              <tbody>
                @foreach($service_item as $service)
                @php
                $service_personal = old("personal_name_".$service['ot_work_id'], $service['user_name']);
                @endphp
                <tr class="list-item" data-service="{{$service['ot_work_id']}}">
                  {{-- <td>{{$service['id']}}</td> --}}
                  <td class="px-2 text-nowrap">{{$ot_date}}</td>
                  <td>{{$ot_id}}</td>
                  <td>{{$potencia}}</td>
                  <td width="250">
                    <h6 class="subtitle mb-0">{{$service['service']}}</h6>
                  </td>
                  <td>{{$service['description']}}</td>
                  <td>
                    <div class="text-center service-personal @error("data.".$service['ot_work_id'].".user_id") d-block is-invalid @enderror">
                      <span class="form-control mt-0 h-auto personal_name" name="personal_name_{{$service['ot_work_id']}}" style="white-space: nowrap;text-overflow: ellipsis;width: 120px;overflow: hidden;" title="{{$service_personal}}" data-toggle="tooltip"> {{ $service_personal ?? '-' }}</span>
                      <input class="form-control user_id d-none" type="text" name="data[{{$service['ot_work_id']}}][user_id]" value="{{ old('data.'.$service['ot_work_id'].'.user_id', $service['user_id']) }}">
                      <input class="form-control d-none" type="text" name="data[{{$service['ot_work_id']}}][ot_work_id]" value="{{ old('data.'.$service['ot_work_id'].'.ot_work_id',  $service['ot_work_id']) }}">
                    </div>
                  </td>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm btn-personal my-0 d-flex align-items-center" data-area="{{$first['area']}}" data-areaid="{{$first['area_id']}}" data-service="{{$service['ot_work_id']}}" data-toggle="modal" data-target="#modalPersonal"><i class="fal fa-user-hard-hat mr-2"></i> {{$service_personal ? 'Cambiar Personal': 'Asignar Personal'}}</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endif
      @endforeach
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
        <div class="search bg-white">
          <input class="form-control p-search" type="text" placeholder="Buscar personal">
        </div>
        <ul class="list-group user-select-none" style="max-height: 380px;max-height: calc(100vh - 240px); overflow-y: auto">
          @foreach ($users as $user)
          <li type="button" data-userid="{{$user->id}}" data-areaid="{{$user->area_id}}" class="list-group-item list-group-item-action d-none"><span class="align-middle personal">{{$user->name .' '.$user->last_name.' '.$user->mother_last_name}} {{-- - {{$user->area}} --}}</span> <span class="badge badge-dark align-middle">Seleccionar</span></li>
          @endforeach
        </ul>
      </div>
      <div class="modal-footer">
        <div class="update ml-auto mr-auto">
          <button type="button" id="btnPersonal" data-service="" class="btn btn-primary btn-round px-md-5" data-dismiss="modal">Confirmar personal</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $('#modalPersonal .list-group-item').on('click dblclick', function () {
    $('#modalPersonal .list-group-item').removeClass('active');
    $(this).addClass('active');
    $('#btnPersonal').prop('disabled', false);
  })

  $('#modalPersonal .list-group-item').bind('dblclick', function () {
    $('#btnPersonal').trigger('click');
  })

  $('#btnPersonal').on('click', function () {
    var $this = $(this),
        item = $('#modalPersonal .list-group-item.active'),
        userid = item.data('userid'),
        areaid = item.data('areaid'),
        personal = item.find('.personal').text();

    var service_item = $('.list-item[data-service="'+$this.data('service')+'"] .service-personal');
    service_item.show();
    service_item.find('.personal_name').text(personal).attr({
      'title': personal,
    });
    service_item.find('.user_id').val(userid);
  })

  $('#modalPersonal').on('hide.bs.modal', function (event) {
    $('.p-search').val('').trigger('keyup');
  })

  $('#modalPersonal').on('show.bs.modal', function (event) {
    var btn = $(event.relatedTarget), area_id = btn.data('areaid');
    $('#modalPersonal .modal-title span').text(" de "+btn.data('area'));
    $('#modalPersonal .list-group-item').addClass('d-none');
    $('#modalPersonal #btnPersonal').data('service', btn.data('service'));
    $('#modalPersonal .list-group-item[data-areaid="'+area_id+'"]').removeClass('d-none');
    $('#modalPersonal .list-group-item.active').removeClass('active');
    $('#btnPersonal').prop('disabled', true);
  })

  $('.p-search').on('keyup', function() {
        var filter = $(this).val();
        $(".list-group li:not(.d-none)").each(function () {
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).hide();
            } else {
                $(this).show()
            }
        });
    })
</script>
@endsection