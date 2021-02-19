@extends('procesovirtual.app', ['body_class' => 'page-ot-list'])

@section('content')

<div class="row">
	<div class="col-md-12">
    <div class="card ots-welcome">
      <div class="card-body">
      <h6 class="mb-0 text"><span class="text-white">¡Bienvenido!</span> Mira aquí un resumen de los procesos virtuales, inventarios y actividades actualizadas.</h6>
    </div>
    </div>
    <div class="card ots-list">
      <div class="card-body px-md-4 py-md-5">
        <div class="row">
          <div class="col-md-8">
      <div class="card-header pt-0 pl-0 pb-4">
        <h4 class="card-title mb-1">Proceso virtual</h4>
        <p class="mb-0">Revisa aquí un breve resumen del proceso virtual del trabajo que estamos realizando para ti.</p>
      </div>
      @if($ordenes->count())
            <div class="table-responsive">
          <table class="table table-ots">
            <!-- <thead class=" text-primary">
              <th class="text-right">
                Orden
              </th>
              <th class="text-center">
                Paso
              </th>
            </thead> -->
            <tbody>
              @foreach($ordenes as $ot)
                <tr>
                  <td>
                    O.T. {{ zerosatleft($ot->code, 3) }} | {{ $ot->marca->name }}
                  </td>
                  <td>
                    <ul class="list-inline d-flex steps mb-0">
                      <li class="s-item completed step-one"><span>Paso 1</span></li>
                      <li class="s-item completed step-two"><span>Paso 2</span></li>
                      <li class="s-item step-three"><span>Paso 3</span></li>
                      <li class="s-item step-four"><span>Paso 4</span></li>
                    </ul>
                  </td>
                  <td class="text-center">
                    <a href="{{ route('ordenes.show', $ot) }}" class="btn btn-default"><i class="fal fa-eye"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @else
        <div class="empty-list text-center p-4 bg-light">
          <p class="mb-2">Por el momento no tiene ordenes.</p>
          <strong class="h3">¯\_(ツ)_/¯</strong>
        </div>
        @endif
          </div>
          <div class="col-md-4">
            <div class="card inventario-card">
              <div class="card-header">
              <h4 class="card-title mt-0">Inventario</h4>
                <p class="mb-0">Revisa aquí los últimos informes técnicos disponibles.</p>
              </div>
              <div class="card-body">
                <ul class="list list-inline mb-0">
                  <li class="item p-2">Información técnica - Motor eléctrico - 100 O.T. N°24563 | HP 250 RPM 3000 x min | SOLPED 153120</li>
                  <li class="item p-2">Información técnica - Taladro eléctrico - 100 O.T. N°24563 | HP 250 RPM 3000 x min | SOLPED 153120</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
