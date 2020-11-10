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
          <div class="row">
            <div class="col-6 col-md-3 col-xl-2 form-group">
                <label class="col-form-label">RDI Código</label>
                <input type="text" class="form-control @error('rdi_codigo') is-invalid @enderror" placeholder="" value="{{old('rdi_codigo')}}" name='rdi_codigo' id="rdi_codigo">
              @error('rdi_codigo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-3 col-xl-2 form-group">
                <label class="col-form-label">Versión</label>
                <input type="text" class="form-control @error('version') is-invalid @enderror" placeholder="" value="{{old('version')}}" name='version' id="version">
              @error('version')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-3 col-xl-3 form-group">
                <label class="col-form-label">Fecha</label>
                <input type="text" class="form-control" disabled="" value="{{date('d-m-Y')}}">
            </div>
            <div class="col-6 col-md-5 form-group">
              <label class="col-form-label" for="selectRuc">Seleccione Cliente</label>
              <select style="width: 100%" class="form-control dropdown2 @error('client_id') is-invalid @enderror" name="client_id" id="selectRuc">
                <option value="">Ingresa Cliente</option>
                @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}" {{old('client_id') == $cliente->id ? 'selected' : ''}}>{{ $cliente->razon_social }}</option>
                @endforeach
              </select>
              @error('client_id')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-4 form-group">
                <label class="col-form-label">Contacto</label>
                <input type="text" class="form-control @error('contact') is-invalid @enderror" placeholder="" value="{{old('contact')}}" name='contact' id="contact">
              @error('contact')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-4 form-group">
                <label class="col-form-label">Area</label>
                <input type="text" class="form-control @error('area') is-invalid @enderror" placeholder="" value="{{old('area')}}" name='area' id="area">
              @error('area')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-4 form-group">
                <label class="col-form-label">Equipo</label>
                <input type="text" class="form-control @error('equipo') is-invalid @enderror" placeholder="" value="{{old('equipo')}}" name='equipo' id="equipo">
              @error('equipo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label">Código</label>
                <input type="text" class="form-control @error('codigo') is-invalid @enderror" placeholder="" value="{{old('codigo')}}" name='codigo' id="codigo">
              @error('codigo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label">Ot</label>
                <input type="text" class="form-control @error('ot') is-invalid @enderror" placeholder="" value="{{old('ot')}}" name='ot' id="ot">
              @error('ot')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label">Fecha de ingreso</label>
                <input type="date" max="{{date('Y-m-d')}}" class="form-control @error('fecha_ingreso') is-invalid @enderror" placeholder="" value="{{old('fecha_ingreso')}}" name='fecha_ingreso' id="fecha_ingreso">
              @error('fecha_ingreso')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label">Tiempo de entrega</label>
                <input type="number" class="form-control @error('tiempo_entrega') is-invalid @enderror" min="1" placeholder="Días de entrega" value="{{old('tiempo_entrega')}}" name='tiempo_entrega' id="tiempo_entrega">
              @error('tiempo_entrega')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-3 form-group">
                <label class="col-form-label">Orden de servicio</label>
                <input type="text" class="form-control @error('orden_servicio') is-invalid @enderror" placeholder="" value="{{old('orden_servicio')}}" name='orden_servicio' id="orden_servicio">
              @error('orden_servicio')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
          </div>
          <h5 class="text-danger mt-4">Datos del Motor</h5>
          <div class="row">
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Marca</label>
              <select style="width: 100%" name="marca_id" class="form-control @error('marca_id') is-invalid @enderror dropdown2" id="selectMarca">
                <option value="">Selecciona la marca</option>
                @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{old('marca_id') == $marca->id ? 'selected' : ''}}>{{ $marca->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3 form-group">
              <label class="col-form-label">N° Serie</label>
              <input type="text" class="form-control @error('nro_serie') is-invalid @enderror" placeholder="Ingrese descripción" value="{{old('nro_serie')}}" name="nro_serie">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Frame</label>
              <input type="text" class="form-control @error('frame') is-invalid @enderror" name="frame" placeholder="Ingrese código del motor" value="{{old('frame')}}">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Potencia</label>
              <input type="text" class="form-control @error('potencia') is-invalid @enderror" placeholder="Potencia" value="{{old('potencia')}}" name="potencia">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Tensión</label>
              <input type="text" class="form-control @error('tension') is-invalid @enderror" placeholder="Tensión" value="{{old('tension')}}" name="tension">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Corriente</label>
              <input type="text" class="form-control @error('corriente') is-invalid @enderror" placeholder="Corriente" value="{{old('corriente')}}" name="corriente">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Velocidad</label>
              <input type="text" class="form-control @error('velocidad') is-invalid @enderror" placeholder="Velocidad" value="{{old('velocidad')}}" name="velocidad">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Conexión</label>
              <input type="text" class="form-control @error('conexion') is-invalid @enderror" placeholder="Conexión" value="{{old('conexion')}}" name="conexion">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Deflexión del Eje</label>
              <input type="text" class="form-control @error('deflexion_eje') is-invalid @enderror" placeholder="Deflexión del Eje" value="{{old('deflexion_eje')}}" name="deflexion_eje">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Rodaje delantero</label>
              <input type="text" class="form-control @error('rodaje_delantero') is-invalid @enderror" placeholder="Rodaje delantero" value="{{old('rodaje_delantero')}}" name="rodaje_delantero">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Rodaje posterior</label>
              <input type="text" class="form-control @error('rodaje_posterior') is-invalid @enderror" placeholder="Rodaje posterior" value="{{old('rodaje_posterior')}}" name="rodaje_posterior">
            </div>
            <div class="col-md-12 form-group">
                <label class="col-form-label">ANTECEDENTES (Indique motivo de salida del componente de las instalaciones del cliente)</label>
                <textarea class="form-control @error('antecedentes') is-invalid @enderror" placeholder="" value="{{old('antecedentes')}}" name="antecedentes"></textarea>
              @error('antecedentes')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-12">
              <label class="col-form-label">Ingresó con:</label>
              <ul class="form-check-list list-inline pt-3">
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" value="1" name="placa_caracteristicas"><span class="align-middle">Placa caracteristicas</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" value="1" name="caja_conexion"><span class="align-middle">Caja conexión</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" value="1" name="bornera"><span class="align-middle">Bornera</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" value="1" name="escudos"><span class="align-middle">Escudos</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" value="1" name="ejes"><span class="align-middle">Ejes</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" value="1" name="funda"><span class="align-middle">Funda</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" value="1" name="ventilador"><span class="align-middle">Ventilador</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" value="1" name="acople"><span class="align-middle">Acople</span>
                </label>
              </li>
              <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="checkbox" class="form-check-input align-middle" value="1" name="chaveta"><span class="align-middle">Chaveta</span>
                </label>
              </li>
              </ul>
            </div>


            <div class="col-12 form-group">
              <label class="col-form-label">Aislamiento a Masa (Ingreso)</label>
              <input type="text" class="form-control @error('aislamiento_masa_ingreso') is-invalid @enderror" placeholder="MΩ" value="{{old('aislamiento_masa_ingreso')}}" name="aislamiento_masa_ingreso">
            </div>
            <div class="col-12">
              <label class="col-form-label">TIPO DE MANTENIMIENTO QUE REQUIERE (Seleccione según corresponda)</label>
              <ul class="form-check-list list-inline pt-3">
                @foreach($maintenancetype as $mtitem)
                <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input align-middle" value="{{$mtitem->id}}" name="rdi_maintenance_type_id"><span class="align-middle">{{$mtitem->name}}</span>
                </label>
                </li>
                @endforeach
              </ul>
            </div>
            <div class="col-12">
              <label class="col-form-label">CRITICIDAD (Seleccione según corresponda)</label>
              <ul class="form-check-list list-inline pt-3">
                @foreach($criticalitytype as $citem)
                <li class="form-check-inline">
                <label class="form-check-label">
                  <input type="radio" class="form-check-input align-middle" value="{{$citem->id}}" name="rdi_criticality_type_id"><span class="align-middle">{{$citem->name}}</span>
                </label>
                </li>
                @endforeach
              </ul>
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