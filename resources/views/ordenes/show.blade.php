@php
	$ot_id = zerosatleft($ot->id, 3);
@endphp
@extends('layouts.app', ['title' => 'Ver OT N° '.$ot_id])
@section('content')
@php
$ot_status = $ot->statuses;
$statuses = array_column($ot_status->toArray(), "name");
$status_last = $ot_status->last();

$roles = Auth::user()->roles;
$role_names = array_column($roles->toArray(), 'name');
$admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
@endphp
<div class="row">
	<div class="col-md-12">
		<div class="card card-user form-card">
			<div class="card-header">
				<h5 class="card-title d-flex justify-content-between align-items-center">
				<span>
					Orden de Trabajo {{$ot_id}}
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
					@if ($admin || in_array("crear_ot", $role_names))
					<a class="btn btn-primary btn-round" href="{{ route('ordenes.edit', $ot) }}"><i class="fa fa-edit"></i> Editar</a>
					@endif
                    @if ($ot->cotizacion)
                    	<a class="btn btn-primary btn-round" target="_new" href="/uploads/cotizacion/{{$ot->cotizacion}}"><i class="fa fa-eye"></i> Ver Cotización</a>
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
					<div class="col-md-4 mb-2">
						<label class="col-label">Código</label>
						<p class="mb-1">{{$ot->codigo_motor ?? '-'}}</p>
					</div>
					<div class="col-md-4 mb-2">
						<label class="col-label">Marca</label>
						<p class="mb-1">{{$ot->marca ?? '-'}}</p>
					</div>
					<div class="col-md-4  mb-2">
						<label class="col-label">Modelo</label>
						<p class="mb-1">{{ $ot->modelo ?? '-' }}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="col-label">Numero de potencia</label>
						<p class="mb-1">{{$ot->numero_potencia ?? '-'}}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="col-label">Medida de potencia</label>
						<p class="mb-1">{{$ot->medida_potencia ?? '-'}}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="col-label">Voltaje</label>
						<p class="mb-1">{{$ot->voltaje ?? '-'}}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="col-label">Velocidad</label>
						<p class="mb-1">{{$ot->velocidad ?? '-'}}</p>
					</div>
				</div>
				</div>
				@if($admin || in_array("evaluador", $role_names) || in_array("aprobador_de_evaluaciones", $role_names) || in_array("tarjeta_de_costo", $role_names) || in_array("aprobador_de_tarjeta_de_costo", $role_names))
				<div class="card-footer">
				<hr>
				<div class="row text-center">
					<div class="col">
				@if($eeval && $meval && in_array("ee_approved", $statuses) && in_array("me_approved", $statuses))
				@if ($ot->tipo_cliente_id == 1)
					@if($rdi)
					<a class="btn btn-sm btn-primary" href="{{ route('rdi.show', $rdi->id) }}"><i class="fas fa-money-check-alt pr-2"></i> Ver RDI</a>
					@else
					<a class="btn btn-sm btn-primary" href="{{ route('rdi.calculate', $ot) }}"><i class="fas fa-money-check-alt pr-2"></i> Generar RDI</a>
					@endif
				@else
					@if (in_array("tarjeta_de_costo", $role_names) || in_array("aprobador_de_tarjeta_de_costo", $role_names))
					@if($cost_card)
					<a class="btn btn-sm btn-primary" href="{{ route('card_cost.cc_show', $ot) }}" class="btn btn-warning"><i class="fal fa-edit"></i> Ver Tarjeta de Costo</a>
					@else
					<a class="btn btn-sm btn-primary" href="{{ route('card_cost.calculate', $ot) }}" class="btn btn-warning"><i class="fal fa-edit"></i> Generar Tarjeta de Costo</a>
					@endif
					@endif
				@endif
				@endif
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
				</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection