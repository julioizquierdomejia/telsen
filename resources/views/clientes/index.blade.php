@extends('layouts.app', ['title' => 'Clientes'])

@section('content')

<div class="row">
	<div class="col">
		<a href="{{ route('clientes.create') }}" class="btn btn-primary">Crear Cliente</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title"> Lista de Clientes</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="clientsTb">
            <thead class=" text-primary">
              <th>Id</th>
              <th>RUC</th>
              <th>Razón Social</th>
              <th class="text-center">Tipo</th>
              <th class="text-center">Celular</th>
              <th class="text-center">Estado</th>
              <th class="text-right">Acciones</th>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
  clientsTb = $('#clientsTb').DataTable({
     processing: true,
     serverSide: true,
     ajax: "{{route('clientes.list')}}",
     pageLength: 5,
     lengthMenu: [ 5, 25, 50 ],
     columns: [
        { data: 'id', class: 'text-center' },
        { data: 'ruc', class: 'text-center' },
        { data: 'razon_social' },
        { data: 'client_type', class: 'text-left' },
        { data: 'celular', class: 'text-left' },
        { data: 'enabled', class: 'text-left' },
        { data: 'tools', class: 'text-left text-nowrap'}
    ],
     columnDefs: [
      { orderable: false, targets: 2 },
    ],
    order: [[ 0, "desc" ]],
    language: dLanguage
  });
</script>
@endsection