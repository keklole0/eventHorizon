<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;

class AdminEventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('creator');
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('id', $search);
            });
        }
        $events = $query->orderByDesc('date_start')->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Логика сохранения события
        return redirect()->route('admin.events.index')->with('success', 'Событие создано');
    }

    public function edit($event)
    {
        $event = \App\Models\Event::with(['address', 'category', 'tags'])->findOrFail($event);
        $categories = \App\Models\Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    public function update(Request $request, $event)
    {
        // Логика обновления события
        return redirect()->route('admin.events.index')->with('success', 'Событие обновлено');
    }

    public function destroy($event)
    {
        // Логика удаления события
        return redirect()->route('admin.events.index')->with('success', 'Событие удалено');
    }

    public function show($event)
    {
        $event = \App\Models\Event::with(['creator', 'address'])->findOrFail($event);
        return view('admin.events.show', compact('event'));
    }
} 