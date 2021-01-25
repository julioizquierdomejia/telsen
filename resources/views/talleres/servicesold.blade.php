@extends('layouts.app', ['body_class' => 'ots', 'title' => 'Mis Tareas'])
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dropzone/dropzone.min.css') }}" />
<script type="text/javascript">var drops = [];</script>
@php
  $single_role = count($roles) == 1;
  $allowed_user = in_array('superadmin', $roles) || in_array('supervisor', $roles) && $single_role;
@endphp
<div class="row">
  <div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title d-flex align-items-center">
          <span>Mis Tareas</span>
          {{-- <select class="form-control col-5 col-md-4 col-xl-3 ml-auto">
            <option value="">Seleccionar OT</option>
            @foreach ($ots as $ot)
              <option value="1">OT-{{$ot}}</option>
            @endforeach
          </select> --}}
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
              @foreach ($services as $item)
              @php
              $logs = $item->work_logs;
              $wl_count = $logs->count();
              $status_code = $wl_count ? $logs->first()->status->code : null;
              $status = $wl_count ? $logs->first()->status->name : null;
              $work_type = $wl_count ? $logs->first()->type : '';
              @endphp
              <tr id="service-{{$item->id}}">
                {{-- <td>{{$item->id}}</td> --}}
                <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
                <td>OT-{{$item->code}}</td>
                <td>{{$item->potencia}}</td>
                <td>{{$item->area}}</td>
                <td>{{$item->service}}</td>
                <td class="status">{!! $wl_count ? '<span class="badge badge-info d-block py-1">'.$status.'</span>' : '-' !!}</td>
                <td class="text-center">
                  <button class="btn btn-primary btn-sm btn-tasks">Actividades <i class="far fa-tasks ml-2"></i></button>
                </td>
              </tr>
              <tr class="text-center" data-id="service-{{$item->id}}" style="display: none;">
                <td class="p-0" colspan="7">
                  <div class="px-3" style="border-left: 10px solid #efefef;border-right: 10px solid #efefef;background-color: #f9f9f9;margin-top: -6px;">
                    <div class="t-details text-white px-2 py-3 mb-3 row">
                      <div class="history bg-dark py-3 col-12 col-md-8 col-xl-10">
                        <h5 class="h6 px-3">Historial</h5>
                        <ul class="works-list text-left list-inline mb-0 text-info" style="max-height: 160px;overflow-y: auto;">
                          @if ($wl_count)
                          @foreach ($logs as $key => $worklog)
                          <li class="item">
                            <span>{{$worklog->status->name ?? '-'}}</span>
                            <span> | {{date('d-m-Y h:i a', strtotime($worklog->created_at))}}</span>
                            <hr class="my-1" style="border-top-color: #444">
                          </li>
                          @endforeach
                          @else
                          <li class="text-muted my-2">No hay historial aún</li>
                          @endif
                        </ul>
                        <hr style="border-top-color: #2b2b2b">
                        <div class="history-footer">
                          <label class="text-white">Comentarios:</label>
                          <textarea class="form-control mt-0 comments" data-otwork="{{$item->id}}" name="comments">{{$item->comments}}</textarea>
                          <p class="mb-0 comments-msg text-success" style="display: none;"><span class="font-weight-light"><i class="fa fa-check"></i> Se guardó.</span></p>
                          {{-- <div class="col-12 col-md-6 text-left">
                            <label class="text-white">Fotos:</label>
                            <ul class="list-inline">
                              <li>foto</li>
                              <li>foto 2</li>
                            </ul>
                            <div id="dZUpload{{$item->id}}" class="dropzone">
                              <div class="dz-default dz-message">Sube aquí tus imágenes</div>
                            </div>
                            <script type="text/javascript">drops.push('dZUpload{{$item->id}}')</script>
                          </div> --}}
                        </div>
                        <hr style="border-top-color: #2b2b2b">
                        <div class="additional">
                          <label class="text-white" data-toggle="collapse" data-target="#collapsetable{{$item->id}}">Información adicional:</label>
                          <div class="table-wrapper mb-3 collapse show">
                            @php
                              $service = App\Models\Service::where('id', $item->service_id)->first();
                              $tables = $service->tables;
                            @endphp
                            @foreach ($tables as $table)
                            <form class="parent-table" id="parentTb{{$table->id}}" action="/worklog/update-data" method="POST">
                              <table class="table text-white" id="infotable{{$table->id}}">
                                  @php
                                    $cols_head_html = ''; $cols_html = '';
                                    $cols = $table->cols;
                                    $cols_count = $cols->count();
                                    $table_rows = $table->rows_quantity;
                                    $counter = -1;
                                    @endphp
                                    @foreach ($cols as $col)
                                    @php
                                    $cols_head_html .= '<th>'.$col->col_name.'</th>';
                                    @endphp
                                    @endforeach
                                  @for ($i = 0; $i < $table_rows; $i++)
                                  @php
                                    $cols_html .= '<tr>';
                                  @endphp
                                    @foreach ($cols as $ckey => $col)
                                    @php
                                    //var_dump($col->data->toArray());
                                    $counter++;
                                    $cols_html .= '<td>
                                      <input class="form-control frm-col mt-0" type="text" hidden="" name="coldata['.$counter.'][id]" value="'.(isset($col->data[$i]->id) ? $col->data[$i]->id : '').'">
                                      <input class="form-control frm-col mt-0" type="text" hidden="" name="coldata['.$counter.'][work_add_info_id]" value="'.$col->work_add_info_id.'">
                                      <input class="form-control frm-col mt-0" type="text" hidden="" name="coldata['.$counter.'][row]" value="'.$i.'">
                                      <input class="form-control frm-col mt-0" type="text" hidden="" name="coldata['.$counter.'][col_id]" value="'.$col->id.'">
                                      <input class="form-control frm-col mt-0" type="text" hidden="" name="coldata['.$counter.'][ot_work_id]" value="'.$item->id.'">
                                      <input class="form-control frm-col mt-0" type="text" name="coldata['.$counter.'][content]" value="'.(isset($col->data[$i]->content) ? $col->data[$i]->content : '').'">
                                    </td>';
                                    @endphp
                                    @endforeach
                                    @php
                                    $cols_html .= '</tr>';
                                  @endphp
                                  @endfor
                                <thead>
                                  <tr>
                                    <th colspan="{{$cols_count}}">
                                      {{$table->name}}
                                    </th>
                                  </tr>
                                  <tr>{!! $cols_head_html !!}</tr>
                                </thead>
                                <tbody>
                                {!! $cols_html !!}
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <td colspan="{{$cols_count}}"><p class="mb-0 coldata-msg text-success" style="display: none;"><span class="font-weight-light"><i class="fa fa-check"></i> Se guardó.</span></p></td>
                                  </tr>
                                </tfoot>
                              </table>
                              </form>
                            @endforeach
                          </div>
                        </div>
                      </div>
                      <div class="work-buttons py-3 col-12 col-md-4 col-xl-2 text-dark">
                      @if ($allowed_user && $wl_count > 0)
                        @if ($status_code == 'approved')
                          <span class="badge badge-success d-block py-1 my-1">Aprobada</span>
                        @elseif($status_code == 'disapproved')
                          <span class="badge badge-secondary d-block py-1 my-1">Desaprobada</span>
                        @else
                        <button class="btn btn-action btn-primary my-1" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalApprove">Aprobar <i class="far fa-check ml-2"></i></button>
                        @endif
                      @else
                      {{-- Trabajador --}}
                        @if ($wl_count == 0)
                          <button class="btn btn-success my-1 btn-action" data-type="start" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Empezar <i class="far fa-play ml-2"></i></button>
                        @else
                          @if($work_type == 'start' || $work_type == 'continue' || $work_type == 'restart')
                          <button class="btn btn-pause btn-warning my-1 btn-action" data-type="pause" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Pausar <i class="far fa-pause ml-2"></i></button>
                          <button class="btn btn-danger my-1 btn-action" data-type="end" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>
                          @elseif($work_type == 'pause')
                          <button class="btn btn-primary my-1 btn-action" data-type="continue" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Continuar <i class="far fa-play ml-2"></i></button>
                          <button class="btn btn-danger my-1 btn-action" data-type="end" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>
                          @elseif($work_type == 'approved' || $work_type == 'disapproved')
                            @if ($status_code == 'approved')
                              <span class="badge badge-success d-block py-1 my-1">Aprobada</span>
                            @elseif($status_code == 'disapproved')
                              <span class="badge badge-secondary d-block py-1 my-1">Desaprobada</span>
                              <button class="btn btn-danger my-1 btn-action" data-type="restart" data-work_id="{{$item->id}}" type="button" data-toggle="modal" data-target="#modalReason">Reiniciar <i class="far fa-play ml-2"></i></button>
                            @endif
                          Finalizó la tarea.
                          @endif
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
<script src="{{ asset('assets/dropzone/dropzone.min.js') }}"></script>
<script>
  Dropzone.autoDiscover = false;
  $(document).ready(function() {

    $.each(drops, function (id, item) {
      var myDrop = new Dropzone("#"+item, {
        url: "{{route('gallery.store')}}",
        addRemoveLinks: true,
        params: {
          _token: '{{csrf_token()}}',
          eval_type: 'workshop',
          ot_id: null,
        },
        renameFile: function (file) {
            let newName = new Date().getTime() + '_' + file.name;
            return newName;
        },
        success: function (file, response) {
            var imgName = response;
            file.previewElement.classList.add("dz-success");
            //createJSON(myDrop.files);
        },
        removedfile: function(file) {
          //createJSON(myDrop.files);
            file.previewElement.remove();
        },
        error: function (file, response) {
            file.previewElement.classList.add("dz-error");
        }
    });

    })

    var actualBtn;
    $('.btn-tasks').on('click', function (event) {
      $(this).parents('tr').next().slideToggle();
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
      console.log("entra a submit")
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
            $('#service-'+work_id+ ' .status').html('<span class="badge badge-info d-block py-1">'+data[0].status.name+'</span>')
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
            @if (!in_array('supervisor', $roles))
            if(type == 'start' || type == 'continue' || type == 'restart') {
              parent.find('.work-buttons').html(`
                <button class="btn btn-pause btn-warning my-1 btn-action" data-type="pause" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalReason">Pausar <i class="far fa-pause ml-2"></i></button>

                <button class="btn btn-danger my-1 btn-action" data-type="end" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>
                `);
            } else if(type == 'pause') {
              parent.find('.work-buttons').html(`
                <button class="btn btn-primary my-1 btn-action" data-type="continue" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalReason">Continuar <i class="far fa-play ml-2"></i></button>

                <button class="btn btn-danger my-1 btn-action" data-type="end" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalReason">Terminar <i class="far fa-stop ml-2"></i></button>
                `);
            } else if(type == 'end') {
              parent.find('.work-buttons').html(`
                Finalizó la tarea.
                `);
            }
            @else
              if(type == 'end') {
              parent.find('.work-buttons').html(`
                Finalizó la tarea.
                @if ($allowed_user)
                  <button class="btn btn-danger my-1 btn-action" data-type="end" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalApprove">Terminar <i class="far fa-check ml-2"></i>Desaprobar</button>
                  <button class="btn btn-danger my-1 btn-action" data-type="end" data-work_id="`+work_id+`" type="button" data-toggle="modal" data-target="#modalApprove">Terminar <i class="far fa-check ml-2"></i>Aprobar</button>
                @endif
                `);
              }
            @endif

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
                console.log(data)
              }
              $('#modalApprove').modal('hide');
              location.reload();
              $('#modalApprove [type="submit"]').attr('disabled', false);
          },
          error: function(request, status, error) {
              var data = jQuery.parseJSON(request.responseText);
              console.log(data);
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