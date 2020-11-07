@extends('layouts.app', ['title' => 'Tarjetas de Costos'])

@section('content')
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title"> Tarjeta de Costo</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="tablas">
            <thead class="text-primary">
              <th>
                Id
              </th>
              <th>
                Cliente
              </th>
              <th>
                Motor
              </th>
              <th class="text-right">
                Herramientas
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
	                	<a href="{{ route('card_cost.calculate', $ot) }}" class="btn btn-warning"><i class="fal fa-edit"></i></a>
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