@extends('layouts.app_real', ['title' => 'Marcas'])

@section('content')

<div class="row">
	<div class="col">
		<a href="{{ route('marcas.create') }}" class="btn btn-primary">Crear Marca</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Marcas de motores</h4>
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
                Descripción
              </th>
              <th class="text-right">
                Acciones
              </th>
            </thead>
            <tbody>
            	@foreach($marcas as $marca)
	              <tr>
	                <td>
	                  {{$marca->id}}
	                </td>
	                <td>
	                  {{$marca->name}}
	                </td>
	                <td>
	                  {{$marca->description}}
	                </td>
	                <td class="text-right">
	                	<a href="{{ route('marcas.edit', $marca) }}" class="btn btn-warning"><i class="fal fa-edit"></i></a>
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
