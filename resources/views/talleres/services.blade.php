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
              {{-- <th class="text-nowrap">ID</th> --}}
              <th class="text-nowrap">Fecha OT</th>
              <th class="text-nowrap">N° de OT</th>
              <th>Potencia</th>
              <th class="text-nowrap">Servicio</th>
              <th class="text-nowrap">Estado</th>
              <th class="text-center">Acciones</th>
            </thead>
            <tbody>
              @foreach ($services as $item)
              @php
                $work_logs = $item->work_logs;
                $wl_count = $work_logs->count();
              @endphp
              <tr id="service-{{$item->id}}">
                {{-- <td>{{$item->id}}</td> --}}
                <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
                <td>OT-{{$item->code}}</td>
                <td>{{$item->potencia}}</td>
                <td>{{$item->service}}</td>
                <td class="status">{!! $wl_count ? '<span class="badge badge-info">'.$work_logs->first()->description.'</span>' : '-' !!}</td>
                <td class="text-center">
                  <button class="btn btn-primary btn-sm btn-tasks">Actividades <i class="far fa-tasks ml-2"></i></button>
                </td>
              </tr>
              <tr class="text-center" data-id="service-{{$item->id}}" style="display: none;">
                <td class="p-0" colspan="6">
                  <div class="d px-3" style="border-left: 10px solid #efefef;border-right: 10px solid #efefef;background-color: #f9f9f9;margin-top: -6px;">
                  <div class="t-details px-2 py-3 mb-3 row align-items-center">
                    <div class="history bg-dark text-white py-3 col-12 col-md-8 col-xl-10">
                      <h5 class="h6 px-3">Historial</h5>
                      <ul class="works-list text-left list-inline mb-0 text-info" style="max-height: 160px;overflow-y: auto;">
                      @if ($wl_count)
                        @foreach ($work_logs as $key => $worklog)
                        <li class="item">{{$worklog->description ?? '-'}}
                          @if ($worklog->type == 'pause')
                            <span> | {{$worklog->reason}}</span>
                          @endif
                          <span> | {{date('d-m-Y h:i a', strtotime($worklog->created_at))}}</span>
                          <hr class="my-1" style="border-top-color: #444">
                        </li>
                        @endforeach
                      @else
                      <li class="text-muted">No hay historial aun</li>
                      @endif
                      </ul>
                    </div>
                    <div class="work-buttons py-3 col-12 col-md-4 col-xl-2">
                    @if ($wl_count == 0)
                      <button class="btn btn-success my-1" data-type="start" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Empezar <i class="far fa-play ml-2"></i></button>
                    @else
                      @if($work_logs->first()->type == 'start')
                        <button class="btn btn-pause btn-warning my-1" data-type="pause" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Pausar <i class="far fa-pause ml-2"></i></button>
                        <button class="btn btn-danger my-1" data-type="stop" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>
                      @elseif($work_logs->first()->type == 'pause')
                        <button class="btn btn-primary my-1" data-type="continue" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Continuar <i class="far fa-play ml-2"></i></button>
                        <button class="btn btn-danger my-1" data-type="stop" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>
                      @elseif($work_logs->first()->type == 'continue')
                        <button class="btn btn-pause btn-warning my-1" data-type="pause" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Pausar <i class="far fa-pause ml-2"></i></button>
                        <button class="btn btn-danger my-1" data-type="stop" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>
                      @elseif($work_logs->first()->type == 'stop')
                        Finalizó la tarea.
                      @endif
                    @endif
                    </div>
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
        <p class="text my-3 body-title">¿Confirmas la actividad?</p>
        <div class="pause-list" style="display: none;">
          <p class="text mb-0">Selecciona el motivo</p>
          <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
            <label class="btn btn-outline-primary">
              <input type="radio" name="reason" id="option1" value="Comida"> Comida
            </label>
            <label class="btn btn-outline-primary">
              <input type="radio" name="reason" id="option2" value="Término de jornada"> Término de jornada
            </label>
            <label class="btn btn-outline-primary">
              <input type="radio" name="reason" id="option3" value="Salud"> Salud
            </label>
          </div>
          <div class="item pt-2"><input class="form-control reason" type="text" name="" placeholder="o escribe el motivo"></div>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-secondary" data-dismiss="modal" type="button">Cancelar</button>
        <button class="btn btn-primary btn-confirm" data-dismiss="modal" type="button" disabled=""><i class="fal fa-check"></i> Confirmar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $(document).ready(function() {
    var actualBtn;
    $('.btn-tasks').on('click', function (event) {
      $(this).parents('tr').next().slideToggle();
    })

    function clearRadios() {
      $('.btn-group-toggle [name="reason"]').attr('checked', false)
      $('.btn-group-toggle .btn').removeClass('active focus')
    }

    $('.reason').on('focus', function (event) {
      clearRadios();

      $('.btn-confirm').data('reason', $('.reason').val()).attr('disabled', false)
    })
    $('.reason').on('keyup', function (event) {
      $('.btn-confirm').data('reason', $('.reason').val())
    })

    $('.btn-group-toggle [name="reason"]').on('change', function (event) {
      $('.btn-confirm').data('reason', $('.btn-group-toggle [name="reason"]:checked').val()).attr('disabled', false)
    })

    $('#modalReason').on('show.bs.modal', function (event) {
      clearRadios();
      $('.reason').val('')
      actualBtn = $(event.relatedTarget);
      if(actualBtn.data('type') == 'pause') {
        $('.btn-confirm').attr('disabled', true)
      } else {
        $('.btn-confirm').attr('disabled', false)
      }
    })

    $(document).on("click", ".work-buttons .btn", function (event) {
      if($(this).data('type') == 'pause') {
        $('.pause-list').show();
        $('.body-title').hide();

        checked = $('.btn-group-toggle [name="reason"]:checked');
        if(checked) {
          $(this).data('reason', checked.val())
        } else {
          $(this).data('reason', $('.reason').val())
        }
      } else {
        $('.pause-list').hide();
        $('.body-title').show();
      }
      $(".modal-footer .btn-confirm").data('work_id', $(this).data('work_id'));
      $(".modal-footer .btn-confirm").data('type', $(this).data('type'));
    })

    $(document).on("click", ".modal-footer .btn-confirm", function (event) {
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
            $('#service-'+work_id+ ' .status').html('<span class="badge badge-info">'+data[0].description+'</span>')
            list.empty();
            $.each(data, function (id, item) {
              list.append(
                `<li class="item">`+item.description + (item.type == 'pause' ? ' | '+item.reason : '') +`<span> | `+dateFormatter(item.created_at)+`</span>
                <hr class="my-1" style="border-top-color: #444">
                </li>`
                )
            })

            if(type == 'start') {
              parent.find('.work-buttons').html(`
                <button class="btn btn-pause btn-warning my-1" data-type="pause" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalReason">Pausar <i class="far fa-pause ml-2"></i></button>

                <button class="btn btn-danger my-1" data-type="stop" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>
                `);
            } else if(type == 'pause') {
              parent.find('.work-buttons').html(`
                <button class="btn btn-primary my-1" data-type="continue" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalReason">Continuar <i class="far fa-play ml-2"></i></button>

                <button class="btn btn-danger my-1" data-type="stop" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>
                `);
            } else if(type == 'continue') {
              parent.find('.work-buttons').html(`
                <button class="btn btn-pause btn-warning my-1" data-type="pause" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalReason">Pausar <i class="far fa-pause ml-2"></i></button>

                <button class="btn btn-danger my-1" data-type="stop" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>
                `);
            } else if(type == 'stop') {
              parent.find('.work-buttons').html(`
                Finalizó la tarea.
                `);
            }

            $this.attr('disabled', true);
          }
        },
        error: function(request, status, error) {

        }
      });
    })

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