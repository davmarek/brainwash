@props(['name', 'href', 'description', 'creator'])

<x-container-section>
    <div class="space-y-1">
        <a href="{{ $href }}" class="hover:underline">
            <h2 class="text-xl font-bold">{{ $name }}</h2>
        </a>
        @isset($description)
            <p>{{ $description }}</p>
        @endisset
        @isset($creator)
            <div>
                <x-course.creator-chip
                    :name="$creator->name"
                    :href="route('profile.show', $creator)"
                />
            </div>
        @endisset
    </div>
</x-container-section>
