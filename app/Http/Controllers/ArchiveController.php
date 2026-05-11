<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ArchiveController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tasks = $user->tasks()->with('course')->where('status_task', 'Completed')->latest('completed_at')->get();

        $recentlyCompleted = [];
        $lastMonth = [];
        $older = [];

        $now = Carbon::now();

        foreach ($tasks as $task) {
            $completedAt = Carbon::parse($task->completed_at);
            if ($completedAt->diffInDays($now) <= 7) {
                $recentlyCompleted[] = $task;
            } elseif ($completedAt->diffInDays($now) <= 30) {
                $lastMonth[] = $task;
            } else {
                $older[] = $task;
            }
        }

        $courseStats = [];
        foreach ($tasks as $task) {
            $courseName = $task->course ? $task->course->name : __('app.noCourseAssigned');
            if (!isset($courseStats[$courseName])) {
                $courseStats[$courseName] = 0;
            }
            $courseStats[$courseName]++;
        }
        arsort($courseStats);

        return view('archive.index', compact('tasks', 'recentlyCompleted', 'lastMonth', 'older', 'courseStats'));
    }

    public function restore(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->update([
            'status_task' => 'Pending',
            'completed_at' => null,
        ]);

        return redirect()->back();
    }
}
