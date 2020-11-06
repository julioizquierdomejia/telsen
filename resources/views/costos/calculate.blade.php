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
                        <th class="py-1">TOTAL</th>
                     </tr>
                </thead>
                <tbody>
                     
                </tbody>
           </table>
           <div class="text-danger text-center p-3">
             <span>DEFLEXION: 0.04 mm</span>
           </div>
            </div>
            <div class="col-md-5 col-xl-4">
              <table class="table table-costs">
                <tbody>
                  <tr>
                    <td class="px-2 py-1">COSTO:</td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost') is-invalid @enderror" placeholder="" value="" readonly="" name="cost">
                    </td>
                  </tr>
                  <tr>
                    <td class="px-2 py-1"></td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost_m1') is-invalid @enderror" placeholder="" value="" readonly="" name="cost_m1">
                    </td>
                  </tr>
                  <tr>
                    <td class="px-2 py-1"></td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost_m2') is-invalid @enderror" placeholder="" value="" readonly="" name="cost_m2">
                    </td>
                  </tr>
                  <tr>
                    <td class="px-2 py-1"></td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost_m3') is-invalid @enderror" placeholder="" value="" readonly="" name="cost_m3">
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-md-7 col-xl-8">
              <table class="table table-costs table-bordered">
                <thead class="text-center">
                  <tr>
                    <td class="px-2 py-1" colspan="2">INFORME:</td>
                    <td class="px-2 py-1" colspan="2">PPTO - COTIZ.</td>
                    <td class="px-2 py-1" rowspan="2">MONTO</td>
                  </tr>
                  <tr>
                    <td class="px-2 py-1">FECHA:</td>
                    <td class="px-2 py-1">INFORM</td>
                    <td class="px-2 py-1">FECHA</td>
                    <td class="px-2 py-1">COT-PPTO</td>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="px-2 py-1"><input type="text" class="form-control" value="" readonly="" name=""></td>
                    <td class="px-2 py-1"><input type="text" class="form-control" value="" readonly="" name=""></td>
                    <td class="px-2 py-1"><input type="text" class="form-control" value="" readonly="" name=""></td>
                    <td class="px-2 py-1"><input type="text" class="form-control" value="" readonly="" name=""></td>
                    <td class="px-2 py-1"><input type="text" class="form-control" value="" readonly="" name=""></td>
                  </tr>
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
              var services = $.parseJSON(response.data), s_length = services.length;
              $.each(services, function (id, item) {
                //console.log(id)
                if (id == 0) {
                  $('#table-tap tbody').append(
                  '<tr class="row-area" data-areaid="'+area+'">'+
                        '<td class="bg-info cell-counter"><span class="number"></span></td>'+
                        '<td class="bg-info" width="200">'+option_selected.text()+'</td>'+
                        '<td class="bg-info"><input type="text" class="form-control" name="personal" value=""></td>'+
                        '<td class="bg-info"><input type="text" class="form-control" name="ingreso" value=""></td>'+
                        '<td class="bg-info"><input type="text" class="form-control" name="salida" value=""></td>'+
                        '<td class="bg-info"><input type="number" placeholder="S/ " class="form-control text-right" name="subtotal" data-areaid="'+area+'" value=""></td>'+
                        '<td class="bg-info" width="50"> </td>'+
                     '</tr>'
                  )
                } else {
                  $('#table-tap tbody').append(
                  '<tr data-areaid="'+area+'">'+
                        '<td></td>'+
                        '<td width="200">'+item.name+'</td>'+
                        '<td><input type="text" class="form-control" name="personal" value=""></td>'+
                        '<td><input type="text" class="form-control" name="ingreso" value=""></td>'+
                        '<td width="100"><input type="text" class="form-control" name="salida" value=""></td>'+
                        '<td width="100"><input type="number" placeholder="S/ " class="form-control text-right" name="subtotal" data-areaid="'+area+'" value=""></td>'+
                        '<td width="100">'
                        +((id == s_length - 1) ? '<input type="number" placeholder="S/ " class="form-control text-right" name="areasubtotal" data-areaid="'+area+'" value="">' : '')+
                        '</td>'+
                     '</tr>'
                  );
                }
              })

              if (services.length) {
                option_selected.attr('disabled', true);
                getServicesSum();
              }
            }
          },
          error: function (request, status, error) {
            
          }
      });
      }
    })

    function getServicesSum() {
      $('[name=subtotal]').keyup(function () {
        var $this = $(this), areaid = $this.attr('data-areaid');
        var items = $('[name="subtotal"][data-areaid='+areaid+']');
        var subtotal_items = $('[name="subtotal"]');
        var total = 0;
        $.each(items, function (id, item) {
          total += $(item).val() << 0;
        })
        $('[name="areasubtotal"][data-areaid='+areaid+']').val(total);

        var totals = 0;
        $.each(subtotal_items, function (id, item) {
          totals += $(item).val() << 0;
        })
        $('[name="cost"]').val(totals);
        $('[name="cost_m1"]').val(totals + (totals / 2));
        $('[name="cost_m2"]').val(totals + (totals * .75));
        $('[name="cost_m3"]').val(totals * 2);
      })
    }
  })
</script>
@endsection