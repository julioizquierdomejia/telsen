@extends('layouts.app', ['title' => 'RDI'])

@section('content')
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title"> Reportes de Ingreso</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="rdi-table">
            <thead class=" text-primary">
              <th class="text-nowrap">Fecha OT</th>
              <th class="text-nowrap">N° de OT</th>
              <th>Estado</th>
              <th>Cliente</th>
              <th>Potencia</th>
              <th class="text-center">Fecha de entrega</th>
              <th class="text-center">Acciones</th>
            </thead>
            {{-- <tbody>
              @if($rdis)
            	@foreach($rdis as $rdi)
	              <tr>
	                <td>
	                  OT-{{zerosatleft($rdi->code, 3)}}
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
              @else
              <tr>
                <td colspan="4">-</td>
              </tr>
              @endif
            </tbody> --}}
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
$(document).ready(function() {
  $('#rdi-table').DataTable({
     processing: true,
     serverSide: true,
     ajax: "{{route('rdi.list_waiting')}}",
     pageLength: 5,
     lengthMenu: [ 5, 25, 50 ],
     columns: [
        { data: 'created_at', class: 'text-nowrap' },
        { data: 'id', class: 'otid' },
        { data: 'status', class: 'text-center' },
        { data: 'razon_social' },
        { data: 'numero_potencia', class: 'text-left' },
        { data: 'fecha_entrega', class: 'text-center bg-light' },
        { data: 'tools', class: 'text-left text-nowrap'}
    ],
     columnDefs: [
      { orderable: false, targets: 2 },
      { orderable: false, targets: 6 }
    ],
    order: [[ 0, "desc" ]],
    language: dLanguage
  });
});
</script>
@endsection