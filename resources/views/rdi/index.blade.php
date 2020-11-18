@extends('layouts.app', ['title' => 'Tarjetas de Costos'])

@section('content')
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title"> Reportes de Ingreso</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="tablas">
            <thead class="text-primary">
              <th>Id</th>
              <th>Cliente</th>
              <th>Equipo</th>
              <th class="text-right">Herramientas</th>
            </thead>
            <tbody>
            	@foreach($rdis as $rdi)
	              <tr>
	                <td>
	                  OT-{{zerosatleft($rdi->id, 3)}}
	                </td>
	                <td>
                    {{$rdi->razon_social}}
                  </td>
                  <td>
                    {{$rdi->equipo}}
                  </td>
	                <td class="text-right">
	                	<a href="{{ route('rdi.calculate', $rdi) }}" class="btn btn-warning" title="Calcular"><i class="fal fa-money-check-alt"></i></a>
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