<x-app-layout>
    <x-slot name="header">
        <x-header-heading>
            <x-slot:sup>
                Questions
            </x-slot:sup>
            {{ $course->name }}
        </x-header-heading>
    </x-slot>

    <x-app-container class="max-w-2xl">
        @isset($questions)
            @foreach($questions as $question)
                <x-question.card
                    :question="$question"
                />
            @endforeach
            <div class="px-4 sm:px-0">
                {{ $questions->links() }}
            </div>
        @else
            No course loaded
        @endisset


    </x-app-container>
</x-app-layout>
