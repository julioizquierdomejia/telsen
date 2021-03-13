@extends('layouts.app_real', ['title' => 'Areas'])

@section('content')
<div class="row">
	<div class="col">
		<a href="{{ route('areas.create') }}" class="btn btn-primary">Crear Area</a>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
    <div class="card form-card">
      <div class="card-header">
        <h4 class="card-title">Areas</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-separate" id="areasTB">
            <thead class="text-primary">
              <th>Id</th>
              <th>Nombre</th>
              <th>En monitoreo</th>
              <th>Estado</th>
              <th class="text-center">Acciones</th>
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
  areasTB = $('#areasTB').DataTable({
     processing: true,
     serverSide: true,
     ajax: "{{route('areas.list')}}",
     pageLength: 5,
     lengthMenu: [ 5, 25, 50 ],
     columns: [
        { data: 'id', class: 'text-center' },
        { data: 'name', class: 'text-left' },
        { data: 'in_monitor', class: 'text-left' },
        { data: 'enabled', class: 'text-left' },
        { data: 'tools', class: 'text-center text-nowrap', orderable: false}
    ],
    order: [[ 0, "desc" ]],
    language: dLanguage
  });
</script>
@endsection