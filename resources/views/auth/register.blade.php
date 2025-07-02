@extends('layouts.app')
@section('title', 'Регистрация')
@section('content')
    <section class="register-section">
        <div class="register-container">
            <h2 class="register-title">Регистрация</h2>
            <form class="register-form" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="avatar">Фото профиля</label>
                        <div class="avatar-upload">
                            <input type="file" id="avatar" name="avatar" accept="image/*" class="avatar-input">
                            <div class="avatar-preview">
                                <img id="avatar-preview" src="{{ asset('images/default-avatar.svg') }}" alt="Preview">
                            </div>
                        </div>
                        @error('avatar')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group full-width">
                        <label for="username">Имя пользователя</label>
                        <input type="text" id="username" name="username" placeholder="Введите имя пользователя" required
                            value="{{ old('username') }}">
                        @error('username')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="first_name">Имя</label>
                        <input type="text" id="first_name" name="first_name" placeholder="Введите ваше имя" required
                            value="{{ old('first_name') }}">
                        @error('first_name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="last_name">Фамилия</label>
                        <input type="text" id="last_name" name="last_name" placeholder="Введите вашу фамилию" required
                            value="{{ old('last_name') }}">
                        @error('last_name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Электронная почта</label>
                        <input type="email" id="email" name="email" placeholder="Введите email" required
                            value="{{ old('email') }}">
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="phone">Номер телефона</label>
                        <input type="tel" id="phone" name="phone" placeholder="Введите номер телефона" required
                            value="{{ old('phone') }}">
                        @error('phone')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group full-width">
                        <label for="password">Пароль</label>
                        <div class="password-input-group">
                            <input type="password" id="password" name="password" placeholder="Введите пароль" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group full-width">
                        <label for="password_confirmation">Подтверждение пароля</label>
                        <div class="password-input-group">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="Подтвердите пароль" required>
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="register-btn">
                    <span>Зарегистрироваться</span>
                </button>
            </form>
            <p class="login-msg">
                Уже есть аккаунт? <a href="{{ route('login') }}">Войдите</a>
            </p>
        </div>
    </section>
@endsection
@extends('layouts.footer')