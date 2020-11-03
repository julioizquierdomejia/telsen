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
              <th>
                Fecha OT
              </th>
              <th>
                Número de OT
              </th>
              <th>
                Estado de OT
              </th>
              <th>
                Cliente 
              </th>
              <th class="text-center">
                Descripción del motor
              </th>
              <th class="text-center">
                Herramientas
              </th>
            </thead>
            <tbody>
            	@foreach($ordenes as $orden)
	              <tr>
	                <td>
	                  {{$orden->fecha_creacion}}
	                </td>
                  <td>
                    {{$orden->id}}
                  </td>
                  <td>
                    <?php
                    foreach ($_ots as $key => $ot) {
                      $ot_status = \DB::table('status_ot')->where('status_ot.ot_id', '=', $ot->id)->get();
                      $array = [];
                      foreach ($ot_status as $key => $status) {
                          $array[] = $status->status_id;
                      }
                      if (!in_array(2, $array)) {
                          $ots[] = $ot;
                      }
                  }
                    ?>
                  </td>
	                <td>
	                  {{$orden->descripcion_motor}}
	                </td>
	                <td class="text-center">
	                  {{$orden->marca['description']}}
	                </td>
	                <td class="text-center">
	                	<a href="{{ route('ordenes.edit', $orden) }}" class="btn btn-warning"><i class="fal fa-edit"></i></a>
                    <a href="" class="btn btn-danger"><i class="fal fa-minus-circle"></i></a>
	                	<div class="dropdown d-inline-block dropleft">
                      <button class="btn btn-secondary dropdown-toggle" type="button" title="Ver Evaluación" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-eye"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('formatos.mechanical.show', $orden) }}">Evaluación mecánica</a>
                        <a class="dropdown-item" href="{{ route('formatos.electrical.show', $orden) }}">Evaluación eléctrica</a>
                      </div>
                    </div>
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
