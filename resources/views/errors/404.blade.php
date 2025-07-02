@extends('layouts.app')

@section('content')
<div class="error-section">
    <div class="error-container">
        <div class="error-content">
            <h1 class="error-title">404</h1>
            <h2 class="error-subtitle">{{ __('Страница не найдена') }}</h2>
            <p class="error-message">
                {{ __('Извините, но страница, которую вы ищете, не существует или была перемещена.') }}
            </p>
            <div class="error-actions">
                <a href="{{ url('/') }}" class="error-btn">
                    <i class="fas fa-home"></i>
                    {{ __('На главную') }}
                </a>
                <a href="javascript:history.back()" class="error-btn error-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    {{ __('Назад') }}
                </a>
            </div>
        </div>
        <div class="error-image">
            <img src="{{ asset('images/404.svg') }}" alt="404 Error">
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection 