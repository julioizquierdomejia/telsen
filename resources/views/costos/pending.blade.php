@extends('layouts.app', ['body_class' => 'ots', 'title' => 'OTS Pendientes de cotización'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Órdenes Pendientes de cotización</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate data-table">
            <thead class=" text-primary">
              <th class="text-nowrap">Fecha OT</th>
              <th class="text-nowrap">N° de OT</th>
              <th>Estado</th>
              <th>Cliente</th>
              <th>Potencia</th>
              <th>Código <br>motor</th>
              <th class="text-center">Fecha de entrega</th>
              <th class="text-center">Acciones</th>
            </thead>
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
  pendingots = $('.data-table').DataTable({
     processing: true,
     serverSide: true,
     ajax: "{{route('card_cost.list_pending')}}",
     pageLength: 5,
     lengthMenu: [ 5, 25, 50 ],
     columns: [
        { data: 'created_at', class: 'text-nowrap' },
        { data: 'id', class: 'otid' },
        { data: 'status', class: 'text-center' },
        { data: 'razon_social' },
        { data: 'numero_potencia', class: 'text-left' },
        { data: 'codigo_motor', class: 'text-left' },
        { data: 'fecha_entrega', class: 'text-center bg-light' },
        { data: 'tools', class: 'text-left text-nowrap'}
    ],
     columnDefs: [
      { orderable: false, targets: 2 },
      //{ orderable: false, targets: 6 }
    ],
    order: [[ 0, "desc" ]],
    language: dLanguage
  });
});
</script>
@endsection