@extends('layouts.app')

@section('title', $category->title)

@section('content')
<div class="main-content">
    <div id="bread">
        <div class="container">
            <div class="block-bread">
                <a href="{{ route('home') }}" class="bread-link">Главная</a>
                <span class="arrow">→</span>
                <span class="bread-link">{{ $category->title }}</span>
            </div>
        </div>
    </div>

    <section class="categories-section">
        <div class="container">
            <h2 class="categories-title">Категория: {{ $category->title }}</h2>
            <div class="categories-container">
                <button class="category-nav-btn category-nav-prev" aria-label="Предыдущая категория">←</button>
                <div class="categories-grid">
                    @foreach($categories as $cat)
                        <a href="{{ route('categories.show', $cat) }}" class="category-card {{ $cat->id === $category->id ? 'active' : '' }}">
                            {{ $cat->title }}
                        </a>
                    @endforeach
                </div>
                <button class="category-nav-btn category-nav-next" aria-label="Следующая категория">→</button>
            </div>
        </div>
    </section>

    <section class="events-section">
        <div class="container">
            <h2 class="events-title">Мероприятия в категории "{{ $category->title }}"</h2>
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
            <div class="pagination">
                {{ $events->links() }}
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.querySelector('.categories-grid');
    const prevBtn = document.querySelector('.category-nav-prev');
    const nextBtn = document.querySelector('.category-nav-next');
    const scrollAmount = 300;

    // Прокручиваем к началу при загрузке страницы
    grid.scrollTo({
        left: 0,
        behavior: 'auto'
    });

    if (prevBtn) {
        prevBtn.addEventListener('click', function() {
            grid.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function() {
            grid.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    }
});
</script>
@endpush

@include('layouts.footer')
@endsection 