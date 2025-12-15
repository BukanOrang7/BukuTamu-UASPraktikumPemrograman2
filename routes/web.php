<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TamuController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Halaman utama -> arahkan ke event terbaru
Route::get('/', function () {
    if (\App\Models\Event::count() == 0) {
        return redirect()->route('event.create');
    }

    $event = \App\Models\Event::latest()->first();
    return redirect()->route('tamu.index', $event->id);
});


// ================================
// EVENT ROUTES
// ================================
Route::get('/event', [EventController::class, 'index'])->name('event.index');  // FIXED
Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
Route::post('/event', [EventController::class, 'store'])->name('event.store');

Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('event.edit');
Route::put('/event/{event}', [EventController::class, 'update'])->name('event.update');

Route::post('/event/{event}/toggle-status', [EventController::class, 'toggleStatus'])
    ->name('event.toggleStatus'); // FIXED exact name

Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('event.destroy');


// ================================
// TAMU ROUTES (berdasarkan event_id)
// ================================
Route::get('/tamu/{event}', [TamuController::class, 'index'])->name('tamu.index');
Route::get('/tamu/{event}/create', [TamuController::class, 'create'])->name('tamu.create');
Route::post('/tamu/{event}', [TamuController::class, 'store'])->name('tamu.store');

Route::get('/tamu/{event}/{tamu}/edit', [TamuController::class, 'edit'])->name('tamu.edit');
Route::put('/tamu/{event}/{tamu}', [TamuController::class, 'update'])->name('tamu.update');

Route::delete('/tamu/{event}/{tamu}', [TamuController::class, 'destroy'])->name('tamu.destroy');

Route::post('/tamu/{event}/{tamu}/presence', [TamuController::class, 'togglePresence'])->name('tamu.presence');

Route::get('/tamu/{event}/export', [TamuController::class, 'exportCSV'])->name('tamu.export');

Route::get('/tamu/{event}/rekap', [TamuController::class, 'rekap'])->name('tamu.rekap');

// Toggle theme (store user's preference in session so it persists across pages)
Route::post('/toggle-theme', function (\Illuminate\Http\Request $request) {
    $current = session('theme', 'light');
    $next = $current === 'dark' ? 'light' : 'dark';
    session(['theme' => $next]);
    return response()->json(['theme' => $next]);
});
