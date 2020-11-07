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

<li class="{{ request()->segment(1) == 'formatos' ? 'active' : '' }}">
  <a href="#" data-toggle="collapse" data-target="#collapseFormatos" aria-expanded="false">
    <i class="fal fa-file-check"></i>
    <p>Evaluaciones <i class="fal fa-angle-down float-right"></i></p>
  </a>
  <ul class="collapse list-inline pl-3" id="collapseFormatos">
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
<li class="{{ request()->segment(1) == 'card_cost' ? 'active' : '' }}">
  <a class="mr-0" href="{{route('card_cost.index')}}">
    <i class="fas fa-money-check-alt"></i>
    <p>Tarjeta de Costos</p>
  </a>
</li>
<li class="px-3"><hr style="border-top-color: #858585;"></li>
<li class="{{ request()->segment(1) == 'clientes' ? 'active' : '' }}">
  <a href="{{route('clientes.index')}}">
    <i class="fal fa-handshake"></i>
    <p>Clientes</p>
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
<li class="{{ request()->segment(1) == 'areas' ? 'active' : '' }}">
  <a class="mr-0" href="{{route('areas.index')}}">
    <i class="fas fa-list-alt"></i>
    <p>Areas</p>
  </a>
</li>
<li class="{{ request()->segment(1) == 'servicios' ? 'active' : '' }}">
  <a class="mr-0" href="{{route('services.index')}}">
    <i class="fas fa-list-ul"></i>
    <p>Servicios</p>
  </a>
</li>

<!--li>
  <a href="./map.html">
    <i class="fal fa-chalkboard-teacher"></i>
    <p>Asignación</p>
  </a>
</li>
<li>
  <a href="./notifications.html">
    <i class="nc-icon nc-tv-2"></i>
    <p>Certificados</p>
  </a>
</li>
<li>
  <a href="./user.html">
    <i class="nc-icon nc-tv-2"></i>
    <p>Video Conferencias</p>
  </a>
</li>
<li>
  <a href="./tables.html">
    <i class="nc-icon nc-money-coins"></i>
    <p>Pagos</p>
  </a>
</li-->