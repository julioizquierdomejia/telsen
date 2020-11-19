@extends('layouts.app', ['title' => 'Evaluación Mecánica'])
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-user form-card">
      <div class="card-header">
        <h5 class="card-title">Evaluación Mecánica</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="{{route('formatos.mechanical.store', ['id' => $ot->id])}}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">OT</label>
              <input type="text" class="form-control" readonly="" value="OT-{{zerosatleft($ot->id, 3)}}">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Fecha de creación</label>
              <input type="date" class="form-control" disabled="" value="{{date('Y-m-d')}}">
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">Máquina</label>
              <input type="text" class="form-control @error('maquina') is-invalid @enderror" placeholder="Máquina" value="{{old('maquina')}}" name="maquina">
              @error('maquina')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-3 form-group">
              <label class="col-form-label">RPM</label>
              <input type="text" class="form-control @error('rpm') is-invalid @enderror" placeholder="RPM" value="{{old('rpm')}}" name="rpm">
              @error('rpm')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">HP/KW</label>
              <input type="text" class="form-control @error('hp_kw') is-invalid @enderror" placeholder="HP/KW" value="{{old('hp_kw')}}" name="hp_kw">
              @error('hp_kw')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Serie</label>
              <input type="text" class="form-control @error('serie') is-invalid @enderror" placeholder="Serie" value="{{old('serie')}}" name="serie">
              @error('serie')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-12">
              <h4>Estado de recepción</h4>
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Placa Caract Orig</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('placa_caract_orig_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="placa_caract_orig_has" {{old('placa_caract_orig_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="placa_caract_orig_has" {{old('placa_caract_orig_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('placa_caract_orig') is-invalid @enderror" placeholder="Placa Caract Orig" value="{{old('placa_caract_orig')}}" name="placa_caract_orig">
              </div>
              @error('placa_caract_orig')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Tapas</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('tapas_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="tapas_has" {{old('tapas_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="tapas_has" {{old('tapas_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('tapas') is-invalid @enderror" placeholder="Tapas" value="{{old('tapas')}}" name="tapas">
              </div>
              @error('tapas')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Ventilador</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('ventilador_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="ventilador_has" {{old('ventilador_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="ventilador_has" {{old('ventilador_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('ventilador') is-invalid @enderror" placeholder="Ventilador" value="{{old('ventilador')}}" name="ventilador">
              </div>
              @error('ventilador')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Caja Conexión</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('caja_conexion_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="caja_conexion_has" {{old('caja_conexion_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="caja_conexion_has" {{old('caja_conexion_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('caja_conexion') is-invalid @enderror" placeholder="Caja Conexión" value="{{old('caja_conexion')}}" name="caja_conexion">
              </div>
              @error('caja_conexion')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Ejes</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('ejes_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="ejes_has" {{old('ejes_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="ejes_has" {{old('ejes_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('ejes') is-invalid @enderror" placeholder="Ejes" value="{{old('ejes')}}" name="ejes">
              </div>
              @error('ejes')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Acople</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('acople_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="acople_has" {{old('acople_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="acople_has" {{old('acople_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('acople') is-invalid @enderror" placeholder="Acople" value="{{old('acople')}}" name="ejes">
              </div>
              @error('acople')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Bornera</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('bornera_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="bornera_has" {{old('bornera_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="bornera_has" {{old('bornera_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('bornera') is-invalid @enderror" placeholder="Bornera" value="{{old('bornera')}}" name="ejes">
              </div>
              @error('bornera')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Fundas</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('fundas_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="fundas_has" {{old('fundas_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="fundas_has" {{old('fundas_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('fundas') is-invalid @enderror" placeholder="Bornera" value="{{old('fundas')}}" name="ejes">
              </div>
              @error('fundas')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Chaveta</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('chaveta_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="chaveta_has" {{old('chaveta_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="chaveta_has" {{old('chaveta_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('chaveta') is-invalid @enderror" placeholder="Bornera" value="{{old('chaveta')}}" name="ejes">
              </div>
              @error('chaveta')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Impro Seal</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('impro_seal_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="impro_seal_has" {{old('impro_seal_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="impro_seal_has" {{old('impro_seal_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('impro_seal') is-invalid @enderror" placeholder="Bornera" value="{{old('impro_seal')}}" name="ejes">
              </div>
              @error('impro_seal')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Laberintos</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('laberintos_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="laberintos_has" {{old('laberintos_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="laberintos_has" {{old('laberintos_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('laberintos') is-invalid @enderror" placeholder="Bornera" value="{{old('laberintos')}}" name="ejes">
              </div>
              @error('laberintos')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Estator</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('estator_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="estator_has" {{old('estator_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="estator_has" {{old('estator_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('estator') is-invalid @enderror" placeholder="Bornera" value="{{old('estator')}}" name="ejes">
              </div>
              @error('estator')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Slam muelle p1</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('slam_muelle_p1_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="slam_muelle_p1_has" {{old('slam_muelle_p1_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="slam_muelle_p1_has" {{old('slam_muelle_p1_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('slam_muelle_p1') is-invalid @enderror" placeholder="Bornera" value="{{old('slam_muelle_p1')}}" name="ejes">
              </div>
              @error('slam_muelle_p1')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Slam muelle p2</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('slam_muelle_p2_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="slam_muelle_p2_has" {{old('slam_muelle_p2_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="slam_muelle_p2_has" {{old('slam_muelle_p2_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('slam_muelle_p2') is-invalid @enderror" placeholder="Bornera" value="{{old('slam_muelle_p2')}}" name="ejes">
              </div>
              @error('slam_muelle_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Resortes contra tapas</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('resortes_contra_tapas_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="resortes_contra_tapas_has" {{old('resortes_contra_tapas_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="resortes_contra_tapas_has" {{old('resortes_contra_tapas_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('resortes_contra_tapas') is-invalid @enderror" placeholder="Bornera" value="{{old('resortes_contra_tapas')}}" name="ejes">
              </div>
              @error('resortes_contra_tapas')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-md-4 col-lg-3 form-group">
              <label class="col-form-label">Alieneamiento paquete</label>
              <div class="d-flex">
                <ul class="form-check-list list-inline mb-0 col-7 @error('alineamiento_paquete_has') is-invalid @enderror">
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="1" name="alineamiento_paquete_has" {{old('alineamiento_paquete_has') == "1" ? 'checked' : ''}}><span class="align-middle">Sí</span>
                    </label>
                  </li>
                  <li class="form-check-inline">
                    <label class="form-check-label">
                      <input type="radio" class="form-check-input align-middle" value="0" name="alineamiento_paquete_has" {{old('alineamiento_paquete_has') == "0" ? 'checked' : ''}}><span class="align-middle">No</span>
                    </label>
                  </li>
                </ul>
                <input type="text" class="form-control col-5 @error('alineamiento_paquete') is-invalid @enderror" placeholder="Bornera" value="{{old('alineamiento_paquete')}}" name="ejes">
              </div>
              @error('alineamiento_paquete')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-12">
              <h4>ROTOR:</h4>
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Rotor deplexion eje</label>
              <input type="text" class="form-control @error('rotor_deplexion_eje') is-invalid @enderror" placeholder="Rotor deplexion eje" value="{{old('rotor_deplexion_eje')}}" name="rotor_deplexion_eje">
              @error('rotor_deplexion_eje')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Rotor valor balanceo</label>
              <input type="text" class="form-control @error('rotor_valor_balanceo') is-invalid @enderror" placeholder="Rotor valor balanceo" value="{{old('rotor_valor_balanceo')}}" name="rotor_valor_balanceo">
              @error('rotor_valor_balanceo')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Rotor cod rodaje p1</label>
              <input type="text" class="form-control @error('rotor_cod_rodaje_p1') is-invalid @enderror" placeholder="Rotor cod rodaje p1" value="{{old('rotor_cod_rodaje_p1')}}" name="rotor_cod_rodaje_p1">
              @error('rotor_cod_rodaje_p1')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Rotor cod rodaje p2</label>
              <input type="text" class="form-control @error('rotor_cod_rodaje_p2') is-invalid @enderror" placeholder="Rotor cod rodaje p2" value="{{old('rotor_cod_rodaje_p2')}}" name="rotor_cod_rodaje_p2">
              @error('rotor_cod_rodaje_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Rotor asiento rodaje p1</label>
              <input type="text" class="form-control @error('rotor_asiento_rodaje_p1') is-invalid @enderror" placeholder="Rotor asiento rodaje p1" value="{{old('rotor_asiento_rodaje_p1')}}" name="rotor_asiento_rodaje_p1">
              @error('rotor_asiento_rodaje_p1')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Rotor asiento rodaje p2</label>
              <input type="text" class="form-control @error('rotor_asiento_rodaje_p2') is-invalid @enderror" placeholder="Rotor asiento rodaje p2" value="{{old('rotor_asiento_rodaje_p2')}}" name="rotor_asiento_rodaje_p2">
              @error('rotor_asiento_rodaje_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Rotor eje zona acople p1</label>
              <input type="text" class="form-control @error('rotor_eje_zona_acople_p1') is-invalid @enderror" placeholder="Rotor eje zona acople p1" value="{{old('rotor_eje_zona_acople_p1')}}" name="rotor_eje_zona_acople_p1">
              @error('rotor_eje_zona_acople_p1')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Rotor eje zona acople p2</label>
              <input type="text" class="form-control @error('rotor_eje_zona_acople_p2') is-invalid @enderror" placeholder="Rotor eje zona acople p2" value="{{old('rotor_eje_zona_acople_p2')}}" name="rotor_eje_zona_acople_p2">
              @error('rotor_eje_zona_acople_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Rotor medida chaveta p1</label>
              <input type="text" class="form-control @error('rotor_medida_chaveta_p1') is-invalid @enderror" placeholder="Rotor medida chaveta p1" value="{{old('rotor_medida_chaveta_p1')}}" name="rotor_medida_chaveta_p1">
              @error('rotor_medida_chaveta_p1')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Rotor medida chaveta p2</label>
              <input type="text" class="form-control @error('rotor_medida_chaveta_p2') is-invalid @enderror" placeholder="Rotor medida chaveta p2" value="{{old('rotor_medida_chaveta_p2')}}" name="rotor_medida_chaveta_p2">
              @error('rotor_medida_chaveta_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-12">
              <h4>Estator</h4>
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Estator alojamiento rodaje tapa p10</label>
              <input type="text" class="form-control @error('estator_alojamiento_rodaje_tapa_p10') is-invalid @enderror" placeholder="Estator alojamiento rodaje tapa p10" value="{{old('estator_alojamiento_rodaje_tapa_p10')}}" name="estator_alojamiento_rodaje_tapa_p10">
              @error('estator_alojamiento_rodaje_tapa_p10')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Estator alojamiento rodaje tapa p20</label>
              <input type="text" class="form-control @error('estator_alojamiento_rodaje_tapa_p20') is-invalid @enderror" placeholder="Estator alojamiento rodaje tapa p20" value="{{old('estator_alojamiento_rodaje_tapa_p20')}}" name="estator_alojamiento_rodaje_tapa_p20">
              @error('estator_alojamiento_rodaje_tapa_p20')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Estator pestana tapa p1</label>
              <input type="text" class="form-control @error('estator_pestana_tapa_p1') is-invalid @enderror" placeholder="Estator pestana tapa p1" value="{{old('estator_pestana_tapa_p1')}}" name="estator_pestana_tapa_p1">
              @error('estator_pestana_tapa_p1')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Estator pestana tapa p2</label>
              <input type="text" class="form-control @error('estator_pestana_tapa_p2') is-invalid @enderror" placeholder="Estator pestana tapa p2" value="{{old('estator_pestana_tapa_p2')}}" name="estator_pestana_tapa_p2">
              @error('estator_pestana_tapa_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Estator contra tapa interna p1</label>
              <input type="text" class="form-control @error('estator_contra_tapa_interna_p1') is-invalid @enderror" placeholder="Estator contra tapa interna p1" value="{{old('estator_contra_tapa_interna_p1')}}" name="estator_contra_tapa_interna_p1">
              @error('estator_contra_tapa_interna_p1')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Estator contra tapa interna p2</label>
              <input type="text" class="form-control @error('estator_contra_tapa_interna_p2') is-invalid @enderror" placeholder="Estator contra tapa interna p2" value="{{old('estator_contra_tapa_interna_p2')}}" name="estator_contra_tapa_interna_p2">
              @error('estator_contra_tapa_interna_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Estator contra tapa externa p1</label>
              <input type="text" class="form-control @error('estator_contra_tapa_externa_p1') is-invalid @enderror" placeholder="Estator contra tapa externa p1" value="{{old('estator_contra_tapa_externa_p1')}}" name="estator_contra_tapa_externa_p1">
              @error('estator_contra_tapa_externa_p1')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Estator contra tapa externa p2</label>
              <input type="text" class="form-control @error('estator_contra_tapa_externa_p2') is-invalid @enderror" placeholder="Estator contra tapa externa p2" value="{{old('estator_contra_tapa_externa_p2')}}" name="estator_contra_tapa_externa_p2">
              @error('estator_contra_tapa_externa_p2')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Ventilador 0</label>
              <input type="text" class="form-control @error('estator_ventilador_0') is-invalid @enderror" placeholder="Ventilador" value="{{old('estator_ventilador_0')}}" name="estator_ventilador_0">
              @error('estator_ventilador_0')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Estator alabes</label>
              <input type="text" class="form-control @error('estator_alabes') is-invalid @enderror" placeholder="Estator alabes" value="{{old('estator_alabes')}}" name="estator_alabes">
              @error('estator_alabes')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Estator caja conexion</label>
              <input type="text" class="form-control @error('estator_caja_conexion') is-invalid @enderror" placeholder="Estator caja conexión" value="{{old('estator_caja_conexion')}}" name="estator_caja_conexion">
              @error('estator_caja_conexion')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-6 col-sm-6 col-lg-3 form-group">
              <label class="col-form-label">Estator tapa conexion</label>
              <input type="text" class="form-control @error('estator_tapa_conexion') is-invalid @enderror" placeholder="Estator tapa conexión" value="{{old('estator_tapa_conexion')}}" name="estator_tapa_conexion">
              @error('estator_tapa_conexion')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-12 form-group">
              <table class="table table-separate text-center table-numbering mb-0 @error('works') is-invalid @enderror" id="table-tap">
                <thead>
                  <tr>
                    <th class="text-center py-1" colspan="2">Trabajos</th>
                  </tr>
                </thead>
                <tbody>
                  @if($works = json_decode(old('works'), true))
                  @foreach($works as $key => $item)
                  <tr>
                    <td class="cell-counter"><span class="number"></span></td>
                    <td><input type="text" class="form-control" value="{{$item[0]}}"></td>
                  </tr>
                  @endforeach
                  @else
                  <tr>
                    <td class="cell-counter"><span class="number"></span></td>
                    <td><input type="text" class="form-control" value=""></td>
                  </tr>
                  @endif
                </tbody>
                <tfoot class="buttons">
                <tr>
                  <td class="p-0" colspan="2">
                    <button class="btn btn-dark btn-add-row btn-sm my-1" type="button">Agregar fila <i class="far ml-1 fa-plus"></i></button>
                    <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button">Remover fila <i class="far ml-1 fa-trash"></i></button>
                    <button class="btn btn-secondary btn-clear btn-sm my-1" type="button">Limpiar <i class="far ml-1 fa-eraser"></i></button>
                  </td>
                </tr>
                </tfoot>
              </table>
              <input type="hidden" class="form-control" value="{{old('works')}}" name="works">
              @error('works')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
            </div>
            <div class="col-md-12 form-group">
              <label class="col-form-label">Observaciones</label>
              <textarea class="form-control @error('observaciones') is-invalid @enderror" placeholder="" name="observaciones">{{old('observaciones')}}</textarea>
              @error('observaciones')
              <p class="error-message text-danger">{{ $message }}</p>
              @enderror
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
function createJSON() {
var json = '{';
var otArr = [];
var tbl2 = $('#table-tap tbody tr').each(function(i) {
x = $(this).children();
var itArr = [];
x.each(function() {
if ($(this).find('.form-control').length) {
itArr.push('"' + $(this).find('.form-control').val() + '"');
}
});
otArr.push('"' + i + '": [' + itArr.join(',') + ']');
})
json += otArr.join(",") + '}'
$('input[name=works]').val(json);
return json;
}
$(document).on('keyup', '#table-tap .form-control', function () {
createJSON();
})
$(document).on('click', '.card .btn-clear', function () {
$('#table-tap .form-control').val('');
})
$('.btn-add-row').click(function () {
var row = '<tr><td class="cell-counter"><span class="number"></span></td><td><input type="text" class="form-control" value=""></td></tr>';
$('#table-tap tbody').append(row);
createJSON();
})
$('.btn-remove-row').click(function () {
var row_index = $('#table-tap tbody tr').length;
if (row_index > 1) {
$('#table-tap tbody tr:nth-child('+row_index+')').remove();
}
createJSON();
})
})
</script>
@endsection