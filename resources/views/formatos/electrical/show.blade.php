@extends('layouts.app', ['title' => 'Ver Evaluación Eléctrica'])
@section('content')
<div class="row">
     <div class="col-md-12">
          @foreach($formato->toArray() as $key => $item)
          <p><strong>{{$key}}</strong>: {{$item}}</p>
          @endforeach
     </div>
</div>
@endsection