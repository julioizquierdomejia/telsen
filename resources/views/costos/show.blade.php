@extends('layouts.app', ['title' => 'Ver Tarjeta Costo'])
@section('content')
@php $data = $ccost->toArray() @endphp
<div class="row">
     <div class="col-md-12">
          @foreach($data as $key => $item)
          <p><strong>{{ucwords(str_replace("_", " ", $key))}}</strong>: {{$item}}</p>
          @endforeach
     </div>
</div>
@endsection