<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class QuestionUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question_text' => ['required', 'string'],
            'is_open_question' => ['boolean'],
            'open_answer' => ['nullable', 'string'],
            'answers' => ['nullable', 'string'],
            'course_id' => ['required', 'exists:courses'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
