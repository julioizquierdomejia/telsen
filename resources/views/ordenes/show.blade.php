@php
$ot_code = zerosatleft($ot->code, 3);
@endphp
@extends('layouts.app_real', ['title' => 'Ver OT N° '.$ot_code])
@section('content')
@php
$ot_status = $ot->statuses;
$statuses = array_column($ot_status->toArray(), "name");
$status_last = $ot_status->last();
$role_names = validateActionbyRole();
$admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
$tarjeta_costo = in_array("tarjeta_de_costo", $role_names) || in_array("aprobador_cotizacion_tarjeta_de_costo", $role_names);
$evaluador = in_array("evaluador", $role_names) || in_array("aprobador_de_evaluaciones", $role_names);
$rol_rdi = in_array("rdi", $role_names);
$role_ap_rdi = in_array("aprobador_rdi", $role_names);
$cotizador_tarjeta = in_array("cotizador_tarjeta_de_costo", $role_names);
$rol_fentrega = in_array("fecha_de_entrega", $role_names);
@endphp
<style type="text/css">
	table.comments_dt {
        background-color: #e5ddd5;
        /*border-radius: 7px;*/
        box-sizing: border-box;
        font-size: 12px;
        padding: 15px 1rem;
        width: 100% !important;
    }
    table.comments_dt,
    table.comments_dt tbody,
    table.comments_dt tr,
    table.comments_dt td {
    	display: block;
    }

    /*--[  This does the job of making the table rows appear as comments_dt ]----------------*/
    .dataTable.comments_dt tbody tr {
    	background-color: white;
    	border-radius: 7px;
    	box-shadow: 0 1px 0.5px #b9b9b9;
	    margin: 5px 0;
	    padding: 6px 10px;
	    width: 90%;
    }
    .dataTable.comments_dt tbody td {
    	border: 0;
        width: 100%;
        overflow: hidden;
        padding: 0;
        text-align: left;
    }
    .comments_dt .c-date {
    	font-size: 10px;
    	margin-top: -5px;
    }
    .dataTable.comments_dt tbody tr:before {
    	content: '';
    	font-family: "Font Awesome 5 Pro";
    	font-weight: 900;
    	font-size: 22px;
    	line-height: 20px;
    	position: absolute;
    	top: 0;
    }
    .dataTable.comments_dt tbody .row-me {
    	background-color: #dcf8c6;
    	border-top-right-radius: 0;
	    margin-left: auto;
    }
    .dataTable.comments_dt tbody .row-me:before {
    	color: #dcf8c6;
    	right: -4px;
    	top: -7px;
    	content: "\F0DA";
    	transform: rotate(-135deg);
    }
    .dataTable.comments_dt tbody .row-other {
    	border-top-left-radius: 0;
    }
    .dataTable.comments_dt tbody .row-other:before {
    	color: #fff;
    	left: -4px;
    	top: -8px;
    	content: "\F0D9";
    	transform: rotate(135deg);
    }
    .comments .table-responsive {
    	max-height: 300px;
    }

    #frmComment {
    	position: relative;
    }
    #ot_comment {
    	resize: none;
    }
    #btnComment {
    	box-shadow: none;
    	font-size: 18px;
    	position: absolute;
    	right: 5px;
    	top: 3px;
    }

    /*---[ The remaining is just more dressing to fit my preferances ]-----------------*/
    .table {
        background-color: #fff;
    }
    .table tbody label {
        display: none;
        margin-right: 5px;
        width: 50px;
    }

    .comments_dt tbody label {
        display: inline;
        position: relative;
        font-size: 85%;
        font-weight: normal;
        top: -5px;
        left: -3px;
        float: left;
        color: #808080;
    }
    .comments_dt tbody td:nth-child(1) {
        text-align: center;
    }
</style>
<div class="row">
	<div class="col-md-12">
		<div class="card card-user form-card">
			<div class="card-header">
				<h5 class="card-title d-flex justify-content-between align-items-center">
				<span>
					Orden de Trabajo {{$ot_code}}
					<span class="d-block">
						@if ($ot_status->count())
						@if($status_last->name == 'cc')
						<span class="badge badge-primary px-2 py-1 w-100">{{ $status_last->description }}</span>
						@elseif($status_last->name == 'cc_waiting')
						<span class="badge badge-danger px-2 py-1 w-100">{{ $status_last->description }}</span>
						@elseif(strpos($status_last->name, '_approved') !== false || $status_last->name == 'delivery_generated')
						<span class="badge badge-success px-2 py-1 w-100">{{ $status_last->description }}</span>
						{{-- @if ($status_last->name == 11)
						Fecha de entrega: <span class="badge badge-secondary">{{$ot->fecha_entrega}}</span>
						@endif --}}
						@elseif($status_last->name == 'rdi_waiting')
						<span class="badge badge-danger px-2 py-1 w-100">{{ $status_last->description }}</span>
						@else
						<span class="badge badge-secondary px-2 py-1 w-100">{{ $status_last->description }}</span>
						@endif
						@endif
					</span>
				</span>
				<span class="card-title-buttons">
					@if ($admin || $tarjeta_costo || $cotizador_tarjeta || $rol_fentrega)
					@if ($ot->cotizacion)
					<a class="btn btn-primary btn-round" target="_new" href="/uploads/cotizacion/{{$ot->cotizacion}}"><i class="fa fa-eye"></i> Ver Cotización</a>
					@endif
					@endif
					@if ($admin || in_array("crear_ot", $role_names))
					<a class="btn btn-primary btn-round" href="{{ route('ordenes.edit', $ot) }}"><i class="fa fa-edit"></i> Editar</a>
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
					<div class="col-6 col-md-3 mb-2">
						<label class="col-label">Prioridad</label>
						<p class="mb-1">{!!$ot->priority == 1 ? '<span class="badge badge-danger px-3">Alta</span>' : '<span class="badge badge-secondary px-3">Normal</span>'!!}</p>
					</div>
					<div class="col-6 col-md-3 mb-2">
						<label class="col-label">Estado</label>
						<p class="mb-1">{!!$ot->enabled == 1 ? '<span class="badge badge-success px-3">Activo</span>' : '<span class="badge badge-danger px-3">Inactivo</span>'!!}</p>
					</div>
				</div>
				<div class="comments border">
					<h3 class="py-2 px-3 bg-light border-bottom mb-0 h6"><i class="far fa-comments pr-2"></i> Comentarios</h3>
					<div class="table-responsive">
						<table class="table comments_dt" id="commentsTD">
						<thead class="d-none">
							<tr>
								<th>ID</th>
								<th>Usuario</th>
								<th>UD</th>
								<th>Comentario</th>
								<th>Fecha</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					</div>
					<div class="comment p-3 bg-light">
						<form class="frm" id="frmComment" method="POST" action="{{ route('ordenes.comment.store', ['orden' => $ot->id]) }}">
							@csrf
								<textarea class="form-control mt-0 rounded-pill pr-4 pl-3" id="ot_comment" placeholder="Comentario" name="comment"></textarea>
								<button class="btn m-0" id="btnComment" type="submit" style="min-width: 0"><i class="far fa-paper-plane"></i></button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="card-footer">
				<hr>
				<div class="row text-center">
					<div class="col">
				@if($eeval && $meval && in_array("ee_approved", $statuses) && in_array("me_approved", $statuses))
					@if ($ot->tipo_cliente_id == 1)
						@if ($admin || $rol_rdi || $role_ap_rdi || $rol_fentrega)
							@if($rdi)
							<a class="btn btn-sm btn-primary" href="{{ route('rdi.show', $rdi->id) }}"><i class="fas fa-money-check-alt pr-2"></i> Ver RDI</a>
							@else
							@if ($admin || $rol_rdi)
							<a class="btn btn-sm btn-primary" href="{{ route('rdi.calculate', $ot) }}"><i class="fas fa-money-check-alt pr-2"></i> Generar RDI</a>
							@endif
							@endif
						@endif
					@else
						@if ($admin || $tarjeta_costo || $cotizador_tarjeta || $rol_fentrega)
						@if($cost_card)
						<a class="btn btn-sm btn-primary" href="{{ route('card_cost.cc_show', $ot) }}" class="btn btn-warning"><i class="fal fa-money-check-alt"></i> Ver Tarjeta de Costo</a>
						@else
						@if ($admin || $tarjeta_costo)
						<a class="btn btn-sm btn-primary" href="{{ route('card_cost.calculate', $ot) }}" class="btn btn-warning"><i class="fal fa-edit"></i> Generar Tarjeta de Costo</a>
						@endif
						@endif
						@endif
					@endif
				@endif
				@if ($admin || $evaluador)
						@if($meval)
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.mechanical.show', $meval->id) }}"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>
						@else
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.mechanical.evaluate', $ot) }}"><i class="fas fa-wrench pr-2"></i> Evaluación mecánica</a>
						@endif
						@if($eeval)
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.electrical.show', $eeval->id) }}"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>
						@else
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.electrical.evaluate', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Evaluación eléctrica</a>
						@endif
				@endif
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
	$(document).ready(function () {
		dLanguage.sEmptyTable = "No hay comentarios aún.";
		var commentsTD = $('#commentsTD').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{route('ordenes.comments', ['orden'=>$ot->id])}}",
			pageLength: 5,
			lengthMenu: [ 5, 25, 50 ],
			'sDom': 't',
			searching: false,
			columns: [
		        { data: 'id', class: 'd-none' },
		        { data: 'user', class: 'text-primary' },
		        { data: 'user_id', class: 'd-none' },
		        { data: 'comment', class: 'text-left comment' },
		        { data: 'created_at', class: 'text-right c-date text-muted' },
		    ],
		    "createdRow": function( row, data, dataIndex){
		    	console.log(data)
	          if( data.user_id == {{auth()->id()}}){
	            $(row).addClass('row-me');
	          } else {
	          	$(row).addClass('row-other');
	          }
	        },
		     columnDefs: [
		      { orderable: false, targets: 2 },
		    ],
		    order: [[ 0, "desc" ]],
		    language: dLanguage
	  	});

		$(document).on("submit", "#frmComment", function(event) {
			event.preventDefault();
			var form = $(this);
    		var url = form.attr('action');
			$.ajax({
		        type: "post",
		        url: url,
		        data: new FormData(this),
		        processData: false,
	        	contentType: false,
		        success: function (data) {
		          $('#ot_comment').val('');
		          commentsTD.ajax.reload();
		        },
		        error: function (request, status, error) {
		          
		        }
		    });
		})
	})
</script>
@endsection