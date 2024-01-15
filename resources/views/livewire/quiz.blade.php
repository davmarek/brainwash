@use('App\Enums\QuizState')

<x-slot name="header" class="">
    <div class="flex gap-2 items-center">
        <a href="{{ route('courses.show', $course) }}">
            @svg('heroicon-o-chevron-left', 'w-6 h-6 text-gray-600')
        </a>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $course->name }}
        </h2>
    </div>
</x-slot>

<div class="p-6 text-gray-900 dark:text-gray-100">
    <div>

        @if($questions->isEmpty())
            {{-- user doesn't have any more unanswered questions --}}
            <div>
                There are no questions you can solve
            </div>

        @else
            {{-- user has unanswered questions --}}
            @isset($this->currentQuestion)
                <h2 class="text-2xl">
                    {{ $this->currentQuestion->question_text }}
                </h2>

                @if($this->currentQuestion->is_open_question)
                    {{-- open question --}}
                    @if($state == QuizState::SelfReview)
                        <div class="mt-4">
                            {{ $this->currentQuestion->open_answer }}
                        </div>
                    @endif
                    <div class="mt-4">
                        <textarea wire:model="openAnswer" rows="4"
                                  class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                  @disabled($state == QuizState::SelfReview) >

                        </textarea>
                    </div>
                @else
                    {{-- Question with answers --}}
                    @isset($this->currentQuestion->answers)
                        <!-- Answers Stack -->
                        <div
                            class="flex flex-col mt-4 gap-2"
                        >
                            @foreach($this->currentQuestion->answers as $answer)
                                <!-- Selectable Answer -->
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
                        <!-- Error if form submitted, but user didn't select any answer -->
                        <div>
                            @error('selectedAnswerId') <span class="text-red-600">{{ $message }}</span> @enderror
                        </div>
                    @else
                        Current question doesn't have answers
                    @endisset


                    {{-- Only question with answers requires to show the result --}}
                    @session('result')
                    <div
                        class="text-white font-bold py-2 px-4 mt-2 rounded-xl {{ $value == "Correct" ? 'bg-green-500' : 'bg-red-600' }}"
                        role="alert">
                        {{ $value }}
                    </div>
                    @endsession

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
                {{--
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
                --}}
            @endisset
            {{-- end: user has unanswered questions --}}
        @endif
    </div>

</div>
