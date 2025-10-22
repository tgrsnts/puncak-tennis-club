<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::prefix('/admin')->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    });

    Route::get('/order', function () {
        return view('admin.order.index');
    });

    Route::get('/gallery-photo', function () {
        return view('admin.gallery-photo.index');
    });

    Route::get('/timetable', function () {
        return view('admin.timetable.index');
    });
});
