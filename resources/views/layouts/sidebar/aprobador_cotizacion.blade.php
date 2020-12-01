<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
  <a href="/home">
    <i class="nc-icon nc-tv-2"></i>
    <p>Dashboard</p>
  </a>
</li>

<li class="{{ request()->segment(1) == 'card_cost' ? 'active' : '' }}">
  <a class="mr-0" href="{{route('card_cost.index')}}">
    <i class="fas fa-money-check-alt"></i>
    <p>Tarjeta de Costos</p>
  </a>
</li>