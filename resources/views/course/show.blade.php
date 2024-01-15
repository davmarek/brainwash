<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">

            <x-header-heading>
                <x-slot:sup>
                    {{ __('Course') }}
                </x-slot:sup>
                {{ $course->name }}
            </x-header-heading>


            <div class="flex gap-2">
                @can('update', $course)
                    <a href="{{ route('courses.edit', $course) }}">
                        <x-secondary-button type="button">
                            {{ __('Edit course') }}
                        </x-secondary-button>
                    </a>
                @endcan
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

                @isset($preview_questions)
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
                                <a href="{{ route('courses.quiz', $course) }}">
                                    <x-primary-button type="button">
                                        {{ __('Start quiz') }}
                                    </x-primary-button>
                                </a>
                            </div>
                        </div>

                    @else
                        {{ __('There are no questions in this course') }}
                    @endif
                @endisset
            </div>
        </x-container-section>
    </x-app-container>
</x-app-layout>
