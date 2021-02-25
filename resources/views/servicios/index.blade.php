@extends('layouts.app', ['title' => 'Servicios'])

@section('content')
<div class="row">
	<div class="col">
		<a href="{{ route('services.create') }}" class="btn btn-primary">Crear Servicio</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title"> Servicio</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="services-table">
            <thead class="text-primary">
              <th>
                Id
              </th>
              <th>
                Nombre
              </th>
              <th>
                Area
              </th>
              <th>
                Estado
              </th>
              <th class="text-right">
                Acciones
              </th>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" id="modalServices">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Eliminar Servicio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h6 class="body-title">¿Seguro desea <span class="m-status">eliminar</span> servicio <br> <strong></strong>?</h6>
        <p class="service-name"></p>
        <p class="service-area"></p>
      </div>
      <div class="modal-footer justify-content-center">
          <button class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-dark btn-status-confirm" data-id="">Confirmar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $(document).ready(function () {
    var services_table = $('#services-table').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{route('services.list')}}",
       pageLength: 5,
       lengthMenu: [ 5, 25, 50 ],
       columns: [
          { data: 'id', class: 'text-nowrap' },
          { data: 'name', class: 'service' },
          { data: 'area' },
          { data: 'status', class: 'text-left' },
          { data: 'tools', class: 'text-center text-nowrap', orderable: false}
      ],
      language: dLanguage
    });

    $(".btn-status-confirm").click(function (e) {
      e.preventDefault();
      var btn = $(this), id = $(this).data('id');
      $.ajax({
          type: "post",
          url: '/servicios/'+id+'/status',
          data: {
            _token: '{{csrf_token()}}',
            status: btn.data('status')
          },
          success: function (response) {
            if (response.success) {
                var data = $.parseJSON(response.data);
                services_table.ajax.reload();
                $('#modalServices').modal('hide');
            }
          },
          error: function (request, status, error) {
            
          }
      });
    });
    $(document).on("click", ".btn-changestatus", function(event) {
      var $this = $(this), status = $this.data('status');
      if(status == 0) {
        $('.modal-title').text('Eliminar Servicio');
        $('.m-status').text('eliminar');
      } else {
        $('.modal-title').text('Activar Servicio');
        $('.m-status').text('activar');
      }
      $('#modalServices .body-title strong').text($(this).parents('tr').find('.service').text());
      $('.btn-status-confirm').data('id', $(this).data('id'));
      $('.btn-status-confirm').data('status', $(this).data('status'));
    })
  })
</script>
@endsection