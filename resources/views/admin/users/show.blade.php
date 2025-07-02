@extends('layouts.app')
@section('title', 'Профиль пользователя')
@section('content')
<div class="admin-dashboard-section">
    <div class="admin-dashboard-container">
        <div class="admin-breadcrumbs" style="margin-bottom: 24px;">
            <a href="{{ route('admin.dashboard') }}" class="admin-breadcrumb-link">Админ-панель</a>
            <span class="admin-breadcrumb-sep">/</span>
            <a href="{{ route('admin.users.index') }}" class="admin-breadcrumb-link">Пользователи</a>
            <span class="admin-breadcrumb-sep">/</span>
            <span class="admin-breadcrumb-current">Профиль пользователя</span>
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
        <h1 class="admin-dashboard-title">Профиль пользователя</h1>
        <div class="card" style="max-width: 500px; margin: 0 auto 30px auto;">
            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
                <img src="{{ $user->avatar_url ?? asset('images/default-avatar.svg') }}" alt="Аватар" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
                <div>
                    <div style="font-size: 1.3rem; font-weight: 600;">{{ $user->first_name }} {{ $user->last_name }}</div>
                    <div style="color: #666;">{{ $user->email }}</div>
                    <div style="color: #888; font-size: 0.95rem;">Логин: {{ $user->username }}</div>
                </div>
            </div>
            <div style="margin-bottom: 10px;"><b>ID:</b> {{ $user->id }}</div>
            <div style="margin-bottom: 10px;"><b>Роль:</b> {{ $user->role == 'admin' ? 'Администратор' : 'Пользователь' }}</div>
            <div style="margin-bottom: 10px;"><b>Дата регистрации:</b> {{ $user->created_at->format('d.m.Y H:i') }}</div>
        </div>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <a href="{{ route('admin.users.edit', $user) }}" class="profile-btn profile-btn-primary admin-edit-user-btn"><i class="fas fa-edit"></i> Редактировать</a>
            <a href="{{ route('admin.users.index') }}" class="profile-btn profile-btn-secondary">Назад к списку</a>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
.admin-edit-user-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 1.15rem;
    font-weight: 600;
    padding: 14px 32px;
    border-radius: 10px;
    background: linear-gradient(90deg, #2563eb 0%, #009ffd 100%);
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(37,99,235,0.10);
    border: none;
    transition: background 0.22s, box-shadow 0.22s, transform 0.18s;
    text-decoration: none !important;
    margin-bottom: 18px;
}
.admin-edit-user-btn i {
    font-size: 1.2em;
    margin-right: 4px;
}
.admin-edit-user-btn:hover, .admin-edit-user-btn:focus {
    background: linear-gradient(90deg, #009ffd 0%, #2563eb 100%);
    color: #fff !important;
    box-shadow: 0 8px 32px rgba(37,99,235,0.18);
    transform: translateY(-2px) scale(1.03);
    text-decoration: none !important;
}
@media (max-width: 480px) {
    .admin-edit-user-btn {
        font-size: 1rem;
        padding: 10px 18px;
    }
}
</style>
@endpush 