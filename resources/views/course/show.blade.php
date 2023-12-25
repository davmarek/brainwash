<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">

            <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $course->name }}
            </h1>

            <div class="flex gap-1">
                <a href="{{ route('course.quiz', $course) }}">
                    <x-primary-button type="button">
                        {{ __('Start quiz') }}
                    </x-primary-button>
                </a>
                <livewire:course-subscribe-button :course="$course"/>
            </div>

        </div>
    </x-slot>

    <x-app-container>
        <x-container-section>
            <div class="text-gray-800 dark:text-gray-200">
                <div class="pb-4 mb-4 border-b border-gray-300 dark:border-gray-700">
                    {{ $course->description }}
                </div>


                @if(!$preview_questions->isEmpty())
                    <div>
                        <p>{{ __("Includes questions like:") }}</p>
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
                                    {{ __('Start quiz') }}
                                </x-primary-button>
                            </a>
                        </div>
                    </div>

                @else
                    {{ __('There are no questions in this course') }}
                @endif
            </div>
        </x-container-section>
    </x-app-container>
</x-app-layout>
