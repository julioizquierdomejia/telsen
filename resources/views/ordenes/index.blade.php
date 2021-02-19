@extends('layouts.app_real', ['body_class' => 'ots', 'title' => 'OTS'])
@section('content')
@php
$role_names = validateActionbyRole();
$allowed_users = in_array("superadmin", $role_names) || in_array("admin", $role_names) || in_array("crear_ot", $role_names);
@endphp
<div class="row">
  @if ($allowed_users)
  <div class="col">
    <a href="/ordenes/crear" class="btn btn-primary">Crear Orden de Trabajo</a>
  </div>
  @endif
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Orden de Trabajo</h4>
      </div>
      <div class="card-body">
        <div class="nav nav-tabs ml-auto" id="nav-tab" role="tablist">
          <a class="nav-item nav-link active" id="nav-enabledots-tab" data-toggle="tab" href="#nav-enabledots" role="tab" aria-controls="nav-enabledots" aria-selected="true">Órdenes de trabajo</a>
          @if ($allowed_users)
          <a class="nav-item nav-link" id="nav-disapprovedots-tab" data-toggle="tab" href="#nav-disapprovedots" role="tab" aria-controls="nav-disapprovedots" aria-selected="false">Ordenes desaprobadas</a>
          <a class="nav-item nav-link" id="nav-disenabledots-tab" data-toggle="tab" href="#nav-disenabledots" role="tab" aria-controls="nav-disenabledots" aria-selected="false">Ordenes eliminadas</a>
          @endif
        </div>
        <div class="tab-content card-body px-0" id="nav-tabContent">
          <div class="tab-pane show active" id="nav-enabledots" role="tabpanel" aria-labelledby="nav-enabledots-tab">
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
          @if ($allowed_users)
          <div class="tab-pane" id="nav-disapprovedots" role="tabpanel" aria-labelledby="nav-disapprovedots-tab">
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
          <div class="tab-pane" id="nav-disenabledots" role="tabpanel" aria-labelledby="nav-disenabledots-tab">
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
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" id="modalDelOT">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar OT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p class="text my-3 body-title">¿Seguro desea eliminar la OT N° "<strong></strong>"?</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancelar</button>
        <button class="btn btn-danger btn-delete-confirm" data-dismiss="modal" type="button" data-otid=""><i class="fal fa-trash"></i> Eliminar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
$(document).ready(function() {
  var enabledots, disapprovedots, disenabledots, priorityots;
  $('#nav-enabledots-tab').click(function() {
    //$.fn.dataTable.isDataTable($('#nav-enabledots .data-table'));
    if(enabledots) {
      enabledots.ajax.reload();
    } else {
      enabledots = $('#nav-enabledots .data-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('ordenes.enabled_ots')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         columns: [
            { data: 'created_at', class: 'text-nowrap' },
            { data: 'id', class: 'otid' },
            { data: 'status', class: 'text-center' },
            { data: 'razon_social' },
            { data: 'numero_potencia', class: 'text-left' },
            { data: 'codigo_motor', class: 'text-left' },
            { data: 'fecha_entrega', class: 'text-center' },
            { data: 'tools', class: 'text-left text-nowrap'}
        ],
        "createdRow": function( row, data, dataIndex){
          if( data.prioridad == 1){
            $(row).find('td').css('background-color', '#fedddd');
          }
        },
         columnDefs: [
          { orderable: false, targets: 2 },
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
    @if ($allowed_users)
    $('#nav-disapprovedots-tab').click(function() {
      if(disapprovedots) {
        disapprovedots.ajax.reload();
      } else {
        disapprovedots = $('#nav-disapprovedots .data-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('ordenes.disapproved_ots')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         columns: [
            { data: 'created_at', class: 'text-nowrap' },
            { data: 'id', class: 'otid' },
            { data: 'status', class: 'text-center' },
            { data: 'razon_social' },
            { data: 'numero_potencia', class: 'text-left' },
            { data: 'codigo_motor', class: 'text-left' },
            { data: 'fecha_entrega', class: 'text-center' },
            { data: 'tools', class: 'text-left text-nowrap'}
        ],
        "createdRow": function( row, data, dataIndex){
          if( data.prioridad == 1){
            $(row).find('td').css('background-color', '#fedddd');
          }
        },
         columnDefs: [
          { orderable: false, targets: 2 },
          //{ orderable: false, targets: 6 }
        ],
        order: [[ 0, "desc" ]],
        language: dLanguage
      });
      }
    })

    $('#nav-disenabledots-tab').click(function() {
      if(disenabledots) {
        disenabledots.ajax.reload();
      } else {
        disenabledots = $('#nav-disenabledots .data-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('ordenes.disabled_ots')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         columns: [
            { data: 'created_at', class: 'text-nowrap' },
            { data: 'id', class: 'otid' },
            { data: 'status', class: 'text-center' },
            { data: 'razon_social' },
            { data: 'numero_potencia', class: 'text-left' },
            { data: 'codigo_motor', class: 'text-left' },
            { data: 'fecha_entrega', class: 'text-center' },
            { data: 'tools', class: 'text-left text-nowrap'}
        ],
        "createdRow": function( row, data, dataIndex){
          if( data.prioridad == 1){
            $(row).find('td').css('background-color', '#fedddd');
          }
        },
         columnDefs: [
          { orderable: false, targets: 2 },
          //{ orderable: false, targets: 6 }
        ],
        order: [[ 0, "desc" ]],
        language: dLanguage
      });
      }
    });

    $('#nav-priorityots-tab').click(function() {
      if(priorityots) {
        priorityots.ajax.reload();
      } else {
        priorityots = $('#nav-priorityots .data-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('ordenes.priority_ots')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         columns: [
            { data: 'created_at', class: 'text-nowrap' },
            { data: 'id', class: 'otid' },
            { data: 'status', class: 'text-center' },
            { data: 'razon_social' },
            { data: 'numero_potencia', class: 'text-left' },
            { data: 'codigo_motor', class: 'text-left' },
            { data: 'fecha_entrega', class: 'text-center' },
            { data: 'tools', class: 'text-left text-nowrap'}
        ],
        "createdRow": function( row, data, dataIndex){
          if( data.prioridad == 1){
            $(row).find('td').css('background-color', '#fedddd');
          }
        },
         columnDefs: [
          { orderable: false, targets: 2 },
          //{ orderable: false, targets: 6 }
        ],
        order: [[ 0, "desc" ]],
        language: dLanguage
      });
      }
    });

    $(document).on("click", ".btn-enablingot", function(event) {
        event.preventDefault();
        var btn = $(this);
        console.log(btn.data('href'))
        $.ajax({
            type: "post",
            url: btn.data('href'),
            data: {
                _token: '{{csrf_token()}}',
            },
            beforeSend: function(data) {

            },
            success: function(response) {
                if (response.success) {
                    var data = $.parseJSON(response.data);
                    //btn.parents('tr').remove();
                    disenabledots.ajax.reload();
                    /*if ($('#nav-disenabledots tbody tr').length == 0) {
                        $('#nav-disenabledots tbody').html('<tr><td class="text-center" colspan="7">No hay órdenes de trabajo eliminadas.</td></tr>');
                    }*/
                }
            },
            error: function(request, status, error) {
                var data = jQuery.parseJSON(request.responseText);
                console.log(data);
            }
        });
    });

    $('.btn-delete-confirm').click(function(event) {
        event.preventDefault();
        var btn = $(this);
        if (btn.data('otid').length == 0) {
            return;
        }
        $.ajax({
            type: "post",
            url: "/ordenes/" + btn.data('otid') + "/eliminar",
            data: {
                _token: '{{csrf_token()}}',
            },
            beforeSend: function(data) {

            },
            success: function(response) {
                if (response.success) {
                    var data = $.parseJSON(response.data);
                    if (data.enabled == 0) {
                        //$('.btn-mdelete[data-otid=' + btn.data('otid') + ']').parents('tr').remove();
                        enabledots.ajax.reload();
                        disapprovedots.ajax.reload();
                        $('#modalDelOT').modal('hide');
                        /*if ($('#nav-enabledots tbody tr').length == 0) {
                            $('#nav-enabledots tbody').html('<tr><td class="text-center" colspan="7">No hay órdenes de trabajo.</td></tr>');
                        }*/
                    }
                }
            },
            error: function(request, status, error) {
                var data = jQuery.parseJSON(request.responseText);
                console.log(data);
            }
        });
    })
    @endif

    $(document).on("click", ".btn-mdelete", function(event) {
        $('#modalDelOT .body-title strong').text($(this).parents('tr').find('.otid').text());
        $('.btn-delete-confirm').data('otid', $(this).data('otid'));
    })

    //Renderizar lista de ordenes:
    $('#nav-enabledots-tab').trigger('click');
});
</script>
@endsection