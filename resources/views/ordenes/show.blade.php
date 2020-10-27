@extends('layouts.app', ['body_class' => 'page_client'])

@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content')

<div class="row">
  
  <div class="col-md-12">
    <div class="card card-user">
      <div class="card-header text-center">
        <p>Revisa aquí el proceso virtual del trabajo que estamos realizando para ti:</p>
        <h5 class="card-title">O.T. {{ sprintf('%05d', $orden->id) }} | {{ $orden->marca['name'] }}</h5>
      </div>
      <div class="card-body">
        <ul class="list-inline steps row row-small">
          <li class="step item col-xs-12 col-md-4 col-lg-3">
            <div class="card">
              <div class="card-header text-center">
                <h5 class="card-title">Paso 1</h5>
              </div>
              <div class="card-body text-center">
                
              </div>
            </div>
          </li>
          <li class="step item col-xs-12 col-md-4 col-lg-3">
            <div class="card">
              <div class="card-header text-center">
                <h5 class="card-title">Paso 2</h5>
              </div>
              <div class="card-body text-center">
                
              </div>
            </div>
          </li>
          <li class="step item col-xs-12 col-md-4 col-lg-3">
            <div class="card">
              <div class="card-header text-center">
                <h5 class="card-title">Paso 3</h5>
              </div>
              <div class="card-body text-center">
                
              </div>
            </div>
          </li>
          <li class="step item col-xs-12 col-md-4 col-lg-3">
            <div class="card">
              <div class="card-header text-center">
                <h5 class="card-title">Paso 4</h5>
              </div>
              <div class="card-body text-center">
                
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
    //$('.dropdown2').select2();
  })
  </script>
@endsection
