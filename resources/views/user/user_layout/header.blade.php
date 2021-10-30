<div class="topbar">

    <div class="topbar-left	d-none d-lg-block">
        <div class="text-center">
            <a href="#" class="logo"><img src="{{ asset('assets/images/logo-dark.png') }}" height="50" alt="logo"></a>
        </div>
    </div>
    <nav class="navbar-custom">
        <li class="nav-item dropdown pull-right">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" style="color: black;"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{Auth::user()->firstname}}
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('logout') }}">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <a class="dropdown-item update" href="#" data-toggle="modal" data-target="#updateprofile" id="{{ Auth::user()->id }}" > 
                    {{ __('Update Profile') }}
                </a>
               
            </div>
        </li>
        <div class="clearfix"></div>
    </nav>
</div>
@include('user.update_user')