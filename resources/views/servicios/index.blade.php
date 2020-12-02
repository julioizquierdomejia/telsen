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
          <table class="table table-separate" id="tablas">
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
            <tbody>
            	@foreach($services as $servicio)
	              <tr>
	                <td>
	                  {{$servicio->id}}
	                </td>
	                <td>
	                  {{$servicio->name}}
	                </td>
                  <td>
                    <span class="badge badge-dark px-3 py-1">{{$servicio->area}}</span>
                  </td>
                  <td>
                    @if($servicio->enabled == 1)
                    <span class="badge badge-success px-3 py-1">Activo</span>
                    @else
                    <span class="badge badge-dark px-3 py-1">Inactivo</span>
                    @endif
                  </td>
	                <td class="text-right">
	                	<a href="{{ route('services.edit', $servicio) }}" class="btn btn-warning"><i class="fal fa-edit"></i></a>
	                	<button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#modalServices" type="button" data-id="{{$servicio->id}}"><i class="fal fa-minus-circle"></i></button>
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
        <h6 class="body-title">¿Seguro desea eliminar servicio?</h6>
        <p class="service-name"></p>
        <p class="service-area"></p>
      </div>
      <div class="modal-footer justify-content-center">
          <button class="btn btn-secondary btn-cancel" data-dismiss="modal">Cancelar</button>
          <button class="btn btn-dark btn-confirm" data-id="">Confirmar</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $(".btn-confirm").click(function (e) {
    e.preventDefault();
    var btn = $(this), id = $(this).data('id');
    $.ajax({
        type: "post",
        url: '/servicios/'+id+'/eliminar',
        data: data,
        success: function (data) {
          btn.parents('tr').remove();
        },
        error: function (request, status, error) {
          var data = jQuery.parseJSON(request.responseText);
          if (data.errors) {
            if (data.errors.name) {
              $('.name_message').text(data.errors.name);
            }
            if (data.errors.enabled) {
              $('.enabled_message').text(data.errors.enabled);
            }
            /*if (data.errors.area_id) {
              $('.area_message').text(data.errors.area_id);
            }*/
          }
        }
    });
});
</script>
@endsection