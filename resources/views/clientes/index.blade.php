@extends('layouts.app', ['title' => 'Clientes'])

@section('content')

<div class="row">
	<div class="col">
		<a href="{{ route('clientes.create') }}" class="btn btn-primary">Crear Cliente</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title"> Lista de Cliente</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="tablas">
            <thead class=" text-primary">
              <th>
                Id
              </th>
              <th>
                RUC
              </th>
              <th>
                Razón Social
              </th>
              <th class="text-center">
                Celular
              </th>
              <th class="text-right">
                Herramientas
              </th>
            </thead>
            <tbody>
            	@foreach($clientes as $cliente)
	              <tr>
	                <td>
	                  {{$cliente->id}}
	                </td>
	                <td>
	                  {{$cliente->ruc}}
	                </td>
	                <td>
	                  {{$cliente->razon_social}}
	                </td>
	                <td class="text-center">
	                  {{$cliente->celular}}
	                </td>
	                <td class="text-right">
	                	<a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning"><i class="fal fa-edit"></i></a>
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
