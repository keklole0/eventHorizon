<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show(Event $event)
    {
        // Загружаем все необходимые связи
        $event->load([
            'category',
            'address',
            'creator',
            'comments.user',
            'comments.replies.user',
            'likes'
        ]);

        // Подсчитываем количество комментариев и лайков
        $event->comments_count = $event->comments()->count();
        $event->likes_count = $event->likes()->count();
        
        // Проверяем, лайкнул ли текущий пользователь
        if (auth()->check()) {
            $event->is_liked = $event->isLikedBy(auth()->user());
        }

        // Получаем похожие мероприятия
        $similarEvents = Event::where('category_id', $event->category_id)
            ->where('id', '!=', $event->id)
            ->with(['category', 'address', 'creator'])
            ->take(2)
            ->get();

        return view('events.show', compact('event', 'similarEvents'));
    }

    public function like(Event $event)
    {
        $user = auth()->user();
        
        if (!$event->isLikedBy($user)) {
            $event->likes()->create(['user_id' => $user->id]);
        }
        
        return response()->json([
            'success' => true,
            'likes_count' => $event->likes()->count(),
            'is_liked' => true
        ]);
    }

    public function unlike(Event $event)
    {
        $user = auth()->user();
        $event->likes()->where('user_id', $user->id)->delete();
        
        return response()->json([
            'success' => true,
            'likes_count' => $event->likes()->count(),
            'is_liked' => false
        ]);
    }

    public function participate(Request $request, Event $event)
    {
        $user = $request->user();
        // Запрет на запись, если мероприятие отменено или окончено
        if (in_array($event->status, ['cancelled', 'completed'])) {
            return response()->json(['success' => false, 'message' => 'Запись на это мероприятие невозможна.'], 403);
        }
        // Проверка: уже записан?
        if ($event->participations()->where('user_id', $user->id)->exists()) {
            return response()->json(['success' => false, 'message' => 'Вы уже записаны на это мероприятие.'], 409);
        }
        $event->participations()->create([
            'user_id' => $user->id,
        ]);
        return response()->json(['success' => true, 'message' => 'Вы успешно записались на мероприятие!']);
    }

    public function create()
    {
        // Получаем все категории для выпадающего списка
        $categories = \App\Models\Category::all();
        return view('create_event', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'age_limit' => 'required|integer',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'description' => 'required|string',
            'preview_image' => 'nullable|image',
            'main_image' => 'nullable|image',
            'address' => 'required|string',
            'category' => 'required|string',
            'tags' => 'nullable|string',
            'max_participants' => 'required|integer|min:1',
        ]);

        // Сохраняем изображения или подставляем по умолчанию
        if ($request->hasFile('preview_image')) {
            $previewImagePath = $request->file('preview_image')->store('events', 'public');
        } else {
            $previewImagePath = 'events/event1.jpg';
        }
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('events', 'public');
        } else {
            $mainImagePath = 'events/event1.jpg';
        }

        // Парсим адрес (ожидаем: город, улица, дом)
        $addressParts = explode(',', $request->address);
        $city = trim($addressParts[0] ?? '');
        $street = trim($addressParts[1] ?? '');
        $house = trim($addressParts[2] ?? '');
        $address = \App\Models\Address::create([
            'title' => trim($request->address),
            'city' => $city,
            'street' => $street,
            'house_number' => $house,
        ]);

        // Категория
        $category = \App\Models\Category::where('title', $request->category)->first();
        if (!$category) {
            $category = \App\Models\Category::create(['title' => $request->category]);
        }

        // Создаём мероприятие
        $event = \App\Models\Event::create([
            'title' => $request->title,
            'age_limit' => $request->age_limit,
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'description' => $request->description,
            'preview_image' => $previewImagePath,
            'main_image' => $mainImagePath,
            'user_id' => $request->user()->id,
            'address_id' => $address->id,
            'category_id' => $category->id,
            'price' => 0,
            'max_participants' => $request->max_participants,
            'status' => 'active',
        ]);

        // Теги
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            foreach ($tags as $tagName) {
                $tag = \App\Models\Tag::firstOrCreate(['title' => $tagName]);
                $event->tags()->attach($tag->id);
            }
        }

        return redirect()->route('events.show', $event->id)->with('success', 'Мероприятие успешно создано!');
    }

    public function edit(Event $event)
    {
        // Только автор может редактировать
        if (auth()->id() !== $event->creator->id) {
            abort(403);
        }
        $categories = \App\Models\Category::all();
        return view('events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, Event $event)
    {
        if (auth()->id() !== $event->creator->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'address' => 'required|string',
            'age_limit' => 'required|integer|min:0',
            'main_image' => 'nullable|image',
            'preview_image' => 'nullable|image',
            'category' => 'required|string',
            'tags' => 'nullable|string',
            'max_participants' => 'required|integer|min:1',
        ]);

        // Обновляем адрес
        $addressParts = explode(',', $request->address);
        $city = trim($addressParts[0] ?? '');
        $street = trim($addressParts[1] ?? '');
        $house = trim($addressParts[2] ?? '');
        if ($event->address) {
            $event->address->update([
                'title' => trim($request->address),
                'city' => $city,
                'street' => $street,
                'house_number' => $house,
                'latitude' => null,
                'longitude' => null,
            ]);
        }

        // Обновляем изображения
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')->store('events', 'public');
            $event->main_image = $mainImagePath;
        } elseif (!$event->main_image) {
            $event->main_image = 'events/event1.jpg';
        }
        if ($request->hasFile('preview_image')) {
            $previewImagePath = $request->file('preview_image')->store('events', 'public');
            $event->preview_image = $previewImagePath;
        } elseif (!$event->preview_image) {
            $event->preview_image = 'events/event1.jpg';
        }

        // Обновляем категорию
        $category = \App\Models\Category::where('title', $request->category)->first();
        if (!$category) {
            $category = \App\Models\Category::create(['title' => $request->category]);
        }
        $event->category_id = $category->id;

        // Обновляем остальные поля
        $event->title = $request->title;
        $event->description = $request->description;
        $event->date_start = $request->date_start;
        $event->date_end = $request->date_end;
        $event->age_limit = $request->age_limit;
        $event->max_participants = $request->max_participants;
        $event->save();

        // Обновляем теги
        if ($request->filled('tags')) {
            $tags = array_map('trim', explode(',', $request->tags));
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = \App\Models\Tag::firstOrCreate(['title' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $event->tags()->sync($tagIds);
        } else {
            $event->tags()->detach();
        }

        return redirect()->route('events.show', $event->id)->with('success', 'Мероприятие успешно обновлено!');
    }
} 