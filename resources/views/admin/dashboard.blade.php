@extends('layouts.app')
@section('title', 'Админ-панель')
@section('content')
<div class="admin-dashboard-section">
    <div class="admin-dashboard-container">
        <h1 class="admin-dashboard-title">Добро пожаловать в админ-панель</h1>
        <p class="admin-dashboard-subtitle">Здесь вы сможете управлять пользователями, мероприятиями, категориями и другими разделами сайта.</p>
        <div class="admin-dashboard-cards">
            <a href="{{ route('admin.users.index') }}" class="admin-dashboard-card" style="text-decoration: none;">
                <span class="admin-dashboard-icon"><i class="fas fa-users"></i></span>
                <h3>Пользователи</h3>
                <p>Управление пользователями</p>
            </a>
            <a href="{{ route('admin.events.index') }}" class="admin-dashboard-card" style="text-decoration: none;">
                <span class="admin-dashboard-icon"><i class="fas fa-calendar-alt"></i></span>
                <h3>Мероприятия</h3>
                <p>Управление мероприятиями</p>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="admin-dashboard-card" style="text-decoration: none;">
                <i class="fas fa-list admin-dashboard-icon"></i>
                <h3>Категории</h3>
                <p>Редактирование категорий</p>
            </a>
            <a href="{{ route('admin.messages.index') }}" class="admin-dashboard-card" style="text-decoration: none;">
                <i class="fas fa-envelope admin-dashboard-icon"></i>
                <h3>Сообщения</h3>
                <p>Обратная связь с сайта</p>
            </a>
        </div>
    </div>
</div>

@endsection

@include('layouts.footer')

@push('scripts')
<style>
body {
    background: linear-gradient(135deg, var(--color-header-bg) 0%, var(--color-primary) 100%) !important;
}
</style>
@endpush 