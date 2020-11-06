@extends('layouts.app', ['title' => 'Crear Tarjeta de costo'])

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Crear Tarjeta de Costo</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="/tarjeta-costo" enctype="multipart/form-data">
          @csrf
          <div class="row">
          	<div class="col-md-6">
              <div class="form-group">
                <label class="col-form-label">Area</label>
                <select name="area_id" class="form-control @error('area_id') is-invalid @enderror dropdown2" id="selectArea">
                <option value="">Selecciona el area</option>
                @foreach($areas as $area)
                  <option value="{{ $area->id }}" {{old('area_id') == $area->id ? 'selected' : ''}}>{{ $area->name }}</option>
                @endforeach
              </select>
              </div>
          			@error('name')
          				<p class="error-message text-danger">{{ $message }}</p>
          			@enderror
            </div>
            <div class="col-md-3 ml-md-auto form-group">
              <label class="col-form-label">Estado</label>
              <select name="enabled" class="form-control @error('enabled') is-invalid @enderror dropdown2" id="selectEstado">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>

            <div class="col-md-12">
              <table class="table table-separate table-bordered text-center table-numbering mb-0" id="table-tap">
                <thead>
                     <tr>
                        <th class="py-1">ITEM</th>
                        <th class="py-1"> </th>
                        <th class="py-1">PERSONAL</th>
                        <th class="py-1">INGRESO</th>
                        <th class="py-1">SALIDA</th>
                        <th class="py-1"> </th>
                        <th class="py-1"> </th>
                     </tr>
                </thead>
                <tbody>
                     
                </tbody>
           </table>
            </div>
          </div>

          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Enviar</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $(document).ready(function () {
    $('#selectArea').change(function () {
      var $this = $(this), area = $('#selectArea').val();
      var token = '{{csrf_token()}}';
      var option_selected = $this.find('option:selected');
      if ($this.val()) {
        $.ajax({
          type: "GET",
          url: "/tarjeta-costo/filterareas",
          data: {id: area, _token:token},
          success: function (response) {
            if (response.success) {
              option_selected.attr('disabled', true);
              var services = $.parseJSON(response.data), s_length = services.length;
              $.each(services, function (id, item) {
                //console.log(id)
                if (id == 0) {
                  $('#table-tap tbody').append(
                  '<tr class="row-area">'+
                        '<td class="cell-counter"><span class="number"></span></td>'+
                        '<td class="bg-info" width="200">'+option_selected.text()+'</td>'+
                        '<td><input type="text" class="form-control" name="personal" value=""></td>'+
                        '<td><input type="text" class="form-control" name="ingreso" value=""></td>'+
                        '<td><input type="text" class="form-control" name="salida" value=""></td>'+
                        '<td><input type="number" placeholder="S/ " class="form-control" name="subtotal" value=""></td>'+
                        '<td width="50"> </td>'+
                     '</tr>'
                  )
                } else {
                  $('#table-tap tbody').append(
                  '<tr>'+
                        '<td></td>'+
                        '<td width="200">'+item.name+'</td>'+
                        '<td><input type="text" class="form-control" name="personal" value=""></td>'+
                        '<td><input type="text" class="form-control" name="ingreso" value=""></td>'+
                        '<td width="100"><input type="text" class="form-control" name="salida" value=""></td>'+
                        '<td width="100"><input type="number" placeholder="S/ " class="form-control" name="subtotal" value=""></td>'+
                        '<td width="100">'
                        +((id == s_length - 1) ? '<input type="number" placeholder="S/ " class="form-control" name="subtotal" value="">' : '')+
                        '</td>'+
                     '</tr>'
                  );
                }
              })
            }
          },
          error: function (request, status, error) {
            
          }
      });
      }
    })
  })
</script>
@endsection