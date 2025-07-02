@extends('layouts.app')
@section('title', 'Сообщение')
@section('content')
<div class="admin-dashboard-section">
    <div class="admin-dashboard-container">
        <div class="admin-breadcrumbs" style="margin-bottom: 24px;">
            <a href="{{ route('admin.dashboard') }}" class="admin-breadcrumb-link">Админ-панель</a>
            <span class="admin-breadcrumb-sep">/</span>
            <a href="{{ route('admin.messages.index') }}" class="admin-breadcrumb-link">Сообщения</a>
            <span class="admin-breadcrumb-sep">/</span>
            <span class="admin-breadcrumb-current">Просмотр сообщения</span>
        </div>
        <h1 class="admin-dashboard-title">Сообщение #{{ $message->id }}</h1>
        <div class="card" style="max-width: 600px; margin: 0 auto 30px auto;">
            <div style="margin-bottom: 10px;"><b>Имя:</b> {{ $message->name }}</div>
            <div style="margin-bottom: 10px;"><b>Email:</b> {{ $message->email }}</div>
            <div style="margin-bottom: 10px;"><b>Дата:</b> {{ $message->created_at->format('d.m.Y H:i') }}</div>
            <div style="margin-bottom: 10px;"><b>Сообщение:</b><br> <span style="color:#444;">{!! nl2br(e($message->message)) !!}</span></div>
        </div>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-form-btn admin-form-btn-secondary" onclick="return confirm('Удалить сообщение?')">Удалить</button>
            </form>
            <a href="{{ route('admin.messages.index') }}" class="admin-form-btn">Назад к списку</a>
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection 