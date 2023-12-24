<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $course->name }}
        </h1>
    </x-slot>

    <x-app-container>
        <x-container-section>
            <div class="text-gray-800 dark:text-gray-200">
                <div class="pb-4 mb-4 border-b border-gray-300 dark:border-gray-700">
                    {{ $course->description }}
                </div>


                @isset($preview_questions)
                    <div>
                        <h3>{{ __("Includes questions like...") }}</h3>
                        <ul class="list-disc">
                            @foreach($preview_questions as $question)
                                <li class="ml-6">
                                    {{ $question->question_text }}
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-4">
                            <a href="{{ route('course.quiz', $course) }}">
                                <x-primary-button type="button">
                                    Start quiz
                                </x-primary-button>
                            </a>
                        </div>
                    </div>

                @else
                    No questions in this course
                @endisset
            </div>
        </x-container-section>
    </x-app-container>
</x-app-layout>
