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

<li class="{{ request()->segment(1) == 'clientes' ? 'active' : '' }}">
  <a href="/clientes">
    <i class="fal fa-handshake"></i>
    <p>Clientes</p>
  </a>
</li>