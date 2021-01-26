@extends('layouts.app', ['body_class' => 'ots', 'title' => 'Mis Tareas'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title d-flex align-items-center">
          <span>Mis Tareas</span>
        </h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate data-table" id="workshop-table">
            <thead class=" text-primary">
              {{-- <th class="text-nowrap">ID</th> --}}
              <th class="text-nowrap">Fecha OT</th>
              <th class="text-nowrap">N° de OT</th>
              <th>Potencia</th>
              <th class="text-nowrap">Area</th>
              <th class="text-nowrap">Servicio</th>
              <th class="text-nowrap">Estado</th>
              <th class="text-center">Acciones</th>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" id="modalReason">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmar Actividad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p class="text my-2 body-title">¿Confirmas la actividad?</p>
        <div class="pause-list" style="display: none;">
          <p class="text mb-0">Selecciona el motivo</p>
          <div class="p-list-content" style="max-height: calc(100vh - 252px);min-height: 100px;overflow-y: auto;">
            <div class="btn-group flex-column btn-group-toggle mb-3" data-toggle="buttons">
              @foreach ($work_reasons as $key => $item)
              <label class="btn btn-outline-primary">
                <input type="radio" name="reason" id="option{{$key}}" value="{{$item->id}}"> {{$item->name}}
              </label>
              @endforeach
            </div>
            {{-- <div class="item pt-2"><input class="form-control reason" type="text" name="" placeholder="o escribe el motivo"></div> --}}
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancelar</button>
        <button class="btn btn-primary btn-wconfirm" data-dismiss="modal" type="button" disabled=""><i class="fal fa-check"></i> Confirmar</button>
      </div>
    </div>
  </div>
</div>
@if ($allowed_user)
<div class="modal fade" tabindex="-1" id="modalApprove">
  <div class="modal-dialog">
    <form class="modal-content" action="/talleres/aprobartarea" method="POST">
      <div class="modal-header">
        @csrf
        <input type="text" hidden="" name="work_id" value="">
        <h5 class="modal-title">Aprobar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p class="text my-2 body-title">¿Aprueba la tarea?</p>
        <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
          <label class="btn btn-outline-secondary px-4">
            <input type="radio" name="status_id" id="approve0" value="disapproved"><i class="far fa-times"></i> No
          </label>
          <label class="btn btn-outline-success px-4">
            <input type="radio" name="status_id" id="approve1" value="approved"><i class="far fa-check"></i> Sí
          </label>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-primary px-5" type="submit">Enviar</button>
      </div>
    </form>
  </div>
</div>
@endif
@endsection
@section('javascript')
<script>
  $(document).ready(function() {
    var allowed_user = {{$allowed_user}};
    var workshopTable;
    if(workshopTable) {
      workshopTable.ajax.reload();
    } else {
      workshopTable = $('#workshop-table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('workshop.services')}}",
         pageLength: 5,
         lengthMenu: [ 5, 25, 50 ],
         columns: [
            { data: 'created_at', class: 'text-nowrap' },
            { data: 'id', class: 'otid' },
            { data: 'numero_potencia', class: 'text-left' },
            { data: 'area', class: 'text-left' },
            { data: 'service', class: 'text-center' },
            { data: 'status', class: 'status text-center' },
            { data: 'tools', class: 'text-left text-nowrap'}
        ],
         columnDefs: [
          { orderable: false, targets: 2 },
          //{ orderable: false, targets: 6 }
        ],
        order: [[ 0, "desc" ]],
        language: dLanguage
      });
    }

    var actualBtn;
    $(document).on('click', '.btn-tasks', function (event) {
      var id = $(this).data('id'),
          row = $('.row-details[data-id='+id+']'),
          content = $(`
          <tr class="text-center row-details row-expanded" data-id="`+id+`">
            <td colspan="7">
              `+row.find('.cell-details').html()+`
            </td>
          </tr>
          `);
      if(row.hasClass('row-expanded')) {
        row.toggle();
      } else {
        parent = $(this).parents('tr[role="row"]');
        row.remove();
        content.insertAfter(parent);
        row.toggle();
      }
    })

    $('.comments').on('change', function (event) {
      var $this = $(this), comments = $this.val(), ot_work = $this.data('otwork');
      var comments_msg = $this.parent().find('.comments-msg');
      $.ajax({
          type: "post",
          url: '/worklog/'+ot_work+'/update',
          data: {
            _token: '{{csrf_token()}}',
            comments: comments,
          },
          beforeSend: function(data) {
            
          },
          success: function(response) {
              if (response.success) {
                var data = response.data;
                comments_msg.show();
                setTimeout(function () {
                  comments_msg.hide();
                }, 3000)
              }
          },
          error: function(request, status, error) {
              var data = jQuery.parseJSON(request.responseText);
              console.log(data);
          }
      });
    })

    $('.frm-col').on('change', function (event) {
      $(this).closest('.parent-table').submit();
    })

    $(document).on("submit", ".parent-table", function(event) {
      var coldata_msg = $(this).find('.coldata-msg');
        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: $(this).attr("action"),
            type: $(this).attr("method"),
            dataType: "JSON",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (response, status) {
              if (response.success) {
                var data = response.data;
                coldata_msg.show();
                setTimeout(function () {
                  coldata_msg.hide();
                }, 3000)
              }
            },
            error: function (xhr, desc, err) {

            }
        });        
    });

    function clearRadios() {
      $('#modalReason [name="reason"]').attr('checked', false)
      $('#modalReason .btn').removeClass('active focus')
    }

    $('.reason').on('focus', function (event) {
      clearRadios();

      $('.btn-wconfirm').data('reason', $('.reason').val()).attr('disabled', false)
    })
    $('.reason').on('keyup', function (event) {
      $('.btn-wconfirm').data('reason', $('.reason').val())
    })

    $('#modalReason [name="reason"]').on('change', function (event) {
      $('.btn-wconfirm').data('reason', $('#modalReason [name="reason"]:checked').val()).attr('disabled', false)
    })

    $('#modalReason').on('show.bs.modal', function (event) {
      clearRadios();
      $('#modalReason .reason').val('')
      actualBtn = $(event.relatedTarget);
      if(actualBtn.data('type') == 'pause') {
        $('.btn-wconfirm').attr('disabled', true)
      } else {
        $('.btn-wconfirm').attr('disabled', false)
      }
    })

    $('#modalReason').on('hide.bs.modal', function (event) {
//      $('.work-buttons .btn-action').prop('disabled', false);
    })

    $('#modalApprove').on('show.bs.modal', function (event) {
      var btn = $(event.relatedTarget);
      $('#modalApprove [name="work_id"]').val(btn.data('work_id'))
    })
    $('#modalApprove').on('hide.bs.modal', function (event) {
      $('#modalApprove [name="work_id"]').val('')
      $('#modalApprove .btn-group-toggle input').removeAttr('checked');
      $('#modalApprove .btn-group-toggle label').removeClass('active');
    })

    $(document).on("click", ".work-buttons .btn-action", function (event) {
      //$('.work-buttons .btn-action').attr('disabled', true);
      var type = $(this).data('type');
      if(type == 'pause') {
        $('.body-title').text('¿Confirmas la actividad?');
        $('.pause-list').show();
        $('.body-title').hide();

        checked = $('#modalReason .btn-group-toggle [name="reason"]:checked');
        if(checked) {
          $(this).data('reason', checked.val())
        } else {
          $(this).data('reason', $('.reason').val())
        }
      } else {
        if(type == 'end') {
          $('#modalReason .body-title').text('¿Confirmas terminar la tarea?');
        }
        $('.pause-list').hide();
        $('.body-title').show();
      }
      $("#modalReason .btn-wconfirm").data('work_id', $(this).data('work_id'));
      $("#modalReason .btn-wconfirm").data('type', type);
    })

    $(document).on("click", "#modalReason .btn-wconfirm", function (event) {
      //$('.work-buttons .btn-action').attr('disabled', true);
    var $this = $(this),
        work_id = $this.data('work_id'),
        d_id = $this.data('id'),
        //user_id = $this.data('user_id'),
        type = $this.data('type'),
        reason = type == 'pause' ? $this.data('reason') : '';
      $.ajax({
        type: "POST",
        url: "{{ route('worklog.store') }}",
        data: {
          _token: '{{csrf_token()}}',
          work_id: work_id,
          //user_id: user_id,
          reason: reason,
          type: type,
        },
        beforeSend: function() {
          $this.attr('disabled', true);
        },
        success: function(response) {
          if (response.success) {
            var data = $.parseJSON(response.data),
              s_length = data.length;
            var parent = actualBtn.parents('.t-details')
                list = parent.find('.works-list');
            $('.row-details[data-id='+work_id+']').prev().find('.status').html('<span class="badge badge-info d-block py-1">'+data[0].status.name+'</span>')
            list.empty();
            $.each(data, function (id, item) {
              list.append(
                `<li class="item">
                  <span>`+item.status.name +`</span>
                  <span> | `+dateFormatter(item.created_at)+`</span>
                  <hr class="my-1" style="border-top-color: #444">
                </li>`
                )
            })
            last_status = data[s_length - 1].code;
            work_type = data[s_length - 1].type;
            html_tools = '';
            if (allowed_user) {
                if (last_status == 'approved') {
                    html_tools += ' <span class="badge badge-success d-block py-1 my-1">Aprobada</span>';
                } else if(last_status == 'disapproved') {
                    html_tools += '<span class="badge badge-secondary d-block py-1 my-1">Desaprobada</span>';
                } else if(work_type == 'end') {
                    html_tools += '<button class="btn btn-action btn-primary my-1" data-work_id="'+work_id+'" type="button" data-toggle="modal" data-target="#modalApprove">Aprobar <i class="far fa-check ml-2"></i></button>';
                } else {
                    html_tools += '<span class="badge badge-light d-block py-1 my-1">En proceso.</span>';
                }
            } else {
            //Trabajador
              if(work_type == 'start' || work_type == 'continue' || work_type == 'restart') {
                  html_tools += '<button class="btn btn-pause btn-warning my-1 btn-action" data-type="pause" data-work_id="'+work_id+'" type="button" data-toggle="modal" data-target="#modalReason">Pausar <i class="far fa-pause ml-2"></i></button><button class="btn btn-danger my-1 btn-action" data-type="end" data-work_id="'+work_id+'" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>';
              } else if(work_type == 'pause') {
                  html_tools += '<button class="btn btn-primary my-1 btn-action" data-type="continue" data-work_id="'+work_id+'" type="button" data-toggle="modal" data-target="#modalReason">Continuar <i class="far fa-play ml-2"></i></button><button class="btn btn-danger my-1 btn-action" data-type="end" data-work_id="'+work_id+'" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>';
              } else if(work_type == 'approved' || work_type == 'disapproved') {
                  if (last_status == 'approved') {
                      html_tools += '<span class="badge badge-success d-block py-1 my-1">Aprobada</span>';
                  } else if(last_status == 'disapproved') {
                      html_tools += '<span class="badge badge-secondary d-block py-1 my-1">Desaprobada</span><button class="btn btn-danger my-1 btn-action" data-type="restart" data-work_id="'+work_id+'" type="button" data-toggle="modal" data-target="#modalReason">Reiniciar <i class="far fa-play ml-2"></i></button>';
                  }
                  html_tools += 'Finalizó la tarea.';
              }
            }
            parent.find('.work-buttons').html(html_tools);

            $this.attr('disabled', true);
          }
        },
        error: function(request, status, error) {

        }
      });
    })
    @if ($allowed_user)
    $("#modalApprove .modal-content").on("submit", function (event) {
      event.preventDefault();
      var form = $(this);
      var url = form.attr('action');
      $.ajax({
          type: "post",
          url: url,
          data: new FormData(this),
          processData: false,
          contentType: false,
          beforeSend: function(data) {
            $('#modalApprove [type="submit"]').attr('disabled', true);
          },
          success: function(response) {
              if (response.success) {
                var data = response.data;
              }
              $('#modalApprove').modal('hide');
              location.reload();
              $('#modalApprove [type="submit"]').attr('disabled', false);
          },
          error: function(request, status, error) {
              var data = jQuery.parseJSON(request.responseText);
              $('#modalApprove [type="submit"]').attr('disabled', false);
          }
      });
    })
    @endif

    function dateFormatter(date) {
      var formattedDate = new Date(date);

      var d = formattedDate.getDate();
      var m =  formattedDate.getMonth();
      m += 1;  // JavaScript months are 0-11
      var y = formattedDate.getFullYear();
      var hours = formattedDate.getHours();
      var symbol = hours >= 12 ? 'pm' : 'am';
      hours = hours % 12;
      hours = hours ? hours : 12;
      var min = formattedDate.getMinutes();
      min = min < 10 ? '0'+min : min;

      return (d + "-" + m + "-" + y + " " + hours + ":" + min + " "+ symbol);
    }
  });
</script>
@endsection