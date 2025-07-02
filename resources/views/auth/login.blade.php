@extends('layouts.app')
@section('title', 'Вход')
@section('content')
    <section class="login-section">
        <div class="login-container">
            <h2 class="login-title">Вход в аккаунт</h2>
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Имя пользователя</label>
                    <input type="text" id="username" name="username" placeholder="Введите имя пользователя" required
                        value="{{ old('username') }}">
                    @error('username')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
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
                <button type="submit" class="login-btn">
                    <span>Войти</span>
                </button>
            </form>
            <p class="register-msg">
                Еще нет аккаунта? <a href="{{ route('register') }}">Зарегистрируйтесь</a>
            </p>
        </div>
    </section>
@endsection
@include('layouts.footer')