<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\QuestionUpdateRequest;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        return view('question.index', [
            'course' => $course,
            'questions' => $course->questions()->with('answers')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        // TODO: add the answers to the question so they can be rendered to the input
        $question->load(['course', 'answers']);

        // TODO: add the proper answer input to the edit form and then figure out how is it gonna work
        return view('question.edit', [
            'question' => $question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionUpdateRequest $request, Question $question): RedirectResponse
    {
        if ($request->user()->cannot('update', $question)) {
            abort(403);
        }

        $validated = $request->validated();
        $question->update($validated);

        return redirect(route('courses.questions.index', $question->course));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        // TODO: implement deleting questions
    }
}
