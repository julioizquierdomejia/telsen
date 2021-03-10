@php
$ot_code = zerosatleft($ot->code, 3);
@endphp
@extends('layouts.app_real', ['title' => 'Ver OT N° '.$ot_code])
@section('css')
<style type="text/css">
	.table .table-counter {
		background-color: transparent !important;
		border-collapse: separate;
    	border-spacing: 2px 0;
		width: auto;
	}
	.table .table-counter td {
		padding: 5px !important;
		width: 38px !important;
	}
	.table .table-counter tbody td {
		background-color: #121212 !important;
		color: #fff !important;
		border-radius: 6px;
		font-size: 14px !important;
		padding: 12px 2px !important;
	}
	.table .table-counter tfoot td {
		background-color: transparent !important;
		color: #000 !important;
		border-radius: 0 0 6px 6px;
		font-size: 11px !important;
		padding: 0px 2px 2px 2px !important;
	}
</style>
@endsection
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
					<button class="btn btn-outline-primary btnAddComment" data-otcode="{{$ot->code}}" data-otid="{{$ot->id}}" type="button" title="Comentar"><i class="fa fa-comments"></i></button>
					@if ($admin || $tarjeta_costo || $cotizador_tarjeta || $rol_fentrega)
					@if ($ot->cost_card && $ot->cost_card->cotizacion)
					<a class="btn btn-primary btn-round" target="_new" href="/uploads/cotizacion/{{$ot->cost_card->cotizacion}}"><i class="fa fa-eye"></i> Ver Cotización</a>
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
						<p class="mb-1">{{ $ot->clientes->razon_social }}</p>
					</div>
					<div class="col-md-2 mb-2">
						<label class="col-label" for="selectRuc">Tipo cliente:</label>
						<p class="mb-1"><span class="badge badge-primary px-3">{{ $ot->clientes->client_type->name }}</span></p>
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
				<div class="works">
					@php
					$ot_date = date('d-m-Y', strtotime($ot->created_at));
					$potencia = trim($ot->numero_potencia . ' ' . $ot->medida_potencia);
					@endphp
					@foreach($services as $service_key => $service_item)
					@php
					$first = reset($service_item);
					@endphp
					<div class="card form-card h-100">
						<div class="card-header">
							<h5 class="card-title">{{$first['area']}}</h5>
						</div>
						<div class="card-body">
							<h5 class="small text-dark">Servicios</h5>
							<div class="table-responsive pb-0">
								<table class="table table-separate data-table mb-0">
									<thead class=" text-primary">
										<th class="text-nowrap px-2" width="90">Fecha OT</th>
										<th class="text-nowrap">Servicio</th>
										<th class="text-center">Trabajador</th>
										<th class="text-center">Tiempo trabajado</th>
									</thead>
									<tbody>
										@foreach($service_item as $service)
										@php
										$service_personal = old("personal_name_".$service['ot_work_id'], $service['user_name']);
										$additional = strpos($service['type'], 'add') !== false ? 'background-color: #bdfdb5;' : '';
										$logs = $service['work_logs'];
										@endphp
										<tr class="list-item" data-service="{{$service['ot_work_id']}}">
											<td class="px-2 text-nowrap" style="{{$additional}}">{{$ot_date}}</td>
											<td width="250" style="{{$additional}}">
												<h6 class="subtitle mb-0">{{$service['service']}}</h6>
											</td>
											<td style="{{$additional}}">
												<span class="personal_name badge {{$service_personal ? 'badge-success' : 'badge-secondary'}}">{{ $service_personal ?? 'No asignado' }}</span>
											</td>
											<td>
												@php
													$dias = '--';
													$hrs = '--';
													$min = '--';
													$seg = '--';
												@endphp
											@if (count($logs))
												@php
													$firstDate = reset($logs)['created_at'];
													$secondDate = end($logs)['created_at'];
													$date1 = new DateTime($secondDate);
													$date2 = new DateTime($firstDate);
													$interval = $date1->diff($date2, true);
													$dias = $interval->d;
													$hrs = $interval->h;
													$min = $interval->i;
													$seg = $interval->s;
												@endphp
											@endif
												<table class="table-counter text-center mx-auto">
													<tbody>
													<tr>
														<td>{{$dias}}</td>
														<td style="background-color: transparent !important; color: #121212 !important;width: 6px !important">:</td>
														<td>{{$hrs}}</td>
														<td style="background-color: transparent !important; color: #121212 !important;width: 6px !important">:</td>
														<td>{{$min}}</td>
														<td style="background-color: transparent !important; color: #121212 !important;width: 6px !important">:</td>
														<td>{{$seg}}</td>
													</tr>
													</tbody>
													<tfoot>
													<tr>
														<td>días</td>
														<td style="background-color: transparent !important; color: #121212 !important;width: 6px !important"></td>
														<td>hrs.</td>
														<td style="background-color: transparent !important; color: #121212 !important;width: 6px !important"></td>
														<td>min.</td>
														<td style="background-color: transparent !important; color: #121212 !important;width: 6px !important"></td>
														<td>seg.</td>
													</tr>
													</tfoot>
												</table>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					@endforeach
				</div>
				{{-- Termina works --}}
			</div>
			<div class="card-footer">
				<hr>
				<div class="row text-center">
					<div class="col">
						@if($ot->eeval && $ot->meval && in_array("ee_approved", $statuses) && in_array("me_approved", $statuses))
						@if ($ot->tipo_cliente_id == 1)
						@if ($admin || $rol_rdi || $role_ap_rdi || $rol_fentrega)
						@if($ot->rdi)
						<a class="btn btn-sm btn-primary" href="{{ route('rdi.show', $rdi->id) }}"><i class="fas fa-money-check-alt pr-2"></i> Ver RDI</a>
						@else
						@if ($admin || $rol_rdi)
						<a class="btn btn-sm btn-primary" href="{{ route('rdi.calculate', $ot) }}"><i class="fas fa-money-check-alt pr-2"></i> Generar RDI</a>
						@endif
						@endif
						@endif
						@else
						@if ($admin || $tarjeta_costo || $cotizador_tarjeta || $rol_fentrega)
						@if($ot->cost_card)
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
						@if($ot->meval)
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.mechanical.show', $ot->meval->id) }}"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>
						@else
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.mechanical.evaluate', $ot) }}"><i class="fas fa-wrench pr-2"></i> Evaluación mecánica</a>
						@endif
						@if($ot->eeval)
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.electrical.show', $ot->eeval->id) }}"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>
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
	
</script>
@endsection