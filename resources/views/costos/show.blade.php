@extends('layouts.app', ['title' => 'Ver Tarjeta Costo'])
@section('content')
@php
$statuses = array_column($ot_status->toArray(), "name");
//$status_last = $ot_status->last();
$cc_approved = in_array("cc_approved", $statuses) && $ccost->fecha_entrega != null;
$cc_disapproved = in_array("cc_disapproved", $statuses);

$role_names = validateActionbyRole();
$admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
$tarjeta_costo = in_array("tarjeta_de_costo", $role_names);
$cotizador_tarjeta = in_array("cotizador_tarjeta_de_costo", $role_names);
$aprobador_cotizacion = in_array("aprobador_cotizacion_tarjeta_de_costo", $role_names);
$rol_fecha = in_array("fecha_de_entrega", $role_names);
@endphp
<div class="row">
	<div class="col-md-12">
		<div class="card card-user form-card">
			<div class="card-header">
				<h5 class="card-title d-flex justify-content-between align-items-center">
				<span>Tarjeta de Costo
			@if($ccost->fecha_entrega)
			<p><span class="badge badge-success">Fecha de entrega: {{date('d-m-Y', strtotime($ccost->fecha_entrega))}}</span></p>
			@endif</span>
				<span class="card-title-buttons">
				@if ($admin || $rol_fecha)
					@if($ccost->fecha_entrega == null && in_array("cc_approved", $statuses))
					<button type="button" class="btn btn-primary mt-0" data-toggle="modal" data-target="#modalFecha">Generar fecha de entrega</button>
					@endif
				@endif
				@if ($admin || $cotizador_tarjeta)
					@if ($ccost->cotizacion)
					<button type="button" class="btn btn-success mt-0" data-toggle="modal" data-target="#modalCotizar"><i class="fa fa-eye"></i> Ver Cotización</button>
					@else
					<button type="button" class="btn btn-primary mt-0" data-toggle="modal" data-target="#modalCotizar">Cotizar</button>
					@endif
				@endif
				</span>
				</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-2 form-group">
						<label class="col-form-label">Número de Orden</label>
						<p class="form-control mb-0">OT-{{zerosatleft($ccost->ot_id, 3)}}</p>
					</div>
					<div class="col-md-5 form-group">
						<label class="col-form-label">Razón social</label>
						<p class="form-control mb-0">{{$ccost->razon_social}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Solped</label>
						<p class="form-control mb-0">{{$ccost->solped ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-3 form-group">
						<label class="col-form-label">Fecha</label>
						<p class="form-control mb-0">{{date('Y-m-d', strtotime($ccost->created_at))}}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 col-xl-4 form-group">
						<label class="col-form-label">Equipo</label>
						<p class="form-control telefono_contacto mb-0">{{$ccost->nro_equipo ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Código</label>
						<p class="form-control mb-0">{{$ccost->codigo_motor ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Hecho por</label>
						<p class="form-control mb-0">{{$ccost->hecho_por ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Número</label>
						<p class="form-control mb-0">{{$ccost->numero ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">HP/KW</label>
						<p class="form-control mb-0">{{$ccost->hp_kw ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Conexión</label>
						<p class="form-control mb-0">{{$ccost->conex ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Placa</label>
						<p class="form-control mb-0">{{$ccost->placa_caract_orig ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Voltios</label>
						<p class="form-control mb-0">{{$ccost->voltaje ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">N° salidas</label>
						<p class="form-control mb-0">{{$ccost->nro_salidas ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Modelo</label>
						<p class="form-control mb-0">{{$ccost->modelo ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Amperios</label>
						<p class="form-control mb-0">{{$ccost->amperaje ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Frecuencia</label>
						<p class="form-control mb-0">{{$ccost->frecuencia ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">N° serie</label>
						<p class="form-control mb-0">{{$ccost->serie ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">RPM</label>
						<p class="form-control mb-0">{{$ccost->rpm ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Tipo</label>
						<p class="form-control mb-0">{{$ccost->tipo ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Marca</label>
						<p class="form-control mb-0">{{$ccost->marca ?? '-'}}</p>
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Frame</label>
						<p class="form-control mb-0">{{$ccost->frame ?? '-'}}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 ml-md-auto form-group">
						<label class="col-form-label">Estado</label>
						<select name="enabled" disabled="" class="form-control dropdown2" id="selectEstado">
							<option value="1" {{$ccost->enabled == 1 ? 'selected' : ''}}>Activo</option>
							<option value="0" {{$ccost->enabled == 0 ? 'selected' : ''}}>Inactivo</option>
						</select>
					</div>
					<div class="col-md-12">

						<div class="formato eel">
          <h4 class="text-primary h5">Evaluación Eléctrica</h4>
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
                  <td><span class="form-control mt-0 h-auto">{{$item->area}}</span></td>
                  <td><span class="form-control mt-0 h-auto">{{$item->service}}</span></td>
                  <td><span class="form-control mt-0 h-auto">{{$item->description}}</span></td>
                  <td><span class="form-control mt-0 h-auto">{{$item->medidas}}</span></td>
                  <td><span class="form-control mt-0 h-auto">{{$item->qty}}</span></td>
                  <td><span class="form-control mt-0 h-auto">{{$item->personal}}</span></td>
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
          <h4 class="text-primary h5">Evaluación Mecánica</h4>
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
                  <td><span class="form-control mt-0 h-auto">{{$item->area}}</span></td>
                  <td><span class="form-control mt-0 h-auto">{{$item->service}}</span></td>
                  <td><span class="form-control mt-0 h-auto">{{$item->description}}</span></td>
                  <td><span class="form-control mt-0 h-auto">{{$item->medidas}}</span></td>
                  <td><span class="form-control mt-0 h-auto">{{$item->qty}}</span></td>
                  <td><span class="form-control mt-0 h-auto">{{$item->personal}}</span></td>
                </tr>
                @endforeach
                @else
                <tr>
                  <td class="cell-counter"><span class="number"></span></td>
                  <td><span class="form-control mt-0 h-auto">-</span></td>
                  <td><span class="form-control mt-0 h-auto">-</span></td>
                  <td><span class="form-control mt-0 h-auto">-</span></td>
                  <td><span class="form-control mt-0 h-auto">-</span></td>
                  <td><span class="form-control mt-0 h-auto">-</span></td>
                  <td><span class="form-control mt-0 h-auto">-</span></td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>
          </div>
						<h4 class="h6 text-center mb-0"><strong>Otros Trabajos</strong></h4>
						{{-- <table class="table table-tap table-separate table-bordered table-numbering mb-0" id="table-tap">
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
								@if ($services)
								<?php
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
								@if($item['service'] == '')
								@if ($key > 1)
								<tr><td colspan="7" height="20"></td></tr>
								@endif
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
									<td width="200"><span class="form-control input-expandable frm-sinput border-0 bg-white" name="area">{{$item['service']}}</span></td>
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
						</table> --}}
						<table class="table table-tap table-separate text-center table-numbering mb-0" id="table-tap">
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
								@if($services)
								@foreach($services as $key => $work)
								<tr>
									<td class="cell-counter"><span class="number"></span></td>
									<td><span class="form-control h-auto">{{$work->area}}</span></td>
									<td><span class="form-control h-auto">{{$work->service}}</span></td>
									<td><span class="form-control h-auto">{{$work->description}}</span></td>
									<td><span class="form-control h-auto">{{$work->medidas}}</span></td>
									<td><span class="form-control h-auto">{{$work->qty}}</span></td>
									<td><span class="form-control h-auto">{{$work->personal}}</span></td>
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="7">-</td>
								</tr>
								@endif
							</tbody>
						</table>
						{{-- <div class="text-danger text-center p-1 bg-light my-2">
							<span>DEFLEXION: 0.04 mm</span>
						</div> --}}
					</div>
					{{-- <div class="col-md-5 col-xl-4">
						<table class="table table-costs">
							<tbody>
								<tr>
									<td class="px-2 py-1">COSTO:</td>
									<td class="px-2 py-1">
										<input type="text" class="form-control text-right" placeholder="" value="{{$ccost->cost}}" readonly="" name="cost">
									</td>
								</tr>
								<tr>
									<td class="px-2 py-1"></td>
									<td class="px-2 py-1">
										<input type="text" class="form-control text-right" placeholder="" value="{{$ccost->cost_m1}}" readonly="" name="cost_m1">
									</td>
								</tr>
								<tr>
									<td class="px-2 py-1"></td>
									<td class="px-2 py-1">
										<input type="text" class="form-control text-right" placeholder="" value="{{$ccost->cost_m2}}" readonly="" name="cost_m2">
									</td>
								</tr>
								<tr>
									<td class="px-2 py-1"></td>
									<td class="px-2 py-1">
										<input type="text" class="form-control text-right" placeholder="" value="{{$ccost->cost_m3}}" readonly="" name="cost_m3">
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
			</div>
		</div>
	</div>
</div>
@if ($admin || $rol_fecha)
<div class="modal fade" tabindex="-1" id="modalFecha">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Fecha de entrega</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="text-center py-3">
				@if (in_array("cc_approved", $statuses) && $ccost->fecha_entrega == null)
				<form class="mt-3 px-3" enctype="multipart/form-data" action="{{route('ordenes.generateotdate', $ccost->ot_id)}}" method="POST" id="generateDateForm">
					@csrf
					<div class="form-group">
						<input class="form-control" type="date" min="{{date('Y-m-d')}}" name="fecha_entrega" required="">
					<button type="submit" class="btn btn-primary btn-sm px-md-5 btn-fecha_entrega">Confirmar</button>
					</div>
				</form>
				@endif
			</div>
		</div>
	</div>
</div>
@endif
<div class="modal fade" tabindex="-1" id="modalCotizar">
	<div class="modal-dialog @if($ccost->cotizacion) modal-lg @endif">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cotización de Tarjeta de Costo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			@if ($ccost->cotizacion == null)
			<form enctype="multipart/form-data" action="{{route('card_cost.upload', $ccost->id)}}" method="POST" id="uploadForm">
				@csrf
				<input class="form-control d-none" type="text" name="ot_id" value="{{$ccost->ot_id}}">
			<div class="modal-body">
				<p class="text-center">Subir cotización</p>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fal fa-file"></i></span>
					</div>
					<div class="custom-file">
						<input type="file" accept="application/pdf" class="custom-file-input" id="inputGroupFile" required="" aria-describedby="inputGroupFile" name="upload_file">
						<label class="custom-file-label" for="inputGroupFile">Elegir</label>
					</div>
				</div>
				<p class="c-ots message text-danger"></p>
			</div>
			<div class="modal-footer justify-content-center">
				<button id="btnUpload" type="submit" class="btn btn-primary btn-sm px-md-5">Enviar</button>
			</div>
			</form>
			@endif
			@if($ccost->cotizacion && !in_array("cc_approved", $statuses) && !in_array("cc_disapproved", $statuses) && ($admin || $aprobador_cotizacion))
			<div class="row approve_tc">
				<div class="update ml-auto mr-auto">
            		<button type="button" class="btn btn-primary btn-sm px-md-5" data-action="1">Aprobar</button>
            	</div>
            	<div class="update ml-auto mr-auto">
              		<button type="button" class="btn btn-secondary btn-sm px-md-5" data-action="2">No Aprobar</button>
            	</div>
			</div>
			@endif
			<div class="text-center py-3">
				@if(in_array("cc_approved", $statuses))
				<span class="badge badge-success px-3 py-2">Cotización Aprobada</span>
				@elseif(in_array("cc_disapproved", $statuses))
				<span class="badge badge-secondary px-3 py-2">Cotización Desaprobada</span>
				@endif
			</div>
			@if($ccost->cotizacion)
			<embed class="w-100" src="/uploads/cotizacion/{{$ccost->cotizacion}}" width="500" height="375" style="height: calc(100vh - 140px)" type="application/pdf">
			@endif
		</div>
	</div>
</div>
@endsection
@section('javascript')
<script>
  $(document).ready(function () {
    @if(!$cc_approved)
    $('.approve_tc .btn').click(function () {
    	var action = $(this).data('action');
    	$.ajax({
	        type: "post",
	        url: "{{route('card_cost.approve', $ccost->ot_id)}}",
	        data: {
	        	_token: '{{csrf_token()}}',
	        	action: action
	        },
	        beforeSend: function (data) {
	        	$('.c-ots').empty();
	        },
	        success: function (response) {
	        	if(response.success) {
	        		setTimeout(function () {
	        			location.reload();
	        		}, 200)
	        	} else if(response.data) {
	        		$('.confirmar_ots .btn').attr('disabled', true);
	        		$('.c-ots').html(response.data);
	        	} else {
	        		$('.c-ots').empty();
	        	}
	        },
	        error: function (request, status, error) {
	          var data = jQuery.parseJSON(request.responseText);
	          console.log(data);
	        }
	    });
    })
    @endif

    $('#inputGroupFile').change(function (event) {
    	var val = $(this).val();
    	if(val) {
    		$('.custom-file-label').text(val.split('\\').pop());
    	} else {
    		$('.custom-file-label').text('Elegir');
    	}
    })

    $('#uploadForm').submit(function (event) {
    	event.preventDefault();
    	var form = $(this);
    	var url = form.attr('action');
    	$.ajax({
	        type: "post",
	        url: url,
	        data: new FormData(this),
	        processData: false,
        	contentType: false,
	        beforeSend: function (data) {
	        	$('.c-ots').empty();
	        },
	        success: function (response) {
	        	if(response.success) {
	        		setTimeout(function () {
	        			location.reload();
	        		}, 200)
	        	} else if(response.data) {
	        		$('.confirmar_ots .btn').attr('disabled', true);
	        		$('.c-ots').html(response.data);
	        	} else {
	        		$('.c-ots').empty();
	        	}
	        },
	        error: function (request, status, error) {
	          var data = jQuery.parseJSON(request.responseText);
	          console.log(data);
	        }
	    });
    })

    $('#generateDateForm').submit(function (event) {
    	event.preventDefault();
    	var form = $(this);
    	var url = form.attr('action');
    	$.ajax({
	        type: "post",
	        url: url,
	        data: new FormData(this),
	        processData: false,
        	contentType: false,
	        beforeSend: function (data) {
	        	$('.c-ots').empty();
	        },
	        success: function (response) {
	        	if(response.success) {
	        		setTimeout(function () {
	        			location.reload();
	        		}, 200)
	        	} else if(response.data) {
	        		$('.btn-fecha_entrega').attr('disabled', true);
	        		$('.c-ots').html(response.data);
	        	} else {
	        		$('.c-ots').empty();
	        	}
	        },
	        error: function (request, status, error) {
	          var data = jQuery.parseJSON(request.responseText);
	          console.log(data);
	        }
	    });
    })
  })
</script>
@endsection