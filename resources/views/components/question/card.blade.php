<x-container-section>
    <div class="space-y-1">
        <a href="{{ '' }}" class="hover:underline">
            <h2 class="text-xl font-bold">{{ $question->question_text }}</h2>
        </a>
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
</x-container-section>
