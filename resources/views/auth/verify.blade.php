@extends('layouts.app')

@section('content')
<div class="verify-section">
    <div class="verify-container">
        <h1 class="verify-title">{{ __('Подтвердите ваш Email') }}</h1>

        @if (session('resent'))
            <div class="verify-alert">
                {{ __('Новое письмо отправлено на вашу почту.') }}
            </div>
        @endif

        <p class="verify-message">
            {{ __('Перед продолжением проверьте вашу почту.') }}
            {{ __('Если вы не получили письмо') }}
        </p>

        <form method="POST" action="{{ route('verification.resend') }}" class="verify-form">
            @csrf
            <button type="submit" class="verify-btn">
                {{ __('Отправить письмо повторно') }}
            </button>
        </form>
    </div>
</div>
@endsection
@include('layouts.footer')