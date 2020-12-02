@extends('layouts.app', ['title' => 'Modelos'])

@section('content')

<div class="row">
	<div class="col">
		<a href="{{ route('modelos.create') }}" class="btn btn-primary">Crear Modelo</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Modelos de motores</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="tablas">
            <thead class=" text-primary">
              <th>
                Id
              </th>
              <th>
                Nombre
              </th>
              <th>
                Descripción
              </th>
              <th class="text-right">
                Acciones
              </th>
            </thead>
            <tbody>
            	@foreach($modelos as $modelo)
	              <tr>
	                <td>
	                  {{$modelo->id}}
	                </td>
	                <td>
	                  {{$modelo->name}}
	                </td>
	                <td>
	                  {{$modelo->description}}
	                </td>
	                <td class="text-right">
	                	<a href=" {{ route('modelos.edit', $modelo) }} " class="btn btn-warning"><i class="fal fa-edit"></i></a>
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
