@guest
    <nav class="navbar sticky-top navbar-expand-md bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand text-white" href="{{ url('/') }}">
                <!-- Logo Image -->
                <img src="{{ asset('profiles/download.png') }}" width="80" alt="Logo Image"
                    class="d-inline-block align-middle mr-2">
                <!-- Logo Text -->
                <span class="text-uppercase font-weight-bold">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto" style="align-items: center">
                    @if (Request::path() == 'register')
                        <li class="nav-item">
                            <a class="btn cmn-btn"" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @elseif (request()->is('password*'))
                        <li class="nav-item">
                            <a class="btn cmn-btn" style="margin-right: 10px;"
                                href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn cmn-btn" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
@endguest
@if (Auth::check())
    <nav class="navbar sticky-top navbar-expand-md bg-white shadow-sm">
        <div class="container">


            <a class="navbar-brand text-white" href="{{ url('/') }}">
                <!-- Logo Image -->
                <img src="{{ asset('profiles/download.png') }}" width="80" alt="Logo Image"
                    class="d-inline-block align-middle mr-2">
                <!-- Logo Text -->
                <span class="text-uppercase font-weight-bold">{{ config('app.name', 'Laravel') }}</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    @if (Auth::user() && Auth::user()->type == '0')
                        <li class="nav-item">
                            <a href="/users"
                                class="nav-link link {{ request()->is('user*') ? 'active' : '' }}">Users</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="/posts" class="nav-link link {{ request()->is('posts') ? 'active' : '' }}"
                            aria-current="page">Posts</a>
                    </li>
                    <li class="nav-item d-md-block d-lg-none">
                        <a href="{{ route('posts.my-posts') }}"
                            class="nav-link link {{ request()->is('posts/my-posts') ? 'active' : '' }}" aria-current="page">My
                            Post</a>
                    </li>


                </ul>


                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto" style="align-items: center">
                    <!-- Authentication Links -->
                    @if (Auth::user() && Auth::user()->type == '0')
                        <li class="nav-item d-none d-lg-block" style="margin-right: 10px;">
                            <a class="btn cmn-btn" href="{{ route('users.create') }}">{{ __('Create User') }}<i
                                    class="bi bi-person-plus-fill"></i></a>
                        </li>
                    @endif
                    {{-- @if (Auth::user() && Auth::user()->type == '1') --}}
                    <li class="nav-item d-none d-lg-block">
                        <a class="btn cmn-btn" href="{{ route('posts.my-posts') }}">{{ __('My Posts') }}</a>
                    </li>
                    {{-- @endif --}}
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="/profiles/{{ Auth::user()->profile }}" class="profile">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('users.profile') }}">
                                {{ __('Profile') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('change.password') }}">
                                {{ __('Change Password') }}
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
                </ul>
            </div>
        </div>
    </nav>
@endif
