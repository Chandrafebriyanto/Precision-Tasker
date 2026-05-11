<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

// Locale Switcher Route
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

use App\Http\Controllers\DashboardController;

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Core App Routes (Controllers to be created)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Tasks
    Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
    Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [\App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/tasks/{task}/complete', [\App\Http\Controllers\TaskController::class, 'complete'])->name('tasks.complete');

    // Courses
    Route::get('/courses', [\App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
    Route::post('/courses', [\App\Http\Controllers\CourseController::class, 'store'])->name('courses.store');
    Route::put('/courses/{course}', [\App\Http\Controllers\CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [\App\Http\Controllers\CourseController::class, 'destroy'])->name('courses.destroy');

    // Archive
    Route::get('/archive', [\App\Http\Controllers\ArchiveController::class, 'index'])->name('archive.index');
    Route::post('/archive/{task}/restore', [\App\Http\Controllers\ArchiveController::class, 'restore'])->name('archive.restore');

    // Test Notification Route
    Route::get('/test-notif', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
    
        // Kirim notifikasi ke user yang sedang login
        $user->notify(new \App\Notifications\TestNotif());
    
        return "Notifikasi sedang meluncur! Coba cek pojok layarmu 🔔";
});
});

// Offline
Route::view('/offline', 'offline')->name('offline');

// Push Subscription
Route::post('/push/subscribe', [\App\Http\Controllers\PushController::class, 'store'])->name('push.subscribe');