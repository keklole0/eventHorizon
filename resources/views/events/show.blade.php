@extends('layouts.app')
@section('title', $event->title)
@section('content')
    @php
        $currentCount = $event->participations->count();
        $max = $event->max_participants;
        $statuses = [
            'active' => 'Активно',
            'completed' => 'Завершено',
            'cancelled' => 'Отменено',
        ];
    @endphp
    <section id="bread">
        <div class="container">
            <div class="block-bread">
                <a href="/" class="bread-link">Главная</a>
                <span class="arrow">&#10095;</span>
                <a href="" class="bread-link">{{ $event->title }}</a>
            </div>
        </div>
    </section>
    
    <section class="event-container">
        <div class="event-header">
            <div class="event-photo">
                <img src="{{ asset('storage/' . $event->main_image) }}" alt="{{ $event->title }}" class="event-photo__img">
                <div class="event-badge">{{ $event->age_limit }}+</div>
            </div>
            
            <div class="event-header-content">
                <h1 class="event-title">{{ $event->title }}</h1>
                @auth
                    @if(auth()->id() === $event->creator->id)
                        <div class="event-actions">
                            <a href="{{ route('events.edit', $event->id) }}" class="event-btn event-btn-edit">
                                <i class="fas fa-edit"></i> Редактировать
                            </a>
                            <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="event-delete-form" onsubmit="return confirm('Вы уверены, что хотите удалить это мероприятие?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="event-btn event-btn-delete">
                                    <i class="fas fa-trash"></i> Удалить
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
                
                <div class="event-meta">
                    <div class="event-author">
                        <a href="{{ route('users.show', $event->creator->id) }}" class="author-link">
                            <img src="{{ $event->creator->avatar ? Storage::url($event->creator->avatar) : asset('images/default-avatar.svg') }}" alt="Avatar" class="author-avatar">
                            <span class="author-username">{{ $event->creator->username }}</span>
                        </a>
                    </div>
                    
                    <div class="like-container">
                        @auth
                            <form action="{{ route('events.like', $event) }}" method="POST" class="like-form">
                                @csrf
                                @method('POST')
                                <button type="submit" class="like-button {{ $event->is_liked ? 'active' : '' }}" 
                                        title="{{ $event->is_liked ? 'Убрать из избранного' : 'Добавить в избранное' }}">
                                    <i class="{{ $event->is_liked ? 'fas' : 'far' }} fa-heart"></i>
                                    <span class="like-count">{{ $event->likes_count }}</span>
                                </button>
                            </form>
                        @else
                            <button type="button" class="like-button" title="Войдите, чтобы добавить в избранное">
                                <i class="far fa-heart"></i>
                                <span class="like-count">{{ $event->likes_count }}</span>
                            </button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="event-content">
            <div class="event-main">
                <div class="event-details card">
                    <h2 class="section-title">О мероприятии</h2>
                    <div class="event-description">
                        <p>{{ $event->description }}</p>
                    </div>
                    
                    <div class="divider"></div>
                    
                    <div class="event-info">
                        <div class="info-row">
                            <div class="info-icon">
                                <i class="far fa-calendar-alt"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Дата и время</div>
                                <div class="info-value">{{ $event->date_start->format('d.m.Y') }}</div>
                                <div class="info-value">с {{ $event->date_start->format('H:i') }} до {{ $event->date_end->format('H:i') }}</div>
                            </div>
                        </div>
                        
                        @if($event->address)
                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Место проведения</div>
                                <div class="info-value">{{ $event->address->title }}</div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="info-row">
                            <div class="info-icon">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="info-content">
                                <div class="info-label">Возрастное ограничение</div>
                                <div class="info-value">{{ $event->age_limit }}+</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="event-participation-status card" style="margin-bottom: 18px; padding: 18px 20px; background: #f8f9fa; border-radius: 10px;">
                        <div style="font-size: 1.1em; margin-bottom: 6px;">
                            <b>Записалось:</b> {{ $currentCount }} из {{ $max }}
                        </div>
                        <div style="font-size: 1.1em; margin-bottom: 6px;">
                            <b>Статус:</b> {{ $statuses[$event->status] ?? $event->status }}
                        </div>
                        @if($currentCount >= $max)
                            <div style="color: #d9363e; font-weight: 500;">Запись на мероприятие завершена (мест нет)</div>
                        @endif
                    </div>
                    
                    @auth
                        @php
                            $alreadyParticipated = $event->participations->where('user_id', auth()->id())->count() > 0;
                            $isClosed = in_array($event->status, ['cancelled', 'completed']);
                        @endphp
                        @if(!$alreadyParticipated && $currentCount < $max && !$isClosed)
                            <button class="event-register-btn" id="participate-btn" data-event-id="{{ $event->id }}">
                                <i class="fas fa-ticket-alt"></i> Записаться на мероприятие
                            </button>
                        @elseif($alreadyParticipated)
                            <div style="color: #2563eb; font-weight: 500; margin-bottom: 10px;">Вы уже записаны на это мероприятие.</div>
                        @endif
                    @endauth
                    <div id="participate-message" style="margin-top:10px;"></div>
                </div>
                
                @if($event->address)
                <div class="event-location card">
                    <h2 class="section-title">Как добраться</h2>
                    <div id="event-map" style="width: 100%; height: 400px;"></div>
                </div>
                @endif
                
                <div class="event-comments card">
                    <h2 class="section-title">Комментарии <span class="comments-count">({{ $event->comments_count ?? 0 }})</span></h2>
                    
                    @if($event->comments->count() > 0)
                    <div class="comments-list">
                        @foreach($event->comments as $comment)
                        <div class="comment">
                            <div class="comment-avatar">
                                <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->user->username }}">
                            </div>
                            <div class="comment-content">
                                <div class="comment-header">
                                    <span class="comment-author">{{ $comment->user->username }}</span>
                                    <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="comment-text">{{ $comment->text }}</p>
                                <div class="comment-actions">
                                    <button class="comment-reply-btn" data-comment-id="{{ $comment->id }}">Ответить</button>
                                </div>
                                @if($comment->replies->count() > 0)
                                <div class="replies-list">
                                    @foreach($comment->replies as $reply)
                                    <div class="reply">
                                        <div class="reply-avatar">
                                            <img src="{{ $reply->user->avatar_url }}" alt="{{ $reply->user->username }}">
                                        </div>
                                        <div class="reply-content">
                                            <div class="reply-header">
                                                <span class="reply-author">{{ $reply->user->username }}</span>
                                                <span class="reply-time">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="reply-text">{{ $reply->text }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                <div class="reply-form-container" id="reply-form-{{ $comment->id }}" style="display: none;">
                                    @auth
                                    <form action="{{ route('replies.store', $comment) }}" method="POST" class="reply-form">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="text" class="reply-input" placeholder="Ваш ответ..." rows="3" required></textarea>
                                            @error('text')
                                                <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="reply-submit">
                                                <i class="fas fa-paper-plane"></i> Отправить
                                            </button>
                                        </div>
                                    </form>
                                    @else
                                    <div class="auth-required">
                                        <p>Для того чтобы ответить на комментарий, пожалуйста, <a href="{{ route('login') }}">войдите</a> или <a href="{{ route('register') }}">зарегистрируйтесь</a>.</p>
                                    </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="no-comments">
                        <p>Пока нет комментариев. Будьте первым, кто оставит отзыв!</p>
                    </div>
                    @endif
                    
                    <div class="comment-form-container">
                        <h3 class="form-title">Оставить комментарий</h3>
                        @auth
                        <form action="{{ route('comments.store', $event) }}" method="POST" class="comment-form">
                            @csrf
                            <div class="form-group">
                                <textarea name="text" class="comment-input" placeholder="Ваш комментарий..." rows="4" required></textarea>
                                @error('text')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="comment-submit">
                                    <i class="fas fa-paper-plane"></i> Отправить
                                </button>
                            </div>
                        </form>
                        @else
                        <div class="auth-required">
                            <p>Для того чтобы оставить комментарий, пожалуйста, <a href="{{ route('login') }}">войдите</a> или <a href="{{ route('register') }}">зарегистрируйтесь</a>.</p>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
            
            <div class="event-sidebar">
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Создатель</h3>
                    <a href="{{ route('users.show', $event->creator->id) }}" class="creator-info">
                        <div class="creator-avatar-container">
                            <img src="{{ $event->creator->avatar ? Storage::url($event->creator->avatar) : asset('images/default-avatar.svg') }}" alt="{{ $event->creator->username }}" class="creator-avatar">
                        </div>
                        <div class="creator-details">
                            <div class="creator-username">{{ $event->creator->username }}</div>
                        </div>
                    </a>
                </div>
                
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Поделиться</h3>
                    <div class="social-share">
                        <a href="https://vk.com/share.php?url={{ urlencode(Request::url()) }}" target="_blank" class="social-button" title="Поделиться ВКонтакте">
                            <i class="fab fa-vk"></i>
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(Request::url()) }}" target="_blank" class="social-button" title="Поделиться в Telegram">
                            <i class="fab fa-telegram-plane"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode(Request::url()) }}" target="_blank" class="social-button" title="Поделиться в WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="social-button copy-link" title="Копировать ссылку" data-url="{{ Request::url() }}">
                            <i class="fas fa-link"></i>
                        </a>
                    </div>
                </div>
                
                @if($similarEvents->count() > 0)
                <div class="sidebar-card">
                    <h3 class="sidebar-title">Похожие мероприятия</h3>
                    <div class="similar-events">
                        @foreach($similarEvents as $similarEvent)
                        <a href="{{ route('events.show', $similarEvent->id) }}" class="similar-event">
                            <div class="similar-event-image">
                                <img src="{{ asset('storage/' . $similarEvent->preview_image) }}" alt="{{ $similarEvent->title }}">
                            </div>
                            <div class="similar-event-info">
                                <div class="similar-event-title">{{ $similarEvent->title }}</div>
                                <div class="similar-event-creator">
                                    <span class="similar-event-username">{{ $similarEvent->creator->username }}</span>
                                </div>
                                <div class="similar-event-date">{{ $similarEvent->date_start->format('d.m.Y') }}</div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=41ace702-81a2-48c5-8e3f-35fbb11e5cde"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($event->address)
        ymaps.ready(function () {
            var myMap = new ymaps.Map('event-map', {
                center: [55.751574, 37.573856], // Москва по умолчанию
                zoom: 15
            });
            @if($event->address->latitude && $event->address->longitude)
                var coords = [{{ $event->address->latitude }}, {{ $event->address->longitude }}];
                myMap.setCenter(coords);
                var myPlacemark = new ymaps.Placemark(coords, {
                    balloonContent: '{{ $event->address->title }}'
                });
                myMap.geoObjects.add(myPlacemark);
            @else
                ymaps.geocode('{{ $event->address->title }}').then(function (res) {
                    var firstGeoObject = res.geoObjects.get(0);
                    if (firstGeoObject) {
                        var coords = firstGeoObject.geometry.getCoordinates();
                        myMap.setCenter(coords);
                        var myPlacemark = new ymaps.Placemark(coords, {
                            balloonContent: '{{ $event->address->title }}'
                        });
                        myMap.geoObjects.add(myPlacemark);
                    }
                });
            @endif
        });
        @endif
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Обработка лайков
    document.querySelectorAll('.like-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Предотвращаем стандартную отправку формы

            const form = this;
            const button = form.querySelector('.like-button');
            const icon = button.querySelector('i');
            const likeCountSpan = button.querySelector('.like-count');
            const url = form.getAttribute('action');
            const method = form.querySelector('input[name="_method"]_{'method'}').value; // POST или DELETE
            const csrfToken = form.querySelector('input[name="_token"]').value;

            fetch(url, {
                method: 'POST', // Fetch API требует POST для отправки форм с методом
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-HTTP-Method-Override': method // Laravel будет использовать этот заголовок для определения DELETE
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Обновляем количество лайков
                    likeCountSpan.textContent = data.likes_count;

                    // Обновляем иконку и класс кнопки
                    if (data.is_liked) {
                        button.classList.add('active');
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        button.setAttribute('title', 'Убрать из избранного');
                        // Меняем action формы для следующего запроса (unlike)
                        form.setAttribute('action', url.replace('/like', '/unlike'));
                        form.querySelector('input[name="_method"]').value = 'DELETE';
                    } else {
                        button.classList.remove('active');
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        button.setAttribute('title', 'Добавить в избранное');
                         // Меняем action формы для следующего запроса (like)
                        form.setAttribute('action', url.replace('/unlike', '/like'));
                        form.querySelector('input[name="_method"]').value = 'POST';
                    }
                } else {
                    // Обработка ошибки, если лайк не прошел
                    console.error('Ошибка при обработке лайка:', data);
                    // Возможно, показать сообщение пользователю
                }
            })
            .catch(error => {
                console.error('Ошибка AJAX-запроса:', error);
                // Обработка ошибок сети или сервера
            });
        });
    });
});
</script>
@endpush
@include('layouts.footer')  