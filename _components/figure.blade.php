{{-- source/_shared/_components/figure.blade.php --}}
@props(['src', 'alt' => '', 'fullWidth' => false])

@php
    $container = \Illuminate\Container\Container::getInstance();
    $jigsawPage = $container->has('pageData') ? $container->make('pageData')->page : null;

    $baseUrl = $jigsawPage->baseUrl ?? '';
@endphp

<figure class="my-10 flex flex-col items-center {{ $fullWidth ? 'w-full' : '' }}">
    <div class="{{ $fullWidth ? 'w-full max-w-7xl' : 'w-fit max-w-full' }} p-3 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-900 dark:border-gray-800">
        
        {{-- The Image Wrapper --}}
        <div class="overflow-hidden rounded-lg">
            <img src="{{ rtrim($baseUrl, '/') }}/{{ ltrim($src, '/') }}" 
                 alt="{{ $alt ?? '' }}" 
                 class="block mx-auto {{ $fullWidth ? 'w-full' : 'max-h-[500px] w-auto' }} h-auto object-contain">
        </div>

        {{-- The Caption (Now inside the box) --}}
        @if($slot->isNotEmpty())
            <figcaption class="mt-3 px-1 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                @inlineMarkdown(trim($slot))
            </figcaption>
        @endif
    </div>
</figure>