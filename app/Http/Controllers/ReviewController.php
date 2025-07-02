<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, User $user)
    {
        $request->validate([
            'comment' => 'required|string|min:1|max:1000',
        ]);

        $review = Review::create([
            'comment' => $request->comment,
            'reviewer_id' => Auth::id(),
            'user_id' => $user->id,
        ]);

        return redirect()->route('users.show', $user->id)
            ->with('success', 'Отзыв успешно добавлен');
    }
} 