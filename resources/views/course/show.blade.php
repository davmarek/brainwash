<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>

    <x-app-container>
        <div>
            <a href="{{ route('course.quiz', $course) }}">
            <x-primary-button type="button">
                Start quiz
            </x-primary-button>
            </a>

        </div>
        @isset($preview_questions)
            <ul class="list-disc">
                @foreach($preview_questions as $question)
                    <li class="ml-6">
                        {{ $question->question_text }}
                    </li>
                @endforeach
            </ul>
        @else
            No questions in this course
        @endisset
    </x-app-container>
</x-app-layout>
