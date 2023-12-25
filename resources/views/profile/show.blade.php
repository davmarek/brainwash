<?php
$youAreHim = $user->is(auth()->user());
?>

<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $user->name }}
        </h1>
    </x-slot>

    <x-app-container>
        <x-container-section>
            <h3 class="font-bold text-xl">
                {{ $youAreHim ? 'Your courses' : 'Created courses'}}
            </h3>

            <ul class="list-disc">
                @forelse($user->createdCourses as $createdCourse)
                    <li class="ml-4">{{ $createdCourse->name }}</li>
                @empty
                    <p>No created courses</p>
                @endforelse
            </ul>
        </x-container-section>


        @if($youAreHim)
            <x-container-section>
                <h3 class="font-bold text-xl">
                    Subscribed courses
                </h3>
                <ul>
                    @forelse($user->subscribedCourses as $subscribedCourse)
                        <li>{{ $subscribedCourse->name }}</li>
                    @empty
                        <p>No subscribed courses</p>
                    @endforelse
                </ul>
            </x-container-section>

            <x-container-section>
                <h3 class="font-bold text-xl">
                    Courses you can edit
                </h3>
                <ul>
                    @forelse($user->editableCourses as $editableCourse)
                        <li>{{ $editableCourse->name }}</li>
                    @empty
                        <p>No editable courses</p>
                    @endforelse
                </ul>
            </x-container-section>
        @endif
    </x-app-container>
</x-app-layout>
