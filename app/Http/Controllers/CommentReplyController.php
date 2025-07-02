<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentReplyController extends Controller
{
    public function store(Request $request, Comment $comment)
    {
        $request->validate([
            'text' => 'required|string|min:1|max:1000',
        ]);

        $reply = new CommentReply([
            'text' => $request->text,
            'user_id' => Auth::id(),
            'comment_id' => $comment->id,
        ]);

        $reply->save();

        return redirect()
            ->route('events.show', $comment->event)
            ->with('success', 'Ответ успешно добавлен');
    }
} 