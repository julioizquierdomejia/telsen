@if ( Auth::user()->roles->first()->name != 'client')
<div class="sidebar" data-color="white" data-active-color="danger">
  <div class="logo">
    <a href="https://www.creative-tim.com" class="simple-text logo-mini">
      <div class="logo-image-small">
        <img src="/assets/img/logo-small.png">
      </div>
      <!-- <p>CT</p> -->
    </a>
    <a href="#" class="simple-text logo-normal">
      Bienvenidos
      <!-- <div class="logo-image-big">
        <img src="../assets/img/logo-big.png">
      </div> -->
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
    {{Auth::user()->name}}
    @if ( Auth::user()->roles->first()->name == 'superadmin')
      @include('layouts.superadminsidebar')
    @endif
    @if ( Auth::user()->roles->first()->name == 'admin')
      @include('layouts.adminsidebar')
    @endif
    @if ( Auth::user()->roles->first()->name == 'user')
      @include('layouts.usersidebar')
    @endif
</ul>
  </div>
</div>
@endif