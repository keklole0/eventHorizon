@extends('layouts.app')
@section('title', 'Главная')
@section('content')
    <div class="main-content">
        <section class="search-section">
            <div class="container">
                <h2 class="search-title">Поиск мероприятий</h2>
                <form class="search-form">
                    <div class="search-input-group">
                        <input type="text" class="search-input" placeholder="Название мероприятия" id="search-input">
                        <div class="autocomplete-results" id="autocomplete-results"></div>
                        <button type="submit" class="search-btn">
                            <img src="{{ asset('images/Vector (2).svg') }}" class="search-icon" alt="search-icon">
                        </button>
                    </div>
                    <input type="date" id="event-date" class="filter-input" placeholder="Укажите Дату">
                </form>
            </div>
        </section>
        <section class="slider-section">
            <div class="slider">
                <div class="container">
                    <h2 class="events-title">Популярные мероприятия</h2>
                </div>
                <div class="slider-track">
                    @foreach($popularEvents as $event)
                    <div class="slide">
                        <img src="{{ asset('storage/' . $event->preview_image) }}" alt="{{ $event->title }}" class="slide-image">
                        <div class="slide-overlay">
                            <h3 class="slide-title">{{ $event->title }}</h3>
                            <!-- <p class="slide-text">{{ $event->description }}</p> -->
                            <div style="margin-top: 15px;">
                                <a href="{{ route('events.show', $event->id) }}" class="btn">Подробнее</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="slider-arrow slider-arrow-prev">
                    <img src="{{ asset('images/arrow-left.svg') }}" alt="Предыдущий" class="arrows">
                </button>
                <button class="slider-arrow slider-arrow-next">
                    <img src="{{ asset('images/arrow-right.svg') }}" alt="Следующий" class="arrows">
                </button>
            </div>
        </section>
        <section class="categories-section">
            <div class="container">
                <h2 class="events-title">Популярные Категории</h2>
                <div class="categories-scroll">
                    @foreach($categories->take(8) as $category)
                    <a href="{{ route('categories.show', $category) }}" class="category-scroll-card">
                        {{ $category->title }}
                    </a>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="events-section">
            <div class="container">
                <h2 class="events-title">Мероприятия</h2>
                <div class="events-grid" id="events-container">
                    @foreach($events as $event)
                    <a href="{{ route('events.show', $event->id) }}" class="event-link">
                        <div class="event-card">
                            <img src="{{ asset('storage/' . $event->preview_image) }}" alt="{{ $event->title }}" class="event-image">
                            <div class="event-info">
                                <h3 class="event-name">{{ $event->title }}</h3>
                                <p class="event-location">Место: {{ $event->address->city }}</p>
                                <p class="event-time">Время: {{ $event->date_start->format('H:i, d.m.Y') }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="load-more-container">
                    <button id="load-more" class="load-more-btn">Показать ещё</button>
                </div>
            </div>
        </section>
    </div>

    <!-- Модальное окно для мероприятий -->
    <div id="eventModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 id="modalEventDate"></h2>
            <div id="modalEventsList"></div>
        </div>
    </div>
@endsection
@include('layouts.footer')
