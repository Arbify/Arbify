@extends('layout')

@section('content')
    <div class="container">
        <h2 class="mb-3">Administration</h2>
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a href="{{ route('administration.statistics') }}"
                   class="nav-link @if(request()->route()->getName() == 'administration.statistics') active @endif">🚧 Statistics</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('administration.settings') }}"
                   class="nav-link @if(request()->route()->getName() == 'administration.settings') active @endif">Settings</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('administration.logs') }}"
                   class="nav-link @if(request()->route()->getName() == 'administration.logs') active @endif">🚧 Logs</a>
            </li>
        </ul>
    </div>

    @yield('administration-content')
@endsection
