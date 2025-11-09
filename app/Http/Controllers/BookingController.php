<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $id = $request->query('id');

        $timetable = Timetable::find($id);

        return view('user.booking.create', [
            'timetableId' => $id,
            'timetable' => $timetable
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }
}
