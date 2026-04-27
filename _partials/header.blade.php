<header class="sticky top-0 z-50 border-b border-green-100 bg-white/80 backdrop-blur-md dark:border-gray-700 dark:bg-gray-900/80">
    <div class="container mx-auto px-4 py-4">
        @include('_shared._partials.top-nav')
        {{-- Mobile Menu Dropdown --}}
        <div id="mobile-menu-dropdown" class="mt-4 hidden flex-col space-y-4 pb-6 md:hidden">
            <a href="/projects" class="text-lg font-medium text-gray-600 dark:text-gray-300">Projects</a>
            <a href="/about" class="text-lg font-medium text-gray-600 dark:text-gray-300">About</a>
            <a href="/docs/api" class="text-lg font-medium text-gray-600 dark:text-gray-300">API</a>
            
            {{-- Divider and Mobile User Context --}}
            <div class="mt-2 border-t border-gray-100 pt-4 dark:border-gray-800">
                @include('_shared._partials.user-menu')
            </div>
        </div>
    </div>
</header>
