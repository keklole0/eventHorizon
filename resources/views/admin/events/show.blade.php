@extends('layouts.app')
@section('title', 'Просмотр мероприятия')
@section('content')
<div class="admin-dashboard-section">
    <div class="admin-dashboard-container">
        <div class="admin-breadcrumbs" style="margin-bottom: 24px;">
            <a href="{{ route('admin.dashboard') }}" class="admin-breadcrumb-link">Админ-панель</a>
            <span class="admin-breadcrumb-sep">/</span>
            <a href="{{ route('admin.events.index') }}" class="admin-breadcrumb-link">Мероприятия</a>
            <span class="admin-breadcrumb-sep">/</span>
            <span class="admin-breadcrumb-current">Просмотр</span>
        </div>
        <h1 class="admin-dashboard-title">Мероприятие: {{ $event->title }}</h1>
        <div class="card" style="max-width: 600px; margin: 0 auto 30px auto;">
            @if($event->preview_image)
                <div style="margin-bottom: 18px; text-align:center;">
                    <img src="{{ asset('storage/' . $event->preview_image) }}" alt="Превью мероприятия" style="max-width: 100%; max-height: 260px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                </div>
            @endif
            @if($event->main_image)
                <div style="margin-bottom: 18px; text-align:center;">
                    <img src="{{ asset('storage/' . $event->main_image) }}" alt="Основное изображение" style="max-width: 100%; max-height: 260px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                </div>
            @endif
            <div style="font-size: 1.3rem; font-weight: 600; margin-bottom: 10px;">{{ $event->title }}</div>
            <div style="margin-bottom: 10px;"><b>Дата начала:</b> {{ $event->date_start ? $event->date_start->format('d.m.Y H:i') : '-' }}</div>
            <div style="margin-bottom: 10px;"><b>Дата окончания:</b> {{ $event->date_end ? $event->date_end->format('d.m.Y H:i') : '-' }}</div>
            <div style="margin-bottom: 10px;"><b>Автор:</b> {{ $event->creator->first_name ?? '—' }} {{ $event->creator->last_name ?? '' }}</div>
            <div style="margin-bottom: 10px;"><b>Место:</b> {{ $event->address->title ?? '-' }}</div>
            <div style="margin-bottom: 10px;"><b>Описание:</b><br> <span style="color:#444;">{!! nl2br(e($event->description)) !!}</span></div>
            <div style="margin-bottom: 10px;"><b>ID:</b> {{ $event->id }}</div>
        </div>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <a href="{{ route('admin.events.edit', $event) }}" class="admin-form-btn" style="display: flex; align-items: center; gap: 8px;"><i class="fas fa-edit"></i> Редактировать</a>
            <a href="{{ route('admin.events.index') }}" class="admin-form-btn admin-form-btn-secondary">Назад к списку</a>
        </div>
    </div>
</div>
<style>
.admin-breadcrumbs {
    font-size: 1.05rem;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.admin-breadcrumb-link {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.18s;
}
.admin-breadcrumb-link:hover {
    color: #009ffd;
    text-decoration: underline;
}
.admin-breadcrumb-sep {
    color: #b0b0b0;
    font-size: 1.1em;
}
.admin-breadcrumb-current {
    color: #888;
    font-weight: 500;
}
</style>
@endsection 