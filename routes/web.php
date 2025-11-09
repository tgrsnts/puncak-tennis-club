<?php

use App\Http\Controllers\Admin\GalleryPhotoController;
use App\Http\Controllers\Admin\GalleryVideoController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MidtransNotificationController;
use App\Models\Coach;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

Route::prefix('{locale?}')
    ->where(['locale' => 'id|en'])
    ->group(function () {
        Route::get('/', function () {
            $coaches = Coach::all();
            return view('index', ['coaches' => $coaches]);
        })->name('home');

        Route::get('/login', fn() => view('auth.login'))->name('login');
        Route::get('/register', fn() => view('auth.register'))->name('register');

        Route::post('/authenticate', [AuthController::class, 'login'])->name('admin.login');
        Route::post('/register', [AuthController::class, 'register'])->name('admin.register');

        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

        Route::prefix('schedule')->name('schedule.')->group(function () {
            Route::get('/', [JadwalController::class, 'index'])->name('index');
        });

        Route::prefix('booking')->name('booking.')->group(function () {
            Route::get('/', [BookingController::class, 'index'])->name('index');
            Route::post('/{booking}/snap', [BookingController::class, 'snap'])->name('snap');
            Route::get('/create', [BookingController::class, 'create'])->name('create');
            Route::post('/{timetable}', [BookingController::class, 'store'])->name('store');
            Route::get('/success/{booking}/{code}', [BookingController::class, 'success'])->name('success');
            Route::get('/s/{code}', [BookingController::class, 'publicShow'])->name('public');
            Route::get('/ticket/{booking}', [BookingController::class, 'ticket'])->name('ticket');
            Route::get('/invoice/{booking}', [BookingController::class, 'invoice'])->name('invoice');
        });

        Route::group(['middleware' => 'auth'], function () {
            Route::prefix('schedule')->name('schedule.')->group(function () {
                Route::get('/create', [JadwalController::class, 'create'])->name('create');
                Route::post('/', [JadwalController::class, 'store'])->name('store');
                Route::get('/{id}', [JadwalController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [JadwalController::class, 'edit'])->name('edit');
                Route::put('/{id}', [JadwalController::class, 'update'])->name('update');
                Route::delete('/{id}', [JadwalController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('booking')->name('booking.')->group(function () {
                Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('edit');
                Route::put('/{id}', [BookingController::class, 'update'])->name('update');
                Route::delete('/{id}', [BookingController::class, 'destroy'])->name('destroy');
            });

            Route::prefix('history')->name('history.')->group(function () {
                Route::get('/', [HistoryController::class, 'index'])->name('index');
                Route::get('/create', [HistoryController::class, 'create'])->name('create');
                Route::post('/', [HistoryController::class, 'store'])->name('store');
                Route::get('/{id}', [HistoryController::class, 'show'])->name('show');
                Route::get('/{id}/edit', [HistoryController::class, 'edit'])->name('edit');
                Route::put('/{id}', [HistoryController::class, 'update'])->name('update');
                Route::delete('/{id}', [HistoryController::class, 'destroy'])->name('destroy');
            });
        });


        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/', fn() => view('admin.index'))->name('index');
            Route::get('/order', fn() => view('admin.order.index'))->name('order');

            // ======== GALLERY PHOTO ========
            Route::prefix('gallery-photo')->name('gallery-photo.')->group(function () {
                Route::get('/', [GalleryPhotoController::class, 'index'])->name('index');
                Route::get('/create', [GalleryPhotoController::class, 'create'])->name('create');
                Route::post('/', [GalleryPhotoController::class, 'store'])->name('store');
                Route::get('/{gallery}/edit', [GalleryPhotoController::class, 'edit'])->name('edit');
                Route::put('/{gallery}', [GalleryPhotoController::class, 'update'])->name('update');
                Route::delete('/{gallery}', [GalleryPhotoController::class, 'destroy'])->name('destroy');
            });

            // ======== GALLERY VIDEO ========
            Route::prefix('gallery-video')->name('gallery-video.')->group(function () {
                Route::get('/', [GalleryVideoController::class, 'index'])->name('index');
                Route::get('/create', [GalleryVideoController::class, 'create'])->name('create');
                Route::post('/', [GalleryVideoController::class, 'store'])->name('store');
                Route::get('/{video}/edit', [GalleryVideoController::class, 'edit'])->name('edit');
                Route::put('/{video}', [GalleryVideoController::class, 'update'])->name('update');
                Route::delete('/{video}', [GalleryVideoController::class, 'destroy'])->name('destroy');
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

            // Admin payment control for testing
            Route::prefix('payment')->name('payment.')->group(function () {
                Route::post('/{payment}/settle', [\App\Http\Controllers\Admin\PaymentController::class, 'settle'])->name('settle');
                Route::post('/{payment}/expire', [\App\Http\Controllers\Admin\PaymentController::class, 'expire'])->name('expire');
            });
        });

        Route::get('/profile', fn() => view('admin.profile.index'))->name('profile');
    });

// (Opsional) Redirect otomatis untuk URL tanpa prefix locale
Route::get('{path}', function (string $path) {
    if (preg_match('#^(id|en)(/|$)#', $path)) {
        abort(404);
    }
    $locale = session('locale', config('app.locale', 'id'));
    return redirect("/{$locale}/{$path}");
})->where('path', '.*');

Route::post('/midtrans/notify', [MidtransNotificationController::class, 'handle'])
    ->withoutMiddleware([VerifyCsrfToken::class])   // <— penting
    ->name('midtrans.notify');
