@extends('layouts.app_real', ['body_class' => 'ots', 'title' => 'Fecha de entrega'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Fecha de entrega</h4>
      </div>
      <div class="card-body">
        <div class="nav nav-tabs ml-auto" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-pdd-tab" data-toggle="tab" href="#nav-pendingDD" role="tab" aria-controls="nav-pendingDD" aria-selected="true">Por generar</a>
          <a class="nav-item nav-link" id="nav-generatedDD-tab" data-toggle="tab" href="#nav-generatedDD" role="tab" aria-controls="nav-generatedDD" aria-selected="false">Generadas</a>
        </div>
        <div class="tab-content card-body px-0" id="nav-tabContent">
          <div class="tab-pane show active" id="nav-pendingDD" role="tabpanel" aria-labelledby="nav-pdd-tab">
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
          <div class="tab-pane" id="nav-generatedDD" role="tabpanel" aria-labelledby="nav-generatedDD-tab">
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
  var pendingDD, generatedDD;
  $('#nav-pdd-tab').click(function() {
    if(pendingDD) {
      pendingDD.ajax.reload();
    } else {
      pendingDD = $('#nav-pendingDD .data-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('delivery_date.pending')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         columns: [
            { data: 'created_at', class: 'text-nowrap' },
            { data: 'id', class: 'otid text-nowrap' },
            { data: 'status', class: 'text-center' },
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
        order: [[ 0, "desc" ]],
        language: dLanguage
      });
    }
    });

    $('#nav-generatedDD-tab').click(function() {
      if(generatedDD) {
        generatedDD.ajax.reload();
      } else {
        generatedDD = $('#nav-generatedDD .data-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('delivery_date.generated')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         columns: [
            { data: 'created_at', class: 'text-nowrap' },
            { data: 'id', class: 'otid text-nowrap' },
            { data: 'status', class: 'text-center' },
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
        order: [[ 0, "desc" ]],
        language: dLanguage
      });
      }
    })

    //Renderizar lista de ordenes:
    $('#nav-pdd-tab').trigger('click');
});
</script>
@endsection