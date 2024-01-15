<x-app-layout>
    <x-slot name="header">
        <x-header-heading>
            {{ __("Create a course") }}
        </x-header-heading>
    </x-slot>

    <x-app-container>
        <x-container-section>
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Name')"/>
                    <x-text-input id="name"
                                  class="block mt-1 w-full"
                                  name="name"
                                  :value="old('name')"
                                  required autofocus
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="description" :value="__('Description')"/>

                    <x-text-input id="description"
                                  class="block mt-1 w-full"
                                  name="description"
                                  :value="old('description')"
                    />

                    <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                </div>

                <div class="mt-4">
                    <x-primary-button>
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </x-container-section>
    </x-app-container>
</x-app-layout>

