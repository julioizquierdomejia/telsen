@extends('layouts.app', ['body_class' => 'page_client page-ot'])

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')

<div class="row">
  
  <div class="col-md-12">
    <div class="card ots-welcome">
      <div class="card-body px-md-4">
      <h6 class="mb-0 text text-uppercase"><span class="text-white">Proceso Virtual</span></h6>
    </div>
    </div>
    <div class="card card-user">
      <div class="card-header text-center">
        <p>Revisa aquí el proceso virtual del trabajo que estamos realizando para ti:</p>
        @if($ordenes->count())
        <div class="ot-list pb-2">
          @foreach($ordenes as $item)
          <select class="form-control select-ot dropdown2" id="select-orden" onchange="window.location=this.value">
            <option value="">Selecciona un O.T.</option>
            <option value="/ordenes/{{$item->id}}/ver">{{ sprintf('%05d', $item->id) }} | {{ $item->marca['name'] }}</option>
          </select>
          @endforeach
        </div>
        @endif
        <h5 class="card-title ot-main-title">O.T. {{ sprintf('%05d', $orden->id) }} | {{ $orden->marca['name'] }}</h5>
      </div>
      <div class="card-body">
        <ul class="list-inline steps row row-small">
          <li class="step item col-xs-12 col-sm-6 col-lg-3 my-2 step-one completed">
            <div class="card h-100">
              <div class="card-header text-center">
                <h5 class="card-title">Paso 1</h5>
              </div>
              <div class="card-body text-center">
                <h3 class="s-title text-uppercase">
                  <span class="s-icon d-block"><i class="fal fa-clipboard-list-check"></i></span>
                  <span>Cotización</span>
                </h3>
                <ul class="s-list list-inline">
                  <li class="mb-3">
                  <p class="s-desc mb-2">Descarga el documento</p>
                  <a class="btn btn-step btn-danger" download=""><i class="far fa-long-arrow-down pr-2"></i>Cotización</a>
                </li>
                </ul>
              </div>
              <div class="card-footer p-3 text-center">
                <span class="c-icon">
                  <i class="fal fa-check-circle"></i>
                </span>
                <p class="mb-0 text-completed">Completado</p>
                <p class="mb-0 text-processing">En proceso</p>
              </div>
            </div>
          </li>
          <li class="step item col-xs-12 col-sm-6 col-lg-3 my-2 step-two completed">
            <div class="card h-100">
              <div class="card-header text-center">
                <h5 class="card-title">Paso 2</h5>
              </div>
              <div class="card-body text-center">
                <h3 class="s-title text-uppercase">
                  <span class="s-icon d-block"><i class="fal fa-cog"></i></span>
                  <span>Mecánica</span>
                </h3>
                <ul class="s-list list-inline">
                  <li class="mb-3">
                    <p class="s-desc mb-2">Resumen de <br>calibraciones mecánicas</p>
                    <a class="btn btn-step btn-success" download=""><i class="far fa-eye pr-2"></i>Ver</a>
                  </li>
                </ul>
              </div>
              <div class="card-footer p-3 text-center">
                <span class="c-icon">
                  <i class="fal fa-check-circle"></i>
                </span>
                <p class="mb-0 text-completed">Completado</p>
                <p class="mb-0 text-processing">En proceso</p>
              </div>
            </div>
          </li>
          <li class="step item col-xs-12 col-sm-6 col-lg-3 my-2 step-three completed">
            <div class="card h-100">
              <div class="card-header text-center">
                <h5 class="card-title">Paso 3</h5>
              </div>
              <div class="card-body text-center">
                <h3 class="s-title text-uppercase">
                  <span class="s-icon d-block"><i class="fal fa-chart-network"></i></span>
                  <span>Electrónica</span>
                </h3>
                <ul class="s-list list-inline">
                  <li class="mb-3">
                    <p class="s-desc mb-2">Pruebas de <br>resistencia de aislamiento</p>
                    <a class="btn btn-step btn-success" download=""><i class="far fa-eye pr-2"></i>Ver</a>
                  </li>
                  <li class="mb-3">
                    <p class="s-desc mb-2">Pruebas de <br>Impulso (Surge)</p>
                    <a class="btn btn-step btn-success" download=""><i class="far fa-eye pr-2"></i>Ver</a>
                  </li>
                </ul>
              </div>
              <div class="card-footer p-3 text-center">
                <span class="c-icon">
                  <i class="fal fa-check-circle"></i>
                </span>
                <p class="mb-0 text-completed">Completado</p>
                <p class="mb-0 text-processing">En proceso</p>
              </div>
            </div>
          </li>
          <li class="step item col-xs-12 col-sm-6 col-lg-3 my-2 step-four">
            <div class="card h-100">
              <div class="card-header text-center">
                <h5 class="card-title">Paso 4</h5>
              </div>
              <div class="card-body text-center">
                <h3 class="s-title text-uppercase">
                  <span class="s-icon d-block"><i class="fal fa-clipboard-list-check"></i></span>
                  <span>Pruebas Finales</span>
                </h3>
                <!-- <ul class="s-list list-inline">
                  <li class="mb-3">
                    <p class="s-desc mb-2">Resumen de <br>calibraciones mecánicas</p>
                    <a class="btn btn-step btn-success" download=""><i class="far fa-eye pr-2"></i>Ver</a>
                  </li>
                </ul> -->
              </div>
              <div class="card-footer p-3 text-center">
                <span class="c-icon">
                  <i class="fal fa-check-circle"></i>
                </span>
                <p class="mb-0 text-completed">Completado</p>
                <p class="mb-0 text-processing">En proceso</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection


@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('.dropdown2').select2();
  })
  </script>
@endsection
