<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik atas
        $totalUsers   = User::count();
        $totalOrders  = Booking::count();
        $totalSales   = Payment::whereIn('status', ['paid', 'settlement', 'success'])->sum('gross_amount');
        $pendingCount = Booking::where('status', 'pending')->count();

        // Sales per bulan (tahun berjalan)
        $sales = Payment::selectRaw('MONTH(paid_at) as month, SUM(gross_amount) as total')
            ->whereIn('status', ['paid', 'settlement', 'success'])
            ->whereYear('paid_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Label bulan & data
        $salesLabels = $sales->map(function ($row) {
            return Carbon::create()->month($row->month)->translatedFormat('F');
        })->toArray();

        $salesData = $sales->pluck('total')->toArray();

        // Running orders (misal 10 terakhir, status tertentu)
        $runningOrders = Booking::with(['user', 'timetable.coach'])
            ->whereIn('status', ['pending', 'confirmed', 'challenge'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.index', [
            'totalUsers'    => $totalUsers,
            'totalOrders'   => $totalOrders,
            'totalSales'    => $totalSales,
            'pendingCount'  => $pendingCount,
            'salesLabels'   => $salesLabels,
            'salesData'     => $salesData,
            'runningOrders' => $runningOrders,
        ]);
    }
}
