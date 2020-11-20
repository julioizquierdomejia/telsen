@extends('layouts.app', ['body_class' => 'ots', 'title' => 'OTS'])
@section('content')
<div class="row">
  <div class="col">
    <a href="/ordenes/crear" class="btn btn-primary">Crear Orden de Trabajo</a>
  </div>
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
          <a class="nav-item nav-link" id="nav-disapprovedots-tab" data-toggle="tab" href="#nav-disapprovedots" role="tab" aria-controls="nav-disapprovedots" aria-selected="false">Ordenes desaprobadas</a>
          <a class="nav-item nav-link" id="nav-disenabledots-tab" data-toggle="tab" href="#nav-disenabledots" role="tab" aria-controls="nav-disenabledots" aria-selected="false">Ordenes eliminadas</a>
        </div>
        <div class="tab-content card-body" id="nav-tabContent">
          <div class="tab-pane show active" id="nav-enabledots" role="tabpanel" aria-labelledby="nav-enabledots-tab">
            <div class="table-responsive">
              <table class="table table-separate data-table">
                <thead class=" text-primary">
                  <th class="text-nowrap">Fecha OT</th>
                  <th class="text-nowrap">N° de OT</th>
                  <th>Estado</th>
                  <th>Cliente</th>
                  <th class="text-center">Descripción del motor</th>
                  <th class="text-center">Herramientas</th>
                </thead>
                <tbody>
                  <tr><td class="text-center" colspan="6">No hay órdenes de trabajo.</td></tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="tab-pane" id="nav-disapprovedots" role="tabpanel" aria-labelledby="nav-disapprovedots-tab">
            <div class="table-responsive">
              <table class="table table-separate data-table">
                <thead class=" text-primary">
                  <th class="text-nowrap">Fecha OT</th>
                  <th class="text-nowrap">N° de OT</th>
                  <th>Estado</th>
                  <th>Cliente</th>
                  <th class="text-center">Descripción del motor</th>
                  <th class="text-center">Herramientas</th>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center" colspan="6">No hay órdenes de trabajo desaprobadas.</td>
                  </tr>
                </tbody>
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
                  <th class="text-center">Descripción del motor</th>
                  <th class="text-center">Herramientas</th>
                </thead>
                <tbody>
                  <tr>
                    <td class="text-center text-muted" colspan="6">No hay órdenes de trabajo.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
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
        <h6 class="body-title">¿Seguro desea eliminar la OT N° "<strong></strong>"?</h6>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancelar</button>
        <button class="btn btn-primary btn-delete-confirm" type="button" data-otid="">Eliminar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
$(document).ready(function() {

  $('#nav-enabledots-tab').click(function() {
        $.ajax({
            type: "get",
            url: "{{route('ordenes.enabled_ots')}}",
            data: {
                _token: '{{csrf_token()}}',
            },
            beforeSend: function(data) {
                $('#nav-enabledots tbody').html('<tr><td class="text-center" colspan="6">No hay órdenes de trabajo.</td></tr>');
            },
            success: function(response) {
                if (response.success) {
                    var data = $.parseJSON(response.data);
                    if (data.length > 0) {
                        $('#nav-enabledots tbody').empty();
                        $.each(data, function(id, item) {
                            var date = new Date(item.created_at);
                            var created_at = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
                            var status = getStatus(item.id);
                            $('#nav-enabledots tbody').append(
                                `<tr class="text-muted" data-id="`+item.id+`">
                                  <td class="text-nowrap">` + created_at + `</td>
                                  <td class="otid">OT-` + pad(item.id, 3) + `</td>
                                  <td class="text-center">` +
                                  status.html
                                  +
                                  `</td>
                                  <td><span class="align-middle">` + item.razon_social + "</span>"+((item.client_type_id == 1) ? `<span class="badge badge-success px-2 py-1 ml-1 align-middle">`+item.client_type+`</span>` : `<span class="badge badge-danger px-2 py-1 ml-1">`+item.client_type+`</span>`) +
                                  `</td>
                                  <td class="text-center">` + item.descripcion_motor + `</td>
                                  <td class="text-left text-nowrap">

                                  <a href="/ordenes/`+item.id+`/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                                  <a href="/ordenes/`+item.id+`/editar" class="btn btn-sm btn-warning"><i class="fal fa-edit"></i></a>
                                  <button type="button" class="btn btn-sm btn-danger btn-mdelete" data-otid="`+item.id+`" data-toggle="modal" data-target="#modalDelOT"><i class="fal fa-trash"></i></button>
                                  `+ getStatusHtml(status, item.id) +
                                  `</td></tr>`
                            );
                        })
                    } else {
                        $('#nav-enabledots tbody').html('<tr><td class="text-center" colspan="6">No hay órdenes de trabajo.</td></tr>');
                    }
                }
            },
            error: function(request, status, error) {
                var data = jQuery.parseJSON(request.responseText);
                console.log(data);
            }
        });
    });

    function getStatus(id) {
      var status = [];
      $.ajax({
        type: "get",
        url: "/ordenes/"+id+"/status",
        data: {
            _token: '{{csrf_token()}}',
        },
        async: false,
        success: function(response) {
            if (response.success) {
                var data = $.parseJSON(response.data);
                status['data'] = data;
                if (data) {
                  $.each(data, function (id, item) {
                    if(item.status_id == 4) {
                      status['html'] = `<span class="badge badge-primary px-2 py-1 w-100">`+item.name+`</span>`
                    }
                    if(item.status_id == 4) {
                      status['html'] = `<span class="badge badge-primary px-2 py-1 w-100">`+item.name+`</span>`
                    } else if(item.status_id == 5 || item.status_id == 8) {
                      status['html'] = `<span class="badge badge-danger px-2 py-1 w-100">`+item.name+`</span>`
                    } else if(item.status_id == 6) {
                      status['html'] = `<span class="badge badge-success px-2 py-1 w-100">`+item.name+`</span>`
                    } else {
                      status['html'] = `<span class="badge badge-secondary px-2 py-1 w-100">`+item.name+`</span>`
                    }
                  })
                }
            }
        }
    })
      return status;
    }

    function getStatusHtml(status, id) {
      var html = "";
      if(status.data.length > 1) {
        html = `<div class="dropdown d-inline-block dropleft">
          <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" title="Ver Evaluaciones" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-check"></i></button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">`;
            for(var i = 0; i < status.data.length; i++) {
              if(status.data[i].id == 2) {
              html += `<a class="dropdown-item" href="/formatos/mechanical/`+id+`/ver"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>`
              }
              if(status.data[i].id == 3) {
              html += `<a class="dropdown-item" href="/formatos/electrical/`+id+`/ver"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>`
              }
              if(status.data[i].id == 4) {
              html += `<a class="dropdown-item" href="/tarjeta-costo/`+id+`/ver"><i class="fas fa-money-check-alt pr-2"></i> Ver Tarjeta de Costo</a>`
              }
              if(status.data[i].id == 11) {
              html += `<a class="dropdown-item" href="/rdi/`+id+`/ver"><i class="fas fa-money-check-alt pr-2"></i> Ver RDI</a>`
              }
            }
            html += `</div></div>`;
        }
        return html;
    }

    function pad(str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

    $('#nav-disapprovedots-tab').click(function() {
        $.ajax({
            type: "get",
            url: "{{route('ordenes.disapproved_ots')}}",
            data: {
                _token: '{{csrf_token()}}',
            },
            beforeSend: function(data) {
                $('#nav-disapprovedots tbody').html('<tr><td class="text-center" colspan="6">No hay órdenes de trabajo desaprobadas.</td></tr>');
            },
            success: function(response) {
                if (response.success) {
                    var data = $.parseJSON(response.data);
                    if (data.length > 0) {
                        $('#nav-disapprovedots tbody').empty();
                        $.each(data, function(id, item) {
                            var date = new Date(item.created_at);
                            var created_at = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
                            var status = getStatus(item.id);
                            $('#nav-disapprovedots tbody').append(
                                `<tr class="text-muted" data-id="`+item.id+`">
                                  <td class="text-nowrap">` + created_at + `</td>
                                  <td class="otid">OT-` + pad(item.id, 3) + `</td>
                                  <td class="text-center">` +
                                  status.html
                                  +
                                  `</td>
                                  <td><span class="align-middle">` + item.razon_social + "</span>"+((item.client_type_id == 1) ? `<span class="badge badge-success px-2 py-1 ml-1 align-middle">`+item.client_type+`</span>` : `<span class="badge badge-danger px-2 py-1 ml-1">`+item.client_type+`</span>`) +
                                  `</td>
                                  <td class="text-center">` + item.descripcion_motor + `</td>
                                  <td class="text-left text-nowrap">

                                  <a href="/ordenes/`+item.id+`/ver" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
                                  <a href="/ordenes/`+item.id+`/editar" class="btn btn-sm btn-warning"><i class="fal fa-edit"></i></a>
                                  <button type="button" class="btn btn-sm btn-danger btn-mdelete" data-otid="`+item.id+`" data-toggle="modal" data-target="#modalDelOT"><i class="fal fa-trash"></i></button>
                                  `+ getStatusHtml(status, item.id) +
                                  `</td></tr>`
                            );
                        })
                    } else {
                        $('#nav-disapprovedots tbody').html('<tr><td class="text-center" colspan="6">No hay órdenes de trabajo desaprobadas.</td></tr>');
                    }
                }
            },
            error: function(request, status, error) {
                var data = jQuery.parseJSON(request.responseText);
                console.log(data);
            }
        });
    })

    $('#nav-disenabledots-tab').click(function() {
        $.ajax({
            type: "get",
            url: "{{route('ordenes.disabled_ots')}}",
            data: {
                _token: '{{csrf_token()}}',
            },
            beforeSend: function(data) {
                $('#nav-disenabledots tbody').html('<tr><td class="text-center text-muted" colspan="6">No hay órdenes de trabajo eliminadas.</td></tr>');
            },
            success: function(response) {
                if (response.success) {
                    var data = $.parseJSON(response.data);
                    if (data.length > 0) {
                        $('#nav-disenabledots tbody').empty();
                        $.each(data, function(id, item) {
                            var date = new Date(item.created_at);
                            var created_at = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
                            $('#nav-disenabledots tbody').append(
                                `<tr>
                    <td class="text-muted text-nowrap">` + created_at + `</td>
                    <td class="text-muted">OT-` + pad(item.id, 3) + `</td>
                    <td class="text-muted text-center">
                    <span class="badge badge-secondary px-2 py-1 w-100">OT Creada</span>
                    </td>
                    <td class="text-muted">` + item.razon_social + `
                    <span class="badge badge-primary">` + item.client_type + `</span>
                    </td>
                    <td class="text-muted text-center">` + item.descripcion_motor + `</td>
                    <td class="text-muted text-left text-nowrap">
                      <button data-href="/ordenes/` + item.id + `/activar" class="btn btn-sm btn-primary btn-enablingot"><i class="fal fa-trash-restore"></i> Restaurar</button>
                    </td>
                </tr>`
                            );
                        })
                    } else {
                        $('#nav-disenabledots tbody').html('<tr><td class="text-center text-muted" colspan="6">No hay órdenes de trabajo eliminadas.</td></tr>');
                    }
                }
            },
            error: function(request, status, error) {
                var data = jQuery.parseJSON(request.responseText);
                console.log(data);
            }
        });
    });

    $(document).on("click", ".btn-mdelete", function(event) {
        $('#modalDelOT .body-title strong').text($(this).parents('tr').find('.otid').text());
        $('.btn-delete-confirm').data('otid', $(this).data('otid'));
    })

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
                    btn.parents('tr').remove();
                    if ($('#nav-disenabledots tbody tr').length == 0) {
                        $('#nav-disenabledots tbody').html('<tr><td class="text-center" colspan="6">No hay órdenes de trabajo eliminadas.</td></tr>');
                    }
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
                    if (data.enabled == 2) {
                        $('.btn-mdelete[data-otid=' + btn.data('otid') + ']').parents('tr').remove();
                        $('#modalDelOT').modal('hide');
                        if ($('#nav-enabledots tbody tr').length == 0) {
                            $('#nav-enabledots tbody').html('<tr><td class="text-center" colspan="6">No hay órdenes de trabajo.</td></tr>');
                        }
                    }
                }
            },
            error: function(request, status, error) {
                var data = jQuery.parseJSON(request.responseText);
                console.log(data);
            }
        });
    })


    //Renderizar lista de ordenes:
    $('#nav-enabledots-tab').trigger('click');
});
</script>
@endsection