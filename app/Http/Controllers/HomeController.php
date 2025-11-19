<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use App\Models\Photo;
use App\Models\Timetable;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $rawDate = $request->query('date');     // "YYYY-MM-DD" idealnya
        $coachId = $request->query('coach_id'); // id coach

        // Build tampilan filter tanggal
        $filterDateDisplay = null;
        if ($rawDate) {
            try {
                $filterDateDisplay = Carbon::parse($rawDate)
                    ->locale('id')->translatedFormat('d F Y');
            } catch (\Throwable $e) {
                $filterDateDisplay = $rawDate;
            }
        }

        $filterCoach = $coachId ? Coach::find($coachId) : null;

        // Query utama — TIDAK dobel filter lagi
        $timetables = Timetable::query()
            ->with('coach')
            // Hitung current_slots SEKALIGUS di query (hindari N+1)
            ->withCount([
                'bookings as current_slots' => function ($q) {
                    $q->whereIn('status', ['pending', 'confirmed', 'completed']);
                }
            ])
            // Filter opsional dari query string
            ->when($rawDate, fn($q) => $q->whereDate('date', $rawDate))
            ->when($coachId, fn($q) => $q->where('coach_id', $coachId))
            // Saring H-1 jam
            ->openForBooking()
            ->orderBy('date')
            ->orderBy('start_time')
            ->paginate(12)         // ✅ pakai pagination biar ringan
            ->withQueryString();   // keep query params saat paging

        $photos = Photo::all();

        if ($photos->isEmpty()) {
            $photoUrls = [
                '/assets/images/photo (1).png',
                '/assets/images/photo (2).png',
                '/assets/images/photo (3).png',
                '/assets/images/photo (4).png',
                '/assets/images/photo (5).png',
            ];
        } else {
            $photoUrls = $photos->map(function ($p) {
                return asset($p->img);
            });
        }


        $videos = Video::all();

        if ($videos->isEmpty()) {
            $videoUrls = [
                '/assets/videos/video (1).mp4',
                '/assets/videos/video (2).mp4',
                '/assets/videos/video (3).mp4',
                '/assets/videos/video (4).mp4',
                '/assets/videos/video (5).mp4',
            ];
        } else {
            $videoUrls = $videos->map(function ($p) {
                return asset($p->img);
            });
        }


        return view('index', [
            'coaches'            => Coach::all(),
            'filterDateDisplay' => $filterDateDisplay,
            'filterCoach'       => $filterCoach,
            'timetables'        => $timetables,
            'photoUrls'         => $photoUrls,
            'videoUrls'         => $videoUrls
        ]);
    }
}
