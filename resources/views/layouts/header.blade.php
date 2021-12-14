<div class="topbar">

    <div class="topbar-left	d-none d-lg-block">
        <div class="text-center">
            <a href="#" class="logo"><img src="{{ asset('assets/images/logo-dark.png') }}" height="50"
                    alt="logo"></a>
        </div>
    </div>

    <nav class="navbar-custom">

        <ul class="navbar-nav ml-auto pull-right">
            <li>
              <select class="form-select" aria-label="Default select example" id="lang">
                <option value="en" @if ( Config::get('app.locale') == 'en') selected="selected" @endif>English</option>
                <option value="fr" @if ( Config::get('app.locale') == 'fr') selected="selected" @endif>French</option>
            
              </select>

              </li>
             
            @guest
            @else
                <li class="nav-item dropdown">
                    <li>
                        <select class="form-select" aria-label="Default select currency" name="currency" class="select" id="currency">
                          <option value="Inr">INR</option>
                          <option value="Euro">EURO</option>
                      
                        </select>
          
                        </li>
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" style="color: black;" href="#" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->email }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
               
            @endguest
        </ul>

        <div class="clearfix"></div>

    </nav>

</div>
