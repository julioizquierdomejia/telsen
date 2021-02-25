@php
$ot_code = "OT-".zerosatleft($ot->code, 3);
@endphp
@extends('layouts.app', ['title' => 'Taller para OT-'.$ot_code])
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
    <form class="form-group" method="POST" action="{{route('workshop.store', $ot)}}" enctype="multipart/form-data">
      <div class="card">
        <div class="card-header row mx-0 align-items-center py-2 justify-content-between">
          <h5 class="h5 my-1 mr-2">Taller para {{$ot_code}}</h5>
        <button class="btn btn-primary my-1" type="submit">Registrar Taller</button>
        </div>
      </div>
      @csrf
      @foreach($services as $service_key => $service_item)
      @php
      $first = reset($service_item);
      @endphp
      @if ($admin || $supervisor || ($first['area_id'] == $user_area_id))
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
                <th class="text-center">Trabajador</th>
                <th class="text-center">Medidas</th>
                <th class="text-center">Cant.</th>
                <th class="text-center">Trabajador</th>
                <th class="text-center">Acciones</th>
              </thead>
              <tbody>
                @foreach($service_item as $service)
                @php
                $service_trabajador = old("trabajador_name_".$service['ot_work_id'], $service['user_name']);
                @endphp
                <tr class="list-item" data-service="{{$service['ot_work_id']}}">
                  {{-- <td>{{$service['id']}}</td> --}}
                  <td class="px-2 text-nowrap">{{$ot_date}}</td>
                  <td>{{$ot_code}}</td>
                  <td>{{$potencia}}</td>
                  <td width="250">
                    <h6 class="subtitle mb-0">{{$service['service']}}</h6>
                  </td>
                  <td>{{$service['description']}}</td>
                  <td>{{$service['medidas']}}</td>
                  <td>{{$service['qty']}}</td>
                  <td>{{$service['personal']}}</td>
                  <td>
                    <div class="text-center service-trabajador @error("data.".$service['ot_work_id'].".user_id") d-block is-invalid @enderror">
                      <span class="form-control mt-0 h-auto trabajador_name" name="trabajador_name_{{$service['ot_work_id']}}" style="white-space: nowrap;text-overflow: ellipsis;width: 120px;overflow: hidden;" title="{{$service_trabajador}}" data-toggle="tooltip"> {{ $service_trabajador ?? '-' }}</span>
                      <input class="form-control user_id d-none" type="text" name="data[{{$service['ot_work_id']}}][user_id]" value="{{ old('data.'.$service['ot_work_id'].'.user_id', $service['user_id']) }}">
                      <input class="form-control d-none" type="text" name="data[{{$service['ot_work_id']}}][ot_work_id]" value="{{ old('data.'.$service['ot_work_id'].'.ot_work_id',  $service['ot_work_id']) }}">
                    </div>
                  </td>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm btn-trabajador my-0 d-flex align-items-center" data-area="{{$first['area']}}" data-areaid="{{$first['area_id']}}" data-service="{{$service['ot_work_id']}}" data-toggle="modal" data-target="#modalWorker"><i class="fal fa-user-hard-hat mr-2"></i> {{$service_trabajador ? 'Cambiar Trabajador': 'Asignar Trabajador'}}</button>
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
    </form>
  </div>
</div>
<div class="modal fade" tabindex="-1" id="modalWorker">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Trabajador <span></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="search bg-white">
          <input class="form-control p-search" type="text" placeholder="Buscar trabajador">
        </div>
        <ul class="list-group user-select-none" style="max-height: 380px;max-height: calc(100vh - 240px); overflow-y: auto">
          @foreach ($users as $user)
          <li type="button" data-userid="{{$user->id}}" data-areaid="{{$user->area_id}}" class="list-group-item list-group-item-action d-none"><span class="align-middle trabajador">{{$user->name .' '.$user->last_name.' '.$user->mother_last_name}} {{-- - {{$user->area}} --}}</span> <span class="badge badge-dark align-middle">Seleccionar</span></li>
          @endforeach
        </ul>
      </div>
      <div class="modal-footer">
        <div class="update ml-auto mr-auto">
          <button type="button" id="btnWorker" data-service="" class="btn btn-primary btn-round px-md-5" data-dismiss="modal">Confirmar trabajador</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $('#modalWorker .list-group-item').on('click dblclick', function () {
    $('#modalWorker .list-group-item').removeClass('active');
    $(this).addClass('active');
    $('#btnWorker').prop('disabled', false);
  })

  $('#modalWorker .list-group-item').bind('dblclick', function () {
    $('#btnWorker').trigger('click');
  })

  $('#btnWorker').on('click', function () {
    var $this = $(this),
        item = $('#modalWorker .list-group-item.active'),
        userid = item.data('userid'),
        areaid = item.data('areaid'),
        trabajador = item.find('.trabajador').text();

    var service_item = $('.list-item[data-service="'+$this.data('service')+'"] .service-trabajador');
    service_item.show();
    service_item.find('.trabajador_name').text(trabajador).attr({
      'title': trabajador,
    });
    service_item.find('.user_id').val(userid);
  })

  $('#modalWorker').on('hide.bs.modal', function (event) {
    $('.p-search').val('').trigger('keyup');
  })

  $('#modalWorker').on('show.bs.modal', function (event) {
    var btn = $(event.relatedTarget), area_id = btn.data('areaid');
    $('#modalWorker .modal-title span').text(" de "+btn.data('area'));
    $('#modalWorker .list-group-item').addClass('d-none');
    $('#modalWorker #btnWorker').data('service', btn.data('service'));
    $('#modalWorker .list-group-item[data-areaid="'+area_id+'"]').removeClass('d-none');
    $('#modalWorker .list-group-item.active').removeClass('active');
    $('#btnWorker').prop('disabled', true);
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