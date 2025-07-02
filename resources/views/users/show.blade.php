@extends('layouts.app')
@section('title', 'Профиль пользователя')
@section('content')
<section class="profile-section">
    <div class="profile-container">
        <!-- Боковая панель профиля -->
        <div class="profile-sidebar">
            <div class="profile-avatar">
                <img src="{{ $user->avatar_url }}" alt="Аватар пользователя">
                <div style="font-size:12px;color:#888;word-break:break-all;">avatar: {{ $user->avatar }}</div>
            </div>
            <div class="profile-info">
                <h2 class="profile-name">{{ $user->username }}</h2>
            </div>
            <div class="profile-stats">
                <div class="stat-item">
                    <div class="stat-value">{{ $user->events_count }}</div>
                    <div class="stat-label">Мероприятий</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $user->participations_count }}</div>
                    <div class="stat-label">Участий</div>
                </div>
            </div>
        </div>

        <!-- Основной контент -->
        <div class="profile-content">
            <div class="profile-events">
                <h2 class="section-title">Организованные мероприятия</h2>
                <div class="events-grid">
                    @forelse($user->events as $event)
                    <a href="{{ route('events.show', $event->id) }}" class="event-card">
                        <div class="event-image">
                            <img src="{{ asset('storage/' . $event->main_image) }}" alt="{{ $event->title }}">
                        </div>
                        <div class="event-info">
                            <h3 class="event-name">{{ $event->title }}</h3>
                            <div class="event-meta">
                                <span class="event-date">{{ $event->date_start->format('d.m.Y') }}</span>
                                <span class="event-location">{{ $event->address->city }}</span>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="no-events">
                        <p>Пользователь пока не организовал ни одного мероприятия</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="profile-reviews">
                <h2 class="section-title">Отзывы</h2>
                @auth
                    @if(Auth::id() !== $user->id)
                        <div class="review-form-container">
                            <form action="{{ route('reviews.store', $user) }}" method="POST" class="review-form">
                                @csrf
                                <div class="form-group">
                                    <textarea name="comment" class="review-input" placeholder="Напишите отзыв о пользователе..." rows="4" required></textarea>
                                    @error('comment')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="review-submit">
                                        <i class="fas fa-paper-plane"></i> Отправить отзыв
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                @endauth
                <div class="reviews-list">
                    @forelse($user->reviews as $review)
                    <div class="review-card">
                        <div class="review-header">
                            @if($review->reviewer)
                            <a href="{{ route('users.show', $review->reviewer->id) }}" class="reviewer-info">
                                <img src="{{ $review->reviewer->avatar_url }}" alt="{{ $review->reviewer->username }}" class="reviewer-avatar">
                                <span class="reviewer-name">{{ $review->reviewer->username }}</span>
                                <!-- <div style="font-size:11px;color:#888;word-break:break-all;">avatar: {{ $review->reviewer->avatar }}</div>
                                <div style="font-size:11px;color:#c00;">
                                    reviewer: {{ get_class($review->reviewer) }}<br>
                                    avatar: {{ $review->reviewer->avatar }}<br>
                                    avatar_url: {{ $review->reviewer->avatar_url ?? 'нет аксессора' }}
                                </div> -->
                            </a>
                            @else
                            <div class="reviewer-info">
                                <img src="{{ asset('images/default-avatar.svg') }}" alt="Анонимный пользователь" class="reviewer-avatar">
                                <span class="reviewer-name">Анонимный пользователь</span>
                            </div>
                            @endif
                        </div>
                        <div class="review-content">
                            <p>{{ $review->comment }}</p>
                        </div>
                        <div class="review-date">{{ $review->created_at->format('d.m.Y') }}</div>
                    </div>
                    @empty
                    <div class="no-reviews">
                        <p>Пока нет отзывов</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
@include('layouts.footer')
@endsection 