@extends('layouts.app')
@section('title', 'Редактировать мероприятие')
@section('content')
<div class="create-event-section">
    <div class="create-event-container">
        <h2 class="create-event-title">Редактировать мероприятие</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form class="create-event-form" action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Название мероприятия</label>
                <input type="text" name="title" id="title" placeholder="Введите название мероприятия" value="{{ old('title', $event->title) }}" required>
                @error('title')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="age_limit">Возрастное ограничение</label>
                <select name="age_limit" id="age_limit" required>
                    <option value="">Выберите возрастное ограничение</option>
                    <option value="0" @if(old('age_limit', $event->age_limit)=='0') selected @endif>0+</option>
                    <option value="6" @if(old('age_limit', $event->age_limit)=='6') selected @endif>6+</option>
                    <option value="12" @if(old('age_limit', $event->age_limit)=='12') selected @endif>12+</option>
                    <option value="16" @if(old('age_limit', $event->age_limit)=='16') selected @endif>16+</option>
                    <option value="18" @if(old('age_limit', $event->age_limit)=='18') selected @endif>18+</option>
                </select>
                @error('age_limit')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_start">Дата начала</label>
                <input type="datetime-local" name="date_start" id="date_start" value="{{ old('date_start', $event->date_start ? $event->date_start->format('Y-m-d\TH:i') : '') }}" required>
                @error('date_start')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_end">Дата окончания</label>
                <input type="datetime-local" name="date_end" id="date_end" value="{{ old('date_end', $event->date_end ? $event->date_end->format('Y-m-d\TH:i') : '') }}" required>
                @error('date_end')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Описание мероприятия</label>
                <textarea name="description" id="description" placeholder="Введите описание мероприятия" required>{{ old('description', $event->description) }}</textarea>
                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="main_image">Основное изображение</label>
                @if($event->main_image)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset('storage/' . $event->main_image) }}" alt="Текущее изображение" style="max-width: 180px; border-radius: 8px;">
                    </div>
                @endif
                <input type="file" name="main_image" id="main_image" accept="image/*">
                @error('main_image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="preview_image">Превью изображение</label>
                @if($event->preview_image)
                    <div style="margin-bottom:10px;">
                        <img src="{{ asset('storage/' . $event->preview_image) }}" alt="Текущее превью" style="max-width: 180px; border-radius: 8px;">
                    </div>
                @endif
                <input type="file" name="preview_image" id="preview_image" accept="image/*">
                @error('preview_image')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Адрес проведения</label>
                <input type="text" name="address" id="address" placeholder="Введите адрес мероприятия" value="{{ old('address', $event->address ? $event->address->title : '') }}" required>
                @error('address')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="category">Категория мероприятия</label>
                <select name="category" id="category" required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->title }}" @if(old('category', $event->category ? $event->category->title : null)==$cat->title) selected @endif>{{ $cat->title }}</option>
                    @endforeach
                </select>
                @error('category')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="tags">Теги (через запятую)</label>
                <input type="text" name="tags" id="tags" placeholder="Например: музыка, концерт, рок" value="{{ old('tags', isset($event->tags) ? $event->tags->pluck('title')->implode(', ') : '') }}">
                @error('tags')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="max_participants">Максимальное количество участников</label>
                <input type="number" name="max_participants" id="max_participants" min="1" placeholder="Введите максимальное количество участников" value="{{ old('max_participants', $event->max_participants) }}" required>
                @error('max_participants')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="create-event-btn">
                <span>Сохранить изменения</span>
            </button>
        </form>
    </div>
</div>
@endsection
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