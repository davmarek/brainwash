@use('App\Enums\QuizState')
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ $course->title }}
    </h2>
</x-slot>

<div class="p-6 text-gray-900 dark:text-gray-100">

    @if($questions->isEmpty())
        {{-- user doesn't have any more unanswered questions --}}
        <div>
            No more questions for you my babe
        </div>

    @else
        {{-- user has unanswered questions --}}
        <h2 class="text-2xl">
            @isset($this->currentQuestion)
                {{ $this->currentQuestion->question_text }}
            @endisset
        </h2>

        @if($this->currentQuestion->is_open_question)
            {{-- open question --}}
            <div class="mt-4">
                <textarea wire:model="openAnswer"
                          rows="4"
                          class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                </textarea>
            </div>
        @else
            {{-- question with answers --}}
            @isset($this->currentQuestion->answers)
                <div
                    class="flex flex-col mt-4 gap-2"
                >
                    @foreach($this->currentQuestion->answers as $answer)
                        <div
                            wire:key="{{ $answer->id }}"
                            wire:click="selectAnswer({{ $answer->id }})"
                            class="cursor-pointer p-4 bg-gray-200 rounded-xl dark:bg-gray-800
                            {{ $state == QuizState::Answering ? 'ring-indigo-500' : '' }}
                            {{ $state == QuizState::ShowingResults && $answer->is_correct ? 'ring-green-500 ring-2' : '' }}
                            {{ $state == QuizState::ShowingResults && !$answer->is_correct ? 'ring-red-500' : '' }}
                            {{ $selectedAnswerId == $answer->id ? 'ring-2' : '' }}"
                        >
                            {{ $answer->answer_text }}
                        </div>
                    @endforeach

                </div>
                <div>
                    @error('selectedAnswerId') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>
            @else
                Current question doesn't have answers
            @endisset

            {{-- result message (correct/wrong) --}}
            @if (session('result'))
                <div class="alert alert-success">
                    {{ session('result') }}
                </div>
            @endif

            {{-- end: question with answers --}}
        @endif

        {{-- control buttons --}}
        <div class="mt-4">
            @if($state == QuizState::ShowingResults)
                <x-primary-button wire:click="next" type="button">
                    Next 🏃
                </x-primary-button>
            @elseif($state == QuizState::SelfReview)
                <x-primary-button wire:click="selfReview(true)" type="button">
                    Correct
                </x-primary-button>
                <x-primary-button wire:click="selfReview(false)" type="button">
                    Wrong
                </x-primary-button>
            @else
                @if($this->currentQuestion->is_open_question)
                    <x-primary-button wire:click="submit" type="button"
                                      x-bind:disabled="$wire.openAnswer === ''">
                        Submit 🚀
                    </x-primary-button>
                @else
                    <x-primary-button wire:click="submit" type="button"
                                      :disabled="$selectedAnswerId == null">
                        Submit 🚀
                    </x-primary-button>
                @endif
                <x-primary-button wire:click="skip" type="button">
                    Skip 🙈
                </x-primary-button>
            @endif
        </div>

        {{-- developer buttons --}}
        <div class="mt-4">
            <x-primary-button wire:click="next" type="button">
                Dalsi
            </x-primary-button>
            <x-primary-button wire:click="submit" type="button">
                Potvrdit
            </x-primary-button>
            <x-primary-button wire:click="skip" type="button">
                Skip
            </x-primary-button>
        </div>
        {{-- end: user has unanswered questions --}}
    @endif

</div>
