<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
  <a href="/home">
    <i class="nc-icon nc-tv-2"></i>
    <p>Dashboard</p>
  </a>
</li>

<li class="{{ request()->routeIs('ordenes') ? 'active' : '' }}">
  <a href="/ordenes">
    <i class="fal fa-network-wired"></i>
    <p>Ordenes de trabajo</p>
  </a>
</li>

<li class="{{ request()->routeIs('clientes') ? 'active' : '' }}">
  <a href="{{route('clientes.index')}}">
    <i class="fal fa-handshake"></i>
    <p>Clientes</p>
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