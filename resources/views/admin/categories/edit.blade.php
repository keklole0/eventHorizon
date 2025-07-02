@extends('layouts.app')
@section('title', 'Редактировать категорию')
@section('content')
<div class="admin-dashboard-section">
    <div class="admin-dashboard-container">
        <div class="admin-breadcrumbs" style="margin-bottom: 24px;">
            <a href="{{ route('admin.dashboard') }}" class="admin-breadcrumb-link">Админ-панель</a>
            <span class="admin-breadcrumb-sep">/</span>
            <a href="{{ route('admin.categories.index') }}" class="admin-breadcrumb-link">Категории</a>
            <span class="admin-breadcrumb-sep">/</span>
            <span class="admin-breadcrumb-current">Редактировать категорию</span>
        </div>
        <h1 class="admin-dashboard-title">Редактировать категорию</h1>
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="create-event-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Название категории</label>
                <input type="text" name="title" id="title" class="input-field" required value="{{ old('title', $category->title) }}">
                @error('title')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="admin-form-btn">Сохранить</button>
            <a href="{{ route('admin.categories.index') }}" class="admin-form-btn admin-form-btn-secondary">Назад</a>
        </form>
    </div>
</div>
@endsection 