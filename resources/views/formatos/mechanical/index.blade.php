@extends('layouts.app', ['title' => 'Evaluación Mecánica'])

@section('content')

<div class="row">
	<div class="col">
		<a href="{{ route('formatos.mechanical.create') }}" class="btn btn-primary">Crear Evaluación Mecánica</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title"> Evaluación Mecánica</h4>
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
                Herramientas
              </th>
            </thead>
            <tbody>
            	@foreach($formatos as $formato)
	              <tr>
	                <td>
	                  {{$formato->id}}
	                </td>
	                <td>
	                  {{$formato->name}}
	                </td>
	                <td>
	                  {{$formato->description}}
	                </td>
	                <td class="text-right">
	                	<a href="{{ route('formatos.edit', $formato) }}" class="btn btn-warning"><i class="fal fa-edit"></i></a>
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
