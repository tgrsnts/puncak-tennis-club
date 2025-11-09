<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
  public function index()
  {

    $user = Auth::user();

    $bookings = Booking::with(['timetable.coach'])
      ->where('user_id', $user->id)
      ->orderBy('created_at', 'desc')
      ->get();

    return view('user.history.index', [
      'bookings' => $bookings,
    ]);
  }

  public function show($locale = null, $id)
  {
    $booking = Booking::with(['timetable.coach'])
      ->where('id', $id)
      ->first();
    return view('user.history.show', [
      'booking' => $booking,
    ]);
  }
}
