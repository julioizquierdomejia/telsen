@php
  $ot_id = zerosatleft($rdi->ot_code, 3);
@endphp
@extends('layouts.app', ['title' => 'Editar RDI de OT-'. $ot_id])

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Editar RDI de OT-<strong>{{$ot_id}}</strong></h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="/rdi" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-6 col-md-3 col-xl-2 form-group">
                <label class="col-form-label" for="rdi_codigo">RDI Código</label>
                <input type="text" class="form-control @error('rdi_codigo') is-invalid @enderror" placeholder="" value="{{old('rdi_codigo', $rdi->rdi_codigo)}}" name='rdi_codigo' id="rdi_codigo" readonly="">
              @error('rdi_codigo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-3 col-xl-2 form-group">
                <label class="col-form-label" for="version">Versión</label>
                <input type="text" class="form-control @error('version') is-invalid @enderror" placeholder="" value="{{old('version', $rdi->version)}}" readonly="" name='version' id="version">
              @error('version')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-3 col-xl-3 form-group">
                <label class="col-form-label">Fecha</label>
                <input type="text" class="form-control" disabled="" value="{{date('d-m-Y', strtotime($rdi->created_at))}}">
            </div>
            <div class="col-6 col-md-5 form-group">
              <label class="col-form-label" for="selectRuc">Seleccione Cliente</label>
              <select style="width: 100%" class="form-control dropdown2 @error('client_id') is-invalid @enderror" name="client_id" id="selectRuc">
                <option value="">Ingresa Cliente</option>
                @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{old('client_id', $rdi->client_id) == $cliente->id ? 'selected' : ''}}>{{ $cliente->razon_social }}</option>
                @endforeach
              </select>
              @error('client_id')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-4 form-group">
                <label class="col-form-label" for="contact">Contacto</label>
                <input type="text" class="form-control @error('contact') is-invalid @enderror" placeholder="" value="{{old('contact', $rdi->contact)}}" name='contact' id="contact">
              @error('contact')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-4 form-group">
                <label class="col-form-label" for="area">Area</label>
                <input type="text" class="form-control @error('area') is-invalid @enderror" placeholder="" value="{{old('area', $rdi->area)}}" name='area' id="area">
              @error('area')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-4 form-group">
                <label class="col-form-label" for="equipo">Equipo</label>
                <input type="text" class="form-control @error('equipo') is-invalid @enderror" placeholder="" value="{{old('equipo', $rdi->equipo)}}" name='equipo' id="equipo">
              @error('equipo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label" for="codigo">Código</label>
                <input type="text" class="form-control @error('codigo') is-invalid @enderror" placeholder="" value="{{old('codigo', $rdi->codigo)}}" name='codigo' id="codigo">
              @error('codigo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            {{-- <div class="col-md-3 form-group">
                <label class="col-form-label" for="ot_id">Ot</label>
                <input type="text" class="form-control @error('ot_id') is-invalid @enderror" placeholder="" value="{{old('ot_id', $rdi->ot_id)}}" name='ot_id' id="ot_id">
              @error('ot_id')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div> --}}
            <div class="col-md-3 form-group">
                <label class="col-form-label" for="fecha_ingreso">Fecha de ingreso</label>
                <input type="date" max="{{date('Y-m-d')}}" class="form-control @error('fecha_ingreso') is-invalid @enderror" placeholder="" value="{{old('fecha_ingreso', date('Y-m-d', strtotime($rdi->fecha_ingreso)))}}" name='fecha_ingreso' id="fecha_ingreso">
              @error('fecha_ingreso')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label" for="tiempo_entrega">Tiempo de entrega</label>
                <input type="number" class="form-control @error('tiempo_entrega') is-invalid @enderror" min="1" placeholder="Días de entrega" value="{{old('tiempo_entrega', $rdi->tiempo_entrega)}}" title="Días de entrega" data-toggle="tooltip" name='tiempo_entrega' id="tiempo_entrega">
              @error('tiempo_entrega')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label" for="orden_servicio">Orden de servicio</label>
                <input type="text" class="form-control @error('orden_servicio') is-invalid @enderror" placeholder="" value="{{old('orden_servicio', $rdi->orden_servicio)}}" name='orden_servicio' id="orden_servicio">
              @error('orden_servicio')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Hecho por</label>
              <input type="text" class="form-control @error('hecho_por') is-invalid @enderror" name="hecho_por" value="{{old('hecho_por', $rdi->hecho_por)}}">
            </div>
          </div>
          <h5 class="text-danger mt-4">Características del Motor</h5>
          <div class="row">
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label" for="selectMarca">Marca</label>
              <select style="width: 100%" name="marca_id" class="form-control @error('marca_id') is-invalid @enderror dropdown2" id="selectMarca">
                <option value="">Selecciona la marca</option>
                @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{old('marca_id', $rdi->marca_id) == $marca->id ? 'selected' : ''}}>{{ $marca->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2 form-group">
              <label class="col-form-label">N° Serie</label>
              <input type="text" class="form-control @error('nro_serie') is-invalid @enderror" placeholder="Ingrese N° Serie" value="{{old('nro_serie', $rdi->nro_serie)}}" name="nro_serie">
            </div>
            <div class="col-6 col-md-2 form-group">
              <label class="col-form-label">Frame</label>
              <input type="text" class="form-control @error('frame') is-invalid @enderror" name="frame" placeholder="Ingrese Frame" value="{{old('frame', $rdi->frame)}}">
            </div>
            <div class="col-6 col-md-2 form-group">
              <label class="col-form-label">Potencia</label>
              <input type="text" class="form-control @error('potencia') is-invalid @enderror" placeholder="Ingrese Potencia" value="{{old('potencia', $rdi->potencia)}}" name="potencia">
            </div>
            <div class="col-6 col-md-2 form-group">
              <label class="col-form-label">Tensión</label>
              <input type="text" class="form-control @error('tension') is-invalid @enderror" placeholder="Ingrese Tensión" value="{{old('tension', $rdi->tension)}}" name="tension">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Corriente</label>
              <input type="text" class="form-control @error('corriente') is-invalid @enderror" placeholder="Ingrese Corriente" value="{{old('corriente', $rdi->corriente)}}" name="corriente">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Velocidad</label>
              <input type="text" class="form-control @error('velocidad') is-invalid @enderror" placeholder="Ingrese Velocidad" value="{{old('velocidad', $rdi->velocidad)}}" name="velocidad">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Conexión</label>
              <input type="text" class="form-control @error('conexion') is-invalid @enderror" placeholder="Ingrese Conexión" value="{{old('conexion', $rdi->conexion)}}" name="conexion">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Deflexión del Eje</label>
              <input type="text" class="form-control @error('deflexion_eje') is-invalid @enderror" placeholder="Ingrese Deflexión del Eje" value="{{old('deflexion_eje', $rdi->deflexion_eje)}}" name="deflexion_eje">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Rodaje delantero</label>
              <input type="text" class="form-control @error('rodaje_delantero') is-invalid @enderror" placeholder="Ingrese Rodaje delantero" value="{{old('rodaje_delantero', $rdi->rodaje_delantero)}}" name="rodaje_delantero">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Rodaje posterior</label>
              <input type="text" class="form-control @error('rodaje_posterior') is-invalid @enderror" placeholder="Ingrese Rodaje posterior" value="{{old('rodaje_posterior', $rdi->rodaje_posterior)}}" name="rodaje_posterior">
            </div>
            <div class="col-md-12 form-group">
                <label class="col-form-label">ANTECEDENTES</label>
                <textarea class="form-control @error('antecedentes') is-invalid @enderror" placeholder="(Indique motivo de salida del componente de las instalaciones del cliente)" name="antecedentes">{{old('antecedentes', $rdi->antecedentes)}}</textarea>
              @error('antecedentes')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-12">
              <label class="col-form-label">Ingresó con:</label>
              <div class="form-control mb-4" style="height: auto">
              <ul class="form-check-list list-inline m-0">
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" {{old('placa_caracteristicas', $rdi->placa_caracteristicas) ? 'checked' : ''}} value="1" name="placa_caracteristicas"><span class="align-middle">Placa caracteristicas</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" {{old('caja_conexion', $rdi->caja_conexion) ? 'checked' : ''}} value="1" name="caja_conexion"><span class="align-middle">Caja conexión</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" {{old('bornera', $rdi->bornera) ? 'checked' : ''}} value="1" name="bornera"><span class="align-middle">Bornera</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" {{old('escudos', $rdi->escudos) ? 'checked' : ''}} value="1" name="escudos"><span class="align-middle">Escudos</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" {{old('ejes', $rdi->ejes) ? 'checked' : ''}} value="1" name="ejes"><span class="align-middle">Ejes</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" {{old('funda', $rdi->funda) ? 'checked' : ''}} value="1" name="funda"><span class="align-middle">Funda</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" {{old('ventilador', $rdi->ventilador) ? 'checked' : ''}} value="1" name="ventilador"><span class="align-middle">Ventilador</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" {{old('acople', $rdi->acople) ? 'checked' : ''}} value="1" name="acople"><span class="align-middle">Acople</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" {{old('chaveta', $rdi->chaveta) ? 'checked' : ''}} value="1" name="chaveta"><span class="align-middle">Chaveta</span>
                </label>
              </li>
              </ul>
              </div>
            </div>
            </div>
            <div class="row">
              <div class="col-12 mb-4">
                <h4 class="h6 text-center mb-0"><strong>Trabajos</strong></h4>
          <div class="table-responsive">
            <table class="table table-tap table-separate text-center table-numbering mb-0 @error('works') is-invalid @enderror" id="table-works">
              <thead>
                <tr>
                  <th class="text-center py-1">Item</th>
                  <th class="text-center py-1">Área</th>
                  <th class="text-center py-1">Tarea</th>
                  <th class="text-center py-1">Descripción</th>
                  <th class="text-center py-1">Medidas</th>
                  <th class="text-center py-1">Cantidad</th>
                  <th class="text-center py-1">Personal</th>
                  <th class="text-center py-1"></th>
                </tr>
              </thead>
              <tbody>
                @if($works = old('works'))
                @foreach($works as $key => $item)
                <tr>
                  <td class="cell-counter"><span class="number"></span></td>
                  <td>
                    <select class="dropdown2 form-control select-area" name="works[{{$key}}][area]" style="width: 100%">
                      <option value="">Seleccionar area</option>
                      @foreach($areas as $area)
                      <option value="{{$area->id}}" {{ old('works'.$key.'area', $item['area']) == $area->id ? 'selected' : '' }}>{{$area->name}}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <select class="dropdown2 form-control select-service" data-value="{{$item['service_id'] ?? ''}}" name="works[{{$key}}][service_id]" style="width: 100%"  disabled="">
                      <option value="">Seleccionar servicio</option>
                    </select>
                  </td>
                  <td width="120">
                    <input type="text" class="form-control mt-0
                    @error("works.".$key.".description") is-invalid @enderror"
                    placeholder="Descripción" value="{{old('works.$key.description', $item['description'])}}" name="works[{{$key}}][description]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control mt-0 @error("works.".$key.".medidas") is-invalid @enderror" placeholder="Medida" value="{{old('works.$key.medidas', $item['medidas'])}}" name="works[{{$key}}][medidas]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control mt-0 @error("works.".$key.".qty") is-invalid @enderror" placeholder="Cantidad" value="{{old('works.$key.qty', $item['qty'])}}" name="works[{{$key}}][qty]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control mt-0 @error("works.".$key.".personal") is-invalid @enderror" placeholder="Personal" value="{{old('works.$key.personal', $item['personal'])}}" name="works[{{$key}}][personal]">
                  </td>
                  <td>
                      <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td class="cell-counter"><span class="number"></span></td>
                    <td>
                      <select class="dropdown2 form-control select-area" name="works[0][area]" style="width: 100%">
                        <option value="">Seleccionar area</option>
                        @foreach($areas as $area)
                        <option value="{{$area->id}}">{{$area->name}}</option>
                        @endforeach
                      </select>
                    </td>
                    <td>
                      <select class="dropdown2 form-control select-service" name="works[0][service_id]" style="width: 100%"  disabled="">
                        <option value="">Seleccionar servicio</option>
                      </select>
                    </td>
                    <td width="120">
                      <input type="text" class="form-control mt-0 @error("works.0.description") is-invalid @enderror" placeholder="Descripción" value="{{old('works.0.description')}}" name="works[0][description]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.0.medidas") is-invalid @enderror" placeholder="Medida" value="{{old('works.0.medidas')}}" name="works[0][medidas]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.0.qty") is-invalid @enderror" placeholder="Cantidad" value="{{old('works.0.qty')}}" name="works[0][qty]">
                    </td>
                    <td width="100">
                      <input type="text" class="form-control mt-0 @error("works.0.personal") is-invalid @enderror" placeholder="Personal" value="{{old('works.0.personal')}}" name="works[0][personal]">
                    </td>
                    <td>
                      <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
                    </td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          <div class="buttons text-center">
              <button class="btn btn-dark btn-add-row btn-sm my-1" type="button">Agregar fila <i class="far ml-1 fa-plus"></i></button>
              <button class="btn btn-secondary btn-clear btn-sm my-1" type="button">Limpiar <i class="far ml-1 fa-eraser"></i></button>
          </div>
              </div>
              <div class="col-12 mb-4">
                <label class="col-form-label" for="diagnostico_actual">DIAGNOSTICO ACTUAL</label>
                <textarea class="form-control h-100 @error('diagnostico_actual') is-invalid @enderror" placeholder="(Indique causa raiz y recomendaciones)" name="diagnostico_actual" id="diagnostico_actual">{{old('diagnostico_actual', $rdi->diagnostico_actual)}}</textarea>
              </div>
            </div>
            <div class="row">
            <div class="col-12 form-group">
              <label class="col-form-label">Aislamiento a Masa (Ingreso)</label>
              <input type="text" class="form-control @error('aislamiento_masa_ingreso') is-invalid @enderror" placeholder="MΩ" value="{{old('aislamiento_masa_ingreso', $rdi->aislamiento_masa_ingreso)}}" name="aislamiento_masa_ingreso">
            </div>
            <div class="col-12">
              <label class="col-form-label">TIPO DE MANTENIMIENTO (Seleccione según corresponda)</label>
              <div class="form-control mb-4" style="height: auto">
              <ul class="form-check-list list-inline mb-0">
                @foreach($maintenancetype as $mtitem)
                <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input align-middle" {{old('rdi_maintenance_type_id', $rdi->maintenancetype) == $mtitem->id ? 'checked' : ''}} value="{{$mtitem->id}}" name="rdi_maintenance_type_id"><span class="align-middle">{{$mtitem->name}}</span>
                </label>
                </li>
                @endforeach
              </ul>
            </div>
            </div>
            <div class="col-12">
              <label class="col-form-label">CRITICIDAD (Seleccione según corresponda)</label>
              <div class="form-control mb-4" style="height: auto">
              <ul class="form-check-list list-inline mb-0">
                @foreach($criticalitytype as $citem)
                <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input align-middle" {{old('rdi_criticality_type_id', $rdi->criticalitytype) == $citem->id ? 'checked' : ''}} value="{{$citem->id}}" name="rdi_criticality_type_id"><span class="align-middle">{{$citem->name}}</span>
                </label>
                </li>
                @endforeach
              </ul>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 form-group">
              <label class="col-form-label">Estado</label>
              <select name="enabled" class="form-control @error('enabled') is-invalid @enderror dropdown2" id="selectEstado">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Enviar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    function servicesTotal() {
      var total = 0;
      $.each($('.service_input'), function (id, item) {
        total += $(this).val() << 0;
      })
      $('[name=cost]').val(total);
    }

    servicesTotal();

    $('.service_input').on('keyup mouseup', function (event) {
      servicesTotal();
    })

    $(document).on('change', '.select-area', function () {
  var $this = $(this), area = $this.val();
  var service = $(this).parents('tr').find('.select-service');
  if($(this).val().length) {
    $.ajax({
          type: "GET",
          url: "/servicios/filterareas",
          data: {id: area, _token:'{{csrf_token()}}'},
          beforeSend: function() {
            service.attr('disabled', true);
          },
          success: function (response) {
            service.attr('disabled', false).focus();
            service.find('option').remove();
            if (response.success) {
              var services = $.parseJSON(response.data), s_length = services.length;
              if (services.length) {
                $.each(services, function (id, item) {
                  service.append('<option value="'+item.id+'">'+item.name+'</option>');
                })
              }
              if(service.data('value')) {
                service.find('option[value='+service.data('value')+']').prop('selected', true);
              }
            }
          },
          error: function (request, status, error) {
            
          }
      });


  } else {
    service.attr('disabled', true);
  }
})

    $('.btn-add-row').click(function () {
  var row_index = $('#table-works tbody tr').length;
var row = `<tr>
    <td class="cell-counter"><span class="number"></span></td>
    <td>
      <select class="dropdown2 form-control select-area" name="works[`+row_index+`][area]" style="width: 100%">
        <option value="">Seleccionar area</option>
        @foreach($areas as $area)
        <option value="{{$area->id}}">{{$area->name}}</option>
        @endforeach
      </select>
    </td>
    <td>
      <select class="dropdown2 form-control select-service" name="works[`+row_index+`][service_id]" style="width: 100%"  disabled="">
        <option value="">Seleccionar servicio</option>
      </select>
    </td>
    <td width="120">
      <input type="text" class="form-control mt-0" placeholder="Descripción" value="" name="works[`+row_index+`][description]">
    </td>
    <td width="100">
      <input type="text" class="form-control mt-0" placeholder="Medida" value="" name="works[`+row_index+`][medidas]">
    </td>
    <td width="100">
      <input type="text" class="form-control mt-0" placeholder="Cantidad" value="" name="works[`+row_index+`][qty]">
    </td>
    <td width="100">
      <input type="text" class="form-control mt-0" placeholder="Personal" value="" name="works[`+row_index+`][personal]">
    </td>
    <td>
      <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button" title="Remover fila"><i class="far fa-trash"></i></button>
    </td>
  </tr>`;
$('#table-works tbody').append(row);
$('#table-works .dropdown2').select2();
//createJSON();
})

    $('.select-area').trigger('change');
  })
</script>
@endsection