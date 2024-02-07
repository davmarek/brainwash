<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\CourseStoreRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('course.index', [
            'courses' => Course::latest()->orderBy('id', 'desc')->with('creator')->simplePaginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $request->user()->createdCourses()->create($validated);

        return redirect(route('profile.show'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $preview_questions = $course->questions()->take(5)->get();

        return view('course.show', [
            'course' => $course,
            'preview_questions' => $preview_questions,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Course $course)
    {
        if ($request->user()->cannot('update', $course)) {
            abort(403);
        }

        return view('course.edit', ['course' => $course]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseUpdateRequest $request, Course $course): RedirectResponse
    {
        if ($request->user()->cannot('update', $course)) {
            abort(403);
        }

        $validated = $request->validated();
        $course->update($validated);

        return redirect(route('courses.show', $course));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Course $course): RedirectResponse
    {
        // TODO: check implementation of confirmation modal before deleting course
        if ($request->user()->cannot('delete', $course)) {
            abort(403);
        }

        $course->delete();

        return redirect(route('profile.show'));
    }
}
