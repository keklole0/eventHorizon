<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
        
        $events = Event::where('title', 'LIKE', "%{$query}%")
            ->where('status', 'active')
            ->select('id', 'title')
            ->limit(5)
            ->get();
            
        return response()->json($events);
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $date = $request->get('date');

        $events = Event::query()
            ->where('status', 'active')
            ->with('address')
            ->when($query, function($q) use ($query) {
                $q->where(function($sub) use ($query) {
                    $sub->whereRaw('LOWER(title) LIKE ?', ['%' . mb_strtolower($query) . '%'])
                        ->orWhereRaw('LOWER(description) LIKE ?', ['%' . mb_strtolower($query) . '%'])
                        ->orWhereHas('address', function($addr) use ($query) {
                            $addr->whereRaw('LOWER(title) LIKE ?', ['%' . mb_strtolower($query) . '%']);
                        });
                });
            })
            ->when($date, function($q) use ($date) {
                $q->whereDate('date_start', $date);
            })
            ->orderByRaw('CASE WHEN date_start >= NOW() THEN 0 ELSE 1 END, ABS(TIMESTAMPDIFF(SECOND, date_start, NOW()))')
            ->paginate(12);

        // Если ничего не найдено и был запрос, не показываем нерелевантные
        if ($query && $events->isEmpty()) {
            return view('search.results', [
                'events' => $events,
                'query' => $query,
                'date' => $date,
                'not_found' => true
            ]);
        }

        return view('search.results', [
            'events' => $events,
            'query' => $query,
            'date' => $date
        ]);
    }
} 