<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            {{ Breadcrumbs::current() ? Breadcrumbs::current()->title . ' ‹ ' : '' }}{{ config('app.name', 'Arbify') }}
        </title>

        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        @stack('head')
    </head>
    <body>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    {{ config('app.name', 'Arbify') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('projects.index') }}" class="nav-link">Projects</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('languages.index') }}" class="nav-link">Languages</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">Users</a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link" style="color: rgba(0, 0, 0, .3)" data-toggle="tooltip" title="Not implemented yet">Administration</a>
                            </li>
                        @endauth
                    </ul>

                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a href="{{ route('account.preferences') }}" class="dropdown-item">
                                        Preferences
                                    </a>
                                    <a href="{{ route('account.change-password') }}" class="dropdown-item">
                                        Change password
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @section('breadcrumbs')
                <nav class="container mb-4">
                    {{ Breadcrumbs::render() }}
                </nav>
            @endsection
            @yield('breadcrumbs')

            @yield('content')
        </main>

        <script src="{{ asset('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
