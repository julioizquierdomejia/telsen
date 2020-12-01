<li class="{{ request()->routeIs('home') ? 'active' : '' }}">
  <a href="{{ route('home')}}">
    <i class="nc-icon nc-tv-2"></i>
    <p>Dashboard</p>
  </a>
</li>

<li class="{{ request()->segment(1) == 'rdi' ? 'active' : '' }}">
  <a href="/rdi">
    <i class="fal fa-network-wired"></i>
    <p>RDI</p>
  </a>
</li>