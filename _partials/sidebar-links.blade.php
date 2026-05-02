@foreach($page->navigation as $label => $item)

    @php
        $isCollection = isset($item['collection']);
        $sectionActive = false;
        $currentPath = trim($page->getPath(), '/');

        if ($isCollection) {
            // 1. Fetch the items for this collection
            $rawItems = ${$item['collection']} ?? collect();

            
            // 2. RELATIONSHIP CHECK: Is the current page actually in this list?
            // We check if any item in this collection has a path that matches our current path.
            $sectionActive = $rawItems->contains(function ($item) use ($currentPath) {
                return trim($item->getPath(), '/') === $currentPath;
            });

            $intro = $rawItems->first(fn($i) => $i->getFilename() === 'introduction');

            // 3. Sorting logic
            $sortedItems = $rawItems->filter(fn($i) => $i->getFilename() !== 'introduction')->sort(function ($a, $b) {
                if ($a->order !== null && $b->order !== null) return $a->order <=> $b->order;
                if ($a->order !== null) return -1;
                if ($b->order !== null) return 1;
                return strcasecmp($a->title, $b->title);
            });
        } else {
            // Simple path check for standalone links (Introduction)
            $sectionActive = ($currentPath === trim($item['url'] ?? '', '/'));
        }
    @endphp

    <h3 class="text-sm font-bold uppercase tracking-wider mb-2 transition-colors duration-200 
        {{ $sectionActive 
            ? 'text-primary-600 dark:text-primary-400' 
            : ($isCollection  ? 'text-gray-600 dark:text-gray-400' : 'text-gray-900 dark:text-white') 
        }}">
        @if(!$isCollection)
            <a href="{{ $item['url'] }}" class="hover:text-primary-500">
                <span>{{ $label }}</span>
            </a>
        @else
            {{ $label }}
        @endif
    </h3>
    @if($isCollection && isset($sortedItems) && $sortedItems->count() > 0)
        <ul class="mb-6 space-y-1 border-l border-gray-100 dark:border-gray-800 ml-1">
            @foreach($sortedItems as $subItem)
                @php $linkActive = (trim($page->getPath(), '/') === trim($subItem->getPath(), '/')); @endphp
                <li>
                    <a href="{{ $subItem->getUrl() }}" 
                        class="block py-1 pl-4 text-sm transition-colors duration-100
                        {{ $linkActive 
                            ? 'text-primary-600 font-bold dark:text-primary-400' 
                            : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' 
                        }}">
                        {{ $subItem->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endforeach