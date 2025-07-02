@extends('layouts.app')

@section('content')
<div class="about-section">
    <div class="about-container">
        <h1 class="about-title">{{ __('О нас') }}</h1>
        
        <div class="about-content">
            <div class="about-text">
                <p class="about-paragraph">
                    {{ __('Мы - команда энтузиастов, создавших платформу для организации и поиска мероприятий. Наша цель - объединить людей, которые хотят проводить интересные события, и тех, кто хочет в них участвовать.') }}
                </p>
                
                <h2 class="about-subtitle">{{ __('Наша миссия') }}</h2>
                <p class="about-paragraph">
                    {{ __('Мы стремимся сделать организацию и посещение мероприятий простым и приятным процессом. Наша платформа помогает организаторам эффективно управлять своими событиями, а посетителям - находить интересные мероприятия рядом с ними.') }}
                </p>

                <h2 class="about-subtitle">{{ __('Наши преимущества') }}</h2>
                <div class="about-features">
                    <div class="feature-item">
                        <i class="fas fa-calendar-check"></i>
                        <h3>{{ __('Удобное планирование') }}</h3>
                        <p>{{ __('Простой и интуитивно понятный интерфейс для создания и управления мероприятиями') }}</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-users"></i>
                        <h3>{{ __('Большая аудитория') }}</h3>
                        <p>{{ __('Доступ к широкой аудитории потенциальных участников') }}</p>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-shield-alt"></i>
                        <h3>{{ __('Безопасность') }}</h3>
                        <p>{{ __('Надежная система бронирования и оплаты') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection 