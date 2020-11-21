@extends('layouts.app', ['body_class' => 'ots', 'title' => 'OTS'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Talleres de OT</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate data-table">
            <thead class=" text-primary">
              <th class="text-nowrap">Fecha OT</th>
              <th class="text-nowrap">N° de OT</th>
              <th>Cliente</th>
              <th>Potencia</th>
              <th class="text-center">Fecha de entrega</th>
              <th class="text-center">Herramientas</th>
            </thead>
            <tbody>
              @if($ots)
              @foreach($ots as $ot)
                <tr>
                  <td>
                    {{date('d-m-Y', strtotime($ot->created_at))}}
                  </td>
                  <td>
                    OT-{{zerosatleft($ot->id, 3)}}
                  </td>
                  <td>
                    {{$ot->razon_social}}
                  </td>
                  <td>
                    {{$ot->numero_potencia . ' ' . $ot->medida_potencia}}
                  </td>
                  <td>
                    <span class="btn btn-success btn-sm">{{date('d-m-Y', strtotime($ot->fecha_entrega))}}</span>
                  </td>
                  <td class="text-right">
                    <a href="{{ route('workshop.calculate', $ot) }}" class="btn btn-orange btn-sm">Evaluar <i class="fal fa-edit ml-2"></i></a>
                  </td>
                </tr>
              @endforeach
              @else
              <tr><td class="text-center" colspan="7">No hay órdenes de trabajo.</td></tr>
              @endif
            </tbody>
          </table>
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
    $(document).on("click", ".btn-mdelete", function(event) {
        $('#modalDelOT .body-title strong').text($(this).parents('tr').find('.otid').text());
        $('.btn-delete-confirm').data('otid', $(this).data('otid'));
    })

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
                            $('#nav-enabledots tbody').html('<tr><td class="text-center" colspan="7">No hay órdenes de trabajo.</td></tr>');
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
});
</script>
@endsection