@php
    $container = \Illuminate\Container\Container::getInstance();
    $jigsawPage = $container->has('pageData') ? $container->make('pageData')->page : null;

    $baseUrl = $jigsawPage->baseUrl ?? '';
@endphp

<div class="group block overflow-hidden my-8 rounded-xl border border-gray-200 bg-white shadow-sm transition-all hover:shadow-md hover:border-green-300 dark:bg-gray-900 dark:border-gray-800 dark:hover:border-green-700">
    @if(isset($image))
        <img src="{{ $baseUrl }}{{ $image }}" alt="{{ $title ?? '' }}" class="h-48 w-full object-cover transition-transform duration-500 group-hover:scale-105">
    @endif

    <div class="p-5">
        @if(isset($title))
            <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white group-hover:text-green-600">
                {{ $title }}
            </h3>
        @endif

        <div class="text-sm text-gray-600 dark:text-gray-400 leading-snug">
            @markdown(trim($slot))
        </div>
    </div>
</div>