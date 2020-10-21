<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
    <a href="{{ route('home') }}">
      <i class="fal fa-tachometer-alt-fastest"></i>
      <p>Dashboard</p>
    </a>
  </li>

  <li class="{{ request()->routeIs('user') ? 'active' : '' }}">
    <a href="{{ route('user') }}">
      <i class="fal fa-user-md"></i>
      <p>Mi perfil</p>
    </a>
  </li>


<li>
  <a href="./icons.html">
    <i class="fal fa-chart-line"></i>
    <p>Mi actividad</p>
  </a>
</li>