<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
  <a href="{{ route('home')}}">
    <i class="nc-icon nc-tv-2"></i>
    <p>Dashboard</p>
  </a>
</li>

<li class="{{ request()->segment(2) == 'mechanical' ? 'active' : '' }}">
  <a class="mr-0" href="{{route('formatos.mechanical')}}">
    <i class="fas fa-wrench"></i>
    <p>F. Evaluación Mecánica</p>
  </a>
</li>