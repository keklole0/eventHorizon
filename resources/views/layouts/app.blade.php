@php
use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Event Horizon'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link href="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.6.0/dist/css/suggestions.min.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container-header">
            <a href="{{ route('home') }}" class="logo">Event Horizon</a>
            
            <div class="header__actions">
                @auth
                    <a href="{{ route('events.create') }}" class="create-event">
                        <i class="fas fa-plus"></i>
                        Создать мероприятие
                    </a>

                    <div class="user-menu">
                        <button class="user-menu__btn">
                            <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('images/default-avatar.svg') }}" 
                                 alt="Avatar" 
                                 class="user-menu__avatar">
                            <!-- Debug info -->
                            @if(auth()->user()->avatar)
                                <div style="display: none;">
                                    Debug: {{ auth()->user()->avatar }}
                                    Full path: {{ storage_path('app/public/' . auth()->user()->avatar) }}
                                    Asset path: {{ asset('storage/' . auth()->user()->avatar) }}
                                </div>
                            @endif
                            <i class="fas fa-chevron-down user-menu__icon"></i>
                        </button>
                        <div class="user-menu__dropdown">
                            <a href="{{ route('profile') }}" class="user-menu__item">
                                <i class="fas fa-user"></i>
                                Личный кабинет
                            </a>
                            <a href="#" class="user-menu__item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i>
                                Выход
                            </a>
                            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn">Войти</a>
                    <a href="{{ route('register') }}" class="btn">Регистрация</a>
                @endauth
            </div>

            <button class="burger-menu">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <main class="main">
        <div class="content-appear">
            @yield('content')
        </div>
    </main>
    @yield('footer')
    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>

    <!-- Query (необходим для DaData) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DaData suggestions JS -->
    <script src="https://cdn.jsdelivr.net/npm/suggestions-jquery@21.6.0/dist/js/jquery.suggestions.min.js"></script>

    @stack('scripts')
</body>

</html>