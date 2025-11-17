<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {
        $data = Booking::all();
        return view('admin.order.index', [
            'data' => $data
        ]);
    }
}
