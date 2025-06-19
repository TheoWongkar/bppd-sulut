<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\EventPlace;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        // Validasi input dari query string
        $validated = $request->validate([
            'search' => 'nullable|string|max:255',
        ]);

        // Ambil nilai pencarian dari hasil validasi
        $search = $validated['search'] ?? null;
        $now = Carbon::now();

        // Query tempat event
        $eventPlaces = EventPlace::with(['firstImage'])
            ->when($search, function ($query, $search) {
                $query->where('business_name', 'like', "%{$search}%");
            })
            ->selectRaw('*, 
            CASE 
                WHEN start_time <= ? AND end_time >= ? THEN 0
                WHEN start_time > ? THEN 1
                ELSE 2
            END as event_status_order', [$now, $now, $now])
            ->orderBy('event_status_order', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(8);

        // Kirim data ke view
        return view('home', compact('eventPlaces'));
    }

    public function about()
    {
        return view('about');
    }
}
