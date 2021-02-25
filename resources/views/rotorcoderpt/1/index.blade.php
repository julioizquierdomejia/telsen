@extends('layouts.app_real', ['title' => 'Códigos Rodaje Pto 1'])

@section('content')
<div class="row">
	<div class="col">
		<a href="{{ route('rotorcoderpt1.create') }}" class="btn btn-primary">Crear Código</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Códigos Rodaje Pto 1</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="codept">
            <thead class=" text-primary">
              <th>Id</th>
              <th>Nombre</th>
              <th>Asiento Rodaje</th>
              <th>Alojamiento Rodaje</th>
              <th>Estado</th>
              <th class="text-right">Acciones</th>
            </thead>
            <tbody>
            	{{-- @foreach($codes as $code)
	              <tr>
	                <td>
	                  {{$code->id}}
	                </td>
	                <td>
	                  {{$code->asiento_rodaje}}
	                </td>
	                <td>
	                  {{$code->alojamiento_rodaje}}
	                </td>
                  <td>
                    @if ($code->enabled == 1)
                    <span class="badge badge-success py-2 px-3">Activo</span>
                    @else
                    <span class="badge badge-danger py-2 px-3">Inactivo</span>
                    @endif
                  </td>
	                <td class="text-right">
	                	<a href=" {{ route('rotorcoderpt1.edit', $code) }} " class="btn btn-warning"><i class="fal fa-edit"></i></a>
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
    $('#codept').DataTable({
       processing: true,
       serverSide: true,
       ajax: "{{route('rotorcoderpt1.list')}}",
       pageLength: 5,
       lengthMenu: [ 5, 25, 50 ],
       columns: [
          { data: 'id', class: 'text-nowrap' },
          { data: 'name', class: '' },
          { data: 'asiento_rodaje', class: 'text-nowrap' },
          { data: 'alojamiento_rodaje' },
          { data: 'enabled', class: 'text-left' },
          { data: 'tools', class: 'text-center text-nowrap', orderable: false}
      ],
       columnDefs: [
        { , targets: 4 }
      ],
      language: dLanguage
    });
  })
</script>
@endsection