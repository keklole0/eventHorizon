<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventLikeSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём 20 лайков случайных пользователей к событиям
        $users = User::all();
        $events = Event::all();
        foreach ($users as $user) {
            $likedEvents = $events->random(rand(1, 5));
            foreach ($likedEvents as $event) {
                DB::table('event_likes')->updateOrInsert([
                    'user_id' => $user->id,
                    'event_id' => $event->id,
                ], [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
} 