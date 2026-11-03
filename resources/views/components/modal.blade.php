@props(['id', 'title', 'size' => 'full', 'zIndex' => 'z-[60]'])

@php
$isFull = ($size === 'full');

$sizeClass = match($size) {
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '4xl' => 'sm:max-w-4xl',
    '5xl' => 'sm:max-w-5xl',
    'full' => 'w-full h-full max-w-full',
    default => 'w-full h-full max-w-full',
};
@endphp

<div id="{{ $id }}" class="hs-overlay hidden w-full h-full fixed top-0 start-0 {{ $zIndex }} overflow-x-hidden overflow-y-auto pointer-events-none" data-hs-overlay-options='{"backdropClasses": "hs-overlay-backdrop transition duration fixed inset-0 bg-gray-900/60 backdrop-blur-xs dark:bg-neutral-900/80 !z-[40]"}'>
    <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-300 opacity-0 ease-out transition-all {{ $isFull ? 'w-full h-full max-w-full p-2 sm:p-4 flex flex-col' : $sizeClass . ' w-full m-3 sm:mx-auto min-h-[calc(100%-3.5rem)] flex items-center hs-overlay-open:mt-7 mt-0' }}">
        <div class="w-full flex flex-col bg-white border border-gray-200 dark:border-gray-700 shadow-2xl rounded-2xl pointer-events-auto dark:bg-gray-800 {{ $isFull ? 'h-full overflow-hidden' : '' }}">
            <!-- Header -->
            <div class="flex justify-between items-center py-4 px-6 border-b dark:border-gray-700 shrink-0">
                <h3 class="font-bold text-lg text-gray-800 dark:text-white">
                    {{ $title }}
                </h3>
                <button type="button" class="flex justify-center items-center w-8 h-8 text-sm font-semibold rounded-full border border-transparent text-gray-800 hover:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-gray-700 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 transition-colors" data-hs-overlay="#{{ $id }}">
                    <span class="sr-only">Close</span>
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            
            <!-- Body -->
            <div class="{{ $isFull ? 'p-6 md:p-8 overflow-y-auto flex-1' : 'p-4 overflow-y-auto' }}">
                {{ $slot }}
            </div>

            <!-- Footer -->
            @if(isset($footer))
                <div class="flex justify-end items-center gap-x-3 py-3.5 px-6 border-t dark:border-gray-700 shrink-0 bg-gray-50/50 dark:bg-gray-800/50">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </div>
</div>
