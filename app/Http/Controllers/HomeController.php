<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // Получаем популярные мероприятия (например, последние 3)
        $popularEvents = Event::with(['category', 'address'])
            ->where('status', 'active')
            ->where('date_end', '>=', now())
            ->latest()
            ->take(3)
            ->get();

        // Получаем 8 популярных категорий
        $categories = Category::withCount('events')
            ->orderBy('events_count', 'desc')
            ->take(8)
            ->get();

        // Получаем первые 3 мероприятия
        $events = Event::with(['category', 'address'])
            ->where('status', 'active')
            ->where('date_end', '>=', now())
            ->latest()
            ->take(3)
            ->get();

        return view('index', compact('popularEvents', 'categories', 'events'));
    }

    public function loadMoreEvents(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = 3;

        $events = Event::with(['category', 'address'])
            ->where('status', 'active')
            ->where('date_end', '>=', now())
            ->latest()
            ->skip($offset)
            ->take($limit)
            ->get();

        $hasMore = Event::count() > ($offset + $limit);

        $html = '';
        foreach ($events as $event) {
            $html .= '<a href="' . route('events.show', $event->id) . '" class="event-link">
                <div class="event-card">
                    <img src="' . asset('storage/' . $event->preview_image) . '" alt="' . $event->title . '" class="event-image">
                    <div class="event-info">
                        <h3 class="event-name">' . $event->title . '</h3>
                        <p class="event-location">Место: ' . $event->address->city . '</p>
                        <p class="event-time">Время: ' . $event->date_start->format('H:i, d.m.Y') . '</p>
                    </div>
                </div>
            </a>';
        }

        Log::info('Load more events', [
            'offset' => $offset,
            'count' => $events->count(),
            'hasMore' => $hasMore
        ]);

        return response()->json([
            'html' => $html,
            'hasMore' => $hasMore
        ]);
    }
} 