@extends('layouts.app', ['title' => 'Ver RDI'])
@section('content')
@php
$ot_status = \DB::table('status_ot')
      ->join('status', 'status_ot.status_id', '=', 'status.id')
      ->where('status_ot.ot_id', '=', $rdi->ot_id)
      ->select('status.id', 'status.name')
      ->get();
$status_last = $ot_status->last();
$rdi_approved = $status_last->id == 9 && $rdi->fecha_entrega != null;
@endphp
<div class="row">
	<div class="col-md-12">
		<div class="card card-user form-card">
			<div class="card-header">
				<h5 class="card-title d-flex justify-content-between align-items-center">
					<span>Ver Reporte de Ingreso (R.D.I.)</span>
					<span class="card-title-buttons">
						@if($rdi_approved)
						<span class="badge badge-success px-3 py-1">Aprobada</span>
						@else
						<button type="button" class="btn btn-primary mt-0" data-toggle="modal" data-target="#modalAprobar">Aprobar</button>
						@endif
					</span>
				</h5>
			</div>
			<div class="card-body">
				<input type="text" class="form-control d-none @error('ot_id') is-invalid @enderror" placeholder="" value="{{$rdi->id}}" name='ot_id' id="ot_id" readonly="">
				<div class="row">
					<div class="col-6 col-md-3 col-xl-3 form-group">
						<label class="col-form-label" for="rdi_codigo">RDI Código</label>
						<p class="form-control mb-0">{{$rdi->rdi_codigo}}</p>
					</div>
					<div class="col-6 col-md-3 col-xl-2 form-group">
						<label class="col-form-label" for="version">Versión</label>
						<p class="form-control mb-0">{{$rdi->version}}</p>
					</div>
					<div class="col-6 col-md-3 col-xl-3 form-group">
						<label class="col-form-label">Fecha</label>
						<p class="form-control mb-0">{{date('d-m-Y', strtotime($rdi->created_at))}}</p>
					</div>
					<div class="col-md-4 form-group">
						<label class="col-form-label" for="contact">Contacto</label>
						<p class="form-control mb-0">{{ $rdi->contact ?? '-' }}</p>
					</div>
					<div class="col-md-3 form-group">
						<label class="col-form-label" for="area">Area</label>
						<p class="form-control mb-0">{{$rdi->area ?? '-' }}</p>
					</div>
					<div class="col-md-3 form-group">
						<label class="col-form-label" for="equipo">Equipo</label>
						<p class="form-control mb-0">{{$rdi->equipo ?? '-' }}</p>
					</div>
					<div class="col-md-2 form-group">
						<label class="col-form-label" for="codigo">Código</label>
						<p class="form-control mb-0">{{$rdi->codigo ?? '-' }}</p>
					</div>
					<div class="col-md-4 form-group">
						<label class="col-form-label" for="razon_social">Razón social</label>
						<p class="form-control mb-0">{{$rdi->razon_social}}</p>
					</div>
					<div class="col-md-3 form-group">
						<label class="col-form-label" for="fecha_ingreso">Fecha de ingreso</label>
						<p class="form-control mb-0">{{ date('d-m-Y', strtotime($rdi->fecha_ingreso)) }}</p>
					</div>
					<div class="col-md-3 form-group">
						<label class="col-form-label" for="tiempo_entrega">Tiempo de entrega</label>
						<p class="form-control mb-0">{{$rdi->tiempo_entrega}}</p>
					</div>
					<div class="col-md-3 form-group">
						<label class="col-form-label" for="orden_servicio">Orden de servicio</label>
						<p class="form-control mb-0">{{ $rdi->orden_servicio ?? '-' }}</p>
					</div>
					<div class="col-md-3 col-xl-3 form-group">
						<label class="col-form-label">Hecho por</label>
						<p class="form-control mb-0">{{$rdi->hecho_por}}</p>
					</div>
				</div>
				<h5 class="text-danger mt-4">Características del Motor</h5>
				<div class="row">
					<div class="col-6 col-md-3 form-group">
						<label class="col-form-label" for="selectMarca">Marca</label>
						<p class="form-control mb-0">{{$rdi->marca}}</p>
					</div>
					<div class="col-md-2 form-group">
						<label class="col-form-label">N° Serie</label>
						<p class="form-control mb-0">{{$rdi->nro_serie}}</p>
					</div>
					<div class="col-6 col-md-2 form-group">
						<label class="col-form-label">Frame</label>
						<p class="form-control mb-0">{{$rdi->frame}}</p>
					</div>
					<div class="col-6 col-md-2 form-group">
						<label class="col-form-label">Potencia</label>
						<p class="form-control mb-0">{{$rdi->potencia}}</p>
					</div>
					<div class="col-6 col-md-2 form-group">
						<label class="col-form-label">Tensión</label>
						<p class="form-control mb-0">{{$rdi->tension}}</p>
					</div>
					<div class="col-6 col-md-3 form-group">
						<label class="col-form-label">Corriente</label>
						<p class="form-control mb-0">{{$rdi->corriente}}</p>
					</div>
					<div class="col-6 col-md-3 form-group">
						<label class="col-form-label">Velocidad</label>
						<p class="form-control mb-0">{{$rdi->velocidad}}</p>
					</div>
					<div class="col-6 col-md-3 form-group">
						<label class="col-form-label">Conexión</label>
						<p class="form-control mb-0">{{$rdi->conexion}}</p>
					</div>
					<div class="col-6 col-md-3 form-group">
						<label class="col-form-label">Deflexión del Eje</label>
						<p class="form-control mb-0">{{$rdi->deflexion_eje}}</p>
					</div>
					<div class="col-6 col-md-3 form-group">
						<label class="col-form-label">Rodaje delantero</label>
						<p class="form-control mb-0">{{$rdi->rodaje_delantero}}</p>
					</div>
					<div class="col-6 col-md-3 form-group">
						<label class="col-form-label">Rodaje posterior</label>
						<p class="form-control mb-0">{{$rdi->rodaje_posterior}}</p>
					</div>
					<div class="col-md-12 form-group">
						<label class="col-form-label">ANTECEDENTES</label>
						<p class="form-control mb-0">{{$rdi->antecedentes}}</p>
					</div>
					<div class="col-md-12">
						<label class="col-form-label">Ingresó con:</label>
						<div class="form-control mb-4" style="height: auto">
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
					<div class="col-12 col-md-6 mb-4">
						<label class="col-form-label">ACTIVIDADES POR REALIZAR</label>
						<div class="form-control h-100">
							<ul class="form-check-list list-inline m-0">
								@foreach($services as $service)
								@php
								@endphp
								<li class="row my-1 align-items-center">
									<label class="form-label col-9 col-md-10 mb-0" for="service_{{$service->rdi_service_id}}"><span class="align-middle">{{$service->name}}</span></label>
									<span class="col-3 col-sm-2 d-inline-block"><span class="form-control service_input text-nowrap px-0 text-center"style="margin-top: 0">{{$service->subtotal}}</span></span>
								</li>
								@endforeach
							</ul>
							<label class="col-form-label">Total</label>
							<span class="form-control text-right disabled">{{$rdi->cost}}</span>
						</div>
					</div>
					<div class="col-12 col-md-6 mb-4">
						<label class="col-form-label" for="diagnostico_actual">DIAGNOSTICO ACTUAL</label>
						<span class="form-control h-100" id="diagnostico_actual">{{$rdi->diagnostico_actual}}</span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 form-group">
						<label class="col-form-label">Aislamiento a Masa (Ingreso)</label>
						<p class="form-control mb-0">{{$rdi->aislamiento_masa_ingreso}}</p>
					</div>
					<div class="col-12 form-group">
						<label class="col-form-label">TIPO DE MANTENIMIENTO (Seleccione según corresponda)</label>
						<p class="form-control mb-0">{{$rdi->maintenancetype}}</p>
					</div>
					<div class="col-12 form-group">
						<label class="col-form-label">CRITICIDAD (Seleccione según corresponda)</label>
						<p class="form-control mb-0">{{$rdi->criticalitytype}}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 form-group">
						<label class="col-form-label">Estado</label>
						<p class="form-control mb-0">
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
@if(!$rdi_approved)
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
      		@if($status_last->id != 9)
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
        	<div class="row fecha_entrega text-center" @if($rdi->fecha_entrega != null)style="display: none;" @endif>
	          	<div class="col-12">
	          		<p><label class="col-form-label" for="fecha_entrega">Fecha de entrega</label></p>
	          		<input class="form-control" min="{{date('Y-m-d')}}" type="date" id="fecha_entrega" name="fecha_entrega">
	          		<p class="c-ots message text-danger"></p>
	          		<button type="button" class="btn btn-primary btn-sm px-md-5" id="btngenerateOTDate">Confirmar</button>
	          	</div>
        	</div>
        </div>  
    </div>
  </div>
</div>
@endif
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
    @if(!$rdi_approved)
    $('#modalAprobar .update .btn').click(function () {
    	var action = $(this).data('action');
    	$.ajax({
	        type: "get",
	        url: "{{route('ordenes.generateotdate', $rdi->ot_id)}}",
	        data: {
	        	action: action
	        },
	        beforeSend: function (data) {
	        	$('.c-ots').empty();
	        },
	        success: function (response) {
	        	if(response.success) {
	        		if(response.data) {
		        		$('.fecha_entrega').show();
		        		$('.confirmar_ots').hide();
		        	}
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
    @if($rdi->fecha_entrega == null)
    $('#btngenerateOTDate').click(function () {
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