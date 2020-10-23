@extends('layouts.app')

@section('content')

<div class="row">
  
  <div class="col-md-12">
    <div class="card card-user">
      <div class="card-header">
        <h5 class="card-title">Crear Orden de Trabajo</h5>
      </div>
      <div class="card-body">
        <form class="form-group" method="POST" action="/" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-5">
              <div class="form-group">
                <label>Número de Orden</label>
                <input type="text" class="form-control" disabled="" placeholder="Company" value="0T - {{$ot_numero}}" name="id">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Fecha de creación <span class="text-danger">(*)</span></label>
                <input type="date" class="form-control" placeholder="" name="date" value="Aqui un date Picker" required>
                <input type="hidden" name="user_id" class="form-control mb-2" value="{{ Auth::user()->id }}">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Vendedor</label>
                <input type="text" class="form-control" placeholder="Ingrese Vendedor" value="">
              </div>
            </div>
          </div>
          <div class="row">
          	<div class="col-md-4">
              <div class="form-group">
                <label>RUC del cliente</label>
                <input type="text" class="form-control" placeholder="Ingrese Ruc del cliente" value="">
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label>Razon social</label>
                <input type="text" class="form-control" placeholder="" value="" disabled="" name="name">
              </div>
            </div>
          </div>
          <div class="row">
          	<div class="col-md-6">
              <div class="form-group">
                <label>Direccion</label>
                <input type="text" class="form-control" placeholder="" value="" disabled="" name="address">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Telefono de contacto</label>
                <input type="text" class="form-control" placeholder="" value="" disabled="" name="phone">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Celular</label>
                <input type="text" class="form-control" placeholder="" value="" disabled="" name="celular">
              </div>
            </div>
          </div>
          <h5 class="text-danger mt-4">Datos del Motor</h5>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>Descripción del motor</label>
                <input type="text" class="form-control" placeholder="Ingrese descripción" value="" name="descriiption">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Código</label>
                <input type="text" class="form-control" placeholder="Ingrese código del motor" value="">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Marca</label>
                <input type="text" class="form-control" placeholder="Ingrese Marca" value="" name="marca">
              </div>
            </div>
            <div class="col-md-4 ">
              <div class="form-group">
                <label>Modelo</label>
                <input type="number" class="form-control" placeholder="Ingrese Modelo" value="" name="modelo">
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label>Numero de potencia</label>
                <input type="text" class="form-control" placeholder="Número de potencia" value="" name="potencia">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Medida de potencia</label>
                <input type="text" class="form-control" placeholder="Medida de potencia" value="" name="marca">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>Voltaje</label>
                <input type="number" class="form-control" placeholder="Voltaje" value="" name="model">
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label>velocidad</label>
                <input type="number" class="form-control" placeholder="Velocidad" value="" name="speed">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="update ml-auto mr-auto">
              <button type="submit" class="btn btn-primary btn-round">Crear Orden de Trabajo</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
