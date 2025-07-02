<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        $events = $category->events()
            ->where('status', 'active')
            ->orderBy('date_start', 'asc')
            ->paginate(12);

        // Получаем все категории и перемещаем текущую в начало
        $categories = Category::all();
        $currentCategory = $categories->where('id', $category->id)->first();
        $categories = $categories->where('id', '!=', $category->id);
        $categories = collect([$currentCategory])->concat($categories);

        return view('categories.show', compact('category', 'events', 'categories'));
    }
} 