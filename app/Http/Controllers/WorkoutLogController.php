<?php

namespace App\Http\Controllers;

use App\Models\WorkoutLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = Auth::user()->workoutLogs()
            ->orderBy('workout_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('workout_logs.index', compact('logs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = ['Lari', 'Jalan Cepat', 'Bersepeda', 'Berenang', 'Lainnya'];
        return view('workout_logs.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'workout_date' => ['required', 'date'],
            'workout_type' => ['required', 'string', 'in:Lari,Jalan Cepat,Bersepeda,Berenang,Lainnya'],
            'duration' => ['required', 'integer', 'min:1'],
            'distance' => ['required', 'numeric', 'min:0.01'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Auth::user()->workoutLogs()->create($validated);

        return redirect()->route('workout-logs.index')
            ->with('success', 'Aktivitas olahraga berhasil dicatat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $workoutLog = Auth::user()->workoutLogs()->findOrFail($id);
        $types = ['Lari', 'Jalan Cepat', 'Bersepeda', 'Berenang', 'Lainnya'];

        return view('workout_logs.edit', compact('workoutLog', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $workoutLog = Auth::user()->workoutLogs()->findOrFail($id);

        $validated = $request->validate([
            'workout_date' => ['required', 'date'],
            'workout_type' => ['required', 'string', 'in:Lari,Jalan Cepat,Bersepeda,Berenang,Lainnya'],
            'duration' => ['required', 'integer', 'min:1'],
            'distance' => ['required', 'numeric', 'min:0.01'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $workoutLog->update($validated);

        return redirect()->route('workout-logs.index')
            ->with('success', 'Aktivitas olahraga berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $workoutLog = Auth::user()->workoutLogs()->findOrFail($id);
        $workoutLog->delete();

        return redirect()->route('workout-logs.index')
            ->with('success', 'Aktivitas olahraga berhasil dihapus!');
    }
}
