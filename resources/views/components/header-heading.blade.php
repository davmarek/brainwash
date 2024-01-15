<div>
    @isset($sup)
        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $sup }}</span>
    @endisset
    <h1 {{ $attributes->twMerge('font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight') }}>
        {{ $slot }}
    </h1>
</div>
