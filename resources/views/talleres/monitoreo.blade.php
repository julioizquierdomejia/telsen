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
	<li class="area-item col-12 col-md-6 col-xxl-4 mb-3">
		<div class="card form-card h-100 mb-0">
			<div class="card-header">
				<h2 class='h6 card-title'>{{$area->name}}</h2>
			</div>
			<div class="card-body pl-3">
			<div class="supervisors mb-2">
				<h6>Supervisores</h6>
				<ul class="list-inline">
				@foreach ($area->users as $user_data)
					@php
						$user = \App\Models\User::where('id', $user_data->user_id)->where('hidden', 0)->where('enabled', 1)->first();
						$uroles = isset($user->roles) ? $user->roles : [];
						$supervisor = false;
					@endphp
					@if (count($uroles))
						@php
							$role_names = array_column($uroles->toArray(), 'name');
							$supervisor = in_array('supervisor', $role_names);
						@endphp
					@endif
					@if ($supervisor)
						<li class="supervisor"> - {{$user_data->name}}</li>
					@endif
				@endforeach
				</ul>
			</div>
			<ul class="list-inline section-services-list">
				@forelse ($area->services as $service)
				<li class="service-item mb-2 @if (count($service->works)==0) d-none @endif">
					<h6 class="btn btn-outline-primary my-0 btn-sm btn-block" data-toggle="collapse" data-target="#collapseS{{$service->id}}">{{$service->name}}</h6>
					<div class="collapse" id="collapseS{{$service->id}}">
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
					</div>
				</li>
				@empty
				{{-- <li class="empty-item text-muted">No hay servicios.</li> --}}
				@endforelse
			</ul>
			</div>
		</div>
	</li>
	@empty
	<li class="empty-item text-muted">No hay areas.</li>
	@endforelse
</ul>
@endsection