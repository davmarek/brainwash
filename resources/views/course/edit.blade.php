<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center">

            <x-header-heading :sup="__('Edit course')">
                {{ $course->name }}
            </x-header-heading>

            <div class="flex gap-2">

                <a href="{{ route('courses.show', $course) }}">
                    <x-primary-button type="button">
                        {{ __('Edit questions') }}
                    </x-primary-button>
                </a>

                @can('delete', $course)
                    <x-danger-button
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-course-deletion')"
                    >{{ __('Delete Course') }}</x-danger-button>
                @endcan

                <a href="{{ route('courses.show', $course) }}">
                    <x-secondary-button type="button">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                </a>
            </div>

        </div>
    </x-slot>

    <x-app-container>
        <x-container-section>
            <form action="{{ route('courses.update', $course) }}" method="POST">
                @csrf
                @method('PATCH')

                <div>
                    <x-input-label for="name" :value="__('Name')"/>
                    <x-text-input id="name"
                                  class="block mt-1 w-full"
                                  name="name"
                                  :value="old('name', $course->name)"
                                  required
                                  x-model="courseName"

                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                <div class="mt-4">
                    <x-input-label for="description" :value="__('Description')"/>

                    <x-text-input id="description" class="block mt-1 w-full"
                                  name="description"
                                  :value="old('description', $course->description)"
                    />

                    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                </div>

                <div class="mt-4">
                    <x-primary-button>
                        {{ __('Update') }}
                    </x-primary-button>
                </div>
            </form>
        </x-container-section>
    </x-app-container>
</x-app-layout>


<!-- Modal to confirm deleting a course -->
    <?php
    // TODO: MAKE IT DELETE THE COURSE, NOT ACCOUNT
    // create a new route course.delete and copy the general body of the controller method from ProfileController
    ?>
<x-modal name="confirm-course-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('courses.destroy', $course) }}" class="p-6">
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


