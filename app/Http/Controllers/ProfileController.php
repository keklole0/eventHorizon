<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Показать профиль пользователя
     */
    public function index()
    {
        $user = Auth::user();
        // Получаем мероприятия, на которые записан пользователь
        $participatedEvents = $user->participations()->with('event.address')->get()->map(function($participation) {
            $event = $participation->event;
            if ($event) {
                $event->days_left = $event->date_start ? now()->diffInDays($event->date_start, false) : null;
            }
            return $event;
        })->filter();

        // Получаем мероприятия, которые понравились пользователю
        $likedEvents = $user->likedEvents()->with(['address', 'category'])->get();

        // Получаем мероприятия, созданные пользователем
        $createdEvents = $user->events()->with(['address', 'category'])->latest('date_start')->get();

        return view('profile', compact('user', 'participatedEvents', 'likedEvents', 'createdEvents'));
    }

    /**
     * Показать форму редактирования
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.settings', compact('user'));
    }

    /**
     * Обновить профиль
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Если email изменился - сбрасываем верификацию
        if ($user->email !== $request->email) {
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
        }

        $user->update($validated);

        // Обработка аватара
        if ($request->hasFile('avatar')) {
            $user->processAvatar($request->file('avatar'));
        }

        return redirect()->route('profile.settings')
            ->with('success', 'Профиль успешно обновлен!');
    }

    /**
     * Удалить аккаунт
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
