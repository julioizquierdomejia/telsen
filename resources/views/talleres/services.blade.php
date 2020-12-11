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
              <th class="text-center">Acciones</th>
            </thead>
            <tbody>
              @foreach ($services as $item)
              <tr id="service-{{$item->id}}">
                <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
                <td>OT-{{$item->code}}</td>
                <td>{{$item->potencia}}</td>
                <td>{{$item->service}}</td>
                <td class="text-center">
                  <button class="btn btn-primary btn-sm btn-tasks">Actividades <i class="far fa-tasks ml-2"></i></button>
                </td>
              </tr>
              <tr class="text-center" data-id="service-{{$item->id}}" style="display: none;">
                <td class="px-4 py-3" colspan="5">
                  <div class="buttons mb-2">
                    <button class="btn btn-success" type="button">Empezar <i class="far fa-play ml-2"></i></button>
                    <button class="btn btn-warning" type="button">Pausar <i class="far fa-pause"></i></button>
                    <button class="btn btn-primary" type="button">Continuar <i class="far fa-play"></i></button>
                  </div>
                  <div class="history">
                    <p class="text-muted mb-0">No hay historial aun</p>
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