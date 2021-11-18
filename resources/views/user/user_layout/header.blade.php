<!-- Header -->
<header class="">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <h2>Stand Blog<em>.</em></h2>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        @if (Route::has('dashboard'))
                            <a class="nav-link" href="{{ route('dashboard') }}">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        @else
                            <a class="nav-link" href="{{ route('dashboard') }}">Home
                            </a>
                        @endif
                    </li>
                    @if (Auth::user())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('blog.createblog') }}">Start Writing
                                <span class="sr-only">(current)</span></a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.login') }}">
                                Strat Writing</a>
                        </li>
                    @endif
                    @if (Auth::user())
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" href="#"
                                aria-haspopup="true" aria-expanded="false" v-pre>{{ Auth::user()->firstname }}
                                <span class="sr-only">(current)</span>

                                <div class="dropdown-menu dropdown-menu-right">
                                    @if (Auth::check())
                                        @if (count(Auth::user()->blogs) > 0)
                                            <a class="dropdown-item" href="{{ route('blog.edit',Auth::user()->id)}}">
                                                
                                                {{ __('Edit Blogs') }}
                                            </a>
                                        @endif
                                    @endif
                                    <a class="dropdown-item update" href="{{ route('update') }}" data-toggle="modal"id="{{Auth::user()->id}}" data-target="#updateprofile" >
                                        {{ __('Edit Profile') }}
                                     
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="get"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.login') }}">Login</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @include('user.update_user');
</header>
