@extends('layouts.app_real', ['title' => 'Taller para OT'])
@section('css')
<style type="text/css">
	@media (min-width: 2000px) {
		.col-xxl-4 {
			flex: 0 0 33.333%;
			max-width: 33.333%;
		}
	}
</style>
@endsection
@section('content')
<ul class="list-inline areas-list row">
	@forelse ($areas as $area)
	<li class="area-item col-12 col-md-6 col-xxl-4">
		<div class="card form-card">
			<div class="card-header"><h2 class='h6 card-title'>{{$area->name}}</h2></div>
			<ul class="list-inline pl-3 section-services-list card-body">
				@forelse ($area->services as $service)
				<li class="service-item mb-3">
					<h6>{{$service->name}}</h6>
					<div class="table-responsive">
						<table class="table table-separate">
							<thead>
								<tr>
									<th>N° O.T.</th>
									<th>Descripción</th>
									<th>Medidas</th>
									<th>Cant.</th>
									<th>Personal</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($service->works as $work)
								<tr class="work-item">
									<td class="text-nowrap">OT-{{$work->ot->code}}</td>
									<td>{{$work->description}}</td>
									<td>{{$work->medidas}}</td>
									<td>{{$work->qty}}</td>
									<td>{{$work->personal}}</td>
								</tr>
								@empty
								<li class="empty-item text-muted">No hay tareas.</li>
								@endforelse
							</tbody>
						</table>
					</div>
				</li>
				@empty
				<li class="empty-item text-muted">No hay servicios.</li>
				@endforelse
			</ul>
		</div>
	</li>
	@empty
	<li class="empty-item text-muted">No hay areas.</li>
	@endforelse
</ul>
@endsection