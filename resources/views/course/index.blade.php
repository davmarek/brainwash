<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <x-app-container>
        @isset($courses)
            @foreach($courses as $course)
                <a href="{{ route('courses.show', $course) }}">
                    {{ $course->title }}
                </a>
            @endforeach
        @else
            No courses
        @endisset
    </x-app-container>
</x-app-layout>
