<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
  <a href="{{ route('home') }}">
    <i class="nc-icon nc-tv-2"></i>
    <p>Dashboard</p>
  </a>
</li>

<li class="{{ request()->routeIs('user') ? 'active' : '' }}">
  <a href="{{ route('home') }}">
    <i class="nc-icon nc-tv-2"></i>
    <p>Mi perfil</p>
  </a>
</li>

<li class="{{ request()->routeIs('matri') ? 'active' : '' }}">
  <a href="{{ route('home') }}">
    <i class="nc-icon nc-tv-2"></i>
    <p>Matrículas</p>
  </a>
</li>

<li>
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
</li>