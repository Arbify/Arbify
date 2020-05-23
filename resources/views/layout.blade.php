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
    <body class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand logo" href="{{ route('dashboard') }}">
                        <u>.Arb</u>ify
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @can('view-any', App\Models\Project::class)
                                <li class="nav-item">
                                    <a href="{{ route('projects.index') }}" class="nav-link">Projects</a>
                                </li>
                            @endcan
                            @can('view-any', App\Models\Language::class)
                                <li class="nav-item">
                                    <a href="{{ route('languages.index') }}" class="nav-link">Languages</a>
                                </li>
                            @endcan
                            @can('view-any', App\Models\User::class)
                                <li class="nav-item">
                                    <a href="{{ route('users.index') }}" class="nav-link">Users</a>
                                </li>
                            @endcan
                            <li class="nav-item">
                                <a href="#" class="nav-link" style="color: rgba(0, 0, 0, .3)" data-toggle="tooltip" title="Not implemented yet">Administration</a>
                            </li>
                        @endauth
                    </ul>

                    <ul class="navbar-nav ml-auto">
                        <a href="https://github.com/Arbify/Arbify" class="nav-link d-inline-flex align-items-center mr-3">
                            <svg width="16" height="16" viewBox="0 0 16 16" version="1.1" fill="currentColor">
                                <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z">
                            </svg>
                        </a>
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

        <footer class="mt-auto py-4">
            <div class="container">
                <span class="text-super-muted">
                    Country flag icons made by <a href="https://www.flaticon.com/authors/freepik">Freepik</a>
                    from <a href="https://www.flaticon.com/">www.flaticon.com</a>.
                </span>
            </div>
        </footer>

        @include('partials.modal')
        <script src="{{ asset('js/app.js') }}"></script>
        @stack('scripts')
    </body>
</html>
