<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $courses = $user->courses()->withCount('tasks')->get();
        return view('courses.index', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'icon_string' => 'nullable|string|max:255',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->courses()->create([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'icon_string' => $validated['icon_string'] ?: 'school',
        ]);

        return redirect()->back();
    }

    public function update(Request $request, Course $course)
    {
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'icon_string' => 'nullable|string|max:255',
        ]);

        $course->update([
            'name' => $validated['name'],
            'code' => $validated['code'],
            'icon_string' => $validated['icon_string'] ?: 'school',
        ]);

        return redirect()->back();
    }

    public function destroy(Course $course)
    {
        if ($course->user_id !== Auth::id()) {
            abort(403);
        }

        $course->delete();
        return redirect()->back();
    }
}
