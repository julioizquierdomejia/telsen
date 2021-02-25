@extends('layouts.app_real', ['body_class' => 'ots', 'title' => 'Lista de RDI'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Lista de RDI</h4>
      </div>
      <div class="card-body">
        <div class="nav nav-tabs ml-auto" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-waiting-tab" data-toggle="tab" href="#nav-waitingcz" role="tab" aria-controls="nav-waitingcz" aria-selected="true">Por aprobar</a>
          <a class="nav-item nav-link" id="nav-approvedcz-tab" data-toggle="tab" href="#nav-approvedcz" role="tab" aria-controls="nav-approvedcz" aria-selected="false">Aprobadas</a>
        </div>
        <div class="tab-content card-body px-0" id="nav-tabContent">
          <div class="tab-pane show active" id="nav-waitingcz" role="tabpanel" aria-labelledby="nav-waiting-tab">
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
          <div class="tab-pane" id="nav-approvedcz" role="tabpanel" aria-labelledby="nav-approvedcz-tab">
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
  </div>
</div>
@endsection
@section('javascript')
<script>
$(document).ready(function() {
  var waitingcz, approvedcz;
  $('#nav-waiting-tab').click(function() {
    if(waitingcz) {
      waitingcz.ajax.reload();
    } else {
      waitingcz = $('#nav-waitingcz .data-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('rdi.list_waiting')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         columns: [
            { data: 'created_at', class: 'text-nowrap' },
            { data: 'id', class: 'otid text-nowrap' },
            { data: 'status', class: 'text-center', orderable: false },
            { data: 'razon_social' },
            { data: 'numero_potencia', class: 'text-left' },
            { data: 'codigo_motor', class: 'text-left' },
            { data: 'fecha_entrega', class: 'text-center' },
            { data: 'tools', class: 'text-center text-nowrap', orderable: false}
        ],
        "createdRow": function( row, data, dataIndex){
          if( data.prioridad == 1){
            $(row).find('td').css('background-color', '#fedddd');
          }
        },
         columnDefs: [
          {
            targets: 6,
            "createdCell": function (td, cellData, rowData, row, col) {
              $(td).addClass('bg-light')
            },
          }
          //{ orderable: false, targets: 6 }
        ],
        language: dLanguage
      });
    }
    });

    $('#nav-approvedcz-tab').click(function() {
      if(approvedcz) {
        approvedcz.ajax.reload();
      } else {
        approvedcz = $('#nav-approvedcz .data-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('rdi.list_approved')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         columns: [
            { data: 'created_at', class: 'text-nowrap' },
            { data: 'id', class: 'otid text-nowrap' },
            { data: 'status', class: 'text-center', orderable: false },
            { data: 'razon_social' },
            { data: 'numero_potencia', class: 'text-left' },
            { data: 'codigo_motor', class: 'text-left' },
            { data: 'fecha_entrega', class: 'text-center' },
            { data: 'tools', class: 'text-center text-nowrap', orderable: false}
        ],
        "createdRow": function( row, data, dataIndex){
          if( data.prioridad == 1){
            $(row).find('td').css('background-color', '#fedddd');
          }
        },
         columnDefs: [
          {
            targets: 6,
            "createdCell": function (td, cellData, rowData, row, col) {
              $(td).addClass('bg-light')
            },
          }
          //{ orderable: false, targets: 6 }
        ],
        language: dLanguage
      });
      }
    })

    //Renderizar lista de ordenes:
    $('#nav-waiting-tab').trigger('click');
});
</script>
@endsection