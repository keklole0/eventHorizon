@extends('layouts.app')
@section('title', 'Добавить мероприятие')
@section('content')
<div class="admin-dashboard-section">
    <div class="admin-dashboard-container">
        <div class="admin-breadcrumbs" style="margin-bottom: 24px;">
            <a href="{{ route('admin.dashboard') }}" class="admin-breadcrumb-link">Админ-панель</a>
            <span class="admin-breadcrumb-sep">/</span>
            <a href="{{ route('admin.events.index') }}" class="admin-breadcrumb-link">Мероприятия</a>
            <span class="admin-breadcrumb-sep">/</span>
            <span class="admin-breadcrumb-current">Добавить мероприятие</span>
        </div>
        <h1 class="admin-dashboard-title">Добавить мероприятие</h1>
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="create-event-form">
            @csrf
            <div class="form-group">
                <label for="title">Название мероприятия</label>
                <input type="text" name="title" id="title" class="input-field" required value="{{ old('title') }}">
                @error('title')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="age_limit">Возрастное ограничение</label>
                <select name="age_limit" id="age_limit" class="input-field" required>
                    <option value="">Выберите возрастное ограничение</option>
                    <option value="0" @if(old('age_limit')=='0') selected @endif>0+</option>
                    <option value="6" @if(old('age_limit')=='6') selected @endif>6+</option>
                    <option value="12" @if(old('age_limit')=='12') selected @endif>12+</option>
                    <option value="16" @if(old('age_limit')=='16') selected @endif>16+</option>
                    <option value="18" @if(old('age_limit')=='18') selected @endif>18+</option>
                </select>
                @error('age_limit')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="date_start">Дата начала</label>
                <input type="datetime-local" name="date_start" id="date_start" class="input-field" value="{{ old('date_start') }}" required>
                @error('date_start')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="date_end">Дата окончания</label>
                <input type="datetime-local" name="date_end" id="date_end" class="input-field" value="{{ old('date_end') }}" required>
                @error('date_end')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="description">Описание мероприятия</label>
                <textarea name="description" id="description" class="input-field" required>{{ old('description') }}</textarea>
                @error('description')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="preview_image">Превью изображение</label>
                <input type="file" name="preview_image" id="preview_image" class="input-field" accept="image/*" required>
                @error('preview_image')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="main_image">Основное изображение</label>
                <input type="file" name="main_image" id="main_image" class="input-field" accept="image/*" required>
                @error('main_image')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="address">Адрес проведения</label>
                <input type="text" name="address" id="address" class="input-field" placeholder="Введите адрес мероприятия" value="{{ old('address') }}" required>
                @error('address')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="category">Категория мероприятия</label>
                <select name="category" id="category" class="input-field" required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->title }}" @if(old('category')==$cat->title) selected @endif>{{ $cat->title }}</option>
                    @endforeach
                </select>
                @error('category')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label for="tags">Теги (через запятую)</label>
                <input type="text" name="tags" id="tags" class="input-field" placeholder="Например: музыка, концерт, рок" value="{{ old('tags') }}">
                @error('tags')<span class="error-message">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="admin-form-btn">Создать</button>
            <a href="{{ route('admin.events.index') }}" class="admin-form-btn admin-form-btn-secondary">Назад</a>
        </form>
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
@push('scripts')
<script>
    $(document).ready(function() {
        if (typeof $.fn.suggestions === 'undefined') {
            console.error('DaData suggestions не загружен!');
        } else {
            $("#address").suggestions({
                token: "51079662f5f0dea9b6ee6b9166ebc5f0d19710b8",
                type: "ADDRESS",
                onSelect: function(suggestion) {
                    console.log('Выбран адрес:', suggestion);
                }
            });
        }
    });
</script>
@endpush
@endsection 