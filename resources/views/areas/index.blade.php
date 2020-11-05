@extends('layouts.app', ['title' => 'Areas'])

@section('content')
<div class="row">
	<div class="col">
		<a href="{{ route('areas.create') }}" class="btn btn-primary">Crear Area</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title"> Area</h4>
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
              <th class="text-right">
                Herramientas
              </th>
            </thead>
            <tbody>
            	@foreach($areas as $area)
	              <tr>
	                <td>
	                  {{$area->id}}
	                </td>
	                <td>
	                  {{$area->name}}
	                </td>
	                <td class="text-right">
	                	<a href="{{ route('areas.edit', $area) }}" class="btn btn-warning"><i class="fal fa-edit"></i></a>
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