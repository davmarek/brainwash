@props(['name', 'href', 'description', 'creator'])

<x-container-section>
    <div class="space-y-1">
        <a href="{{ $href }}" class="hover:underline">
            <h2 class="text-xl font-bold">{{ $name }}</h2>
        </a>
        <p>{{ $description }}</p>
        <div>
            <x-course.creator-chip
                :name="$creator->name"
                :href="route('profile.show', $creator)"
            />
        </div>
    </div>
</x-container-section>
