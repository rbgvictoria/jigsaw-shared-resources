<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>{{ $page->siteName }} | {{ $page->title }}</title>
      <meta name="description" content="{{ $page->description ?? '' }}" />
      
      <link rel="preconnect" href="https://fonts.bunny.net" />
      <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
      <link rel="icon" href="/favicon.ico" sizes="any">
      
      @viteRefresh()
      {{-- This helper looks for the manifest at the project root --}}
      <link rel="stylesheet" href="{{ $page->baseUrl }}{{ vite('source/assets/css/main.css') }}">
      <script src="https://cdn.jsdelivr.net/npm/svg-pan-zoom@3.6.1/dist/svg-pan-zoom.min.js"></script>
  </head>
  
  <body class="fade-in min-h-screen bg-gradient-to-br from-[var(--page-bg-from)] via-white to-[var(--page-bg-to)] dark:from-gray-900 dark:via-gray-800 dark:to-gray-950 font-sans">
      @includeFirst(['_partials.header', '_shared._partials.header'])
      
      <div class="container mx-auto grid grid-cols-1 gap-4 lg:gap-8 lg:grid-cols-4 py-6 px-4 h-full">
          @include('_shared._partials.sidebar')
          
          <main class="lg:col-span-3 prose prose-sm max-w-none dark:prose-invert">
              <div class="bg-white border border-gray-200 rounded-xl mt-2 p-6 pt-6 dark:bg-black dark:border-gray-700">
                  
                  <div class="mb-8">
                      @include('_shared._partials.breadcrumbs')

                      <h1 class="text-3xl sm:text-4xl font-semibold text-gray-900 dark:text-white tracking-tight">
                          {{ $page->title }}
                      </h1>
                      
                      @if($page->description)
                          <p class="mt-2 text-lg text-gray-500 dark:text-gray-400">
                              {{ $page->description }}
                          </p>
                      @endif
                  </div>

                  @if($page->getFilename() !== 'introduction')
                      @include('_shared._partials.toc', ['maxLevel' => $page->tocLevel ?? 3])
                  @endif

                  <div class="prose dark:prose-invert max-w-none">
                      @yield('content')
                  </div>
              </div>
          </main>
      </div>

      @include('_shared._partials.mobile-menu')

      <script type="module" src="{{ $page->baseUrl }}{{ vite('source/assets/js/main.js') }}"></script>
      
      {{-- Shared JS (Menu logic, etc.) --}}
      <script>
          document.addEventListener('DOMContentLoaded', function () {
              const toggleButton = document.getElementById('mobile-menu-toggle');
              const mobileMenu = document.getElementById('mobile-menu-dropdown');
              const menuIcon = document.getElementById('menu-icon');
              const closeIcon = document.getElementById('close-icon');

              if (toggleButton && mobileMenu && menuIcon && closeIcon) {
                  const toggleMenu = (hide) => {
                      mobileMenu.classList.toggle('hidden', hide);
                      mobileMenu.classList.toggle('flex', !hide);
                      menuIcon.classList.toggle('hidden', !hide);
                      closeIcon.classList.toggle('hidden', hide);
                  };

                  toggleButton.addEventListener('click', () => toggleMenu(!mobileMenu.classList.contains('hidden')));
                  mobileMenu.querySelectorAll('a').forEach(link => link.addEventListener('click', () => toggleMenu(true)));
              }

              // Active Link Highlighting & Auto-scroll
              const activeLink = document.querySelector('aside .bg-emerald-50, aside .bg-emerald-900\\/30, aside .text-emerald-600');
              if (activeLink) {
                  setTimeout(() => activeLink.scrollIntoView({ behavior: 'smooth', block: 'nearest' }), 100);
              }

              const sidebarToggle = document.getElementById('sidebar-toggle');
              const sidebarMenu = document.getElementById('sidebar-menu');
              const sidebarArrow = document.getElementById('sidebar-arrow');

              if (sidebarToggle && sidebarMenu) {
                  sidebarToggle.addEventListener('click', () => {
                      const isHidden = sidebarMenu.classList.toggle('hidden');
                      if (sidebarArrow) sidebarArrow.style.transform = isHidden ? 'rotate(0deg)' : 'rotate(180deg)';
                  });
              }
          });
      </script>
      @stack('scripts')
  </body>
</html>