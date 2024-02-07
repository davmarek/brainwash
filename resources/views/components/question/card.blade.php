<x-container-section>
    <div class="grid grid-cols-[1fr_auto]">

        <div class="space-y-1">
            <h2 class="text-xl font-bold">{{ $question->question_text }}</h2>
            @if($question->is_open_question)
                <p>{{ $question->open_answer }}</p>
            @else
                @if($question->answers->isEmpty())
                    <p>No answers yet added</p>
                @else
                    <ul class="list-disc">
                        @foreach($question->answers as $answer)
                            <li class="ml-4">
                                {{ $answer->answer_text }}
                            </li>
                        @endforeach
                    </ul>

                @endif
            @endif
        </div>
        @if($canUpdate)
        <div>
            <x-dropdown>
                <x-slot:trigger>
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path
                                d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                        </svg>
                    </button>
                </x-slot:trigger>
                <x-slot:content>
                    <x-dropdown-link :href="route('questions.edit', $question)">
                        {{ __('Edit') }}
                    </x-dropdown-link>
                </x-slot:content>
            </x-dropdown>
        </div>
        @endif
    </div>
</x-container-section>
