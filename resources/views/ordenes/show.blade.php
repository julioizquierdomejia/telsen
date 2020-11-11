@extends('layouts.app', ['title' => 'Ver OT'])
@section('content')
<?php
$ot_status = \DB::table('status_ot')
      ->join('status', 'status_ot.status_id', '=', 'status.id')
      ->where('status_ot.ot_id', '=', $ot->id)
      ->select('status.id', 'status.name')
      ->get();
$status_last = $ot_status->last();
?>
<div class="row">
	<div class="col-md-12">
		<div class="card card-user form-card">
			<div class="card-header">
				<h5 class="card-title d-flex justify-content-between align-items-center">
				<span>
					Orden de Trabajo {{zerosatleft($ot->id, 3)}}
                    <span class="d-block">
                    	@if ($status_last)
                      @if($status_last->id == 4)
                      <span class="badge badge-primary px-2 py-1 w-100">{{ $status_last->name }}</span>
                      @else
                      <span class="badge badge-secondary px-2 py-1 w-100">{{ $status_last->name }}</span>
                      @endif
                    @endif
                    </span>
				</span>
				<span class="card-title-buttons">
					<a class="btn btn-primary btn-round" href="{{ route('ordenes.edit', $ot) }}"><i class="fa fa-edit"></i> Editar</a>
					<div class="dropdown d-inline-block dropleft">
						<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" title="Ver Evaluaciones" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-file-check"></i> Evaluaciones
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						@if(count($ot_status) == 1)
							<a class="dropdown-item" href="{{ route('formatos.electrical.evaluate', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Evaluación eléctrica</a>
							<a class="dropdown-item" href="{{ route('formatos.mechanical.evaluate', $ot) }}"><i class="fas fa-wrench pr-2"></i> Evaluación mecánica</a>
						@elseif(count($ot_status) == 2)
							@if($status_last->id == 2)
							<!-- Tiene mecanica: muestra electrica -->
							<a class="dropdown-item" href="{{ route('formatos.electrical.evaluate', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Evaluación eléctrica</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('formatos.mechanical.show', $ot) }}"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>
							@else
							<!-- Tiene electrica: muestra mecanica -->
							<a class="dropdown-item" href="{{ route('formatos.mechanical.evaluate', $ot) }}"><i class="fas fa-wrench pr-2"></i> Evaluación mecánica</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('formatos.electrical.show', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>
							@endif
						@elseif(count($ot_status) == 3)
							<a class="dropdown-item" href="{{ route('formatos.mechanical.show', $ot) }}"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>
							<a class="dropdown-item" href="{{ route('formatos.electrical.show', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>
							<div class="dropdown-divider"></div>
							@if($ot->tipo_cliente_id == 1)
							<a class="dropdown-item" href="{{ route('rdi.create', $ot) }}"><i class="fas fa-money-check-alt pr-2"></i> Generar RDI</a>
							@elseif($ot->tipo_cliente_id == 2)
							<a class="dropdown-item" href="{{ route('card_cost.calculate', $ot) }}" class="btn btn-warning"><i class="fal fa-edit"></i> Generar Tarjeta de Costo</a>
							@endif
						@elseif(count($ot_status) == 4)
							<a class="dropdown-item" href="{{ route('formatos.mechanical.show', $ot) }}"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>
							<a class="dropdown-item" href="{{ route('formatos.electrical.show', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>
							<div class="dropdown-divider"></div>
							@if($ot->tipo_cliente_id == 1)
							<a class="dropdown-item" href="{{ route('rdi.show', $ot) }}"><i class="fas fa-money-check-alt pr-2"></i> Ver RDI</a>
							@elseif($ot->tipo_cliente_id == 2)
							<a class="dropdown-item" href="{{ route('card_cost.show', $ot) }}" class="btn btn-warning"><i class="fal fa-edit"></i> Ver Tarjeta de Costo</a>
							@endif
						@endif
						</div>
					</div>
				</span>
				</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3 mb-2">
						<label class="c-label">Fecha de creación <span class="text-danger">(*)</span></label>
						<p class="mb-1">{{date('d-m-Y', strtotime($ot->created_at))}}</p>
					</div>
					<div class="col-md-2 mb-2">
						<label class="c-label">Vendedor</label>
						<p class="mb-1">{{$ot->guia_cliente}}</p>
					</div>
					<div class="col-md-5 mb-2">
						<label class="c-label" for="selectRuc">Razón social:</label>
						<p class="mb-1">{{ $ot->razon_social }}</p>
					</div>
					<div class="col-md-2 mb-2">
						<label class="c-label" for="selectRuc">Tipo cliente:</label>
						<p class="mb-1"><span class="badge badge-primary px-3">{{ $ot->tipo_cliente }}</span></p>
					</div>
				</div>
				<h5 class="second-title text-danger py-2">Datos del Motor</h5>
				<div class="row">
					<div class="col-md-12 mb-2">
						<label class="c-label">Descripción del motor</label>
						<p class="mb-1">{{$ot->descripcion_motor}}</p>
					</div>
					<div class="col-md-4 mb-2">
						<label class="c-label">Código</label>
						<p class="mb-1">{{$ot->codigo_motor}}</p>
					</div>
					<div class="col-md-4 mb-2">
						<label class="c-label">Marca</label>
						<p class="mb-1">{{$ot->marca}}</p>
					</div>
					<div class="col-md-4  mb-2">
						<label class="c-label">Modelo</label>
						<p class="mb-1">{{ $ot->modelo }}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="c-label">Numero de potencia</label>
						<p class="mb-1">{{$ot->numero_potencia}}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="c-label">Medida de potencia</label>
						<p class="mb-1">{{$ot->medida_potencia}}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="c-label">Voltaje</label>
						<p class="mb-1">{{$ot->voltaje}}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="c-label">Velocidad</label>
						<p class="mb-1">{{$ot->velocidad}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection