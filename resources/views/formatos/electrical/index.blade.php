@extends('layouts.app_real', ['title' => 'Evaluación Eléctrica'])

@section('content')

<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Evaluaciones Eléctricas</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate data-table ee-table">
            <thead class="text-primary">
              <th>Fecha OT</th>
              <th>N° de OT</th>
              <th>Cliente</th>
              <th>Motor</th>
              <th class="text-center">Acciones</th>
            </thead>
            <tbody>
            	{{-- @foreach($ots as $ot)
	              <tr>
	                <td>
	                  OT-{{zerosatleft($ot->code, 3)}}
	                </td>
	                <td>
	                  {{$ot->razon_social}}
	                </td>
	                <td>
	                  {{$ot->descripcion_motor}}
	                </td>
	                <td class="text-right">
	                	<a href="{{ route('formatos.electrical.evaluate', $ot) }}" class="btn btn-orange btn-sm">Evaluar <i class="fal fa-edit ml-2"></i></a>
	                </td>
	              </tr>
              @endforeach --}}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $(document).ready(function () {
    $('.ee-table').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{route('ordenes.ee_ots')}}",
       pageLength: 5,
       lengthMenu: [ 5, 25, 50 ],
       columns: [
          { data: 'created_at', class: 'text-nowrap' },
          { data: 'id', class: 'otid text-nowrap' },
          { data: 'razon_social' },
          { data: 'numero_potencia', class: 'text-left' },
          { data: 'tools', class: 'text-center text-nowrap', orderable: false}
      ],
      order: [[ 0, "desc" ]],
      language: dLanguage
    });
  })
</script>
@endsection