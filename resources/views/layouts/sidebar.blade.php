<ul class="nav">
	{{Auth::user()->name}}
  @if ( Auth::user()->roles->first()->name == 'superadmin')
    @include('layouts.superadminsidebar')
  @endif
  @if ( Auth::user()->roles->first()->name == 'adim')
    @include('layouts.adminsidebar')
  @endif
  @if ( Auth::user()->roles->first()->name == 'user')
    @include('layouts.usersidebar')
  @endif

</ul>