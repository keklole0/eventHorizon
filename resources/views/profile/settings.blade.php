@extends('layouts.app')
@section('title', 'Настройки профиля')
@section('content')
<section class="profile-section">
    <div class="profile-container">
        <div class="profile-sidebar">
            <div class="profile-avatar avatar-settings">
                <img src="{{ $user->avatar_url }}" alt="Аватар пользователя" class="avatar-preview-img">
                <form action="{{ route('profile.settings.update') }}" method="POST" enctype="multipart/form-data" class="avatar-upload-form">
                    @csrf
                    <label class="profile-avatar-edit avatar-upload-label">
                        <input type="file" name="avatar" accept="image/*" class="avatar-input" onchange="this.form.submit()">
                        <span>Изменить фото</span>
                    </label>
                    @error('avatar')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </form>
            </div>
            <div class="profile-info">
                <h2 class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</h2>
                <p class="profile-email">{{ $user->email }}</p>
            </div>
            @if($user->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="profile-btn profile-btn-admin admin-panel-btn" style="margin-top: 20px;"><i class="fas fa-shield-alt"></i> Вход в админ-панель</a>
            @endif
        </div>
        <div class="calendar-section profile-settings-section">
            <h2 class="calendar-title">Редактировать профиль</h2>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('profile.settings.update') }}" method="POST" enctype="multipart/form-data" class="profile-settings-form">
                @csrf
                <div class="form-group">
                    <label for="username">Логин</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required class="input-field">
                    @error('username')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="input-field">
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="first_name">Имя</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" required class="input-field">
                    @error('first_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="last_name">Фамилия</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" required class="input-field">
                    @error('last_name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Телефон</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required class="input-field">
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="profile-btn profile-btn-primary save-profile-btn">Сохранить изменения</button>
            </form>
            <form action="{{ route('profile.delete') }}" method="POST" class="delete-account-form">
                @csrf
                @method('DELETE')
                <div class="form-group">
                    <label for="password">Подтвердите пароль для удаления аккаунта</label>
                    <input type="password" name="password" id="password" required class="input-field">
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="profile-btn delete-account-btn">Удалить аккаунт</button>
            </form>
        </div>
    </div>
</section>
@endsection
@push('styles')
<style>
.admin-panel-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    font-size: 1.13rem;
    font-weight: 600;
    padding: 14px 32px;
    border-radius: 10px;
    background: linear-gradient(90deg, #009ffd 0%, #2563eb 100%);
    color: #fff !important;
    box-shadow: 0 4px 16px rgba(37,99,235,0.10);
    border: none;
    transition: background 0.22s, box-shadow 0.22s, transform 0.18s;
    text-decoration: none !important;
    margin-bottom: 18px;
    letter-spacing: 0.5px;
}
.admin-panel-btn i {
    font-size: 1.2em;
    margin-right: 4px;
}
.admin-panel-btn:hover, .admin-panel-btn:focus {
    background: linear-gradient(90deg, #2563eb 0%, #009ffd 100%);
    color: #fff !important;
    box-shadow: 0 8px 32px rgba(37,99,235,0.18);
    transform: translateY(-2px) scale(1.03);
    text-decoration: none !important;
}
@media (max-width: 480px) {
    .admin-panel-btn {
        font-size: 1rem;
        padding: 10px 18px;
    }
}
</style>
@endpush 