{{-- source/_components/svg-viewer.blade.php --}}
@php
    $container = \Illuminate\Container\Container::getInstance();
    $jigsawPage = $container->has('pageData') ? $container->make('pageData')->page : null;

    $baseUrl = $jigsawPage->baseUrl ?? '';

    $id = $id ?? 'svg-' . uniqid();
    $height = $height ?? '500px';
    $path = $path ?? '';
    $status = $status ?? 'draft';
    
    $badgeClasses = ($status === 'final') ? 'bg-emerald-500' : 'bg-amber-500';
    $badgeText = ($status === 'final') ? 'FINAL' : 'SCAFFOLD';
@endphp

<div id="wrapper-{{ $id }}" class="flex flex-col border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden bg-white/50 dark:bg-black/20 backdrop-blur-sm fullscreen:h-screen fullscreen:bg-white dark:fullscreen:bg-gray-900">
    
    {{-- Header Bar --}}
    <div class="flex items-center justify-between px-4 py-2 bg-gray-50/80 dark:bg-gray-800/80 border-b border-gray-200 dark:border-gray-700 z-20">
        {{-- Status Badge --}}
        <span class="{{ $badgeClasses }} text-white text-[10px] font-bold px-2 py-0.5 rounded tracking-wider uppercase">
            {{ $badgeText }}
        </span>

        {{-- Control Group --}}
        <div class="flex items-center gap-2">
            <button id="zoom-in-{{ $id }}" class="hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 w-8 h-8 flex items-center justify-center rounded border border-gray-300 dark:border-gray-600 font-bold text-lg transition-colors" title="Zoom In">+</button>
            <button id="zoom-out-{{ $id }}" class="hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 w-8 h-8 flex items-center justify-center rounded border border-gray-300 dark:border-gray-600 font-bold text-lg transition-colors" title="Zoom Out">−</button>
            <button id="reset-{{ $id }}" class="hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 w-8 h-8 flex items-center justify-center rounded border border-gray-300 dark:border-gray-600 text-lg transition-colors" title="Reset View">⟲</button>
            <button id="fullscreen-{{ $id }}" class="hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 w-8 h-8 flex items-center justify-center rounded border border-gray-300 dark:border-gray-600 text-lg transition-colors" title="Toggle Full Screen">⛶</button>
        </div>
    </div>

    {{-- Viewer Area --}}
    <div class="svg-viewer-container p-4 transition-all duration-300" style="height: {{ $height }};">
        <object id="{{ $id }}" type="image/svg+xml" data="{{ $baseUrl }}{{ $path }}" class="w-full h-full block">
            Your browser does not support SVG
        </object>
    </div>

    {{-- The Caption Slot --}}
    @if($slot->isNotEmpty())
        <figcaption class="mt-3 p-4 text-sm leading-relaxed text-gray-600 dark:text-gray-400 fullscreen:hidden">
            @inlineMarkdown(trim($slot))
        </figcaption>
    @endif
</div>

@push('scripts')
<script>
    (function() {
        const init = () => {
            const id = '{{ $id }}';
            const embed = document.getElementById(id);
            if (!embed) return;

            const start = () => {
                // --- ADDED THESE LINES ---
                const wrapper = document.getElementById('wrapper-' + id);
                const container = embed.parentElement; // Finds the .svg-viewer-container
                const fsBtn = document.getElementById('fullscreen-' + id);
                const originalHeight = '{{ $height }}'; 
                // -------------------------

                const instance = svgPanZoom(embed, {
                    zoomEnabled: true,
                    controlIconsEnabled: false,
                    fit: true,
                    center: true
                });

                // Zoom & Reset Controls
                document.getElementById('zoom-in-' + id).onclick = () => instance.zoomIn();
                document.getElementById('zoom-out-' + id).onclick = () => instance.zoomOut();
                document.getElementById('reset-' + id).onclick = () => {
                    instance.resetZoom();
                    instance.center();
                    instance.fit();
                };

                // Full Screen Logic
                if (fsBtn && wrapper && container) {
                    fsBtn.onclick = (e) => {
                        e.preventDefault();
                        if (!document.fullscreenElement) {
                            wrapper.requestFullscreen().catch(err => {
                                console.error(`Fullscreen error: ${err.message}`);
                            });
                        } else {
                            document.exitFullscreen();
                        }
                    };

                    document.addEventListener('fullscreenchange', () => {
                        if (document.fullscreenElement) {
                            // GOING FULLSCREEN - Kill the inline height and grow
                            container.style.setProperty('height', 'calc(100vh - 48px)', 'important');
                            container.style.flex = '1';
                        } else {
                            // RETURNING TO PAGE - Restore original height
                            container.style.setProperty('height', originalHeight, 'important');
                            container.style.flex = 'none';
                        }

                        setTimeout(() => {
                            instance.resize();
                            instance.fit();
                            instance.center();
                        }, 200); 
                    });
                }
            };

            if (embed.contentDocument && embed.contentDocument.documentElement) {
                start();
            } else {
                embed.addEventListener('load', start);
            }
        };

        window.addEventListener('load', init);
    })();
</script>
@endpush
