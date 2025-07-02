<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Category::query();
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('id', $search);
            });
        }
        $categories = $query->orderByDesc('id')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        // Форма создания категории
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        // Логика сохранения категории
        return redirect()->route('admin.categories.index')->with('success', 'Категория создана');
    }

    public function edit($category)
    {
        $category = \App\Models\Category::findOrFail($category);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $category)
    {
        $category = \App\Models\Category::findOrFail($category);
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $category->update(['title' => $request->title]);
        return redirect()->route('admin.categories.index')->with('success', 'Категория обновлена');
    }

    public function destroy($category)
    {
        $category = \App\Models\Category::findOrFail($category);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Категория удалена');
    }

    public function show($category)
    {
        // Просмотр категории
        return view('admin.categories.show', compact('category'));
    }
} 