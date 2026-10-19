@props(['id', 'title', 'size' => 'md', 'zIndex' => 'z-[60]'])

@php
$sizeClass = match($size) {
    'sm' => 'sm:max-w-sm',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '4xl' => 'sm:max-w-4xl',
    'full' => 'sm:max-w-full sm:h-full',
    default => 'sm:max-w-md',
};
@endphp

<div id="{{ $id }}" class="hs-overlay hidden w-full h-full fixed top-0 start-0 {{ $zIndex }} overflow-x-hidden overflow-y-auto pointer-events-none" data-hs-overlay-options='{"backdropClasses": "hs-overlay-backdrop transition duration fixed inset-0 bg-gray-900/50 dark:bg-neutral-900/80 !z-[40]"}'>
    <div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-0 opacity-0 ease-out transition-all {{ $sizeClass }} w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center">
        <div class="w-full flex flex-col bg-white border shadow-sm rounded-xl pointer-events-auto dark:bg-gray-800 dark:border-gray-700 dark:shadow-slate-700/[.7]">
            <!-- Header -->
            <div class="flex justify-between items-center py-3 px-4 border-b dark:border-gray-700">
                <h3 class="font-bold text-gray-800 dark:text-white">
                    {{ $title }}
                </h3>
                <button type="button" class="flex justify-center items-center w-7 h-7 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#{{ $id }}">
                    <span class="sr-only">Close</span>
                    <iconify-icon icon="solar:close-circle-linear" class="text-xl"></iconify-icon>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-4 overflow-y-auto">
                {{ $slot }}
            </div>

            <!-- Footer -->
            @if(isset($footer))
                <div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t dark:border-gray-700">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
