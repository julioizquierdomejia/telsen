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

<li class="{{ request()->segment(1) == 'marcas' ? 'active' : '' }}">
  <a href="{{route('marcas.index')}}">
    <i class="fal fa-copyright"></i>
    <p>Marca de Motores</p>
  </a>
</li>

<li class="{{ request()->segment(1) == 'modelos' ? 'active' : '' }}">
  <a href="{{route('modelos.index')}}">
    <i class="fas fa-barcode"></i>
    <p>Modelo de Motores</p>
  </a>
</li>