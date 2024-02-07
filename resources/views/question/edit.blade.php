<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">

            <x-header-heading :sup="__('Edit question')">
                {{ $question->question_text }}
            </x-header-heading>

            <div class="flex gap-2">
                @can('delete', $question)
                    <x-danger-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-course-deletion')"
                    >{{ __('Delete Course') }}</x-danger-button>
                @endcan

                <a href="{{ route('courses.questions.index', $question->course) }}">
                    <x-secondary-button type="button">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                </a>
            </div>

        </div>
    </x-slot>

    <x-app-container>
        <x-container-section>
            <form action="{{ route('questions.update', $question) }}"
                  method="POST"
                  x-data="{isOpenQuestion: false}">
                @csrf
                @method('PATCH')

                <!-- Question itself -->
                <div>
                    <x-input-label for="question_text" :value="__('Question')"/>
                    <x-text-input id="question_text"
                                  class="block mt-1 w-full"
                                  name="question_text"
                                  :value="old('name', $question->question_text)"
                                  required
                    />
                    <x-input-error :messages="$errors->get('question_text')" class="mt-2"/>
                </div>

                <!-- Is the question open? -->
                <div class="mt-4" >
                    <x-input-label for="is_open_question" :value="__('Is open question')"/>
                    <div class="flex items-center mt-2">
                        <x-text-input id="is_open_question"
                                      type="checkbox"
                                      class="inline-block"
                                      name="is_open_question"

                                      value="{{ old('is_open_question', $question->is_open_question) }}"
                                      required
                                      x-model="isOpenQuestion"
                                      x-init="isOpenQuestion = $el.value"
                        />
                        {{ $question->is_open_question ? 'open' : 'not_open' }}
                        <span class="ml-2 leading-none"
                              x-text="isOpenQuestion ? 'Question is open' : 'Question has answers'"></span>
                    </div>
                    <x-input-error :messages="$errors->get('is_open_question')" class="mt-2"/>
                </div>

                <!-- Open answer -->
                <div class="mt-4" x-show="isOpenQuestion" style="display: none">
                    <x-input-label for="open_answer" :value="__('Open answer')"/>
                    <x-text-input id="open_answer"
                                  class="block mt-1 w-full"
                                  name="question_text"
                                  :value="old('open_answer', $question->open_answer)"
                                  required
                    />
                    <x-input-error :messages="$errors->get('open_answer')" class="mt-2"/>
                </div>

                <!-- or answers separated by enter -->
                <div class="mt-4" x-show="!isOpenQuestion" style="display: none">
                    <x-input-label for="answers" :value="__('Answers')"/>
                    <x-text-input id="answers"
                                  class="block mt-1 w-full"
                                  name="answers"
                                  :value="old('answers', $question->answers->collect()->join('ahoj'))"
                                  required
                    />
                    {{ $question->answers->pluck('answer_text') }}
                    <x-input-error :messages="$errors->get('open_answer')" class="mt-2"/>
                </div>

                <div class="mt-4">
                    <x-primary-button>
                        {{ __('Save') }}
                    </x-primary-button>
                </div>
            </form>
        </x-container-section>
    </x-app-container>
</x-app-layout>


<!-- Modal to confirm deleting a course -->
    <?php
    // TODO: MAKE IT DELETE THE QUESTION, NOT ACCOUNT
    // create a new route course.delete and copy the general body of the controller method from ProfileController
    ?>
<x-modal name="confirm-course-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('questions.destroy', $question) }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Are you sure you want to delete this course?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
        </p>

        <div class="mt-6">
            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only"/>

            <x-text-input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-3/4"
                placeholder="{{ __('Password') }}"
            />

            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2"/>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>


