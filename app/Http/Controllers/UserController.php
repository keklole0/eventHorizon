<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        $user->load(['events' => function($query) {
            $query->with(['address', 'category']);
        }, 'reviews' => function($query) {
            $query->with(['reviewer' => function($query) {
                $query->select('id', 'username');
            }]);
        }]);
        $user->events_count = $user->events->count();
        $user->participations_count = $user->participations->count();
        
        return view('users.show', compact('user'));
    }
} 