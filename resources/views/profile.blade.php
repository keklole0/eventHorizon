@extends('layouts.app')
@section('title', 'Профиль')
@section('content')
<section class="profile-section">
    <div class="profile-container">
        <!-- Боковая панель профиля -->
        <div class="profile-sidebar">
            <div class="profile-avatar">
                <img src="{{ $user->avatar_url }}" alt="Аватар пользователя">
            </div>
            <div class="profile-info">
                <h2 class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</h2>
                <p class="profile-email">{{ $user->email }}</p>
            </div>
            <div class="profile-stats">
                <div class="stat-item">
                    <div class="stat-value">{{ $createdEvents->count() }}</div>
                    <div class="stat-label">Мероприятий</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $participatedEvents->count() }}</div>
                    <div class="stat-label">Записей</div>
                </div>
            </div>
            <div class="profile-actions">
                <a href="{{ route('profile.settings') }}" class="profile-btn profile-btn-secondary">Настройки</a>
            </div>
        </div>

        <!-- Основной контент --> 
        <div class="calendar-section">
            <div class="calendar-header">
                <h2 class="calendar-title">Мои мероприятия</h2>
                <div class="calendar-nav">
                    <button class="calendar-nav-btn" id="prevMonth">&lt;</button>
                    <button class="calendar-nav-btn" id="nextMonth">&gt;</button>
                </div>
            </div>

            <!-- Календарь -->
            <div id="calendar"></div>

            <!-- Список мероприятий -->
            <div class="calendar-events">
                @forelse($participatedEvents as $event)
                <a href="{{ route('events.show', ['event' => $event->id]) }}" class="calendar-event" style="display: block; text-decoration: none; color: inherit;">
                    <div class="event-time">
                        {{ optional($event->date_start)->format('d.m.Y H:i') }}
                        @if(!is_null($event->days_left))
                            <span class="event-days-left">
                                ({{ $event->days_left > 0 ? 'Через ' . $event->days_left . ' дн.' : ($event->days_left == 0 ? 'Сегодня' : 'Уже прошло') }})
                            </span>
                        @endif
                    </div>
                    <h3 class="event-title">{{ $event->title }}</h3>
                    <p class="event-location">
                        {{ optional($event->address)->title }}
                    </p>
                </a>
                @empty
                    <div class="calendar-event">Нет записей на мероприятия.</div>
                @endforelse
            </div>
        </div>
        
    </div>
        <!-- Секция для понравившихся мероприятий -->
        <div class="profile-liked-events-section">
            <h2 class="profile-liked-events-title">Понравившиеся мероприятия</h2>
            <div class="profile-liked-events-horizontal-list huatina-scroll">
                @forelse($likedEvents ?? [] as $event)
                <a href="{{ route('events.show', $event->id) }}" class="profile-liked-event-card">
                    <div class="profile-liked-event-image">
                        <img src="{{ isset($event->main_image) ? asset('storage/' . $event->main_image) : asset('images/default-event-image.png') }}" alt="{{ $event->title }}">
                    </div>
                    <div class="profile-liked-event-info">
                        <h3 class="profile-liked-event-card-title">{{ $event->title }}</h3>
                        <p class="profile-liked-event-card-date">{{ optional($event->date_start)->format('d.m.Y H:i') }}</p>
                        @if($event->address)
                            <p class="profile-liked-event-card-location">{{ optional($event->address)->title }}</p>
                        @endif
                    </div>
                </a>
                @empty
                    <div class="profile-no-liked-events">У вас пока нет понравившихся мероприятий.</div>
                @endforelse
            </div>
        </div>
        <!-- Секция для созданных мероприятий -->
        <div class="profile-liked-events-section">
            <h2 class="profile-liked-events-title">Созданные мероприятия</h2>
            <div class="profile-liked-events-horizontal-list huatina-scroll">
                @forelse($createdEvents ?? [] as $event)
                <a href="{{ route('events.show', $event->id) }}" class="profile-liked-event-card">
                    <div class="profile-liked-event-image">
                        <img src="{{ isset($event->main_image) ? asset('storage/' . $event->main_image) : asset('images/default-event-image.png') }}" alt="{{ $event->title }}">
                    </div>
                    <div class="profile-liked-event-info">
                        <h3 class="profile-liked-event-card-title">{{ $event->title }}</h3>
                        <p class="profile-liked-event-card-date">{{ optional($event->date_start)->format('d.m.Y H:i') }}</p>
                        @if($event->address)
                            <p class="profile-liked-event-card-location">{{ optional($event->address)->title }}</p>
                        @endif
                    </div>
                </a>
                @empty
                    <div class="profile-no-liked-events">Вы ещё не создали ни одного мероприятия.</div>
                @endforelse
            </div>
        </div>

</section>

<!-- Модальное окно для мероприятий -->
<div id="eventModal" class="modal">
    <div class="modal-content">
        <span class="close-button">&times;</span>
        <h2 id="modalEventDate"></h2>
        <div id="modalEventsList"></div>
    </div>
</div>

@endsection
@extends('layouts.footer')

@section('footer')
<script>
const calendarEl = document.getElementById('calendar');
const monthNames = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
let today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();

const eventModal = document.getElementById('eventModal');
const modalEventDate = document.getElementById('modalEventDate');
const modalEventsList = document.getElementById('modalEventsList');
const closeButton = eventModal ? eventModal.querySelector('.close-button') : null;

let eventDates = [];

function fetchEventDates(month, year, callback) {
    fetch(`/event-dates?month=${month + 1}&year=${year}`)
        .then(response => response.json())
        .then(dates => {
            eventDates = dates;
            if (callback) callback();
        })
        .catch(error => console.error('Error fetching event dates:', error));
}

function fetchEventsByDate(date, callback) {
    fetch(`/events-by-date?date=${date}`)
        .then(response => response.json())
        .then(events => {
            if (callback) callback(events);
        })
        .catch(error => console.error('Error fetching events by date:', error));
}

function renderCalendar(month, year) {
    let firstDay = new Date(year, month, 1).getDay();
    firstDay = firstDay === 0 ? 7 : firstDay;
    let daysInMonth = new Date(year, month + 1, 0).getDate();
    let html = `<div class='calendar-month-title'>${monthNames[month]} ${year}</div>`;
    html += `<div class='calendar-grid'>`;
    ['Пн','Вт','Ср','Чт','Пт','Сб','Вс'].forEach(d => html += `<div class='calendar-day calendar-day-header'>${d}</div>`);
    let day = 1;
    for (let i = 1; i <= 42; i++) {
        if (i < firstDay || day > daysInMonth) {
            html += `<div class='calendar-day'></div>`;
        } else {
            const date = new Date(year, month, day);
            const dateString = date.getFullYear() + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + ('0' + date.getDate()).slice(-2);
            let isToday = date.getDate() === today.getDate() && date.getMonth() === today.getMonth() && date.getFullYear() === today.getFullYear();
            let hasEvent = eventDates && eventDates.includes(dateString);
            let classes = 'calendar-day';
            if (isToday) classes += ' today';
            if (hasEvent) classes += ' has-event';
            html += `<div class='${classes}' data-date="${dateString}">${day}</div>`;
            day++;
        }
    }
    html += `</div>`;
    calendarEl.innerHTML = html;
    document.querySelectorAll('.calendar-day.has-event').forEach(dayElement => {
        dayElement.addEventListener('click', function() {
            const selectedDate = this.getAttribute('data-date');
            modalEventDate.textContent = `Мероприятия на ${selectedDate.split('-').reverse().join('.')}`;
            modalEventsList.innerHTML = 'Загрузка...';
            eventModal.style.display = 'block';

            fetchEventsByDate(selectedDate, (events) => {
                modalEventsList.innerHTML = '';
                if (events.length > 0) {
                    events.forEach(event => {
                        const eventElement = document.createElement('div');
                        eventElement.classList.add('modal-event-item');
                        eventElement.innerHTML = `
                            <h3>${event.title}</h3>
                            <p>Время: ${new Date(event.date_start).toLocaleTimeString('ru-RU', { hour: '2-digit', minute: '2-digit' })}</p>
                            ${event.address ? `<p>Место: ${event.address.title}</p>` : ''}
                            <a href="/events/${event.id}" class="modal-event-link">Подробнее</a>
                        `;
                        modalEventsList.appendChild(eventElement);
                    });
                } else {
                    modalEventsList.innerHTML = '<p>На эту дату мероприятий нет.</p>';
                }
            });
        });
         dayElement.title = 'Есть мероприятия';
    });

}

fetchEventDates(currentMonth, currentYear, () => {
    renderCalendar(currentMonth, currentYear);
});

document.getElementById('prevMonth').onclick = function() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    fetchEventDates(currentMonth, currentYear, () => {
        renderCalendar(currentMonth, currentYear);
    });
};
document.getElementById('nextMonth').onclick = function() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    fetchEventDates(currentMonth, currentYear, () => {
        renderCalendar(currentMonth, currentYear);
    });
};

if (closeButton) {
    closeButton.onclick = function() {
        eventModal.style.display = "none";
    }
}

window.onclick = function(event) {
    if (event.target == eventModal) {
        eventModal.style.display = "none";
    }
}
</script>
@endsection
