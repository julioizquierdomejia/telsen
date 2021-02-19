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
        $segment_1 = request()->segment(1);
        $segment_2 = request()->segment(2);
        $is_format = $segment_1 == 'formatos';
        $role_names = validateActionbyRole();
        $admin = in_array("superadmin", $role_names) || in_array("admin", $role_names);
        $supervisor = in_array("supervisor", $role_names);
        $role_closure = in_array("closure", $role_names);
        $evaluador = in_array("evaluador", $role_names);
        $rdi = in_array("rdi", $role_names);
        $aprobador_rdi = in_array("aprobador_rdi", $role_names);
        $tarjeta_costo = in_array("tarjeta_de_costo", $role_names);

        $is_cc = $segment_1 == 'tarjeta-costo';
        $is_cz = $segment_1 == 'cotizaciones';
        $is_delivery = $segment_1 == 'fecha-entrega';

        $is_rotorcode = $segment_1 == 'rotorcoderodajept';
      @endphp
      <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
        <a href="{{ route('home')}}">
          <i class="nc-icon nc-tv-2 mr-1"></i>
          <p>Dashboard</p>
        </a>
      </li>
      @if ($admin)
      <li class="{{ request()->routeIs('ordenes.index') ? 'active' : '' }}">
        <a href="/ordenes">
          <i class="fal fa-network-wired mr-1"></i>
          <p>Ordenes de trabajo</p>
        </a>
      </li>
      <li class="{{ request()->routeIs('ordenes.priority_ots') ? 'active' : '' }}">
        <a class="pr-2" href="{{route('ordenes.priority_ots')}}">
          <i class="fal fa-network-wired mr-1"></i>
          <p>OTS de Prioridad <i class="fal fa-exclamation-triangle float-right"></i></p>
        </a>
      </li>
      @endif
      @if ($admin || $evaluador || in_array("aprobador_de_evaluaciones", $role_names))
      <li class="{{ $is_format ? 'active' : '' }}">
        <a href="#" data-toggle="collapse" data-target="#collapseFormatos" aria-expanded="true">
          <i class="fal fa-file-check mr-1"></i>
          <p>Evaluaciones <i class="fal fa-angle-down float-right"></i></p>
        </a>
        <ul class="collapse list-inline pl-3 {{$is_format ? 'show': ''}}" id="collapseFormatos">
          @if (!$evaluador)
          <li class="{{ request()->routeIs('formatos.pending_ots') ? 'active' : '' }}">
            <a class="mr-0" href="{{route('formatos.pending_ots')}}">
              <i class="fas fa-charging-station mr-1"></i>
              <p>Por aprobar</p>
            </a>
          </li>
          @endif
          <li class="{{ $segment_2 == 'electrical' ? 'active' : '' }}">
            <a class="mr-0" href="{{route('formatos.electrical')}}">
              <i class="fas fa-charging-station mr-1"></i>
              <p>F. Evaluación Eléctrica</p>
            </a>
          </li>
          <li class="{{ $segment_2 == 'mechanical' ? 'active' : '' }}">
            <a class="mr-0" href="{{route('formatos.mechanical')}}">
              <i class="fas fa-wrench mr-1"></i>
              <p>F. Evaluación Mecánica</p>
            </a>
          </li>
        </ul>
      </li>
      @endif
      @if ($admin || $rdi || $aprobador_rdi)
      <li class="{{ $segment_1 == 'rdi' ? 'active' : '' }}">
        <a class="mr-0" href="#" data-toggle="collapse" data-target="#collapseRDI" aria-expanded="true">
          <i class="fal fa-network-wired mr-1"></i>
          <p>RDI <i class="fal fa-angle-down float-right"></i></p>
        </a>
        <ul class="collapse list-inline pl-3 {{ $segment_1 == 'rdi' ? 'show' : '' }}" id="collapseRDI">
          @if ($admin || $rdi)
          <li class="{{ request()->routeIs('rdi.index') ? 'active' : '' }}">
            <a class="mr-0" href="{{route('rdi.index')}}">
              <i class="fas fa-money-check-alt mr-1"></i>
              <p>Generar</p>
            </a>
          </li>
          @endif
          @if($admin || $aprobador_rdi)
          <li class="{{ request()->routeIs('rdi.list_group') ? 'active' : '' }}">
            <a class="mr-0" href="{{route('rdi.list_group')}}">
              <i class="fas fa-charging-station mr-1"></i>
              <p>Aprobar RDI</p>
            </a>
          </li>
          @endif
        </ul>
      </li>
      @endif
      @if ($admin || $tarjeta_costo || in_array("cotizador_tarjeta_de_costo", $role_names))
      <li class="{{ $is_cc ? 'active' : '' }}">
        <a class="mr-0" href="#" data-toggle="collapse" data-target="#collapseCC" aria-expanded="true">
          <i class="fas fa-money-check-alt mr-1"></i>
          <p>Tarjeta de Costos <i class="fal fa-angle-down float-right"></i></p>
        </a>
        <ul class="collapse list-inline pl-3 {{ $is_cc ? 'show' : '' }}" id="collapseCC">
          @if ($admin || $tarjeta_costo)
          <li class="{{ request()->routeIs('card_cost.index') ? 'active' : '' }}">
            <a class="mr-0" href="{{route('card_cost.index')}}">
              <i class="fas fa-money-check-alt mr-1"></i>
              <p>Generar</p>
            </a>
          </li>
          @endif
          @if($admin || in_array("cotizador_tarjeta_de_costo", $role_names))
          <li class="{{ $segment_2 == 'pending' ? 'active' : '' }}">
            <a class="mr-0" href="{{route('card_cost.pending')}}">
              <i class="fas fa-charging-station mr-1"></i>
              <p>Por cotizar</p>
            </a>
          </li>
          @endif
        </ul>
      </li>
      @endif
      @if ($admin || $supervisor)
      <li class="{{ $segment_1 == 'talleres' ? 'active' : '' }}">
        <a href="/talleres">
          <i class="fal fa-user-hard-hat mr-1"></i>
          <p>Talleres</p>
        </a>
      </li>
      @endif
      @if ($admin || in_array("aprobador_cotizacion_tarjeta_de_costo", $role_names))
      <li class="{{ $is_cz ? 'active' : '' }}">
        <a class="mr-0" href="{{route('card_cost.cz')}}">
          <i class="fas fa-money-check-alt mr-1"></i>
          <p>Cotizaciones</p>
        </a>
      </li>
      @endif
      @if ($admin || in_array("fecha_de_entrega", $role_names))
      <li class="{{ $is_delivery ? 'active' : '' }}">
        <a class="mr-0" href="{{route('delivery_date.index')}}">
          <i class="fas fa-calendar-week mr-1"></i>
          <p>Fecha de entrega</p>
        </a>
      </li>
      @endif
      @if ($admin || $supervisor || in_array("worker", $role_names))
      <li class="{{ request()->routeIs('workshop.tasks') ? 'active' : '' }}">
        <a class="mr-0" href="{{route('workshop.tasks')}}">
          <i class="fas fa-cogs mr-1"></i>
          <p>Mis tareas</p>
        </a>
      </li>
      @endif
      @if ($admin || $role_closure)
      <li class="{{ request()->routeIs('workshop.closure') ? 'active' : '' }}">
        <a class="mr-0" href="{{route('workshop.closure')}}">
          <i class="fas fa-file-contract mr-1"></i>
          <p>Cierre de OTs</p>
        </a>
      </li>
      @endif
      @if ($admin)
      <li class="px-3"><hr style="border-top-color: #858585;"></li>
      <li class="{{ $segment_1 == 'clientes' ? 'active' : '' }}">
        <a href="{{route('clientes.index')}}">
          <i class="fal fa-handshake mr-1"></i>
          <p>Clientes</p>
        </a>
      </li>
      <li class="{{ $segment_1 == 'marcas' ? 'active' : '' }}">
        <a href="{{route('marcas.index')}}">
          <i class="fal fa-copyright mr-1"></i>
          <p>Marca de Motores</p>
        </a>
      </li>
      <li class="{{ $segment_1 == 'modelos' ? 'active' : '' }}">
        <a href="{{route('modelos.index')}}">
          <i class="fas fa-barcode mr-1"></i>
          <p>Modelo de Motores</p>
        </a>
      </li>
      <li class="{{ $segment_1 == 'areas' ? 'active' : '' }}">
        <a class="mr-0" href="{{route('areas.index')}}">
          <i class="fas fa-list-alt mr-1"></i>
          <p>Areas</p>
        </a>
      </li>
      <li class="{{ $segment_1 == 'servicios' ? 'active' : '' }}">
        <a class="mr-0" href="{{route('services.index')}}">
          <i class="fas fa-list-ul mr-1"></i>
          <p>Servicios</p>
        </a>
      </li>
      <li class="{{ $is_rotorcode ? 'active' : '' }}">
        <a class="mr-0" href="#" data-toggle="collapse" data-target="#collapseCRPt" aria-expanded="true">
          <i class="fas fa-barcode mr-1"></i>
          <p>Código Rotor Pt <i class="fal fa-angle-down float-right"></i></p>
        </a>
        <ul class="collapse list-inline pl-3 {{ $is_rotorcode ? 'show' : '' }}" id="collapseCRPt">
          <li class="{{ request()->routeIs('rotorcoderpt1.index') ? 'active' : '' }}">
            <a class="mr-0" href="{{route('rotorcoderpt1.index')}}">
              <i class="fas fa-barcode mr-1"></i>
              <p>1</p>
            </a>
          </li>
          <li class="{{ request()->routeIs('rotorcoderpt2.index') ? 'active' : '' }}">
            <a class="mr-0" href="{{route('rotorcoderpt2.index')}}">
              <i class="fas fa-barcode mr-1"></i>
              <p>2</p>
            </a>
          </li>
        </ul>
      </li>
      @endif
    @endif
  </ul>
</div>
</div>