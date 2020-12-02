@php
  $is_format = request()->segment(1) == 'formatos';
@endphp
<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
  <a href="{{ route('home')}}">
    <i class="nc-icon nc-tv-2"></i>
    <p>Dashboard</p>
  </a>
</li>

<li class="{{ request()->segment(1) == 'ordenes' ? 'active' : '' }}">
  <a href="/ordenes">
    <i class="fal fa-network-wired"></i>
    <p>Ordenes de trabajo</p>
  </a>
</li>

<li class="{{ $is_format ? 'active' : '' }}">
  <a href="#" data-toggle="collapse" data-target="#collapseFormatos" aria-expanded="false">
    <i class="fal fa-file-check"></i>
    <p>Evaluaciones <i class="fal fa-angle-down float-right"></i></p>
  </a>
  <ul class="collapse list-inline pl-3 {{$is_format ? 'show': ''}}" id="collapseFormatos">
    <li class="{{ request()->segment(2) == 'electrical' ? 'active' : '' }}">
      <a class="mr-0" href="{{route('formatos.electrical')}}">
        <i class="fas fa-charging-station"></i>
        <p>F. Evaluación Eléctrica</p>
      </a>
    </li>
    <li class="{{ request()->segment(2) == 'mechanical' ? 'active' : '' }}">
      <a class="mr-0" href="{{route('formatos.mechanical')}}">
        <i class="fas fa-wrench"></i>
        <p>F. Evaluación Mecánica</p>
      </a>
    </li>
  </ul>
</li>
<li class="{{ request()->segment(1) == 'rdi' ? 'active' : '' }}">
  <a href="/rdi">
    <i class="fal fa-network-wired"></i>
    <p>RDI</p>
  </a>
</li>
<li class="{{ request()->segment(1) == 'tarjeta-costo' ? 'active' : '' }}">
  <a class="mr-0" href="{{route('card_cost.index')}}">
    <i class="fas fa-money-check-alt"></i>
    <p>Tarjeta de Costos</p>
  </a>
</li>
<li class="{{ request()->segment(1) == 'talleres' ? 'active' : '' }}">
  <a href="/talleres">
    <i class="fal fa-user-hard-hat"></i>
    <p>Talleres</p>
  </a>
</li>