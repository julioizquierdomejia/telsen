@extends('layouts.app', ['title' => 'Servicios'])

@section('content')
<div class="row">
	<div class="col">
		<a href="{{ route('services.create') }}" class="btn btn-primary">Crear Servicio</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title"> Servicio</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="tablas">
            <thead class="text-primary">
              <th>
                Id
              </th>
              <th>
                Nombre
              </th>
              <th>
                Area
              </th>
              <th class="text-right">
                Herramientas
              </th>
            </thead>
            <tbody>
            	@foreach($services as $servicio)
	              <tr>
	                <td>
	                  {{$servicio->id}}
	                </td>
	                <td>
	                  {{$servicio->name}}
	                </td>
                  <td>
                    <span class="badge badge-dark px-3 py-1">{{$servicio->area}}</span>
                  </td>
	                <td class="text-right">
	                	<a href="{{ route('services.edit', $servicio) }}" class="btn btn-warning"><i class="fal fa-edit"></i></a>
	                	<a href="" class="btn btn-danger"><i class="fal fa-minus-circle"></i></a>
	                </td>
	              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection