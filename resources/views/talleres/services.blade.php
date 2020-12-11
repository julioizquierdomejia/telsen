@extends('layouts.app', ['body_class' => 'ots', 'title' => 'Mis Tareas'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Mis Tareas</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate data-table" id="workshop-table">
            <thead class=" text-primary">
              <th class="text-nowrap">Fecha OT</th>
              <th class="text-nowrap">N° de OT</th>
              <th>Potencia</th>
              <th class="text-nowrap">Servicio</th>
              <th class="text-nowrap">Estado</th>
              <th class="text-center">Acciones</th>
            </thead>
            <tbody>
              @foreach ($services as $item)
              <tr id="service-{{$item->id}}">
                <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
                <td>OT-{{$item->code}}</td>
                <td>{{$item->potencia}}</td>
                <td>{{$item->service}}</td>
                <td>-</td>
                <td class="text-center">
                  <button class="btn btn-primary btn-sm btn-tasks">Actividades <i class="far fa-tasks ml-2"></i></button>
                </td>
              </tr>
              <tr class="text-center" data-id="service-{{$item->id}}" style="display: none;">
                <td class="p-0" colspan="6">
                  <div class="t-details px-2 py-3 mb-3" style="border-left: 10px solid #efefef;border-right: 10px solid #efefef;background-color: #f9f9f9;margin-top: -6px;">
                    <div class="buttons mb-3">
                      <button class="btn btn-success" type="button">Empezar <i class="far fa-play ml-2"></i></button>
                      <button class="btn btn-warning" type="button">Pausar <i class="far fa-pause"></i></button>
                      <button class="btn btn-primary" type="button">Continuar <i class="far fa-play"></i></button>
                    </div>
                    <div class="history bg-dark text-white pt-3">
                      <h5 class="h6 px-3">Historial</h5>
                      @if (true)
                        <ul class="list-inline small pb-3" style="max-height: 160px;overflow-y: auto;">
                          <li class="px-3">Inició tarea</li>
                        </ul>
                      @else
                      <p class="text-muted mb-0">No hay historial aun</p>
                      @endif
                    </div>
                    </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $(document).ready(function() {
    $('.btn-tasks').on('click', function (event) {
      $(this).parents('tr').next().slideToggle();
    })
  });
</script>
@endsection