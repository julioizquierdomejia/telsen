@extends('layouts.app', ['title' => 'Ver OT'])
@section('content')
@php
$ot_status = \DB::table('status_ot')
      ->join('status', 'status_ot.status_id', '=', 'status.id')
      ->where('status_ot.ot_id', '=', $ot->id)
      ->select('status_ot.status_id', 'status.id', 'status.name')
      ->get();
$status_last = $ot_status->last();
@endphp
<div class="row">
	<div class="col-md-12">
		<div class="card card-user form-card">
			<div class="card-header">
				<h5 class="card-title d-flex justify-content-between align-items-center">
				<span>
					Orden de Trabajo {{zerosatleft($ot->id, 3)}}
                    <span class="d-block">
                    	@if ($status_last)
                      @if($status_last->status_id == 4)
                      <span class="badge badge-primary px-2 py-1 w-100">{{ $status_last->name }}</span>
                      @else
                      <span class="badge badge-secondary px-2 py-1 w-100">{{ $status_last->name }}</span>
                      @endif
                    @endif
                    </span>
				</span>
				<span class="card-title-buttons">
					<a class="btn btn-primary btn-round" href="{{ route('ordenes.edit', $ot) }}"><i class="fa fa-edit"></i> Editar</a>
                    @if ($ot->cotizacion)
                    	<a class="btn btn-primary btn-round" target="_new" href="/uploads/cotizacion/{{$ot->cotizacion}}"><i class="fa fa-eye"></i> Ver Cotización</a>
                    @endif
				</span>
				</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3 mb-2">
						<label class="col-form-label">Fecha de creación <span class="text-danger">(*)</span></label>
						<p class="form-control mb-1">{{date('d-m-Y', strtotime($ot->created_at))}}</p>
					</div>
					<div class="col-md-2 mb-2">
						<label class="col-form-label">Vendedor</label>
						<p class="form-control mb-1">{{$ot->guia_cliente ?? '-'}}</p>
					</div>
					<div class="col-md-5 mb-2">
						<label class="col-form-label" for="selectRuc">Razón social:</label>
						<p class="form-control mb-1">{{ $ot->razon_social }}</p>
					</div>
					<div class="col-md-2 mb-2">
						<label class="col-form-label" for="selectRuc">Tipo cliente:</label>
						<p class="form-control mb-1"><span class="badge badge-primary px-3">{{ $ot->tipo_cliente }}</span></p>
					</div>
				</div>
				<h5 class="second-title text-danger py-2">Datos del Motor</h5>
				<div class="row">
					<div class="col-md-12 mb-2">
						<label class="col-form-label">Descripción del motor</label>
						<p class="form-control mb-1">{{$ot->descripcion_motor ?? '-'}}</p>
					</div>
					<div class="col-md-4 mb-2">
						<label class="col-form-label">Código</label>
						<p class="form-control mb-1">{{$ot->codigo_motor ?? '-'}}</p>
					</div>
					<div class="col-md-4 mb-2">
						<label class="col-form-label">Marca</label>
						<p class="form-control mb-1">{{$ot->marca ?? '-'}}</p>
					</div>
					<div class="col-md-4  mb-2">
						<label class="col-form-label">Modelo</label>
						<p class="form-control mb-1">{{ $ot->modelo ?? '-' }}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="col-form-label">Numero de potencia</label>
						<p class="form-control mb-1">{{$ot->numero_potencia ?? '-'}}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="col-form-label">Medida de potencia</label>
						<p class="form-control mb-1">{{$ot->medida_potencia ?? '-'}}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="col-form-label">Voltaje</label>
						<p class="form-control mb-1">{{$ot->voltaje ?? '-'}}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="col-form-label">Velocidad</label>
						<p class="form-control mb-1">{{$ot->velocidad ?? '-'}}</p>
					</div>
				</div>
				</div>
				<div class="card-footer">
				<hr>
				<div class="row text-center">
					<div class="col">
					@if(count($ot_status) == 1)
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.electrical.evaluate', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Evaluación eléctrica</a>
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.mechanical.evaluate', $ot) }}"><i class="fas fa-wrench pr-2"></i> Evaluación mecánica</a>
					@elseif(count($ot_status) == 2)
						@if($status_last->status_id == 2)
						<!-- Tiene mecanica: muestra electrica -->
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.electrical.evaluate', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Evaluación eléctrica</a>
						<div class="dropdown-divider"></div>
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.mechanical.show', $ot) }}"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>
						@else
						<!-- Tiene electrica: muestra mecanica -->
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.mechanical.evaluate', $ot) }}"><i class="fas fa-wrench pr-2"></i> Evaluación mecánica</a>
						<div class="dropdown-divider"></div>
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.electrical.show', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>
						@endif
					@elseif(count($ot_status) == 3)
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.mechanical.show', $ot) }}"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.electrical.show', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>
						<div class="dropdown-divider"></div>
						@if($ot->tipo_cliente_id == 1)
						<a class="btn btn-sm btn-primary" href="{{ route('rdi.create', $ot) }}"><i class="fas fa-money-check-alt pr-2"></i> Generar RDI</a>
						@elseif($ot->tipo_cliente_id == 2)
						<a class="btn btn-sm btn-primary" href="{{ route('card_cost.calculate', $ot) }}" class="btn btn-warning"><i class="fal fa-edit"></i> Generar Tarjeta de Costo</a>
						@endif
					@elseif(count($ot_status) == 4)
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.mechanical.show', $ot) }}"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>
						<a class="btn btn-sm btn-primary" href="{{ route('formatos.electrical.show', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>
						<div class="dropdown-divider"></div>
					@endif
					@if($status_last->status_id == 8 || $status_last->status_id == 9 && $ot->tipo_cliente_id == 1)
					<a class="btn btn-sm btn-primary" href="{{ route('rdi.show', $ot) }}"><i class="fas fa-money-check-alt pr-2"></i> Ver RDI</a>
					@endif
					@if($status_last->status_id == 4 || $status_last->status_id == 5 || $status_last->status_id == 6 && $ot->tipo_cliente_id == 2)
					<a class="btn btn-sm btn-primary" href="{{ route('card_cost.cc_show', $ot) }}" class="btn btn-warning"><i class="fal fa-edit"></i> Ver Tarjeta de Costo</a>
					@endif
				</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection