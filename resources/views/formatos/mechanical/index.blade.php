@extends('layouts.app', ['title' => 'Evaluación Mecánica'])

@section('content')

<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Evaluaciones Mecánicas</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="tablas">
            <thead class="text-primary">
              <th>
                OT Id
              </th>
              <th>
                Cliente
              </th>
              <th>
                Motor
              </th>
              <th class="text-right">
                Acciones
              </th>
            </thead>
            <tbody>
            	@foreach($ots as $ot)
	              <tr>
	                <td>
	                  OT-{{zerosatleft($ot->id, 3)}}
	                </td>
	                <td>
	                  {{$ot->razon_social}}
	                </td>
	                <td>
	                  {{$ot->descripcion_motor}}
	                </td>
	                <td class="text-right">
	                	<a href="{{ route('formatos.mechanical.evaluate', $ot) }}" class="btn btn-orange btn-sm">Evaluar <i class="fal fa-edit ml-2"></i></a>
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
