<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Tasks and Courses
        $tasks = $user->tasks()->with('course')->get();
        $courses = $user->courses()->withCount('tasks')->get();

        // Calculations
        $totalTasks = $tasks->count();
        $completedTasks = $tasks->where('status_task', 'Completed')->count();
        $pendingTasks = $totalTasks - $completedTasks;
        
        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;

        // Nearest Deadline (Pending only)
        $nearestTask = $tasks->where('status_task', 'Pending')
            ->whereNotNull('deadline')
            ->sortBy('deadline')
            ->first();

        // Course Overview (take 3 for dashboard)
        $topCourses = $courses->take(3);

        // High Priority
        $highPriorityTasks = $tasks->where('status_task', 'Pending')
            ->where('priority', 'High')
            ->sortBy('deadline')
            ->take(5);

        // Weekly Productivity (Last 7 days including today)
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $weeklyData['labels'][] = $date->format('D');
            
            // Tasks completed on this day
            $completed = $tasks->filter(function($task) use ($date) {
                return $task->status_task === 'Completed' && 
                       $task->completed_at && 
                       Carbon::parse($task->completed_at)->isSameDay($date);
            })->count();
            
            // Tasks created on this day
            $created = $tasks->filter(function($task) use ($date) {
                return Carbon::parse($task->created_at)->isSameDay($date);
            })->count();

            $weeklyData['completed'][] = $completed;
            $weeklyData['created'][] = $created;
        }

        return view('dashboard', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'progress',
            'nearestTask',
            'courses',
            'topCourses',
            'highPriorityTasks',
            'weeklyData'
        ));
    }
}
