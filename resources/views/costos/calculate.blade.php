@extends('layouts.app', ['title' => 'Crear Tarjeta de costo'])

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Crear Tarjeta de Costo</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="{{route('card_cost.store', ['id' => $ot->id])}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-2 form-group">
              <label class="col-form-label">Número de Orden</label>
              <input type="text" class="form-control" disabled="" value="OT-{{zerosatleft($ot->id, 3)}}">
            </div>
            <div class="col-md-5 form-group">
              <label class="col-form-label">Razón social</label>
              <input type="text" class="form-control" disabled="" value="{{$ot->razon_social}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Solped</label>
              <input type="text" class="form-control" readonly="" value="{{$ot->solped}}">
            </div>
            <div class="col-md-3 col-xl-3 form-group">
              <label class="col-form-label">Fecha</label>
              <input type="date" class="form-control" readonly="" value="{{date('Y-m-d')}}">
            </div>
          </div>
          <div class="row">
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Equipo</label>
              <input type="text" class="form-control telefono_contacto" name="equipo" value="{{$ot->nro_equipo}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Código</label>
              <input type="text" class="form-control" name="codigo" readonly="" value="{{$ot->codigo_motor}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Hecha por</label>
              <input type="text" class="form-control @error('hecho_por') is-invalid @enderror" name="hecho_por" value="{{old('hecho_por')}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Número</label>
              <input type="text" class="form-control" name="numero">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">HP/KW</label>
              <input type="text" class="form-control" value="{{$ot->hp_kw}}" name="kw">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Conexión</label>
              <input type="text" class="form-control" name="conexion" value="{{$ot->conex}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Placa</label>
              <input type="text" class="form-control" name="placa" value="{{$ot->placa_caract_orig}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Voltios</label>
              <input type="text" class="form-control" name="voltios" value="{{$ot->voltaje}}" readonly="">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">N° salidas</label>
              <input type="text" class="form-control" name="nro_salidas" value="">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Modelo</label>
              <input type="text" class="form-control" name="modelo" readonly="" value="{{$ot->modelo}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Amperios</label>
              <input type="text" class="form-control" name="amperios" value="{{$ot->amperaje}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Frecuencia</label>
              <input type="text" class="form-control" name="frecuencia" value="{{$ot->frecuencia}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">N° serie</label>
              <input type="text" class="form-control" name="nro_serie" value="{{$ot->serie}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">RPM</label>
              <input type="text" class="form-control" name="rpm" value="{{$ot->rpm}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Tipo</label>
              <input type="text" class="form-control" name="tipo" value="">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Marca</label>
              <input type="text" class="form-control" name="marca" readonly="" value="{{$ot->marca}}">
            </div>
            <div class="col-md-3 col-xl-2 form-group">
              <label class="col-form-label">Frame</label>
              <input type="text" class="form-control" name="frame" value="{{$ot->frame}}">
            </div>
          </div>
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
              <table class="table table-separate table-bordered table-numbering mb-0" id="table-tap">
                <thead class="text-center">
                     <tr>
                        <th class="py-1 px-2" width="50">ITEM</th>
                        <th class="py-1"> </th>
                        <th class="py-1">PERSONAL</th>
                        <th class="py-1">INGRESO</th>
                        <th class="py-1">SALIDA</th>
                        <th class="py-1"> </th>
                        <th class="py-1">TOTAL</th>
                     </tr>
                </thead>
                <tbody>
                  <tr class="empty-services text-center">
                    <td colspan="7">Seleccione un area</td>
                  </tr>
                </tbody>
           </table>
           <input class="form-control d-none" type="text" name="cost_card_service" value="{{old('cost_card_service')}}" readonly="">
            @error('cost_card_service')
              <p class="error-message text-danger">{{ $message }}</p>
            @enderror
           <div class="text-danger text-center p-1 bg-light my-2">
             <span>DEFLEXION: 0.04 mm</span>
           </div>
            </div>
            <div class="col-md-5 col-xl-4">
              <table class="table table-costs">
                <tbody>
                  <tr>
                    <td class="px-2 py-1">COSTO:</td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost') is-invalid @enderror" placeholder="" value="0" readonly="" name="cost">
                    </td>
                  </tr>
                  <tr>
                    <td class="px-2 py-1"></td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost_m1') is-invalid @enderror" placeholder="" value="0" readonly="" name="cost_m1">
                    </td>
                  </tr>
                  <tr>
                    <td class="px-2 py-1"></td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost_m2') is-invalid @enderror" placeholder="" value="0" readonly="" name="cost_m2">
                    </td>
                  </tr>
                  <tr>
                    <td class="px-2 py-1"></td>
                    <td class="px-2 py-1">
                      <input type="text" class="form-control text-right @error('cost_m3') is-invalid @enderror" placeholder="" value="0" readonly="" name="cost_m3">
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
                    <td class="px-2 py-1"><input type="date" class="form-control" value="{{date('Y-m-d')}}" readonly="" name=""></td>
                    <td class="px-2 py-1"><input type="text" class="form-control" value="" readonly="" name=""></td>
                    <td class="px-2 py-1"><input type="date" class="form-control" value="{{date('Y-m-d')}}" readonly="" name=""></td>
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
              $('.empty-services').remove();
              $('#table-tap tbody').append(
                  '<tr class="row-area" data-areaid="'+area+'">'+
                        '<td class="bg-info cell-counter text-center" width="50"><span class="number"></span></td>'+
                        '<td class="bg-info" width="200">'+option_selected.text()+'</td>'+
                        '<td class="bg-info"><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="personal" value=""></td>'+
                        '<td class="bg-info"><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="ingreso" value=""></td>'+
                        '<td class="bg-info"><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="salida" value=""></td>'+
                        '<td class="bg-info"><input type="number" placeholder="S/ " class="form-control frm-sinput text-right" name="subtotal" data-areaid="'+area+'" value=""></td>'+
                        '<td class="bg-info" width="50"> </td>'+
                     '</tr>'
                  )
              $.each(services, function (id, item) {
                //console.log(id)
                $('#table-tap tbody').append(
                  '<tr data-serviceid="'+item.id+'">'+
                        '<td width="50"></td>'+
                        '<td width="200">'+item.name+'</td>'+
                        '<td><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="personal" value=""></td>'+
                        '<td><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="ingreso" value=""></td>'+
                        '<td width="100"><input type="text" class="form-control frm-sinput" data-areaid="'+area+'" name="salida" value=""></td>'+
                        '<td width="100"><input type="number" placeholder="S/ " class="form-control frm-sinput text-right" name="subtotal" data-areaid="'+area+'" value=""></td>'+
                        '<td width="100">'
                        +((id == s_length - 1) ? '<input type="number" placeholder="S/ " class="form-control frm-sinput text-right" name="areasubtotal" data-areaid="'+area+'" value="">' : '')+
                        '</td>'+
                     '</tr>'
                  );
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
      $('.frm-sinput').bind('keyup mouseup', function () {
        var sinput = $(this), areaid = sinput.attr('data-areaid');
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

        var json = '{';
        var otArr = [];
        var tbl2 = $('#table-tap tbody tr').each(function(i, tr_item) {
          x = $(this).children();
          var itArr = [];
          var notempty = false;
          x.each(function(cell_id, cell_item) {
            var cparent = $(cell_item).parent();
            var personal = cparent.find('[name="personal"]');
            var ingreso = cparent.find('[name="ingreso"]');
            var salida = cparent.find('[name="salida"]');
            var subtotal = $(cell_item).find('[name="subtotal"]');
              if (subtotal.length && subtotal.val().length) {
                notempty = true;
                itArr.push(
                  '"personal": "'+personal.val() + '", "ingreso": "' +ingreso.val() + '", "salida": "' + salida.val() + '", "subtotal": "' + subtotal.val() + '"');
              }
          });
          if (notempty) {
            var itemid = $(tr_item).attr('data-areaid') ? '"area": "'+$(tr_item).attr('data-areaid') : '"service": "'+$(tr_item).attr('data-serviceid');
            otArr.push('"' + i + '": {'+ itemid +'", '+ itArr.join(',') + '}');
          }
        })
        json += otArr + '}'
        parse_json = JSON.stringify(JSON.parse(json), null, '\t');
        $('input[name=cost_card_service]').val(parse_json);
        return json;
      })
    }

  })
</script>
@endsection