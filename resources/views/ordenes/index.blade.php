<?php $body_class = Auth::user()->roles->first()->name == 'client' ? 'page_client page-ot-list' : '' ?>
@extends('layouts.app', ['body_class' => $body_class, 'title' => 'OTS'])

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
            	@foreach($ordenes as $orden)
	              <tr>
	                <td class="text-nowrap">{{$orden->fecha_creacion}}</td>
                  <td>{{$orden->id}}</td>
                  <td>
                    <?php
                    $ot_status = \DB::table('status_ot')
                          ->join('status', 'status_ot.status_id', '=', 'status.id')
                          ->where('status_ot.ot_id', '=', $orden->id)
                          ->select('status.id', 'status.name')
                          ->get()->last();
                    if ($ot_status) {
                      echo $ot_status->name;
                    }
                    ?>
                  </td>
	                <td>{{$orden->razon_social}}</td>
	                <td class="text-center">{{$orden->marca['description']}}</td>
	                <td class="text-center text-nowrap">
	                	<a href="{{ route('ordenes.edit', $orden) }}" class="btn btn-sm btn-warning"><i class="fal fa-edit"></i></a>
                    <a href="" class="btn btn-sm btn-danger"><i class="fal fa-minus-circle"></i></a>
                    @if($ot_status->id == 2 || $ot_status->id == 3)
	                	<div class="dropdown d-inline-block dropleft">
                      <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" title="Ver Evaluación" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-eye"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @if($ot_status->id == 2)
                        <a class="dropdown-item" href="{{ route('formatos.mechanical.show', $orden) }}">Evaluación mecánica</a>
                        @endif
                        @if($ot_status->id == 3)
                        <a class="dropdown-item" href="{{ route('formatos.electrical.show', $orden) }}">Evaluación eléctrica</a>
                        @endif
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
