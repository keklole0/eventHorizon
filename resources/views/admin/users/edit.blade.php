@extends('layouts.app')
@section('title', 'Редактировать пользователя')
@section('content')
<div class="admin-dashboard-section">
    <div class="admin-dashboard-container">
        <div class="admin-breadcrumbs" style="margin-bottom: 24px;">
            <a href="{{ route('admin.dashboard') }}" class="admin-breadcrumb-link">Админ-панель</a>
            <span class="admin-breadcrumb-sep">/</span>
            <a href="{{ route('admin.users.index') }}" class="admin-breadcrumb-link">Пользователи</a>
            <span class="admin-breadcrumb-sep">/</span>
            <span class="admin-breadcrumb-current">Редактировать пользователя</span>
        </div>
        <h1 class="admin-dashboard-title">Редактировать пользователя</h1>
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="edit-user-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="first_name">Имя</label>
                <input type="text" name="first_name" id="first_name" class="input-field" required value="{{ old('first_name', $user->first_name) }}">
                @error('first_name')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="last_name">Фамилия</label>
                <input type="text" name="last_name" id="last_name" class="input-field" required value="{{ old('last_name', $user->last_name) }}">
                @error('last_name')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="input-field" required value="{{ old('email', $user->email) }}">
                @error('email')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="username">Логин</label>
                <input type="text" name="username" id="username" class="input-field" required value="{{ old('username', $user->username) }}">
                @error('username')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="role">Роль</label>
                <select name="role" id="role" class="input-field" required>
                    <option value="user" @if(old('role', $user->role)=='user') selected @endif>Пользователь</option>
                    <option value="admin" @if(old('role', $user->role)=='admin') selected @endif>Администратор</option>
                </select>
                @error('role')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="password">Пароль (оставьте пустым, чтобы не менять)</label>
                <input type="password" name="password" id="password" class="input-field">
                @error('password')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="admin-form-btn">Сохранить</button>
            <a href="{{ route('admin.users.index') }}" class="admin-form-btn admin-form-btn-secondary">Назад</a>
        </form>
    </div>
</div>
<style>
.admin-form-btn {
    display: inline-block;
    padding: 12px 28px;
    border-radius: 8px;
    background: #2563eb;
    color: #fff;
    font-size: 1.08rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    margin-top: 10px;
    margin-bottom: 10px;
    transition: background 0.18s, color 0.18s, box-shadow 0.18s;
    box-shadow: 0 2px 8px rgba(37,99,235,0.08);
    text-decoration: none !important;
}
.admin-form-btn:hover, .admin-form-btn:focus {
    background: #009ffd;
    color: #fff;
    text-decoration: none !important;
}
.admin-form-btn-secondary {
    background: #f7f8fa;
    color: #2563eb;
    border: 1.5px solid #2563eb;
    margin-left: 10px;
}
.admin-form-btn-secondary:hover, .admin-form-btn-secondary:focus {
    background: #2563eb;
    color: #fff;
}
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