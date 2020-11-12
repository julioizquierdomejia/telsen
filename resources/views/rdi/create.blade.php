@extends('layouts.app', ['title' => 'Crear Reporte de Ingreso'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Crear Reporte de Ingreso (R.D.I.)</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="/rdi" enctype="multipart/form-data">
          @csrf
          <input type="text" class="form-control d-none @error('ot_id') is-invalid @enderror" placeholder="" value="{{$ot->id}}" name='ot_id' id="ot_id" readonly="">
          <div class="row">
            <div class="col-6 col-md-3 col-xl-3 form-group">
              <label class="col-form-label" for="rdi_codigo">RDI Código</label>
              <input type="text" class="form-control @error('rdi_codigo') is-invalid @enderror" placeholder="" value="{{old('rdi_codigo', 'RDI-TL-'.$counter)}}" name='rdi_codigo' id="rdi_codigo" readonly="">
              @error('rdi_codigo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-3 col-xl-2 form-group">
              <label class="col-form-label" for="version">Versión</label>
              <input type="text" class="form-control @error('version') is-invalid @enderror" placeholder="" value="{{old('version', 3)}}" readonly="" name='version' id="version">
              @error('version')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-3 col-xl-3 form-group">
              <label class="col-form-label">Fecha</label>
              <input type="text" class="form-control" disabled="" value="{{date('d-m-Y')}}">
            </div>
            <div class="col-md-4 form-group">
              <label class="col-form-label" for="contact">Contacto</label>
              <input type="text" class="form-control @error('contact') is-invalid @enderror" placeholder="" value="{{old('contact')}}" name='contact' id="contact">
              @error('contact')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label" for="area">Area</label>
              <input type="text" class="form-control @error('area') is-invalid @enderror" placeholder="" value="{{old('area')}}" name='area' id="area">
              @error('area')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label" for="equipo">Equipo</label>
              <input type="text" class="form-control @error('equipo') is-invalid @enderror" placeholder="" value="{{old('equipo')}}" name='equipo' id="equipo">
              @error('equipo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-2 form-group">
              <label class="col-form-label" for="codigo">Código</label>
              <input type="text" class="form-control @error('codigo') is-invalid @enderror" placeholder="" value="{{old('codigo')}}" name='codigo' id="codigo">
              @error('codigo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-4 form-group">
              <label class="col-form-label" for="razon_social">Razón social</label>
              <input type="text" readonly="" class="form-control @error('razon_social') is-invalid @enderror" placeholder="" value="{{old('razon_social', $ot->razon_social)}}" id="razon_social">
              @error('razon_social')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label" for="fecha_ingreso">Fecha de ingreso</label>
              <input type="date" max="{{date('Y-m-d')}}" class="form-control @error('fecha_ingreso') is-invalid @enderror" placeholder="" value="{{old('fecha_ingreso', date('Y-m-d'))}}" name='fecha_ingreso' id="fecha_ingreso">
              @error('fecha_ingreso')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label" for="tiempo_entrega">Tiempo de entrega</label>
              <input type="number" class="form-control @error('tiempo_entrega') is-invalid @enderror" min="1" placeholder="Días de entrega" value="{{old('tiempo_entrega', 1)}}" title="Días de entrega" data-toggle="tooltip" name='tiempo_entrega' id="tiempo_entrega">
              @error('tiempo_entrega')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label" for="orden_servicio">Orden de servicio</label>
              <input type="text" class="form-control @error('orden_servicio') is-invalid @enderror" placeholder="" value="{{old('orden_servicio')}}" name='orden_servicio' id="orden_servicio">
              @error('orden_servicio')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 col-xl-3 form-group">
              <label class="col-form-label">Hecho por</label>
              <input type="text" class="form-control @error('hecho_por') is-invalid @enderror" name="hecho_por" value="{{old('hecho_por')}}">
            </div>
          </div>
          <h5 class="text-danger mt-4">Características del Motor</h5>
          <div class="row">
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label" for="selectMarca">Marca</label>
              <select style="width: 100%" name="marca_id" class="form-control @error('marca_id') is-invalid @enderror dropdown2" id="selectMarca">
                <option value="">Selecciona la marca</option>
                @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{old('marca_id') == $marca->id ? 'selected' : ''}}>{{ $marca->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-2 form-group">
              <label class="col-form-label">N° Serie</label>
              <input type="text" class="form-control @error('nro_serie') is-invalid @enderror" placeholder="Ingrese N° Serie" value="{{old('nro_serie')}}" name="nro_serie">
            </div>
            <div class="col-6 col-md-2 form-group">
              <label class="col-form-label">Frame</label>
              <input type="text" class="form-control @error('frame') is-invalid @enderror" name="frame" placeholder="Ingrese Frame" value="{{old('frame')}}">
            </div>
            <div class="col-6 col-md-2 form-group">
              <label class="col-form-label">Potencia</label>
              <input type="text" class="form-control @error('potencia') is-invalid @enderror" placeholder="Ingrese Potencia" value="{{old('potencia')}}" name="potencia">
            </div>
            <div class="col-6 col-md-2 form-group">
              <label class="col-form-label">Tensión</label>
              <input type="text" class="form-control @error('tension') is-invalid @enderror" placeholder="Ingrese Tensión" value="{{old('tension')}}" name="tension">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Corriente</label>
              <input type="text" class="form-control @error('corriente') is-invalid @enderror" placeholder="Ingrese Corriente" value="{{old('corriente')}}" name="corriente">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Velocidad</label>
              <input type="text" class="form-control @error('velocidad') is-invalid @enderror" placeholder="Ingrese Velocidad" value="{{old('velocidad')}}" name="velocidad">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Conexión</label>
              <input type="text" class="form-control @error('conexion') is-invalid @enderror" placeholder="Ingrese Conexión" value="{{old('conexion')}}" name="conexion">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Deflexión del Eje</label>
              <input type="text" class="form-control @error('deflexion_eje') is-invalid @enderror" placeholder="Ingrese Deflexión del Eje" value="{{old('deflexion_eje')}}" name="deflexion_eje">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Rodaje delantero</label>
              <input type="text" class="form-control @error('rodaje_delantero') is-invalid @enderror" placeholder="Ingrese Rodaje delantero" value="{{old('rodaje_delantero')}}" name="rodaje_delantero">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Rodaje posterior</label>
              <input type="text" class="form-control @error('rodaje_posterior') is-invalid @enderror" placeholder="Ingrese Rodaje posterior" value="{{old('rodaje_posterior')}}" name="rodaje_posterior">
            </div>
            <div class="col-md-12 form-group">
              <label class="col-form-label">ANTECEDENTES</label>
              <textarea class="form-control @error('antecedentes') is-invalid @enderror" placeholder="(Indique motivo de salida del componente de las instalaciones del cliente)" value="{{old('antecedentes')}}" name="antecedentes"></textarea>
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
                      <input type="checkbox" class="form-check-input align-middle" value="1" {{old('placa_caracteristicas') ? 'checked' : ''}} name="placa_caracteristicas"><span class="align-middle">Placa caracteristicas</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input align-middle" value="1" {{old('caja_conexion') ? 'checked' : ''}} name="caja_conexion"><span class="align-middle">Caja conexión</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input align-middle" value="1" {{old('bornera') ? 'checked' : ''}} name="bornera"><span class="align-middle">Bornera</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input align-middle" value="1" {{old('escudos') ? 'checked' : ''}} name="escudos"><span class="align-middle">Escudos</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input align-middle" value="1" {{old('ejes') ? 'checked' : ''}} name="ejes"><span class="align-middle">Ejes</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input align-middle" value="1" {{old('funda') ? 'checked' : ''}} name="funda"><span class="align-middle">Funda</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input align-middle" value="1" {{old('ventilador') ? 'checked' : ''}} name="ventilador"><span class="align-middle">Ventilador</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input align-middle" value="1" {{old('acople') ? 'checked' : ''}} name="acople"><span class="align-middle">Acople</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input align-middle" value="1" {{old('chaveta') ? 'checked' : ''}} name="chaveta"><span class="align-middle">Chaveta</span>
                    </label>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6 mb-4">
              <label class="col-form-label">ACTIVIDADES POR REALIZAR</label>
              <div class="form-control h-100">
                <ul class="form-check-list list-inline m-0">
                  @foreach($services as $service)
                  <li class="row my-1 align-items-center">
                    <label class="form-label col-10 mb-0" for="service_{{$service->id}}"><span class="align-middle">{{$service->name}}</span></label>
                    <span class="col-2 d-inline-block"><input type="text" class="form-control service_input" value="{{old('services')[$service->id]}}" style="margin-top: 0" id="service_{{$service->id}}" name="services[{{$service->id}}]"></span>
                  </li>
                  @endforeach
                </ul>
                <label class="col-form-label">Total</label>
                <input class="form-control text-right @error('cost') is-invalid @enderror" type="text" readonly="" name="cost" value="0">
              </div>
            </div>
            <div class="col-12 col-md-6 mb-4">
              <label class="col-form-label" for="diagnostico_actual">DIAGNOSTICO ACTUAL</label>
              <textarea class="form-control h-100 @error('diagnostico_actual') is-invalid @enderror" placeholder="(Indique causa raiz y recomendaciones)" value="{{old('diagnostico_actual')}}" name="diagnostico_actual" id="diagnostico_actual"></textarea>
            </div>
          </div>
          <div class="row">
            <div class="col-12 form-group">
              <label class="col-form-label">Aislamiento a Masa (Ingreso)</label>
              <input type="text" class="form-control @error('aislamiento_masa_ingreso') is-invalid @enderror" placeholder="MΩ" value="{{old('aislamiento_masa_ingreso')}}" name="aislamiento_masa_ingreso">
            </div>
            <div class="col-12">
              <label class="col-form-label">TIPO DE MANTENIMIENTO (Seleccione según corresponda)</label>
              <div class="form-control mb-4 @error('rdi_maintenance_type_id') is-invalid @enderror" style="height: auto">
                <ul class="form-check-list list-inline mb-0">
                  @foreach($maintenancetype as $mtitem)
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" {{old('rdi_maintenance_type_id') == $mtitem->id ? 'checked' : ''}} value="{{$mtitem->id}}" name="rdi_maintenance_type_id"><span class="align-middle">{{$mtitem->name}}</span>
                    </label>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
            <div class="col-12">
              <label class="col-form-label">CRITICIDAD (Seleccione según corresponda)</label>
              <div class="form-control mb-4 @error('rdi_criticality_type_id') is-invalid @enderror" style="height: auto">
                <ul class="form-check-list list-inline mb-0">
                  @foreach($criticalitytype as $citem)
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" {{old('rdi_criticality_type_id') == $citem->id ? 'checked' : ''}} value="{{$citem->id}}" name="rdi_criticality_type_id"><span class="align-middle">{{$citem->name}}</span>
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
  })
</script>
@endsection