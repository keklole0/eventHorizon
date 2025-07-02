@extends('layouts.app')
@section('title', 'Создание Мероприятия')
@section('content')
<div class="create-event-section">
    <div class="create-event-container">
        <h2 class="create-event-title">Создать мероприятие</h2>
        <form class="create-event-form" action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Название мероприятия</label>
                <input type="text" name="title" id="title" placeholder="Введите название мероприятия" value="{{ old('title') }}" required>
            </div>
            <div class="form-group">
                <label for="age_limit">Возрастное ограничение</label>
                <select name="age_limit" id="age_limit" required>
                    <option value="">Выберите возрастное ограничение</option>
                    <option value="0" @if(old('age_limit')=='0') selected @endif>0+</option>
                    <option value="6" @if(old('age_limit')=='6') selected @endif>6+</option>
                    <option value="12" @if(old('age_limit')=='12') selected @endif>12+</option>
                    <option value="16" @if(old('age_limit')=='16') selected @endif>16+</option>
                    <option value="18" @if(old('age_limit')=='18') selected @endif>18+</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_start">Дата начала</label>
                <input type="datetime-local" name="date_start" id="date_start" value="{{ old('date_start') }}" required>
            </div>
            <div class="form-group">
                <label for="date_end">Дата окончания</label>
                <input type="datetime-local" name="date_end" id="date_end" value="{{ old('date_end') }}" required>
            </div>
            <div class="form-group">
                <label for="description">Описание мероприятия</label>
                <textarea name="description" id="description" placeholder="Введите описание мероприятия" required>{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="preview_image">Превью изображение</label>
                <input type="file" name="preview_image" id="preview_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="main_image">Основное изображение</label>
                <input type="file" name="main_image" id="main_image" accept="image/*">
            </div>
            <div class="form-group">
                <label for="address">Адрес проведения</label>
                <input type="text" name="address" id="address" placeholder="Введите адрес мероприятия" value="{{ old('address') }}" required>
            </div>
            <div class="form-group">
                <label for="category">Категория мероприятия</label>
                <select name="category" id="category" required>
                    <option value="">Выберите категорию</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->title }}" @if(old('category')==$cat->title) selected @endif>{{ $cat->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tags">Теги (через запятую)</label>
                <input type="text" name="tags" id="tags" placeholder="Например: музыка, концерт, рок" value="{{ old('tags') }}">
            </div>
            <div class="form-group">
                <label for="max_participants">Максимальное количество участников</label>
                <input type="number" name="max_participants" id="max_participants" min="1" placeholder="Введите максимальное количество участников" value="{{ old('max_participants') }}" required>
            </div>
            <button type="submit" class="create-event-btn">
                <span>Создать мероприятие</span>
            </button>
        </form>
    </div>
</div>
@endsection
@extends('layouts.footer')

@push('scripts')
<script>
    $(document).ready(function() {
        console.log('jQuery работает, инициализация DaData...');
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
            console.log('DaData suggestions инициализирован!');
        }
    });
</script>
@endpush
