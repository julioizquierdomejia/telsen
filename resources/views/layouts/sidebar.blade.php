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
      @if (Auth::user()->roles->first())
        @include('layouts.sidebar.'.Auth::user()->roles->first()->name)
      @endif
    </ul>
  </div>
</div>