<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Participation;

class EventCalendarController extends Controller
{
    public function getEventDates(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');

        // Проверка на наличие месяца и года
        if (empty($month) || empty($year)) {
            return response()->json([]);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json([]);
        }

        // Получаем мероприятия, на которые записан пользователь, за указанный месяц и год
        $participations = $user->participations()
            ->whereHas('event', function ($query) use ($year, $month) {
                $query->whereYear('date_start', $year)
                      ->whereMonth('date_start', $month)
                      ->where('status', 'active');
            })
            ->with('event')
            ->get();

        $events = $participations->pluck('event')->filter();

        $eventDates = $events->pluck('date_start')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->unique()
            ->values()
            ->toArray();

        return response()->json($eventDates);
    }

    public function getEventsByDate(Request $request)
    {
        $date = $request->get('date');

        // Проверка на наличие даты
        if (empty($date)) {
            return response()->json([]);
        }

        // Получаем мероприятия на указанную дату
        $events = Event::whereDate('date_start', $date)
                       ->where('status', 'active')
                       ->with('address') // Загружаем адрес, если нужно
                       ->orderBy('date_start', 'asc')
                       ->get();

        return response()->json($events);
    }
} 