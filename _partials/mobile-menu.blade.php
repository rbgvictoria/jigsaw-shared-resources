<div id="mobile-menu" class="hidden fixed inset-0 z-100 lg:hidden" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

    <div class="fixed inset-y-0 left-0 w-full max-w-xs bg-white dark:bg-black p-6 shadow-xl">
        <div class="flex items-center justify-between mb-8">
            <span class="text-emerald-600 font-bold dark:text-emerald-400">Botanical Keys</span>
            <button onclick="toggleMobileMenu()" class="text-gray-500">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <nav class="space-y-4">
            @include('_shared._partials.sidebar-links')
        </nav>
    </div>
</div>