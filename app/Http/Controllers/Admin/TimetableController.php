<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index() {
        $data = Timetable::all();
        return view('admin.timetable.index', [
            'data' => $data
        ]);
    }

    public function create() {
        return view('admin.timetable.create');
    }

    public function store() {
        
    }

    public function show() {
        
    }

    public function edit() {
        
    }

    public function update() {
        
    }

    public function destroy() {
        
    }
}
