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
              <tr id="service-{{$item->id}}">
                {{-- <td>{{$item->id}}</td> --}}
                <td>{{date('d-m-Y', strtotime($item->created_at))}}</td>
                <td>OT-{{$item->code}}</td>
                <td>{{$item->potencia}}</td>
                <td>{{$item->service}}</td>
                <td>-</td>
                <td class="text-center">
                  <button class="btn btn-primary btn-sm btn-tasks">Actividades <i class="far fa-tasks ml-2"></i></button>
                </td>
              </tr>
              <tr class="text-center" data-id="service-{{$item->id}}" style="display: none;">
                <td class="p-0" colspan="6">
                  <div class="t-details px-2 py-3 mb-3" style="border-left: 10px solid #efefef;border-right: 10px solid #efefef;background-color: #f9f9f9;margin-top: -6px;">
                    <div class="work-buttons mb-3">
                      <button class="btn btn-success" data-type="start" data-work_id="{{$item->id}}" data-id="{{$item->id}}" type="button">Empezar <i class="far fa-play ml-2"></i></button>
                      <button class="btn btn-warning" data-type="pause" data-work_id="{{$item->id}}" data-id="{{$item->id}}" type="button">Pausar <i class="far fa-pause ml-2"></i></button>
                      <button class="btn btn-primary" data-type="continue" data-work_id="{{$item->id}}" data-id="{{$item->id}}" type="button">Continuar <i class="far fa-play ml-2"></i></button>
                    </div>
                    <div class="history bg-dark text-white pt-3">
                      <h5 class="h6 px-3">Historial</h5>
                      @if ($item->work_logs)
                        <ol class="works-list pb-3" style="max-height: 160px;overflow-y: auto;">
                          @foreach ($item->work_logs as $worklog)
                          <li class="px-3"><span>{{date('d-m-Y H:i', strtotime($worklog->created_at))}}</span> | {{$worklog->description ?? '-'}}</li>
                          @endforeach
                        </ol>
                      @else
                      <p class="text-muted mb-0 pb-3">No hay historial aun</p>
                      @endif
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
@endsection
@section('javascript')
<script>
  $(document).ready(function() {
    $('.btn-tasks').on('click', function (event) {
      $(this).parents('tr').next().slideToggle();
    })

    $('.work-buttons .btn').on('click', function (event) {
    var $this = $(this),
        work_id = $this.data('work_id'),
        //user_id = $this.data('user_id'),
        type = $this.data('type');
      $.ajax({
        type: "POST",
        url: "{{ route('worklog.store') }}",
        data: {
          _token: '{{csrf_token()}}',
          work_id: work_id,
          //user_id: user_id,
          type: type,
        },
        beforeSend: function() {
          $this.attr('disabled', true);
        },
        success: function(response) {
          if (response.success) {
            var data = $.parseJSON(response.data),
              s_length = data.length;
              var list = $this.parents('.t-details').find('.works-list');
              list.empty();
              $.each(data, function (id, item) {
                list.append(
                  '<li class="px-3"><span>'+dateFormatter(item.created_at)+'</span> | '+item.description+'</li>'
                  )
              })
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
      var h = formattedDate.getHours() + ":" +formattedDate.getMinutes();

      return (d + "-" + m + "-" + y + " " + h);
    }
  });
</script>
@endsection