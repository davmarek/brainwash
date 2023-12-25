@props(['name', 'href'])
<a
    href="{{ $href }}"
    class="bg-indigo-500 text-white font-bold px-2 py-1 text-xs rounded dark:bg-indigo-400 dark:text-gray-900">
    by {{ $name }}
</a>
