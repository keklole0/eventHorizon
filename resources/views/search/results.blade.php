@extends('layouts.app')
@section('title', 'Результаты поиска')
@section('content')
    <section id="bread">
        <div class="container">
            <div class="block-bread">
                <a href="/" class="bread-link">Главная</a>
                <span class="arrow">&#10095;</span>
                <a href="" class="bread-link">Результаты поиска</a>
            </div>
        </div>
    </section>

    <section class="search-results-section">
        <div class="container">
            <div class="search-results-header">
                <h1 class="search-results-title">
                    @if($query || $date)
                        Результаты поиска
                        @if($query)
                            по запросу "{{ $query }}"
                        @endif
                        @if($date)
                            на дату {{ \Carbon\Carbon::parse($date)->format('d.m.Y') }}
                        @endif
                    @else
                        Все мероприятия
                    @endif
                </h1>
                <div class="search-results-count">
                    Найдено мероприятий: {{ $events->total() }}
                </div>
            </div>

            @if($events->isEmpty())
                <div class="no-results">
                    <p>К сожалению, по вашему запросу ничего не найдено.</p>
                    <p>Попробуйте изменить параметры поиска или вернитесь на <a href="{{ route('home') }}">главную страницу</a>.</p>
                </div>
            @else
                <div class="events-grid">
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

                <div class="pagination-container">
                    {{ $events->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection 