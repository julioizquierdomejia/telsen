@extends('layouts.app', ['title' => 'RDI | '. $rdi->name])

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Editar RDI <strong>{{$rdi->name}}</strong></h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="{{route('rdi.edit', ['rdi' => $rdi->id])}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-form-label">Nombre</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="" value="{{$rdi->name}}" name="name">
              </div>
                @error('name')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-3 form-group">
              <label class="col-form-label">Estado</label>
              <select name="enabled" class="form-control @error('enabled') is-invalid @enderror dropdown2" id="selectEstado">
                <option value="1" {{$rdi->enabled == 1 ? 'selected': ''}}>Activo</option>
                <option value="0" {{$rdi->enabled == 0 ? 'selected': ''}}>Inactivo</option>
              </select>
              @error('enabled')
                  <p class="error-message text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-md-9 pt-1">
              <button type="button" class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalServices">Agregar servicios</button>
            </div>
            
          </div>
          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Actualizar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
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

            <input type="text" class="form-control d-none" required="" value="{{$rdi->id}}" name='area_id' id="sselectArea">

            <div class="col-md-12">
              <label class="col-form-label" for="sselectEstado">Estado</label>
              <select name="enabled" class="form-control dropdown2" id="sselectEstado" style="width: 100%">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
              <p class="enabled_message text-danger"></p>
            </div>
          </div>
          <p class="area_message text-danger"></p>
          <h4 class="h6"><strong>Servicios</strong></h4>
          <ul class="services-list">
          @foreach($services as $service)
          <li>{{$service->name}}</li>
          @endforeach
          </ul>
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
    var area_id = $('#sselectArea').val();
    var estado = $('#sselectEstado').val();
    var token = '{{csrf_token()}}';// ó $("#token").val() si lo tienes en una etiqueta html.
    var data={name:inputname, area_id: area_id, enabled: estado,_token:token, ajax: true};
    if (inputname == '') {
      $('.name_message').text('Ingrese el nombre');
      return;
    } else {
      $('.name_message').text('');
    }
    if (area_id == '') {
      $('.area_message').text('Seleccione el area');
      return;
    } else {
      $('.area_message').text('');
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
            if (data.errors.area_id) {
              $('.area_message').text(data.errors.area_id);
            }
          }
        }
    });
});
</script>
@endsection