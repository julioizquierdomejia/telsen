@php
  $ot_code = zerosatleft($formato->ot_code, 3);
@endphp
@extends('layouts.app', ['title' => 'Evaluación Mecánica de OT N° '.$ot_code])
@section('content')
@php
$statuses = array_column($ot_status->toArray(), "name");
$status_last = $ot_status->last();

$role_names = validateActionbyRole();
$admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
$evaluador = in_array("evaluador", $role_names);
$aprobador = in_array("aprobador_de_evaluaciones", $role_names);
@endphp
<div class="row">
	<div class="col-md-12">
		<div class="card form-card">
			<div class="card-header">
				<h4 class="card-title d-flex align-items-center justify-content-between">
					<span>Evaluación Mecánica</span>
					<span class="card-title-buttons">
					@if($admin || $evaluador)
						@if(!in_array('me_approved', $statuses) && !in_array('me_disapproved', $statuses))
						<a class="btn btn-primary btn-round" href="{{route('formatos.mechanical.edit', $formato->id)}}">Editar <i class="fa fa-edit"></i></a>
						@endif
					@endif
					@if ($admin || $aprobador)
						@if(in_array('me_approved', $statuses))
			            <button type="button" class="btn btn-success mt-0">Aprobada</button>
			            @elseif(in_array('me_disapproved', $statuses))
			            <button type="button" class="btn btn-danger mt-0">Desaprobada</button>
			            @else
			            <button type="button" class="btn btn-primary mt-0" data-toggle="modal" data-target="#modalAprobar">Aprobar</button>
			            @endif
			        @endif
					</span>
				</h4>
				@if($maded_by)
		        <p class="mb-0 mt-2 py-2 bg-light row mx-0 justify-content-between">
		          <span class="col-auto">Hecho por: {{ $maded_by->{'name'} }}</span>
		          @if($approved_by)
		            <span class="col-auto">{{in_array('me_approved', $statuses) ? 'Aprobado por:' : 'Desaprobado por:'}} {{ $approved_by->{'name'} }}</span>
		            @endif
		        </p>
		        @endif
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-6 col-md-3 form-group">
						<label class="c-label">OT</label>
						<p class="mb-0">OT-{{$ot_code}}</p>
					</div>
					<div class="col-6 col-md-3 form-group">
						<label class="c-label">Fecha de creación</label>
						<p class="mb-0">{{date('d-m-Y', strtotime($formato->created_at))}}</p>
					</div>
					<div class="col-6 col-md-3 form-group">
						<label class="c-label">Máquina</label>
						<p>{{$formato->maquina ?? '-'}}</p>
					</div>
					<div class="col-6 col-md-3 form-group">
						<label class="c-label">RPM</label>
						<p class="mb-0">{{$formato->rpm ?? '-'}}</p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">HP/KW</label>
						<p class="mb-0">{{$formato->hp_kw ?? '-'}}</p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Serie</label>
						<p class="mb-0">{{$formato->serie ?? '-'}}</p>
					</div>
					<div class="col-12">
						<h4 class="second-title text-danger py-2">Estado de recepción</h4>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Placa Caract Orig</label>
						<p class="mb-1"><span class="badge align-middle mr-2 px-3 py-1{{$formato->placa_caract_orig_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->placa_caract_orig_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->placa_caract_orig ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Tapas</label>
						<p class="mb-0"><span class="badge align-middle mr-2 px-3 py-1{{$formato->tapas_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->tapas_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->tapas ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Ventilador</label>
						<p class="mb-0"><span class="badge align-middle mr-2 px-3 py-1{{$formato->ventilador_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->ventilador_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->ventilador ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Caja Conexión</label>
						<p class="mb-0"><span class="badge align-middle mr-2 px-3 py-1{{$formato->caja_conexion_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->caja_conexion_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->caja_conexion ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Ejes</label>
						<p class="mb-0"><span class="badge align-middle mr-2 px-3 py-1{{$formato->ejes_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->ejes_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->ejes ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Acople</label>
						<p class="mb-0"><span class="badge align-middle mr-2 px-3 py-1{{$formato->acople_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->acople_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->acople ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Bornera</label>
						<p class="mb-0"><span class="badge align-middle mr-2 px-3 py-1{{$formato->bornera_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->bornera_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->bornera ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Fundas</label>
						<p class="mb-0"><span class="badge align-middle mr-2 px-3 py-1{{$formato->fundas_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->fundas_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->fundas ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Chaveta</label>
						<p class="mb-0"><span class="badge align-middle mr-2 px-3 py-1{{$formato->chaveta_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->chaveta_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->chaveta ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Impro Seal</label>
						<p class="mb-0"><span class="badge align-middle mr-2 px-3 py-1{{$formato->impro_seal_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->impro_seal_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->impro_seal ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Laberintos</label>
						<p class="mb-0"><span class="badge align-middle mr-2 px-3 py-1{{$formato->laberintos_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->laberintos_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->laberintos ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Estator</label>
						<p class="mb-0"><span class="badge align-middle mr-2 px-3 py-1{{$formato->estator_has == "1" ? ' badge-success' : ' badge-danger'}}">{{$formato->estator_has == "1" ? 'Sí ' : 'No '}}</span><span class="align-middle">{{$formato->estator ?? '-'}}</span></p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Slam muelle p1</label>
						<p class="mb-0">{{$formato->slam_muelle_p1 ?? '-'}}</p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Slam muelle p2</label>
						<p class="mb-0">{{$formato->slam_muelle_p2 ?? '-'}}</p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Resortes contra tapas</label>
						<p class="mb-0">{{$formato->resortes_contra_tapas ?? '-'}}</p>
					</div>
					<div class="col-6 col-md-4 col-lg-3 form-group">
						<label class="c-label">Alieneamiento paquete</label>
						<p class="mb-0">{{$formato->alineamiento_paquete ?? '-'}}</p>
					</div>
					<div class="col-12">
						<h4 class="second-title text-danger py-2">ROTOR:</h4>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Deplexion eje</label>
						<p class="mb-0">{{$formato->rotor_deplexion_eje ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Valor balanceo</label>
						<p class="mb-0">{{$formato->rotor_valor_balanceo ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Cod rodaje p1</label>
						<p class="mb-0">{{$formato->rotor_cod_rodaje_p1 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Cod rodaje p2</label>
						<p class="mb-0">{{$formato->rotor_cod_rodaje_p2 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Asiento rodaje p1</label>
						<p class="mb-0">{{$formato->rotor_asiento_rodaje_p1 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Asiento rodaje p2</label>
						<p class="mb-0">{{$formato->rotor_asiento_rodaje_p2 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Eje zona acople p1</label>
						<p class="mb-0">{{$formato->rotor_eje_zona_acople_p1 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Eje zona acople p2</label>
						<p class="mb-0">{{$formato->rotor_eje_zona_acople_p2 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Medida chaveta p1</label>
						<p class="mb-0">{{$formato->rotor_medida_chaveta_p1 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Medida chaveta p2</label>
						<p class="mb-0">{{$formato->rotor_medida_chaveta_p2 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Canal chaveta p1</label>
						<p class="mb-0">{{$formato->rotor_canal_chaveta_p1 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Canal chaveta p2</label>
						<p class="mb-0">{{$formato->rotor_canal_chaveta_p2 ?? '-'}}</p>
					</div>
					<div class="col-12">
						<h4 class="second-title text-danger py-2">Estator</h4>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Estator alojamiento rodaje tapa p10</label>
						<p class="mb-0">{{$formato->estator_alojamiento_rodaje_tapa_p10 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Estator alojamiento rodaje tapa p20</label>
						<p class="mb-0">{{$formato->estator_alojamiento_rodaje_tapa_p20 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Estator pestana tapa p1</label>
						<p class="mb-0">{{$formato->estator_pestana_tapa_p1 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Estator pestana tapa p2</label>
						<p class="mb-0">{{$formato->estator_pestana_tapa_p2 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Estator contra tapa interna p1</label>
						<p class="mb-0">{{$formato->estator_contra_tapa_interna_p1 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Estator contra tapa interna p2</label>
						<p class="mb-0">{{$formato->estator_contra_tapa_interna_p2 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Estator contra tapa externa p1</label>
						<p class="mb-0">{{$formato->estator_contra_tapa_externa_p1 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Estator contra tapa externa p2</label>
						<p class="mb-0">{{$formato->estator_contra_tapa_externa_p2 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Ventilador 0</label>
						<p class="mb-0">{{$formato->estator_ventilador_0 ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Estator alabes</label>
						<p class="mb-0">{{$formato->estator_alabes ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Estator caja conexión</label>
						<p class="mb-0">{{$formato->estator_caja_conexion ?? '-'}}</p>
					</div>
					<div class="col-6 col-sm-6 col-lg-3 form-group">
						<label class="c-label">Estator tapa conexión</label>
						<p class="mb-0">{{$formato->estator_tapa_conexion ?? '-'}}</p>
					</div>
					<div class="col-md-12 form-group">
						<h4 class="h6 text-center mb-0"><strong>Trabajos</strong></h4>
						<div class="table-responsive">
						<table class="table table-tap table-separate text-center table-numbering mb-0" id="table-tap">
							<thead>
								<tr>
									<th class="text-center py-1">Item</th>
									<th class="text-center py-1">Área</th>
									<th class="text-center py-1">Tarea</th>
									<th class="text-center py-1">Descripción</th>
									<th class="text-center py-1">Medidas</th>
									<th class="text-center py-1">Cantidad</th>
									<th class="text-center py-1">Personal</th>
								</tr>
							</thead>
							<tbody>
								@if($works->count())
								@foreach($works as $key => $work)
								<tr>
									<td class="cell-counter"><span class="number"></span></td>
									<td><span class="form-control h-auto mt-0">{{$work->area}}</span></td>
									<td><span class="form-control h-auto mt-0">{{$work->service}}</span></td>
									<td><span class="form-control h-auto mt-0">{{$work->description}}</span></td>
									<td><span class="form-control h-auto mt-0">{{$work->medidas}}</span></td>
									<td><span class="form-control h-auto mt-0">{{$work->qty}}</span></td>
									<td><span class="form-control h-auto mt-0">{{$work->personal}}</span></td>
								</tr>
								@endforeach
								@else
								<tr>
									<td class="text-center" colspan="7">No se agregaron trabajos</td>
								</tr>
								@endif
							</tbody>
						</table>
						</div>
					</div>
					<div class="col-md-12 form-group">
						<label class="c-label">Observaciones</label>
						<div class="text">
							{{$formato->observaciones ?? '-'}}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card form-card">
	      <div class="card-header">
	        <h4 class="second-title text-danger py-2">Galería</h4>
	      </div>
	      <div class="card-body">
	          <div class="gallery">
	            @if($gallery->count())
	            <ul class="row list-unstyled">
	            @foreach($gallery as $file)
	            <li class="gallery-item col-12 col-md-4 col-xl-3 py-2">
	              <img class="btn p-0" data-toggle="modal" data-target="#galleryModal" src="{{ asset("uploads/ots/$formato->ot_id/mechanical/$file->name") }}" width="250">
	            </li>
	            @endforeach
	            </ul>
	            @else
	            <p class="text-center">No se agregaron imágenes.</p>
	            @endif
	          </div>
	      </div>
	    </div>
	</div>
</div>
@if(!in_array('me_approved', $statuses) || !in_array('me_disapproved', $statuses))
<div class="modal fade" tabindex="-1" id="modalAprobar">
    <div class="modal-dialog confirmar_eval">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Aprobar Evaluación Mecánica</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body">
            <p class="text-center my-3">¿Confirma aprobación de evaluación mecánica  para OT-{{$ot_code}}?</p>
        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-primary btn-sm px-md-5" data-action="1">Aprobar</button>
          @if (env('SHOW_BOTH_APPROVATIONS', true))
          <button type="button" class="btn btn-secondary btn-sm px-md-5" data-action="2">No Aprobar</button>
          @endif
        </div>
    </div>
  </div>
</div>
@endif
<div class="modal fade" tabindex="-1" id="galleryModal">
    <div class="modal-dialog modal-lg" style="max-height: calc(100vh - 40px)">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Galería</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <div class="modal-body h-100 text-center">
            <img class="image img-fluid" src="" width="600">
        </div>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script>
  $(document).ready(function () {
    $('.confirmar_eval .btn').click(function () {
      var action = $(this).data('action');
      $.ajax({
          type: "post",
          url: "{{route('formatos.mechanical.approve', $formato->ot_id)}}",
          data: {
            _token: '{{csrf_token()}}',
            action: action
          },
          beforeSend: function (data) {
            
          },
          success: function (response) {
            if(response.success) {
              $('#modalAprobar').modal('hide');
              setTimeout(function () {
                location.reload();
              }, 200)
            } else if(response.data) {
              $('.confirmar_eval .btn').attr('disabled', true);
            }
          },
          error: function (request, status, error) {
            var data = jQuery.parseJSON(request.responseText);
            console.log(data);
          }
      });
    })

    $('#galleryModal').on('show.bs.modal', function (event) {
    	$('#galleryModal .modal-body .image').attr('src', $(event.relatedTarget).attr('src'))
    })
  })
</script>
@endsection