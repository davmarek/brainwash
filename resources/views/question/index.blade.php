<x-app-layout>
    <x-slot name="header">
        <x-header-heading>
            {{ __('Courses') }}
        </x-header-heading>
    </x-slot>

    <x-app-container class="max-w-2xl">
        @isset($course)
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
            No course loaded
        @endisset


    </x-app-container>
</x-app-layout>
