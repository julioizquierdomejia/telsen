@extends('layouts.app', ['body_class' => 'ots', 'title' => 'Mis Servicios'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Mis Servicios</h4>
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
              <tr>
                <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
                <td>OT-{{$item->code}}</td>
                <td>{{$item->potencia}}</td>
                <td>{{$item->service}}</td>
                <td class="text-center">
                  <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalService">Actividades <i class="far fa-task ml-2"></i></button>
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
<div class="modal fade" tabindex="-1" id="modalService">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Actividades del Servicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <button class="btn btn-success" type="button">Empezar <i class="far fa-play ml-2"></i></button>
        <button class="btn btn-warning" type="button">Pausar <i class="far fa-pause"></i></button>
        <button class="btn btn-primary" type="button">Continuar <i class="far fa-play"></i></button>
      </div>
      <div class="modal-footer">
        <div class="update ml-auto mr-auto">
          <button type="button" id="btnPersonal" data-service="" class="btn btn-primary btn-round px-md-5" data-dismiss="modal">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
/*$(document).ready(function() {
    $('#workshop-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('talleres.list_workshop')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         columns: [
            { data: 'created_at', class: 'text-nowrap' },
            { data: 'id', class: 'otid' },
            { data: 'status', class: 'text-center' },
            { data: 'razon_social' },
            { data: 'numero_potencia', class: 'text-left' },
            { data: 'fecha_entrega', class: 'text-center bg-light' },
            { data: 'tools', class: 'text-left text-nowrap'}
        ],
         columnDefs: [
          { orderable: false, targets: 2 },
          { orderable: false, targets: 6 }
        ],
        language: dLanguage
      });
});*/
</script>
@endsection