@extends('layouts.app', ['title' => 'Areas | '. $area->name])

@section('content')
<div class="row">
  <div class="col-md-12">
    <form class="card card-user form-card" method="POST" action="{{route('areas.edit', ['area' => $area->id])}}" enctype="multipart/form-data">
      <div class="card-header">
        <h5 class="card-title d-flex align-items-center">
          <span>Editar area <strong>{{$area->name}}</strong></span>
          <div class="custom-control custom-switch ml-auto @error('enabled') is-invalid @enderror"  style="font-size: 12px;text-transform: none;font-weight: 500;">
          <input type="checkbox" class="custom-control-input" id="enabled" value="1" {{old('enabled', $area->enabled) == 1 ? 'checked': ''}} name="enabled">
          <label class="custom-control-label text-dark" for="enabled">Activo</label>
          @error('enabled')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
        </div>
        </h5>
      </div>
      <div class="card-body">
          @csrf
          <div class="row">
            <div class="col-md-12 form-group">
                <label class="col-form-label">Nombre</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="" value="{{$area->name}}" name="name">
                @error('name')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-9">
              <button type="button" class="btn btn-primary mt-0" data-toggle="modal" data-target="#modalServices">Agregar servicios</button>
            </div>
            
          </div>
          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Actualizar</button>
            </div>
          </div>
      </div>
    </form>
  </div>
</div>
<div class="modal fade" tabindex="-1" id="modalServices">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Servicios</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-form-label">Nombre</label>
                <input type="text" class="form-control" placeholder="" required="" value="" name='name' id="inputname">
              </div>
              <p class="name_message text-danger"></p>
            </div>

            <div class="col-md-12">
              <label class="col-form-label" for="sselectEstado">Estado</label>
              <select name="enabled" class="form-control dropdown2" id="sselectEstado" style="width: 100%">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
              <p class="enabled_message text-danger"></p>
            </div>
          </div>
          <h4 class="h6"><strong>Servicios</strong></h4>
          @if($services->count())
          <ul class="services-list">
          @foreach($services as $service)
          <li>{{$service->name}}</li>
          @endforeach
          </ul>
          @else
          <ul class="services-list"><li>Esta area aun no cuenta con servicios.</li></ul>
          @endif
          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="button" id="btnServices" class="btn btn-primary btn-round px-md-5">Enviar</button>
            </div>
          </div>
        </div>  
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $("#btnServices").click(function (e) {
    e.preventDefault();
    var inputname = $('#inputname').val();
    var estado = $('#sselectEstado').val();
    var token = '{{csrf_token()}}';// ó $("#token").val() si lo tienes en una etiqueta html.
    var data={name:inputname, area_id: {{$area->id}}, enabled: estado,_token:token, ajax: true};
    if (inputname == '') {
      $('.name_message').text('Ingrese el nombre');
      return;
    } else {
      $('.name_message').text('');
    }
    if (estado == '') {
      $('.enabled_message').text('Seleccione el estado');
      return;
    } else {
      $('.enabled_message').text('');
    }
    $.ajax({
        type: "post",
        url: "{{route('services.store')}}",
        data: data,
        success: function (data) {
          //alert("Se ha realizado el POST con exito "+data);
          $('.services-list').empty();
          $.each(data, function (id, item) {
            $('.services-list').append('<li>'+item.name+'</li>');
          })
          $('#inputname').val('').focus();
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