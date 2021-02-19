<header class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent flex-wrap">
<nav class="container-fluid container-nav">
  <div class="navbar-toggle">
        <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
        </button>
    </div>
    <div class="navbar-wrapper">
      <a class="btn-link" href="/"><i class="fa fa-envelope"></i> mantenimiento@telsen.net</a>
      <a class="btn-link" href="tel:515642536"><i class="fa fa-phone"></i> +51 564-2536</a>
    </div>
    <div class="collapse navbar-collapse justify-content-end" id="navigation">
      <!--form>
        <div class="input-group no-border">
          <input type="text" value="" class="form-control" placeholder="Search...">
          <div class="input-group-append">
            <div class="input-group-text">
              <i class="nc-icon nc-zoom-split"></i>
            </div>
          </div>
        </div>
      </form-->
      <ul class="navbar-nav">
        <!--li class="nav-item">
          <a class="nav-link btn-magnify" href="javascript:;">
            <i class="nc-icon nc-layout-11"></i>
            <p>
              <span class="d-lg-none d-md-block">Stats</span>
            </p>
          </a>
        </li-->
        <li class="nav-item btn-rotate dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="nc-icon nc-bell-55"></i>
            <p>
              <span class="d-lg-none d-md-block">Some Actions</span>
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <!--li class="nav-item">
          <a class="nav-link btn-rotate" href="javascript:;">
            <i class="nc-icon nc-settings-gear-65"></i>
            <p>
              <span class="d-lg-none d-md-block">Account</span>
            </p>
          </a>
        </li-->
        <!-- Authentication Links -->
        @guest
            <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle text-lowercase" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->email }} <span class="icon"><img src="/assets/img/logo-small.png" width="30" height="30"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('users.perfil') }}">
                        Mi Perfil
                    </a>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
      </ul>
    </div>
</nav>
</header>