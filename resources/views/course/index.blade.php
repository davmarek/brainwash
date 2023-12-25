<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Courses') }}
        </h1>
    </x-slot>

    <x-app-container class="max-w-2xl">
        @isset($courses)
            @foreach($courses as $course)
                <x-course.card
                    :name="$course->name"
                    :href="route('courses.show', $course)"
                    :description="$course->description"
                    :creator="$course->creator"
                />
            @endforeach
            <div class="px-4 sm:px-0">
                {{ $courses->links() }}
            </div>
        @else
            No courses
        @endisset


    </x-app-container>
</x-app-layout>
