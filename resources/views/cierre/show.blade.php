@php
  $ot_code = zerosatleft($ot->code, 3);
@endphp
@extends('layouts.app', ['body_class' => 'ots', 'title' => 'OT-'.$ot_code.' Pendiente de cierre'])
@section('content')
@php
$ot_status = $ot->statuses;
$statuses = array_column($ot_status->toArray(), "name");
$status_last = $ot_status->last();
$role_names = validateActionbyRole();
$admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
$before_closure = $status_last->name == 'delivery_generated';
@endphp
<link rel="stylesheet" href="{{ asset('assets/dropzone/dropzone.min.css') }}" />
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title d-flex justify-content-between align-items-center">
        <span>
          Orden de Trabajo {{$ot_code}}
          <span class="d-block">
            @if($status_last->name == 'cc')
            <span class="badge badge-primary px-2 py-1 w-100">{{ $status_last->description }}</span>
            @elseif($status_last->name == 'cc_waiting')
            <span class="badge badge-danger px-2 py-1 w-100">{{ $status_last->description }}</span>
            @elseif(strpos($status_last->name, '_approved') !== false || $status_last->name == 'delivery_generated')
            <span class="badge badge-success px-2 py-1 w-100">{{ $status_last->description }}</span>
            @elseif($status_last->name == 'rdi_waiting')
            <span class="badge badge-danger px-2 py-1 w-100">{{ $status_last->description }}</span>
            @else
            <span class="badge badge-secondary px-2 py-1 w-100">{{ $status_last->description }}</span>
            @endif
          </span>
        </span>
        <span class="card-title-buttons">
        @if ($status_last->name == 'pending_closure')
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalCloseOT">Cerrar OT</button>
            @endif
          </span>
        </h5>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 mb-2">
            <label class="col-label">Fecha de creación <span class="text-danger">(*)</span></label>
            <p class="mb-1">{{date('d-m-Y', strtotime($ot->created_at))}}</p>
          </div>
          <div class="col-md-2 mb-2">
            <label class="col-label">Vendedor</label>
            <p class="mb-1">{{$ot->guia_cliente ?? '-'}}</p>
          </div>
          <div class="col-md-5 mb-2">
            <label class="col-label" for="selectRuc">Razón social:</label>
            <p class="mb-1">{{ $ot->razon_social }}</p>
          </div>
          <div class="col-md-2 mb-2">
            <label class="col-label" for="selectRuc">Tipo cliente:</label>
            <p class="mb-1"><span class="badge badge-primary px-3">{{ $ot->tipo_cliente }}</span></p>
          </div>
        </div>
        <h5 class="second-title text-danger py-2">Datos del Motor</h5>
        <div class="row">
          <div class="col-md-12 mb-2">
            <label class="col-label">Descripción del motor</label>
            <p class="mb-1">{{$ot->descripcion_motor ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="col-label">Código</label>
            <p class="mb-1">{{$ot->codigo_motor ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="col-label">Marca</label>
            <p class="mb-1">{{isset($ot->marca) ? $ot->marca->name : '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="col-label">Solped</label>
            <p class="mb-1">{{$ot->solped ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3  mb-2">
            <label class="col-label">Modelo</label>
            <p class="mb-1">{{isset($ot->modelo) ? $ot->modelo->name : '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="col-label">Numero de potencia</label>
            <p class="mb-1">{{$ot->numero_potencia ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="col-label">Medida de potencia</label>
            <p class="mb-1">{{$ot->medida_potencia ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="col-label">Voltaje</label>
            <p class="mb-1">{{$ot->voltaje ?? '-'}}</p>
          </div>
          <div class="col-6 col-md-3 mb-2">
            <label class="col-label">Velocidad</label>
            <p class="mb-1">{{$ot->velocidad ?? '-'}}</p>
          </div>
          <div class="col-12 mb-4">
            <label class="col-label">Estado</label>
            <p class="mb-1">{!!$ot->enabled == 1 ? '<span class="badge badge-success px-3">Activo</span>' : '<span class="badge badge-danger px-3">Inactivo</span>'!!}</p>
          </div>
          <div class="col-12 mb-2">
            <div class="gallery">
              <h6>Galería</h6>
            @if($gallery->count())
            <ul class="row list-unstyled">
            @foreach($gallery as $file)
            @php
              $file_name = preg_replace('/[0-9]+_/', '', $file->name);
            @endphp
            <li class="gallery-item col-12 col-md-4 col-xl-3 py-2">
              <button class="btn m-0 text-truncate text-nowrap btn-light" style="font-size: 11px;max-width: 100%" data-toggle="modal" data-target="#galleryModal" data-src="{{ asset("uploads/ots/$ot->id/closure/$file->name") }}" title="{{$file_name}}"><i class="fa fa-file-pdf"></i> {{$file_name}}</button>
            </li>
            @endforeach
            </ul>
            @else
            <p class="text-center">No se agregaron imágenes.</p>
            @endif
            @if ($before_closure)
            <div id="dZUpload" class="dropzone">
            <input class="form-control images d-none" type="text" name="files" value="{{old('files')}}">
              <div class="dz-default dz-message">Sube aquí tus archivos</div>
            </div>
            @endif
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" id="galleryModal">
    <div class="modal-dialog modal-lg" style="max-height: calc(100vh - 40px)">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Galería</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body h-100 text-center">
            <div class="embed-responsive embed-responsive-16by9">
              <iframe class="embed-responsive-item file" src=""></iframe>
            </div>
        </div>
    </div>
  </div>
</div>
@if ($status_last->name == 'pending_closure')
<div class="modal fade" tabindex="-1" id="modalCloseOT">
  <div class="modal-dialog">
    <form class="modal-content" action="{{ route('ordenes.closure') }}" method="POST" enctype="multipart/form-data">
      <div class="modal-header">
        @csrf
        <h5 class="modal-title">Cerrar OT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p class="text my-2 body-title">¿Seguro desea cerrar la OT?</p>
        <input type="text" name="ot_id" value="{{$ot->id}}" hidden="">
        <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
          {{-- <label class="btn btn-outline-secondary px-4">
            <input type="radio" name="accept" id="close1" value="0"><i class="far fa-times"></i> No
          </label> --}}
          <label class="btn btn-outline-success px-4">
            <input type="radio" name="accept" id="close2" value="1" checked=""><i class="far fa-check"></i> Sí
          </label>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-primary px-5" type="submit">Confirmar</button>
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
  @if ($before_closure)
  var myDrop = new Dropzone("#dZUpload", {
    url: "{{route('gallery.store')}}",
    addRemoveLinks: true,
    maxFilesize: 2000,
    timeout: 180000,
    acceptedFiles: ".pdf",
    //autoProcessQueue: false,
    params: {
      _token: '{{csrf_token()}}',
      eval_type: 'closure',
      ot_id: {{$ot->id}},
    },
    renameFile: function(file) {
      let newName = new Date().getTime() + '_' + file.name;
      return newName;
    },
    success: function(file, response) {
      var imgName = response;
      file.previewElement.classList.add("dz-success");
      createJSON(myDrop.files);
    },
    removedfile: function(file) {
      createJSON(myDrop.files);
      file.previewElement.remove();
    },
    error: function(file, response) {
      file.previewElement.classList.add("dz-error");
    }
  });
  @endif

  function createJSON(files) {
    var json = '{';
    var otArr = [];
    $.each(files, function(id, item) {
      console.log(item)
      otArr.push('"' + id + '": {' +
        '"name":"' + item.upload.filename +
        '", "type":"' + item.type +
        '", "status":"' + item.status +
        '", "url":"' + item.url +
        '"}');
    });
    json += otArr.join(",") + '}'
    $('.images').val(json)
    return json;
  }

  $('#galleryModal').on('hide.bs.modal', function (event) {
      $('#galleryModal .modal-body .file').removeAttr('src');
    })
  $('#galleryModal').on('show.bs.modal', function (event) {
      $('#galleryModal .modal-body .file').attr('src', $(event.relatedTarget).data('src'))
    })

});
</script>
@endsection