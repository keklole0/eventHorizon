@extends('layouts.app')

@section('content')
<div class="contacts-section">
    <div class="contacts-container">
        <h1 class="contacts-title">{{ __('Контакты') }}</h1>
        
        <div class="contacts-content">
            <div class="contacts-info">
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="contact-text">
                        <h3>{{ __('Адрес') }}</h3>
                        <p>{{ __('г. Москва, ул. Примерная, д. 123') }}</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <div class="contact-text">
                        <h3>{{ __('Телефон') }}</h3>
                        <p>+7 (999) 123-45-67</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <div class="contact-text">
                        <h3>{{ __('Email') }}</h3>
                        <p>info@example.com</p>
                    </div>
                </div>

                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <div class="contact-text">
                        <h3>{{ __('Режим работы') }}</h3>
                        <p>{{ __('Пн-Пт: 9:00 - 18:00') }}</p>
                        <p>{{ __('Сб-Вс: 10:00 - 16:00') }}</p>
                    </div>
                </div>
            </div>

            <div class="contact-form">
                <h2 class="form-title">{{ __('Свяжитесь с нами') }}</h2>
                <form action="{{ route('contacts.send') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ __('Ваше имя') }}</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">{{ __('Email') }}</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="message">{{ __('Сообщение') }}</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">
                        {{ __('Отправить') }}
                    </button>
                </form>
                @if(session('success'))
                    <div class="alert alert-success" style="margin-top: 18px;">{{ session('success') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection 