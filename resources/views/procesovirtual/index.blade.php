@extends('procesovirtual.app', ['body_class' => 'page_client page-ot'])

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
          <select class="form-control select-ot dropdown2" id="select-orden" onchange="window.location=this.value">
            <option value="">Selecciona un O.T.</option>
            @foreach($ordenes as $item)
            <option value="/ordenes/{{$item->id}}/ver">{{ sprintf('%05d', $item->id) }} | {{ $item->marca['name'] }}</option>
            @endforeach
          </select>
        </div>
        @endif
      </div>
      <div class="card-body text-center">
        <div class="icon mt-4 mt-md-5 mb-3">
          <img alt="Proceso virtual" src="/images/procesovirtual.png" width="147" height="171">
        </div>
        <p class="mb-0"><strong>Selecciona una O.T. para ver el proceso</strong></p>
        <p>No hay O.T. seleccionado.</p>
      </div>
    </div>
  </div>
</div>

@endsection


@section('javascript')

@endsection
