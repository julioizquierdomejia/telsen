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
          <table class="table table-separate">
            <thead class=" text-primary">
              <th>
                Id
              </th>
              <th>
                Fecha de Creación
              </th>
              <th>
                Descripción
              </th>
              <th class="text-center">
                Marca del motor
              </th>
              <th class="text-center">
                Herramientas
              </th>
            </thead>
            <tbody>
            	@foreach($ordenes as $orden)
	              <tr>
	                <td>
	                  {{$orden->id}}
	                </td>
	                <td>
	                  {{$orden->fecha_creacion}}
	                </td>
	                <td>
	                  {{$orden->descripcion_motor}}
	                </td>
	                <td class="text-center">
	                  {{$orden->marca['name']}}
	                </td>
	                <td class="text-center">
	                	<a href="{{ route('ordenes.edit', $orden) }}" class="btn btn-warning"><i class="fal fa-edit"></i></a>
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
