@extends('layouts.app', ['title' => 'Ver Tarjeta Costo'])
@section('content')
@php $data = $ccost->toArray() @endphp
<div class="row">
	<div class="col-md-12">
		<div class="card card-user form-card">
			<div class="card-header">
				<h5 class="card-title d-flex justify-content-between align-items-center">
				<span>Tarjeta de Costo</span>
				<span class="card-title-buttons">
					@if ($ccost->cotizacion)
					<button type="button" class="btn btn-primary mt-0" data-toggle="modal" data-target="#modalCotizar"><i class="fa fa-eye"></i> Ver Cotización</button>
					@else
					<button type="button" class="btn btn-primary mt-0" data-toggle="modal" data-target="#modalCotizar">Cotizar</button>
					@endif
				</span>
				</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-2 form-group">
						<label class="col-form-label">Número de Orden</label>
						<input type="text" class="form-control" disabled="" value="OT-{{zerosatleft($ccost->ot_id, 3)}}">
					</div>
					<div class="col-md-5 form-group">
						<label class="col-form-label">Razón social</label>
						<input type="text" class="form-control" disabled="" value="{{$ccost->razon_social}}">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Solped</label>
						<input type="text" class="form-control" readonly="" value="{{$ccost->solped}}">
					</div>
					<div class="col-md-3 col-xl-3 form-group">
						<label class="col-form-label">Fecha</label>
						<input type="date" class="form-control" readonly="" value="{{date('Y-m-d', strtotime($ccost->created_at))}}">
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 col-xl-4 form-group">
						<label class="col-form-label">Equipo</label>
						<input type="text" class="form-control telefono_contacto" name="equipo" value="{{$ccost->nro_equipo}}">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Código</label>
						<input type="text" class="form-control" name="codigo" readonly="" value="{{$ccost->codigo_motor}}">
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
						<input type="text" class="form-control" value="{{$ccost->hp_kw}}" name="kw">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Conexión</label>
						<input type="text" class="form-control" name="conexion" value="{{$ccost->conex}}">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Placa</label>
						<input type="text" class="form-control" name="placa" value="{{$ccost->placa_caract_orig}}">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Voltios</label>
						<input type="text" class="form-control" name="voltios" value="{{$ccost->voltaje}}" readonly="">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">N° salidas</label>
						<input type="text" class="form-control" name="nro_salidas" value="">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Modelo</label>
						<input type="text" class="form-control" name="modelo" readonly="" value="{{$ccost->modelo}}">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Amperios</label>
						<input type="text" class="form-control" name="amperios" value="{{$ccost->amperaje}}">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Frecuencia</label>
						<input type="text" class="form-control" name="frecuencia" value="{{$ccost->frecuencia}}">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">N° serie</label>
						<input type="text" class="form-control" name="nro_serie" value="{{$ccost->serie}}">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">RPM</label>
						<input type="text" class="form-control" name="rpm" value="{{$ccost->rpm}}">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Tipo</label>
						<input type="text" class="form-control" name="tipo" value="">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Marca</label>
						<input type="text" class="form-control" name="marca" readonly="" value="{{$ccost->marca}}">
					</div>
					<div class="col-md-3 col-xl-2 form-group">
						<label class="col-form-label">Frame</label>
						<input type="text" class="form-control" name="frame" value="{{$ccost->frame}}">
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 ml-md-auto form-group">
						<label class="col-form-label">Estado</label>
						<select name="enabled" class="form-control @error('enabled') is-invalid @enderror dropdown2" id="selectEstado">
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
					<div class="col-md-12">
						<table class="table table-separate table-bordered table-numbering mb-0" id="table-tap">
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
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
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
			<div class="modal-body">
				<p class="text-center">Subir cotización</p>
				<div class="input-group">
					<div class="input-group-prepend">
						<span class="input-group-text"><i class="fal fa-file"></i></span>
					</div>
					<div class="custom-file">
						<input type="file" accept="application/pdf" class="custom-file-input" id="inputGroupFile"
						aria-describedby="inputGroupFile" name="upload_file">
						<label class="custom-file-label" for="inputGroupFile">Elegir</label>
					</div>
				</div>
				<p class="c-ots message text-danger"></p>
			</div>
			<div class="modal-footer justify-content-center">
				<button id="btnUpload" type="submit" class="btn btn-primary btn-sm px-md-5">Enviar</button>
			</div>
			</form>
			@else
			<embed class="w-100" src="/uploads/cotizacion/{{$ccost->cotizacion}}" width="500" height="375" style="height: calc(100vh - 120px)" type="application/pdf">
			@endif
		</div>
	</div>
</div>
@endsection
@section('javascript')
<script>
	$('#inputGroupFile').change(function (event) {
		if($(this).val()) {
			$('.custom-file-label').text($(this).val().split('\\').pop());
		} else {
			$('.custom-file-label').text('Elegir');
		}
	})
	$('#uploadForm').submit(function (event) {
		event.preventDefault();
		var formData = new FormData(this);
    	var upload_file = $('#inputGroupFile').val();
    	if(upload_file.length == 0) {
    		$('#upload_file').addClass('is-invalid');
    		$('.c-ots').html('Ingrese archivo');
    		return;
    	}

    	//ajax
    	$.ajax({
	        type: "post",
	        url: "{{route('card_cost.upload', $ccost->id)}}",
	        data: formData,
	        dataType: "JSON",
	        processData: false,
        	contentType: false,
	        beforeSend: function (data) {
	        	$('#inputGroupFile').removeClass('is-invalid');
	        	$('.c-ots').empty();
	        },
	        success: function (response) {
	        	if(response.success) {
	        		if(response.data) {
	        			$('#modalCotizar').modal('hide');
	        			$('#inputGroupFile').val();
		        		$('.c-ots').empty();
		        		setTimeout(function () {
		        			location.reload();
		        		}, 200)
		        	}
	        	}
	        },
	        error: function (request, status, error) {
	        	var data = jQuery.parseJSON(request.responseText);
	          	if(data.errors) {
	          		$('.c-ots').html(data.errors.upload_file[0].replace('upload file', ' '));
	        	}
	        }
	    });
    })
</script>
@endsection