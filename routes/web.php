<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


Route::prefix('{locale?}')
    ->where(['locale' => 'id|en'])
    ->group(function () {
        Route::get('/', fn() => view('index'))->name('home');

        Route::prefix('admin')->group(function () {
            Route::get('/', fn() => view('admin.index'))->name('admin.index');

            Route::get('/order', fn() => view('admin.order.index'))->name('admin.order');

            Route::prefix('gallery-photo')->group(function () {
                Route::get('/', fn() => view('admin.gallery-photo.index'))->name('admin.gallery-photo.index');
                Route::get('/create', fn() => view('admin.gallery-photo.create'))->name('admin.gallery-photo.create');
                Route::get('/edit', fn() => view('admin.gallery-photo.edit'))->name('admin.gallery-photo.edit');
            });

            Route::get('/timetable', fn() => view('admin.timetable.index'))->name('admin.timetable');
        });
    });

// (Opsional) Redirect otomatis untuk URL tanpa prefix locale
Route::get('{path}', function (string $path) {
    if (preg_match('#^(id|en)(/|$)#', $path)) {
        abort(404); // biar gak loop kalau route-nya memang tidak ada
    }
    $locale = session('locale', config('app.locale', 'id'));
    return redirect("/{$locale}/{$path}");
})->where('path', '.*');