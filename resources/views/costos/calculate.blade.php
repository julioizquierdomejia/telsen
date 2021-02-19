@extends('layouts.app', ['title' => 'Crear Tarjeta de costo'])
@section('content')
    <form class="card card-user form-card" method="POST" action="{{route('card_cost.store', ['id' => $ot->id])}}" enctype="multipart/form-data">
      <div class="card-header">
        <h5 class="card-title d-flex align-items-center">
        <span class="pl-2">Crear Tarjeta de Costo</span>
        <div class="custom-control custom-switch ml-auto @error('enabled') is-invalid @enderror"  style="font-size: 12px;text-transform: none;font-weight: 500;">
          <input type="checkbox" class="custom-control-input" id="enabled" value="1" {{old('enabled') == 1 ? 'checked': ''}} name="enabled">
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
            <div class="col-md-2 form-group">
              <label class="col-form-label">Número de Orden</label>
              <input type="text" class="form-control" disabled="" value="OT-{{zerosatleft($ot->code, 3)}}">
            </div>
            <div class="col-md-5 form-group">
              <label class="col-form-label">Razón social</label>
              <input type="text" class="form-control" disabled="" value="{{$ot->razon_social}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Solped</label>
              <input type="text" class="form-control" readonly="" value="{{$ot->solped}}">
            </div>
            <div class="col-md-3 col-xl-3 form-group">
              <label class="col-form-label">Fecha</label>
              <input type="date" class="form-control" readonly="" value="{{date('Y-m-d')}}">
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-xl-4 form-group">
              <label class="col-form-label">Equipo</label>
              <input type="text" class="form-control telefono_contacto" name="equipo" value="{{$ot->nro_equipo}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Código</label>
              <input type="text" class="form-control" name="codigo" readonly="" value="{{$ot->codigo_motor}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Hecho por</label>
              <input type="text" class="form-control @error('hecho_por') is-invalid @enderror" name="hecho_por" value="{{old('hecho_por')}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Número</label>
              <input type="text" class="form-control" name="numero">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">HP/KW</label>
              <input type="text" class="form-control" value="{{$ot->hp_kw}}" name="kw">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Conexión</label>
              <input type="text" class="form-control" name="conexion" value="{{$ot->conex}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Placa</label>
              <input type="text" class="form-control" name="placa" value="{{$ot->placa_caract_orig}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Voltios</label>
              <input type="text" class="form-control" name="voltios" value="{{$ot->voltaje}}" readonly="">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">N° salidas</label>
              <input type="text" class="form-control" name="nro_salidas" value="">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Modelo</label>
              <input type="text" class="form-control" name="modelo" readonly="" value="{{isset($ot->modelo) ? $ot->modelo->name : '-'}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Amperios</label>
              <input type="text" class="form-control" name="amperios" value="{{$ot->amperaje}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Frecuencia</label>
              <input type="text" class="form-control" name="frecuencia" value="{{$ot->frecuencia}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">N° serie</label>
              <input type="text" class="form-control" name="nro_serie" value="{{$ot->serie}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">RPM</label>
              <input type="text" class="form-control" name="rpm" value="{{$ot->rpm}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Tipo</label>
              <input type="text" class="form-control" name="tipo" value="">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Marca</label>
              <input type="text" class="form-control" name="marca" readonly="" value="{{isset($ot->marca) ? $ot->marca->name : '-'}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Frame</label>
              <input type="text" class="form-control" name="frame" value="{{$ot->frame}}">
            </div>
          </div>
          <div class="row">
            {{-- <div class="col-md-6">
              <div class="form-group">
                <label class="col-form-label">Area</label>
                <select name="area_id" class="form-control @error('area_id') is-invalid @enderror dropdown2" id="selectArea">
                  <option value="">Selecciona el area</option>
                  @foreach($areas as $area)
                  <option value="{{ $area->id }}" {{old('area_id') == $area->id ? 'selected' : ''}}>{{ $area->name }}</option>
                  @endforeach
                </select>
              </div>
            </div> --}}
            {{-- <div class="col-md-12">
              <table class="table table-tap table-separate table-bordered table-numbering mb-0" id="table-tap">
                <thead class="text-center">
                  <tr>
                    <th class="py-1 px-2" width="50">ITEM</th>
                    <th class="py-1"> </th>
                    <th class="py-1">PERSONAL</th>
                    <th class="py-1">INGRESO</th>
                    <th class="py-1">SALIDA</th>
                    <th class="py-1"> </th>
                    <th class="py-1">TOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  @if (old('cost_card_services'))
                  <?php
                  $services = json_decode(old('cost_card_services'), true);
                  $services_count = count($services);
                  $previousGroup = false;
                  $row_total = 0;
                  ?>
                  @foreach($services as $key => $item)
                  @php
                  $lastItem = false;
                  $row_total += $item['subtotal'];
                  @endphp
                  @if($previousGroup !== false && isset($item['service']) && $previousGroup !== $item['service'])
                  @php
                  $lastItem = true;
                  @endphp
                  @endif
                  @if ($key > 1)
                  <tr><td colspan="7" height="20"></td></tr>
                  @endif
                  @if($item['service'] == '')
                  @php $row_total = $item['subtotal']; @endphp
                  <tr class="row-area" data-areaid="{{$item['area_id']}}">
                    <td class="bg-info cell-counter text-center" width="50"><span class="number"></span></td>
                    <td class="bg-info" width="200"><span class="form-control input-expandable frm-sinput border-0 bg-white" name="area">{{$item['area']}}</span></td>
                    <td class="bg-info"><input type="text" class="form-control frm-sinput" data-areaid="{{$item['area_id']}}" name="personal" value="{{$item['personal']}}"></td>
                    <td class="bg-info"><input type="text" class="form-control frm-sinput" data-areaid="{{$item['area_id']}}" name="ingreso" value="{{$item['ingreso']}}"></td>
                    <td class="bg-info" width="100"><input type="text" class="form-control frm-sinput" data-areaid="{{$item['area_id']}}" name="salida" value="{{$item['salida']}}"></td>
                    <td class="bg-info" width="100"><input type="number" min="0" placeholder="S/ " class="form-control frm-sinput text-right" name="subtotal" data-areaid="{{$item['area_id']}}" value="{{$item['subtotal']}}"></td>
                    <td class="bg-info" width="50"></td>
                  </tr>
                  @else
                  <tr data-areaid="{{$item['area_id']}}" data-serviceid="{{$item['service']}}">
                    <td width="50"></td>
                    <td width="200"><span class="form-control input-expandable frm-sinput border-0 bg-white" name="area">{{$item['area']}}</span></td>
                    <td><input type="text" class="form-control frm-sinput" data-areaid="{{$item['area_id']}}" name="personal" value="{{$item['personal']}}"></td>
                    <td><input type="text" class="form-control frm-sinput" data-areaid="{{$item['area_id']}}" name="ingreso" value="{{$item['ingreso']}}"></td>
                    <td width="100"><input type="text" class="form-control frm-sinput" data-areaid="{{$item['area_id']}}" name="salida" value="{{$item['salida']}}"></td>
                    <td width="100"><input type="number" min="0" placeholder="S/ " class="form-control frm-sinput text-right" name="subtotal" data-areaid="{{$item['area_id']}}" value="{{$item['subtotal']}}"></td>
                    <td width="50">
                      @if($lastItem)
                      <input type="number" min="0" placeholder="S/ " class="form-control frm-sinput text-right" name="areasubtotal" data-areaid="{{$item['area_id']}}" value="{{$row_total}}">
                      @endif
                    </td>
                  </tr>
                  @endif
                  @php
                  $previousGroup = $item['area_id'];
                  @endphp
                  @endforeach
                  @else
                  <tr class="empty-services text-center">
                    <td colspan="7">Seleccione un area</td>
                  </tr>
                  @endif
                </tbody>
              </table>
              <input class="form-control d-none" type="text" name="cost_card_services" value="{{old('cost_card_services')}}" readonly="">
              @error('cost_card_services')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
              <div class="text-danger text-center p-1 bg-light my-2">
                <span>DEFLEXION: 0.04 mm</span>
              </div>
            </div>
            <div class="col-md-5 col-xl-4">
              <table class="table table-costs">
                <tbody>
                  <tr>
                    <td class="px-2 py-1">COSTO:</td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost') is-invalid @enderror" placeholder="" value="0" readonly="" name="cost">
                    </td>
                  </tr>
                  <tr>
                    <td class="px-2 py-1"></td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost_m1') is-invalid @enderror" placeholder="" value="0" readonly="" name="cost_m1">
                    </td>
                  </tr>
                  <tr>
                    <td class="px-2 py-1"></td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost_m2') is-invalid @enderror" placeholder="" value="0" readonly="" name="cost_m2">
                    </td>
                  </tr>
                  <tr>
                    <td class="px-2 py-1"></td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost_m3') is-invalid @enderror" placeholder="" value="0" readonly="" name="cost_m3">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-7 col-xl-8">
              <table class="table table-costs table-bordered">
                <thead class="text-center">
                  <tr>
                    <td class="px-2 py-1" colspan="2">INFORME:</td>
                    <td class="px-2 py-1" colspan="2">PPTO - COTIZ.</td>
                    <td class="px-2 py-1" rowspan="2">MONTO</td>
                  </tr>
                  <tr>
                    <td class="px-2 py-1">FECHA:</td>
                    <td class="px-2 py-1">INFORM</td>
                    <td class="px-2 py-1">FECHA</td>
                    <td class="px-2 py-1">COT-PPTO</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="px-2 py-1"><input type="date" class="form-control" value="{{date('Y-m-d')}}" readonly="" name=""></td>
                    <td class="px-2 py-1"><input type="text" class="form-control" value="" readonly="" name=""></td>
                    <td class="px-2 py-1"><input type="date" class="form-control" value="{{date('Y-m-d')}}" readonly="" name=""></td>
                    <td class="px-2 py-1"><input type="text" class="form-control" value="" readonly="" name=""></td>
                    <td class="px-2 py-1"><input type="text" class="form-control" value="" readonly="" name=""></td>
                  </tr>
                </tbody>
              </table>
            </div> --}}
          </div>
          <div class="formato eel">
          <h4>Evaluación Eléctrica</h4>
          <h4 class="h6 text-center mb-0"><strong>Trabajos</strong></h4>
          <div class="table-responsive">
            <table class="table table-separate text-center table-numbering mb-0 @error('works') is-invalid @enderror" id="table-works-el">
              <thead>
                <tr>
                  <th class="text-center py-1">Item</th>
                  <th class="text-center py-1">Área</th>
                  <th class="text-center py-1">Tarea</th>
                  <th class="text-center py-1">Descripción</th>
                  <th class="text-center py-1">Medidas</th>
                  <th class="text-center py-1">Cantidad</th>
                  <th class="text-center py-1">Personal</th>
                </tr>
              </thead>
              <tbody>
                @if($works_el)
                @foreach($works_el as $key => $item)
                <tr>
                  <td class="cell-counter"><span class="number"></span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->area}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->service}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->description ? $item->description : '-'}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->medidas ? $item->medidas : '-'}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->qty ? $item->qty : '-'}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->personal ? $item->personal : '-'}}</span></td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td class="cell-counter"><span class="number"></span></td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          </div>
          <div class="formato mel">
          <h4>Evaluación Mecánica</h4>
          <h4 class="h6 text-center mb-0"><strong>Trabajos</strong></h4>
          <div class="table-responsive">
            <table class="table table-separate text-center table-numbering mb-0 @error('works') is-invalid @enderror" id="table-works-mec">
              <thead>
                <tr>
                  <th class="text-center py-1">Item</th>
                  <th class="text-center py-1">Área</th>
                  <th class="text-center py-1">Tarea</th>
                  <th class="text-center py-1">Descripción</th>
                  <th class="text-center py-1">Medidas</th>
                  <th class="text-center py-1">Cantidad</th>
                  <th class="text-center py-1">Personal</th>
                </tr>
              </thead>
              <tbody>
                @if($works_mec)
                @foreach($works_mec as $key => $item)
                <tr>
                  <td class="cell-counter"><span class="number"></span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->area}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->service}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->description ? $item->description : '-'}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->medidas ? $item->medidas : '-'}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->qty ? $item->qty : '-'}}</span></td>
                  <td><span class="form-control mt-0 h-100">{{$item->personal ? $item->personal : '-'}}</span></td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td class="cell-counter"><span class="number"></span></td>
                  <td><span class="form-control mt-0 h-100">-</span></td>
                  <td><span class="form-control mt-0 h-100">-</span></td>
                  <td><span class="form-control mt-0 h-100">-</span></td>
                  <td><span class="form-control mt-0 h-100">-</span></td>
                  <td><span class="form-control mt-0 h-100">-</span></td>
                  <td><span class="form-control mt-0 h-100">-</span></td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          </div>
          <h4>Otros</h4>
          <h4 class="h6 text-center mb-0"><strong>Trabajos</strong></h4>
          <div class="table-responsive">
            <table class="table table-separate text-center table-numbering mb-0 @error('works') is-invalid @enderror" id="table-works">
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
                    <input type="text" class="form-control
                    @error("works.".$key.".description") is-invalid @enderror"
                    placeholder="Descripción" value="{{old('works.$key.description', $item['description'])}}" name="works[{{$key}}][description]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control @error("works.".$key.".medidas") is-invalid @enderror" placeholder="Medida" value="{{old('works.'.$key.'.medidas', $item['medidas'])}}" name="works[{{$key}}][medidas]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control @error("works".$key.".qty") is-invalid @enderror" placeholder="Cantidad" value="{{old('works.'.$key.'.qty', $item['qty'])}}" name="works[{{$key}}][qty]">
                  </td>
                  <td width="100">
                    <input type="text" class="form-control @error("works".$key.".personal") is-invalid @enderror" placeholder="Personal" value="{{old('works.'.$key.'.personal', $item['personal'])}}" name="works[{{$key}}][personal]">
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
              <tfoot class="buttons">
              <tr>
                <td class="p-0" colspan="7">
                  <button class="btn btn-dark btn-add-row btn-sm my-1" type="button">Agregar fila <i class="far ml-1 fa-plus"></i></button>
                  <button class="btn btn-secondary btn-clear btn-sm my-1" type="button">Limpiar <i class="far ml-1 fa-eraser"></i></button>
                </td>
              </tr>
              </tfoot>
            </table>
          </div>

          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Enviar</button>
            </div>
          </div>
      </div>
</form>
@endsection
@section('javascript')
<script>
  $(document).ready(function () {
    /*$('#selectArea').change(function () {
      var $this = $(this), area = $('#selectArea').val();
      var token = '{{csrf_token()}}';
      var option_selected = $this.find('option:selected');
      if ($this.val()) {
        $.ajax({
          type: "GET",
          url: "/servicios/filterareas",
          data: {id: area, _token:token},
          success: function (response) {
            if (response.success) {
              var services = $.parseJSON(response.data), s_length = services.length;
              $('.empty-services').remove();
              if($('#table-tap tbody tr').length > 0) {
                $('#table-tap tbody').append('<tr><td class="bg-white" colspan="7" height="20"></td></tr>');
              }
              $('#table-tap tbody').append(
                  '<tr class="row-area" data-areaid="'+area+'">'+
                        '<td class="bg-info cell-counter text-center" width="50"><span class="number"></span></td>'+
                        '<td class="bg-info" width="200"><span class="form-control input-expandable frm-sinput border-0 bg-white" name="area" disabled="">'+option_selected.text()+'</span></td>'+
                        '<td class="bg-info"><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="personal" value=""></td>'+
                        '<td class="bg-info"><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="ingreso" value=""></td>'+
                        '<td class="bg-info"><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="salida" value=""></td>'+
                        '<td class="bg-info"><input type="number" min="0" placeholder="S/ " class="form-control frm-sinput text-right" name="subtotal" data-areaid="'+area+'" value=""></td>'+
                        '<td class="bg-info" width="50"> </td>'+
                     '</tr>'
                  )
              $.each(services, function (id, item) {
                //console.log(id)
                $('#table-tap tbody').append(
                  '<tr data-areaid="'+area+'" data-serviceid="'+item.id+'">'+
                        '<td width="50"></td>'+
                        '<td width="200"><span class="form-control input-expandable frm-sinput border-0 bg-white" name="area" disabled="">'+item.name+'</span></td>'+
                        '<td><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="personal" value=""></td>'+
                        '<td><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="ingreso" value=""></td>'+
                        '<td width="100"><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="salida" value=""></td>'+
                        '<td width="100"><input type="number" min="0" placeholder="S/ " class="form-control frm-sinput text-right" name="subtotal" data-areaid="'+area+'" value=""></td>'+
                        '<td width="100">'
                        +((id == s_length - 1) ? '<input type="number" min="0" placeholder="S/ " class="form-control frm-sinput text-right" name="areasubtotal" data-areaid="'+area+'" value="">' : '')+
                        '</td>'+
                     '</tr>'
                  );
              })

              if (services.length) {
                option_selected.attr('disabled', true);
                getServicesSum(false);
              }
            }
          },
          error: function (request, status, error) {
            
          }
      });
      }
    })
    $(document).on('keyup mouseup', '.frm-sinput', function (e) {
      getServicesSum();
    })

    function getServicesSum() {
      var json = '{';
      var otArr = [];
      var totals = 0;
      var services_array = {}, dataareaid;
      var counter = -1;
      var tbl2 = $('#table-tap tbody tr').each(function(i, tr_item) {
        x = $(this).children();
        var itArr = [];
        var notempty = false;
        x.each(function(cell_id, cell_item) {
          var cparent = $(cell_item).parent();
          var area = cparent.find('[name="area"]').text();
          var personal = cparent.find('[name="personal"]');
          var ingreso = cparent.find('[name="ingreso"]');
          var salida = cparent.find('[name="salida"]');
          var subtotal = $(cell_item).find('[name="subtotal"]');
          totals += subtotal.val() << 0;
            if (subtotal.length && subtotal.val().length && parseFloat(subtotal.val()) > 0) {
              notempty = true;
              counter++;
              itArr.push(
                '"area_id": "' + $(tr_item).attr('data-areaid') +
                '", "service": "' + ($(tr_item).attr('data-serviceid') ? $(tr_item).attr('data-serviceid') : '') +
                '", "area": "' + area +
                '", "personal": "' + personal.val() +
                '", "ingreso": "' + ingreso.val() +
                '", "salida": "' + salida.val() +
                '", "subtotal": "' + subtotal.val() + '"'
              );
            }
        });
        if (notempty) {
          otArr.push('"' + counter + '": {'+ itArr.join(',') + '}');
        }
      })

      $('[name="subtotal"]').each(function(i, el){
          dataareaid = $(el).data('areaid');
          if($(el).val().length > 0) {
            if (services_array.hasOwnProperty(dataareaid)) {
              services_array[dataareaid] += parseFloat($(el).val());
            } else {
              services_array[dataareaid] = parseFloat($(el).val());
            }
            $('[name="areasubtotal"][data-areaid="'+dataareaid+'"]').val(services_array[dataareaid]);
          }
      });

      $('[name="cost"]').val(totals);
      $('[name="cost_m1"]').val(totals + (totals / 2));
      $('[name="cost_m2"]').val(totals + (totals * .75));
      $('[name="cost_m3"]').val(totals * 2);
      json += otArr + '}'
      parse_json = JSON.stringify(JSON.parse(json), null, '\t');
      $('input[name=cost_card_services]').val(parse_json);
      return json;
    }

    getServicesSum();*/

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
  
  $(document).on('click', '.card .btn-clear', function() {
    $('#table-works .form-control').val('');
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
  $(document).on('click', '.btn-remove-tap-row', function () {
    var row_index = $('#table-works tbody tr').length;
    if (row_index > 1) {
      $('#table-works tbody tr:nth-child(' + row_index + ')').remove();
    }
    //createJSON();
  })
  $(document).on('click', '.btn-remove-row', function () {
    var row_index = $('#table-works tbody tr').length;
    if (row_index > 1) {
      $('#table-works tbody tr:nth-child(' + row_index + ')').remove();
    }
  })

  $('.select-area').trigger('change');
})
</script>
@endsection