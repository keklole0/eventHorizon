<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'text' => 'required|string|min:1|max:1000',
        ]);

        $comment = new Comment($validated);
        $comment->user_id = auth()->id();
        $event->comments()->save($comment);

        // Обновляем счётчик комментариев
        $event->increment('comments_count');

        return redirect()->back()->with('success', 'Комментарий успешно добавлен');
    }
} 