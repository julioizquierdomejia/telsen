<div class="sidebar text-white d-print-none" data-color="white" data-active-color="danger">
  <div class="sidebar-top">
    <div class="logo text-center">
      <a href="/home" class="simple-text logo-normal">
        <div class="logo-image-big">
          <img src="/images/logo-white.png">
        </div>
      </a>
      <!-- <div class="col">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
      </div> -->
    </div>
    <div class="sidebar-account text-center pt-3">
      <h4 class="account-name">{{user_data()->name}}</h4>
      <p><a class="text-white" href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></p>
      <div class="logo-image-small">
        <span class="icon"><img src="/assets/img/logo-small.png" width="50" height="50"></span>
      </div>
    </div>
  </div>
  <div class="sidebar-wrapper pt-4">
    <ul class="nav">
      @if (Auth::user()->roles->count())
      @php
        $is_format = request()->segment(1) == 'formatos';
        $role_names = validateActionbyRole();
        $admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);

        $is_cc = request()->segment(1) == 'tarjeta-costo';
        $is_cz = request()->segment(1) == 'cotizaciones';
      @endphp
      <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
        <a href="{{ route('home')}}">
          <i class="nc-icon nc-tv-2"></i>
          <p>Dashboard</p>
        </a>
      </li>
      @if ($admin || in_array("crear_ot", $role_names) || in_array("evaluador", $role_names) || in_array("aprobador_de_evaluaciones", $role_names) || in_array("tarjeta_de_costo", $role_names) || in_array("aprobador_cotizacion_tarjeta_de_costo", $role_names))
      <li class="{{ request()->segment(1) == 'ordenes' ? 'active' : '' }}">
        <a href="/ordenes">
          <i class="fal fa-network-wired"></i>
          <p>Ordenes de trabajo</p>
        </a>
      </li>
      @endif
      @if ($admin || in_array("evaluador", $role_names) || in_array("aprobador_de_evaluaciones", $role_names))
      <li class="{{ $is_format ? 'active' : '' }}">
        <a href="#" data-toggle="collapse" data-target="#collapseFormatos" aria-expanded="true">
          <i class="fal fa-file-check"></i>
          <p>Evaluaciones <i class="fal fa-angle-down float-right"></i></p>
        </a>
        <ul class="collapse list-inline pl-3 {{$is_format ? 'show': ''}}" id="collapseFormatos">
          <li class="{{ request()->routeIs('formatos.pending_ots') ? 'active' : '' }}">
            <a class="mr-0" href="{{route('formatos.pending_ots')}}">
              <i class="fas fa-charging-station"></i>
              <p>Por aprobar</p>
            </a>
          </li>
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
      @endif
      @if ($admin || in_array("rdi", $role_names) || in_array("aprobador_rdi", $role_names))
      <li class="{{ request()->segment(1) == 'rdi' ? 'active' : '' }}">
        <a href="/rdi">
          <i class="fal fa-network-wired"></i>
          <p>RDI</p>
        </a>
      </li>
      @endif
      @if ($admin || in_array("tarjeta_de_costo", $role_names) || in_array("cotizador_tarjeta_de_costo", $role_names))
      <li class="{{ $is_cc ? 'active' : '' }}">
        <a class="mr-0" href="#" data-toggle="collapse" data-target="#collapseCC" aria-expanded="true">
          <i class="fas fa-money-check-alt"></i>
          <p>Tarjeta de Costos <i class="fal fa-angle-down float-right"></i></p>
        </a>
        <ul class="collapse list-inline pl-3 {{ $is_cc ? 'show' : '' }}" id="collapseCC">
          @if ($admin || in_array("tarjeta_de_costo", $role_names))
          <li class="{{ request()->routeIs('card_cost.index') ? 'active' : '' }}">
            <a class="mr-0" href="{{route('card_cost.index')}}">
              <i class="fas fa-money-check-alt"></i>
              <p>Generar</p>
            </a>
          </li>
          @endif
          @if($admin || in_array("cotizador_tarjeta_de_costo", $role_names))
          <li class="{{ request()->segment(2) == 'pending' ? 'active' : '' }}">
            <a class="mr-0" href="{{route('card_cost.pending')}}">
              <i class="fas fa-charging-station"></i>
              <p>Por cotizar</p>
            </a>
          </li>
          @endif
        </ul>
      </li>
      @endif
      @if ($admin || in_array("aprobador_cotizacion_tarjeta_de_costo", $role_names))
      <li class="{{ $is_cz ? 'active' : '' }}">
        <a class="mr-0" href="{{route('card_cost.cz')}}">
          <i class="fas fa-money-check-alt"></i>
          <p>Cotizaciones</p>
        </a>
      </li>
      @endif
      @if ($admin)
      <li class="{{ request()->segment(1) == 'talleres' ? 'active' : '' }}">
        <a href="/talleres">
          <i class="fal fa-user-hard-hat"></i>
          <p>Talleres</p>
        </a>
      </li>
      @endif
      @if ($admin)
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
      @endif
    @endif
  </ul>
</div>
</div>