@extends('layouts.app', ['title' => 'Ver Evaluación Eléctrica'])
@section('content')
@php $data = $formato->toArray() @endphp
<div class="row">
     <div class="col-md-12">
          @foreach($data as $key => $item)
          <p><strong>{{ucwords(str_replace("_", " ", $key))}}</strong>: {{$item}}</p>
          @endforeach
     </div>
</div>
@endsection