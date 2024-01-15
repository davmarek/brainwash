<?php

namespace App\Http\Requests\Course;

use App\Models\Course;
use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'user_id' => ['nullable', 'exists:users'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create', Course::class);
    }
}
