@extends('layouts.app', ['title' => 'Crear Taller'])
@section('css')
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <h5 class="h5">Taller para OT-{{zerosatleft($ot->id, 3)}}</h5>
    <form class="form-group" method="POST" action="/talleres" enctype="multipart/form-data">
    @csrf
    @foreach($areas as $area)
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">{{$area->name}}</h5>
      </div>
      <div class="card-body">
          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Crear</button>
            </div>
          </div>
      </div>
    </div>
    @endforeach
    </form>
  </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
$(document).ready(function(){
$('#selectRuc').change(function () {
var $this = $(this), val = $this.val(), selected = $this.find('option:selected');
if (!val) {
$('.razon_social').val("");
$('.direccion').val("");
$('.telefono').val("");
$('.celular').val("");
$('.tipocliente').val("");
$('.telefono_contacto').val("");
return;
}
$('.razon_social').val(selected.data('rs'));
$('.direccion').val(selected.data('dir'));
$('.telefono').val(selected.data('tel'));
$('.celular').val(selected.data('celular'));
$('.telefono_contacto').val(selected.data('contacto'));
$('.tipocliente').val(selected.data('type'));
/*$.ajax({
url: "/clientes/"+val+"/ver",
data: {},
type: 'GET',
beforeSend: function () {
},
complete: function () {
},
success: function (response) {
$('.razon_social').val(response.razon_social);
$('.direccion').val(response.direccion);
$('.telefono').val(response.telefono);
$('.celular').val(response.celular);
$('.telefono_contacto').val(response.telefono_contacto);
},
error: function (request, status, error) { // if error occured
}
});*/
})
})
</script>
@endsection