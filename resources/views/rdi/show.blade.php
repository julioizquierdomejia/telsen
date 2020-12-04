@extends('layouts.app', ['title' => 'Ver RDI'])
@section('content')
@php
$statuses = array_column($ot_status->toArray(), "name");
$status_last = $ot_status->last();
$rdi_forapprove = ($status_last->name == "rdi_waiting");
$rdi_approved = ($status_last->name == "rdi_approved");
$rdi_disapproved = $status_last->name == "rdi_disapproved";
$rdi_fecha = $status_last->name == "delivery_generated" && $rdi->fecha_entrega != null;

$role_names = validateActionbyRole();
$admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
$role_rdi = in_array("rdi", $role_names);
$role_ap_rdi = in_array("aprobador_rdi", $role_names);
$role_fentrega = in_array("fecha_de_entrega", $role_names);
@endphp
<div class="row">
	<div class="col-md-12">
		<div class="card card-user form-card">
			<div class="card-header">
				<h5 class="card-title d-flex justify-content-between align-items-center">
					<span>Ver Reporte de Ingreso (R.D.I.)@if($rdi_forapprove)
						<span class="badge badge-danger px-3 py-1">Por aprobar</span>@endif</span>
					<span class="card-title-buttons text-right">
						@if ($rdi_fecha)
						<p class="mb-0 mt-2">Fecha de entrega <span class="badge badge-success px-3 py-1">{{date('d-m-Y', strtotime($rdi->fecha_entrega))}}</span></p>
						@endif
						@if ($admin || $role_fentrega)
						@if($rdi->fecha_entrega == null && $rdi_approved)
						<button type="button" class="btn btn-primary mt-0" data-toggle="modal" data-target="#modalAprobar">Generar fecha de entrega</button>
						@endif
						@endif
						@if($rdi_approved)
						<span class="badge badge-success px-3 py-1">Aprobada</span>
						@elseif($rdi_disapproved)
						<span class="badge badge-secondary px-3 py-1">Desaprobada</span>
						@endif
						@if ($admin || $role_ap_rdi)
						@if(!in_array("rdi_approved", $statuses) && !in_array("rdi_disapproved", $statuses))
						<button type="button" class="btn btn-primary mt-0" data-toggle="modal" data-target="#modalAprobar">Aprobar</button>
						@endif
						@endif
						<button class="btn btn-secondary d-print-none" type="button" onclick="window.print();"><i class="fa fa-print"></i></button>
					</span>
				</h5>
			</div>
			<div class="card-body">
				<input type="text" class="form-control d-none @error('ot_id') is-invalid @enderror" placeholder="" value="{{$rdi->id}}" name='ot_id' id="ot_id" readonly="">
				<div class="row">
					<div class="col-6 col-sm-3 form-group">
						<label class="col-label d-block border-bottom" for="rdi_codigo">RDI Código</label>
						<p class="mb-0">{{$rdi->rdi_codigo}}</p>
					</div>
					<div class="col-6 col-sm-2 col-xl-2 form-group">
						<label class="col-label d-block border-bottom" for="version">Versión</label>
						<p class="mb-0">{{$rdi->version}}</p>
					</div>
					<div class="col-6 col-sm-3 form-group">
						<label class="col-label d-block border-bottom">Fecha</label>
						<p class="mb-0">{{date('d-m-Y', strtotime($rdi->created_at))}}</p>
					</div>
					<div class="col-12 col-sm-4 form-group">
						<label class="col-label d-block border-bottom" for="contact">Contacto</label>
						<p class="mb-0">{{ $rdi->contact ?? '-' }}</p>
					</div>
					<div class="col-12 col-sm-3 form-group">
						<label class="col-label d-block border-bottom" for="area">Area</label>
						<p class="mb-0">{{$rdi->area ?? '-' }}</p>
					</div>
					<div class="col-12 col-sm-3 form-group">
						<label class="col-label d-block border-bottom" for="equipo">Equipo</label>
						<p class="mb-0">{{$rdi->equipo ?? '-' }}</p>
					</div>
					<div class="col-12 col-sm-6 col-md-2 form-group">
						<label class="col-label d-block border-bottom" for="codigo">Código</label>
						<p class="mb-0">{{$rdi->codigo ?? '-' }}</p>
					</div>
					<div class="col-12 col-sm-6 form-group">
						<label class="col-label d-block border-bottom" for="razon_social">Razón social</label>
						<p class="mb-0">{{$rdi->razon_social}}</p>
					</div>
					<div class="col-12 col-sm-3 form-group">
						<label class="col-label d-block border-bottom" for="fecha_ingreso">Fecha de ingreso</label>
						<p class="mb-0">{{ date('d-m-Y', strtotime($rdi->fecha_ingreso)) }}</p>
					</div>
					<div class="col-12 col-sm-3 form-group">
						<label class="col-label d-block border-bottom" for="tiempo_entrega">Tiempo de entrega</label>
						<p class="mb-0">{{$rdi->tiempo_entrega}}</p>
					</div>
					<div class="col-12 col-sm-4 form-group">
						<label class="col-label d-block border-bottom" for="orden_servicio">Orden de servicio</label>
						<p class="mb-0">{{ $rdi->orden_servicio ?? '-' }}</p>
					</div>
					<div class="col-12 col-sm-4 form-group">
						<label class="col-label d-block border-bottom">Hecho por</label>
						<p class="mb-0">{{$rdi->hecho_por ?? '-'}}</p>
					</div>
				</div>
				<h5 class="text-danger mt-4">Características del Motor</h5>
				<div class="row">
					<div class="col-6 col-sm-4 form-group">
						<label class="col-label d-block border-bottom" for="selectMarca">Marca</label>
						<p class="mb-0">{{$rdi->marca}}</p>
					</div>
					<div class="col-6 col-sm-4 col-md-2 form-group">
						<label class="col-label d-block border-bottom">N° Serie</label>
						<p class="mb-0">{{$rdi->nro_serie ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-4 col-md-2 form-group">
						<label class="col-label d-block border-bottom">Frame</label>
						<p class="mb-0">{{$rdi->frame ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-3 col-md-2 form-group">
						<label class="col-label d-block border-bottom">Potencia</label>
						<p class="mb-0">{{$rdi->potencia ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-3 col-md-2 form-group">
						<label class="col-label d-block border-bottom">Tensión</label>
						<p class="mb-0">{{$rdi->tension ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-3 form-group">
						<label class="col-label d-block border-bottom">Corriente</label>
						<p class="mb-0">{{$rdi->corriente ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-3 form-group">
						<label class="col-label d-block border-bottom">Velocidad</label>
						<p class="mb-0">{{$rdi->velocidad ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-3 form-group">
						<label class="col-label d-block border-bottom">Conexión</label>
						<p class="mb-0">{{$rdi->conexion ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-3 form-group">
						<label class="col-label d-block border-bottom">Deflexión del Eje</label>
						<p class="mb-0">{{$rdi->deflexion_eje ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-3 form-group">
						<label class="col-label d-block border-bottom">Rodaje delantero</label>
						<p class="mb-0">{{$rdi->rodaje_delantero ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-3 form-group">
						<label class="col-label d-block border-bottom">Rodaje posterior</label>
						<p class="mb-0">{{$rdi->rodaje_posterior ?? '-'}}</p>
					</div>
					<div class="col-md-12 form-group">
						<label class="col-label d-block border-bottom">ANTECEDENTES</label>
						<p class="mb-0">{{$rdi->antecedentes ?? '-'}}</p>
					</div>
					<div class="col-md-12">
						<label class="col-label d-block border-bottom">Ingresó con:</label>
						<div class="mb-4">
							@if($ingresos)
							<ul class="form-check-list list-inline m-0">
								<li class="form-check-inline">
									<label class="form-check-label my-1">
										<input type="checkbox" disabled class="form-check-input align-middle" value="1" {{$ingresos->placa_caracteristicas ? 'checked' : ''}} name="placa_caracteristicas"><span class="align-middle">Placa caracteristicas</span>
									</label>
								</li>
								<li class="form-check-inline">
									<label class="form-check-label my-1">
										<input type="checkbox" disabled class="form-check-input align-middle" value="1" {{$ingresos->caja_conexion ? 'checked' : ''}} name="caja_conexion"><span class="align-middle">Caja conexión</span>
									</label>
								</li>
								<li class="form-check-inline">
									<label class="form-check-label my-1">
										<input type="checkbox" disabled class="form-check-input align-middle" value="1" {{$ingresos->bornera ? 'checked' : ''}} name="bornera"><span class="align-middle">Bornera</span>
									</label>
								</li>
								<li class="form-check-inline">
									<label class="form-check-label my-1">
										<input type="checkbox" disabled class="form-check-input align-middle" value="1" {{$ingresos->escudos ? 'checked' : ''}} name="escudos"><span class="align-middle">Escudos</span>
									</label>
								</li>
								<li class="form-check-inline">
									<label class="form-check-label my-1">
										<input type="checkbox" disabled class="form-check-input align-middle" value="1" {{$ingresos->ejes ? 'checked' : ''}} name="ejes"><span class="align-middle">Ejes</span>
									</label>
								</li>
								<li class="form-check-inline">
									<label class="form-check-label my-1">
										<input type="checkbox" disabled class="form-check-input align-middle" value="1" {{$ingresos->funda ? 'checked' : ''}} name="funda"><span class="align-middle">Funda</span>
									</label>
								</li>
								<li class="form-check-inline">
									<label class="form-check-label my-1">
										<input type="checkbox" disabled class="form-check-input align-middle" value="1" {{$ingresos->ventilador ? 'checked' : ''}} name="ventilador"><span class="align-middle">Ventilador</span>
									</label>
								</li>
								<li class="form-check-inline">
									<label class="form-check-label my-1">
										<input type="checkbox" disabled class="form-check-input align-middle" value="1" {{$ingresos->acople ? 'checked' : ''}} name="acople"><span class="align-middle">Acople</span>
									</label>
								</li>
								<li class="form-check-inline">
									<label class="form-check-label my-1">
										<input type="checkbox" disabled class="form-check-input align-middle" value="1" {{$ingresos->chaveta ? 'checked' : ''}} name="chaveta"><span class="align-middle">Chaveta</span>
									</label>
								</li>
							</ul>
							@endif
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 mb-4">
						<h4 class="h6 text-center mb-0"><strong>Trabajos</strong></h4>
						{{-- <label class="col-label d-block border-bottom">ACTIVIDADES POR REALIZAR</label>
						<div class="h-100">
							<ul class="form-check-list list-inline m-0">
								@foreach($services as $service)
								@php
								@endphp
								<li class="row my-1 align-items-center">
									<label class="form-label col-9 col-md-10 mb-0" for="service_{{$service->service_id}}"><span class="align-middle">{{$service->name}}</span></label>
									<span class="col-3 col-sm-2 d-inline-block"><span class="form-control service_input text-nowrap px-0 text-center"style="margin-top: 0">{{$service->subtotal}}</span></span>
								</li>
								@endforeach
							</ul>
							<label class="col-form-label">Total</label>
							<span class="form-control text-right disabled">{{$rdi->cost}}</span>
						</div> --}}
						<div class="table-responsive">
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
									<td><div class="form-control h-100 mt-0">{{$work->area}}</div></td>
									<td><div class="form-control h-100 mt-0">{{$work->service}}</div></td>
									<td><div class="form-control h-100 mt-0">{{$work->description}}</div></td>
									<td><div class="form-control h-100 mt-0">{{$work->medidas}}</div></td>
									<td><div class="form-control h-100 mt-0">{{$work->qty}}</div></td>
									<td><div class="form-control h-100 mt-0">{{$work->personal}}</div></td>
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="7">-</td>
								</tr>
								@endif
							</tbody>
						</table>
						</div>
					</div>
					<div class="col-12 mb-4">
						<label class="col-label d-block border-bottom" for="diagnostico_actual">DIAGNOSTICO ACTUAL</label>
						<div class="d-block h-100" id="diagnostico_actual">{{$rdi->diagnostico_actual}}</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label class="col-label d-block border-bottom">Aislamiento a Masa (Ingreso)</label>
						<p class="mb-0">{{$rdi->aislamiento_masa_ingreso}}</p>
					</div>
					<div class="col-12 col-sm-6 form-group">
						<label class="col-label d-block border-bottom">TIPO DE MANTENIMIENTO</label>
						<p class="mb-0"><span class="badge badge-primary px-3 py-1">{{$rdi->maintenancetype}}</span></p>
					</div>
					<div class="col-12 col-sm-6 form-group">
						<label class="col-label d-block border-bottom">CRITICIDAD</label>
						<p class="mb-0"><span class="badge badge-primary px-3 py-1">{{$rdi->criticalitytype}}</span></p>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-3 form-group">
						<label class="col-label d-block border-bottom">Estado</label>
						<p class="mb-0">
							@if ($rdi->enabled)
							<span class="badge badge-success px-4 py-2">Activo</span>
							@else
							<span class="badge badge-secondary px-4 py-2">Inactivo</span>
							@endif
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" tabindex="-1" id="modalAprobar">
  	<div class="modal-dialog">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalLabel">Aprobar RDI</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
	      	</div>
      	<div class="modal-body">
      		@if(!$rdi_approved && !$rdi_disapproved)
      		@if($status_last->name != "rdi_approved")
        	<div class="row confirmar_ots">
      			<p class="text-center col-12">¿Confirma aprobación de {{$rdi->rdi_codigo}}?</p>
            	<div class="update ml-auto mr-auto">
            		<button type="button" class="btn btn-primary btn-sm px-md-5" data-action="1">Aprobar</button>
            	</div>
            	<div class="update ml-auto mr-auto">
              		<button type="button" class="btn btn-secondary btn-sm px-md-5" data-action="2">No Aprobar</button>
            	</div>
            	<p class="c-ots message text-danger"></p>
        	</div>
        	@endif
        	@endif
        	@if(!$rdi_fecha && $rdi_approved)
        	<div class="row fecha_entrega text-center">
	          	<div class="col-12">
	          		<p><label class="col-label d-block" for="fecha_entrega">Fecha de entrega</label></p>
	          		<input class="form-control" min="{{date('Y-m-d')}}" type="date" id="fecha_entrega" name="fecha_entrega">
	          		<p class="c-ots message text-danger"></p>
	          		<button type="button" class="btn btn-primary btn-sm px-md-5" id="btngenerateOTDate">Confirmar</button>
	          	</div>
        	</div>
        	@endif
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
    $('.confirmar_ots .btn').click(function () {
    	var action = $(this).data('action');
    	$.ajax({
	        type: "post",
	        url: "{{route('rdi.approve', $rdi->ot_id)}}",
	        data: {
	        	_token: '{{csrf_token()}}',
	        	action: action
	        },
	        beforeSend: function (data) {
	        	$('.c-ots').empty();
	        },
	        success: function (response) {
	        	if(response.success) {
        			$('#modalAprobar').modal('hide');
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
    @if(($admin || $role_fentrega) && (!$rdi_fecha))
    $('.fecha_entrega #btngenerateOTDate').click(function () {
    	var fentrega = $('#fecha_entrega').val();
    	if(fentrega.length == 0) {
    		$('#fecha_entrega').addClass('is-invalid');
    		$('.c-ots').html('Ingrese fecha de entrega');
    		return;
    	}
    	$.ajax({
	        type: "post",
	        url: "{{route('ordenes.generateotdate', $rdi->ot_id)}}",
	        data: {
	        	_token: '{{csrf_token()}}',
	        	fecha_entrega: fentrega
	        },
	        beforeSend: function (data) {
	        	$('#fecha_entrega').removeClass('is-invalid');
	        	$('.c-ots').empty();
	        },
	        success: function (response) {
	        	if(response.success) {
	        		if(response.data) {
	        			$('#modalAprobar').modal('hide');
	        			$('#fecha_entrega').empty();
		        		$('.c-ots').empty();
		        		setTimeout(function () {
		        			location.reload();
		        		}, 200)
		        	}
	        	} else {
	        		setTimeout(function () {
	        			location.reload();
	        		}, 200)
	        	}
	        },
	        error: function (request, status, error) {
	          var data = jQuery.parseJSON(request.responseText);
	          console.log(data);
	        }
	    });
    })
    @endif
  })
</script>
@endsection