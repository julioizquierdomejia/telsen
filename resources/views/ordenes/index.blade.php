@extends('layouts.app', ['body_class' => 'ots', 'title' => 'OTS'])

@section('content')

<div class="row">
	<div class="col">
		<a href="/ordenes/crear" class="btn btn-primary">Crear Orden de Trabajo</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Orden de Trabajo</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="tablas">
            <thead class=" text-primary">
              <th class="text-nowrap">Fecha OT</th>
              <th>N° de OT</th>
              <th>Estado de OT</th>
              <th>Cliente</th>
              <th class="text-center">Descripción del motor</th>
              <th class="text-center">Herramientas</th>
            </thead>
            <tbody>
            	@foreach($ordenes as $ot)
	              <tr>
	                <td class="text-nowrap">{{date("d-m-Y", strtotime($ot->created_at))}}</td>
                  <td>OT-{{zerosatleft($ot->id, 3)}}</td>
                  <td class="text-center">
                    <?php
                    $ot_status = \DB::table('status_ot')
                          ->join('status', 'status_ot.status_id', '=', 'status.id')
                          ->where('status_ot.ot_id', '=', $ot->id)
                          ->select('status.id', 'status.name')
                          ->get();
                    $status_last = $ot_status->last();
                    ?>
                    @if ($status_last)
                      @if($status_last->id == 4 || $status_last->id == 9)
                      <span class="badge badge-primary px-2 py-1 w-100">{{ $status_last->name }}</span>
                      @else
                      <span class="badge badge-secondary px-2 py-1 w-100">{{ $status_last->name }}</span>
                      @endif
                    @endif
                  </td>
	                <td>{{$ot->razon_social}}</td>
	                <td class="text-center">{{$ot->descripcion_motor}}</td>
	                <td class="text-left text-nowrap">
                    <a href="{{ route('ordenes.ot_show', $ot) }}" class="btn btn-sm btn-primary"><i class="fal fa-eye"></i></a>
	                	<a href="{{ route('ordenes.edit', $ot) }}" class="btn btn-sm btn-warning"><i class="fal fa-edit"></i></a>
                    <a href="" class="btn btn-sm btn-danger"><i class="fal fa-minus-circle"></i></a>
                    @if(count($ot_status) > 1)
	                	<div class="dropdown d-inline-block dropleft">
                      <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" title="Ver Evaluaciones" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-file-check"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach($ot_status as $ostatus)
                        @if($ostatus->id == 2)
                        <a class="dropdown-item" href="{{ route('formatos.mechanical.show', $ot) }}"><i class="fas fa-wrench pr-2"></i> Ver Evaluación mecánica</a>
                        @endif
                        @if($ostatus->id == 3)
                        <a class="dropdown-item" href="{{ route('formatos.electrical.show', $ot) }}"><i class="fas fa-charging-station pr-2"></i> Ver Evaluación eléctrica</a>
                        @endif
                        @if($ostatus->id == 4)
                        <a class="dropdown-item" href="{{ route('card_cost.cc_show', $ot) }}"><i class="fas fa-money-check-alt pr-2"></i> Ver Tarjeta de Costo</a>
                        @endif
                        @endforeach
                      </div>
                    </div>
                    @endif
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
