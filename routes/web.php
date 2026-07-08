<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkoutLogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        $totalDistance = round($user->workoutLogs()->sum('distance'), 1);
        $completedRuns = $user->workoutLogs()->count();
        $totalDuration = $user->workoutLogs()->sum('duration');
        
        if ($totalDistance > 0) {
            $averagePaceRaw = $totalDuration / $totalDistance;
            $paceMinutes = floor($averagePaceRaw);
            $paceSeconds = round(($averagePaceRaw - $paceMinutes) * 60);
            if ($paceSeconds == 60) {
                $paceMinutes += 1;
                $paceSeconds = 0;
            }
            $averagePace = sprintf("%d'%02d\"", $paceMinutes, $paceSeconds);
        } else {
            $averagePace = "0'00\"";
        }
        
        $caloriesBurned = number_format($totalDuration * 8.5);
        $recentLogs = $user->workoutLogs()
            ->orderBy('workout_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact('totalDistance', 'completedRuns', 'averagePace', 'caloriesBurned', 'recentLogs'));
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('workout-logs', WorkoutLogController::class);
});
