<?php

use App\Http\Controllers\Admin\GalleryPhotoController;
use App\Http\Controllers\Admin\GalleryVideoController;
use App\Http\Controllers\Admin\TimetableController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


Route::prefix('{locale?}')
    ->where(['locale' => 'id|en'])
    ->group(function () {
        Route::get('/', fn() => view('index'))->name('home');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/', fn() => view('admin.index'))->name('index');

            Route::get('/order', fn() => view('admin.order.index'))->name('order');

            // ======== GALLERY PHOTO ========
            Route::prefix('gallery-photo')->name('gallery-photo.')->group(function () {
                Route::get('/', [GalleryPhotoController::class, 'index'])->name('index');
                Route::get('/create', [GalleryPhotoController::class, 'create'])->name('create');
                Route::post('/', [GalleryPhotoController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [GalleryPhotoController::class, 'edit'])->name('edit');
                Route::put('/{id}', [GalleryPhotoController::class, 'update'])->name('update');
                Route::delete('/{id}', [GalleryPhotoController::class, 'destroy'])->name('destroy');
            });

            // ======== GALLERY VIDEO ========
            Route::prefix('gallery-video')->name('gallery-video.')->group(function () {
                Route::get('/', [GalleryVideoController::class, 'index'])->name('index');
                Route::get('/create', [GalleryVideoController::class, 'create'])->name('create');
                Route::post('/', [GalleryVideoController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [GalleryVideoController::class, 'edit'])->name('edit');
                Route::put('/{id}', [GalleryVideoController::class, 'update'])->name('update');
                Route::delete('/{id}', [GalleryVideoController::class, 'destroy'])->name('destroy');
            });

            // ======== TIMETABLE ========
            Route::prefix('timetable')->name('timetable.')->group(function () {
                Route::get('/', [TimetableController::class, 'index'])->name('index');
                Route::get('/create', [TimetableController::class, 'create'])->name('create');
                Route::post('/', [TimetableController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [TimetableController::class, 'edit'])->name('edit');
                Route::put('/{id}', [TimetableController::class, 'update'])->name('update');
                Route::delete('/{id}', [TimetableController::class, 'destroy'])->name('destroy');
            });
        });

        Route::get('/profile', fn() => view('admin.profile.index'))->name('profile');
    });

// (Opsional) Redirect otomatis untuk URL tanpa prefix locale
Route::get('{path}', function (string $path) {
    if (preg_match('#^(id|en)(/|$)#', $path)) {
        abort(404); // biar gak loop kalau route-nya memang tidak ada
    }
    $locale = session('locale', config('app.locale', 'id'));
    return redirect("/{$locale}/{$path}");
})->where('path', '.*');
