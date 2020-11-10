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
					@if(count($ot_status) > 1)
					<div class="dropdown d-inline-block dropleft">
						<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" title="Ver Evaluaciones" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-file-check"></i>
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							@foreach($ot_status as $ostatus)
							@if($ostatus->id == 2)
							<a class="dropdown-item" href="{{ route('formatos.mechanical.show', $ot) }}"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>
							@endif
							@if($ostatus->id == 3)
							<a class="dropdown-item" href="{{ route('formatos.electrical.show', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>
							@endif
							@if($ostatus->id == 4)
							<a class="dropdown-item" href="{{ route('card_cost.cc_show', $ot) }}"><i class="fas fa-money-check-alt pr-2"></i> Ver Tarjeta de Costo</a>
							@endif
							@endforeach
						</div>
					</div>
					@else
					<div class="dropdown d-inline-block dropleft">
						<button class="btn btn-sm btn-secondary dropdown-toggle" type="button" title="Evaluar" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-file-check"></i> Evaluar
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="{{ route('formatos.mechanical.evaluate', $ot) }}"><i class="fas fa-wrench pr-2"></i> Evaluación mecánica</a>
							<a class="dropdown-item" href="{{ route('formatos.electrical.evaluate', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Evaluación eléctrica</a>
						</div>
					</div>
					@endif
				</span>
				</h5>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3 mb-2">
						<label class="c-label">Fecha de creación <span class="text-danger">(*)</span></label>
						<p class="mb-1">{{date('d-m-Y', strtotime($ot->created_at))}}</p>
					</div>
					<div class="col-md-3 mb-2">
						<label class="c-label">Vendedor</label>
						<p class="mb-1">{{$ot->guia_cliente}}</p>
					</div>
					<div class="col-md-6 mb-2">
						<label class="c-label" for="selectRuc">Razón social:</label>
						<p class="mb-1">{{ $ot->razon_social }}</p>
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