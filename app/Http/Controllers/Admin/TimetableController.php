<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\Timetable;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index()
    {
        $data = Timetable::query()
            ->with('coach')
            // Hitung current_slots SEKALIGUS di query (hindari N+1)
            ->withCount([
                'bookings as current_slots' => function ($q) {
                    $q->whereIn('status', ['pending', 'confirmed', 'completed']);
                }
            ])
            ->openForBooking()
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
        return view('admin.timetable.index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        $coach = Coach::all();
        return view('admin.timetable.create', [
            'coach' => $coach
        ]);
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'date'      => ['required', 'date'],
            'start_time'     => ['required'],
            'duration'    => ['required'],
            'coach_id' => ['required', 'exists:coach,id'],
            'level'     => ['required', 'string'],
            'max_slots'  => ['required', 'integer', 'min:1'],
            'price'     => ['required', 'integer', 'min:0'],
        ]);

        $durationHours = intval($validated['duration']);

        $start = Carbon::createFromFormat('H:i', $validated['start_time']);
        $end   = (clone $start)->addHours($durationHours);

        $startTime = $start->format('H:i:s'); // cocok sama kolom TIME di DB
        $endTime   = $end->format('H:i:s');

        $hasOverlap = Timetable::whereDate('date', $validated['date'])
            ->where(function ($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime)  // existing.start < new.end
                    ->where('end_time', '>', $startTime); // existing.end > new.start
            })
            ->exists();


        if ($hasOverlap) {
            return back()
                ->withErrors([
                    'start_time' => 'Jadwal bentrok dengan sesi lain di lapangan ini pada jam tersebut. Silakan pilih waktu lain.',
                ])
                ->withInput();
        }

        // 2. Simpan ke database
        Timetable::create([
            'date'       => $validated['date'],
            'start_time' => $startTime,
            'end_time'   => $endTime,
            'coach_id'  => $validated['coach_id'],
            'level'      => $validated['level'],
            'max_slots'   => $validated['max_slots'],
            'price'      => $validated['price'],
        ]);

        // 3. Redirect balik ke index
        return redirect()
            ->route('admin.timetable.index')
            ->with('success', 'Timetable berhasil dibuat.');
    }

    public function show() {}

    public function edit() {}

    public function update() {}

    public function destroy() {}
}
