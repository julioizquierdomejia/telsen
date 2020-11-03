@extends('layouts.app', ['title' => 'Evaluación Eléctrica'])
@section('content')
<div class="row">
     <div class="col-md-12">
          <form class="form-group" method="POST" action="{{route('formatos.mechanical.store', ['id' => $ot->id])}}" enctype="multipart/form-data">
               @csrf
               <div class="card card-user form-card">
                    <div class="card-header">
                         <h5 class="card-title">Evaluación Eléctrica</h5>
                    </div>
                    <div class="card-body pb-3">
                         <h4 class="second-title text-danger py-2">Características del Equipo</h4>
                         <div class="row">
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">OT:</label>
                                   <input type="text" readonly="" class="form-control @error('ot_id') is-invalid @enderror" placeholder="OT" value="{{$ot->id}}" name="ot_id">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Fecha:</label>
                                   <input type="date" class="form-control" disabled="" value="{{date('Y-m-d')}}">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Solped:</label>
                                   <input type="text" class="form-control @error('solped') is-invalid @enderror" placeholder="Solped" value="" name="solped">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Recepcionado por:</label>
                                   <input type="text" class="form-control @error('recepcionado_por') is-invalid @enderror" placeholder="Recepcionado por" value="" name="recepcionado_por">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Potencia</label>
                                   <input type="text" class="form-control @error('potencia') is-invalid @enderror" placeholder="Potencia" value="" name="potencia">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Conex:</label>
                                   <input type="text" class="form-control @error('conex') is-invalid @enderror" placeholder="Conex" value="" name="conex">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Mod:</label>
                                   <input type="text" class="form-control @error('mod') is-invalid @enderror" placeholder="Mod" value="" name="mod">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Voltaje:</label>
                                   <input type="text" class="form-control @error('voltaje') is-invalid @enderror" placeholder="Voltaje" value="" name="mod">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">N° salida</label>
                                   <input type="number" class="form-control @error('n_salida') is-invalid @enderror" placeholder="N° salida" value="" name="n_salida">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Tipo:</label>
                                   <input type="text" class="form-control @error('tipo') is-invalid @enderror" placeholder="Tipo" value="" name="tipo">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Amperaje:</label>
                                   <input type="text" class="form-control @error('amperaje') is-invalid @enderror" placeholder="Amperaje" value="" name="amperaje">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Rod.l.a:</label>
                                   <input type="text" class="form-control @error('rodla') is-invalid @enderror" placeholder="Rod.l.a" value="" name="rodla">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">N° equipo:</label>
                                   <input type="text" class="form-control @error('nro_equipo') is-invalid @enderror" placeholder="N° equipo" value="" name="nro_equipo">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Velocidad:</label>
                                   <input type="text" class="form-control @error('velocidad') is-invalid @enderror" placeholder="Velocidad" value="" name="velocidad">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Rod.l.o.a:</label>
                                   <input type="text" class="form-control @error('rodloa') is-invalid @enderror" placeholder="Rod.l.o.a" value="" name="rodloa">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Frame:</label>
                                   <input type="text" class="form-control @error('frame') is-invalid @enderror" placeholder="Frame" value="" name="frame">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Frecuencia:</label>
                                   <input type="text" class="form-control @error('frecuencia') is-invalid @enderror" placeholder="Frecuencia" value="" name="frecuencia">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Lub:</label>
                                   <input type="text" class="form-control @error('lub') is-invalid @enderror" placeholder="Lub" value="" name="lub">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">F.S</label>
                                   <input type="text" class="form-control @error('fs') is-invalid @enderror" placeholder="F.S" value="" name="fs">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Encl</label>
                                   <input type="text" class="form-control @error('encl') is-invalid @enderror" placeholder="Encl" value="" name="encl">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Cos o:</label>
                                   <input type="text" class="form-control @error('cos_o') is-invalid @enderror" placeholder="Cos o" value="" name="cos_o">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Aisl. Clase:</label>
                                   <input type="text" class="form-control @error('aisl_clase') is-invalid @enderror" placeholder="Aisl. Clase" value="" name="aisl_clase">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Ef:</label>
                                   <input type="text" class="form-control @error('ef') is-invalid @enderror" placeholder="Ef" value="" name="ef">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Cod:</label>
                                   <input type="text" class="form-control @error('cod') is-invalid @enderror" placeholder="Cod" value="" name="cod">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Diseño NEMA:</label>
                                   <input type="text" class="form-control @error('maquina') is-invalid @enderror" placeholder="Diseño NEMA" value="" name="maquina">
                              </div>
                         </div>
                    </div>
               </div>
               <div class="card card-user form-card">
                    <div class="card-header">
                         <h4 class="second-title text-danger py-2">Características del redactor/bomba/ventilador u otros</h4>
                    </div>
                    <div class="card-body pb-3">
                         <div class="row">
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Marca:</label>
                                   <input type="text" class="form-control @error('maquina') is-invalid @enderror" placeholder="Marca" value="" name="maquina">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Potencia:</label>
                                   <input type="text" class="form-control @error('potencia') is-invalid @enderror" placeholder="Potencia" value="" name="potencia">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Escudos:</label>
                                   <input type="text" class="form-control @error('escudos') is-invalid @enderror" placeholder="Escudos" value="" name="escudos">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Mod</label>
                                   <input type="text" class="form-control @error('mod') is-invalid @enderror" placeholder="Mod" value="" name="mod">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Voltaje:</label>
                                   <input type="text" class="form-control @error('voltaje') is-invalid @enderror" placeholder="Voltaje" value="" name="voltaje">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Ejes</label>
                                   <input type="text" class="form-control @error('ejes') is-invalid @enderror" placeholder="Ejes" value="" name="ejes">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Amperaje:</label>
                                   <input type="text" class="form-control @error('amperaje') is-invalid @enderror" placeholder="Amperaje" value="" name="amperaje">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Funda:</label>
                                   <input type="text" class="form-control @error('funda') is-invalid @enderror" placeholder="Máquina" value="" name="funda">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Frame:</label>
                                   <input type="text" class="form-control @error('frame') is-invalid @enderror" placeholder="Frame" value="" name="frame">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Velocidad:</label>
                                   <input type="text" class="form-control @error('velocidad') is-invalid @enderror" placeholder="Velocidad" value="" name="velocidad">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Acople:</label>
                                   <input type="text" class="form-control @error('acople') is-invalid @enderror" placeholder="Acople" value="" name="acople">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">F.S:</label>
                                   <input type="text" class="form-control @error('fs') is-invalid @enderror" placeholder="F.S" value="" name="fs">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Encl:</label>
                                   <input type="text" class="form-control @error('encl') is-invalid @enderror" placeholder="Encl" value="" name="encl">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Peso:</label>
                                   <input type="text" class="form-control @error('peso') is-invalid @enderror" placeholder="Peso" value="" name="peso">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Frecuencia:</label>
                                   <input type="text" class="form-control @error('frecuencia') is-invalid @enderror" placeholder="Frecuencia" value="" name="frecuencia">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Otros:</label>
                                   <input type="text" class="form-control @error('otros') is-invalid @enderror" placeholder="Otros" value="" name="otros">
                              </div>
                         </div>
                    </div>
               </div>
               <div class="card card-user form-card">
                    <div class="card-header">
                         <h4 class="second-title text-danger py-2">Estado en recepción</h4>
                    </div>
                    <div class="card-body pb-3">
                         <div class="row">
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Placa caract. Orig:</label>
                                   <input type="text" class="form-control @error('placa_caract_orig') is-invalid @enderror" placeholder="Placa caract. Orig" value="" name="placa_caract_orig">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Escudos:</label>
                                   <input type="text" class="form-control @error('escudos') is-invalid @enderror" placeholder="Escudos" value="" name="escudos">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Ventilador:</label>
                                   <input type="text" class="form-control @error('ventilador') is-invalid @enderror" placeholder="Ventilador" value="" name="ventilador">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Caja de Conexión:</label>
                                   <input type="text" class="form-control @error('caja_conexion') is-invalid @enderror" placeholder="Caja de Conexión" value="" name="Caja de conexión">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Ejes:</label>
                                   <input type="text" class="form-control @error('ejes') is-invalid @enderror" placeholder="Ejes" value="" name="ejes">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Acople:</label>
                                   <input type="text" class="form-control @error('acople') is-invalid @enderror" placeholder="Acople" value="" name="acople">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Bornera:</label>
                                   <input type="text" class="form-control @error('bornera') is-invalid @enderror" placeholder="Bornera" value="" name="bornera">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Funda:</label>
                                   <input type="text" class="form-control @error('funda') is-invalid @enderror" placeholder="Funda" value="" name="funda">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Chaveta:</label>
                                   <input type="text" class="form-control @error('chaveta') is-invalid @enderror" placeholder="Chaveta" value="" name="chaveta">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Otros:</label>
                                   <input type="text" class="form-control @error('otros') is-invalid @enderror" placeholder="Otros" value="" name="otros">
                              </div>
                              <div class="col-12">
                                   <label class="col-form-label">Detalles:</label>
                                   <input type="text" class="form-control @error('detalles') is-invalid @enderror" placeholder="Detalles" value="" name="detalles">
                              </div>
                         </div>
                    </div>
               </div>
               <div class="card card-user form-card">
                    <div class="card-header">
                         <h4 class="second-title text-danger py-2">Pruebas de Ingreso</h4>
                    </div>
                    <div class="card-body pb-3">
                         <div class="row">
                              <div class="col-md-6">
                                   <h4 class="second-title text-danger py-2">Motor</h4>
                                   <div class="row">
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">Aisl.(M):</label>
                                        <input type="text" class="form-control @error('aisl_m') is-invalid @enderror" placeholder="Aisl.(M)" value="" name="aisl_m">
                                   </div>
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">N° salidas:</label>
                                        <input type="number" class="form-control @error('n_salidas') is-invalid @enderror" placeholder="N° salidas" value="" name="n° salidas">
                                   </div>
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">Conexión:</label>
                                        <input type="text" class="form-control @error('Conexión') is-invalid @enderror" placeholder="Conexión" value="" name="conexión">
                                   </div>
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">Volt(v):</label>
                                        <input type="text" class="form-control @error('Volt(v)') is-invalid @enderror" placeholder="Volt(v)" value="" name="Volt(v)">
                                   </div>
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">Amp(A):</label>
                                        <input type="text" class="form-control @error('Amp(A)') is-invalid @enderror" placeholder="Amp(A)" value="" name="Amp(a)">
                                   </div>
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">RPM:</label>
                                        <input type="number" class="form-control @error('RPM') is-invalid @enderror" placeholder="RPM" value="" name="rpm">
                                   </div>
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">Frec.(HZ):</label>
                                        <input type="text" class="form-control @error('Frec.(HZ)') is-invalid @enderror" placeholder="Frec.(HZ)" value="" name="Frec.(hz)">
                                   </div>
                                   </div>
                              </div>
                              <div class="col-md-6">
                                   <h4 class="second-title text-danger py-2">Pruebas del estator/rotor</h4>
                                   <div class="row">
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">Aisl.(M):</label>
                                        <input type="text" class="form-control @error('aisl_m') is-invalid @enderror" placeholder="Aisl.(M)" value="" name="aisl_m">
                                   </div>
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">N° salidas:</label>
                                        <input type="number" class="form-control @error('nro_salidas') is-invalid @enderror" placeholder="N° salidas" value="" name="nro_salidas">
                                   </div>
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">Conexión:</label>
                                        <input type="text" class="form-control @error('conexion') is-invalid @enderror" placeholder="Conexión" value="" name="conexion">
                                   </div>
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">Volt(v):</label>
                                        <input type="text" class="form-control @error('volt_v') is-invalid @enderror" placeholder="Volt(v)" value="" name="volt_v">
                                   </div>
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">Amp(A):</label>
                                        <input type="text" class="form-control @error('amp_a') is-invalid @enderror" placeholder="Amp(A)" value="" name="amp_a">
                                   </div>
                                   <div class="col-sm-6 col-md-4">
                                        <label class="col-form-label">N° polos:</label>
                                        <input type="number" class="form-control @error('nro_polos') is-invalid @enderror" placeholder="N° polos" value="" name="nro_polos">
                                   </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
               <div class="card card-user form-card">
                    <div class="card-header">
                         <h4 class="second-title text-danger py-2">Transformador</h4>
                    </div>
                    <div class="card-body pb-3 pt-0">
                         <table class="table table-separate text-center table-numbering mb-0" id="table-tap">
                              <thead>
                                   <tr>
                                        <th class="text-center py-1" colspan="7">Tap</th>
                                   </tr>
                                   <tr>
                                        <th class="py-1">N°</th>
                                        <th class="py-1">U-V</th>
                                        <th class="py-1">U-V</th>
                                        <th class="py-1">V-U</th>
                                        <th class="py-1">V-U</th>
                                        <th class="py-1">W-U</th>
                                        <th class="py-1">W-U</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <tr>
                                        <td class="cell-counter"><span class="number"></span></td>
                                        <td><input type="text" class="form-control" value=""></td>
                                        <td><input type="text" class="form-control" value=""></td>
                                        <td><input type="text" class="form-control" value=""></td>
                                        <td><input type="text" class="form-control" value=""></td>
                                        <td><input type="text" class="form-control" value=""></td>
                                        <td><input type="text" class="form-control" value=""></td>
                                   </tr>
                              </tbody>
                         </table>
                         <input type="hidden" class="form-control" value="" name="tap">
                         <div class="buttons">
                              <button class="btn btn-dark btn-add-row btn-sm my-1" type="button">Agregar fila</button>
                              <button class="btn btn-secondary btn-remove-row btn-sm my-1" type="button">Remover fila</button>
                         </div>
                         <div class="row">
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Aisl.(M):</label>
                                   <input type="text" class="form-control @error('aisl_m') is-invalid @enderror" placeholder="Aisl.(M)" name="aisl_m">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">N° salidas:</label>
                                   <input type="number" class="form-control @error('nro_salidas') is-invalid @enderror" placeholder="N° salidas" name="nro_salidas">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Conexión:</label>
                                   <input type="text" class="form-control @error('nro_conexion') is-invalid @enderror" placeholder="Conexión" name="nro_conexion">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Volt(V):</label>
                                   <input type="text" class="form-control @error('volt_v') is-invalid @enderror" placeholder="Volt(V)" value="" name="volt_v">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Amp(A):</label>
                                   <input type="text" class="form-control @error('amp_a') is-invalid @enderror" placeholder="Amp(A)" value="" name="amp_a">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">N° polos:</label>
                                   <input type="text" class="form-control @error('nro_polos') is-invalid @enderror" placeholder="N° polos" name="nro_polos">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Aisl.(M): A.T.masa:</label>
                                   <input type="text" class="form-control @error('aisl_m_a_t_masa') is-invalid @enderror" placeholder="Aisl.(M): A.T.masa" name="aisl_m_a_t_masa">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">S.T masa:</label>
                                   <input type="text" class="form-control @error('s_t_masa') is-invalid @enderror" placeholder="N° S.T masa" name="s_t_masa">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">E.T-A.T:</label>
                                   <input type="text" class="form-control @error('et_at') is-invalid @enderror" placeholder="E.T-A.T" value="" name="et_at">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Grupo conex:</label>
                                   <input type="text" class="form-control @error('grupo_conex') is-invalid @enderror" placeholder="Grupo conex" name="grupo_conex">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Polaridad:</label>
                                   <input type="text" class="form-control @error('polaridad') is-invalid @enderror" placeholder="N° Polaridad" name="polaridad">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Relac. Transf:</label>
                                   <input type="text" class="form-control @error('relac_transf') is-invalid @enderror" placeholder="N° Relac. Transf" name="relac_transf">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">o.t.p:</label>
                                   <input type="text" class="form-control @error('otp') is-invalid @enderror" placeholder="o.t.p" value="" name="otp">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Tec:</label>
                                   <input type="text" class="form-control @error('tec') is-invalid @enderror" placeholder="Tec" value="" name="tec">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Amp:</label>
                                   <input type="text" class="form-control @error('amp') is-invalid @enderror" placeholder="Amp" value="" name="amp">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Rig. Diel. Aceite:</label>
                                   <input type="text" class="form-control @error('rig_diel_aceite') is-invalid @enderror" placeholder="Rig. Diel. Aceite" name="rig_diel_aceite">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">R.u.v:</label>
                                   <input type="text" class="form-control @error('ruv') is-invalid @enderror" placeholder="R.u.v" value="" name="ruv">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Rv-w:</label>
                                   <input type="text" class="form-control @error('rv_w') is-invalid @enderror" placeholder="Rv-w" value="" name="rv_w">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Rw-u:</label>
                                   <input type="text" class="form-control @error('rw_u') is-invalid @enderror" placeholder="Rw-u" value="" name="rw_u">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Ru-v:</label>
                                   <input type="text" class="form-control @error('ru_v') is-invalid @enderror" placeholder="Ru-v" value="" name="ru_v">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Rv-u:</label>
                                   <input type="text" class="form-control @error('rv_u') is-invalid @enderror" placeholder="Rv-u" value="" name="rv_u">
                              </div>
                              <div class="col-12 col-sm-6 col-md-3">
                                   <label class="col-form-label">Ww:</label>
                                   <input type="text" class="form-control @error('ww') is-invalid @enderror" placeholder="Ww" value="" name="ww">
                              </div>

                              <div class="col-12 text-center mt-4">
                                   <button type="submit" class="btn btn-primary btn-round">Enviar</button>
                              </div>
                         </div>
                    </div>
               </div>
          </form>
     </div>
</div>
@endsection
@section('javascript')
<script>
     $('.btn-add-row').click(function () {
          var row = '<tr><td class="cell-counter"><span class="number"></span></td><td><input type="text" class="form-control" value=""></td><td><input type="text" class="form-control" value=""></td><td><input type="text" class="form-control" value=""></td><td><input type="text" class="form-control" value=""></td><td><input type="text" class="form-control" value=""></td><td><input type="text" class="form-control" value=""></td></tr>';
          $('#table-tap tbody').append(row);
          createJSON();
     })
     $('.btn-remove-row').click(function () {
          var row_index = $('#table-tap tbody tr').length - 1;
          $('#table-tap tbody tr:nth-child('+row_index+')').remove();
     })

     createJSON();

     function createJSON() {
          $('#table-tap .form-control').on('keyup', function () {
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
               $('input[name=tap]').val(json);
               return json;
          })
     }
</script>
@endsection