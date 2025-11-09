<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $rawDate  = $request->query('date');      // idealnya format YYYY-MM-DD
        $coachId  = $request->query('coach_id');  // atau pakai 'coach' sesuai form-mu

        // Siapkan data tampilan filter
        $filterDateDisplay = null;
        if ($rawDate) {
            try {
                $filterDateDisplay = Carbon::parse($rawDate)
                    ->locale('id')->translatedFormat('d F Y'); // "6 November 2025"
            } catch (\Throwable $e) {
                $filterDateDisplay = $rawDate; // fallback kalau formatnya "6 Nov 2025"
            }
        }

        $filterCoach = null;
        if ($coachId) {
            $filterCoach = Coach::find($coachId); // ->name
        }

        $timetables = Timetable::query();
        if ($rawDate) {
            $timetables->where('date', $rawDate);
        }
        if ($coachId) {       
            $timetables->where('coach_id', $coachId);
        }

        $timetables = $timetables->get();

        return view('user.schedule.index', [
            'filterDateDisplay' => $filterDateDisplay,
            'filterCoach' => $filterCoach,
            'timetables' => $timetables
        ]);
    }
}
