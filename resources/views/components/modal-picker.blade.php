@props([
    'id', 
    'name', 
    'label', 
    'url', 
    'placeholder' => 'Select Item', 
    'required' => false
])

<div class="mb-4" id="picker-container-{{ $id }}" data-modal-picker data-id="{{ $id }}" data-name="{{ $name }}" data-url="{{ $url }}">
    <label class="text-dark dark:text-darklink font-semibold mb-2 block">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    <div class="flex gap-2">
        <input type="hidden" name="{{ $name }}" id="hidden-{{ $id }}" {{ $required ? 'required' : '' }}>
        <input type="text" id="display-{{ $id }}" class="form-control py-2 w-full bg-gray-100 dark:bg-gray-700 cursor-not-allowed" placeholder="{{ $placeholder }}" readonly>
        
        <button type="button" class="btn btn-primary bg-primary text-white py-2 px-4 rounded-md" data-hs-overlay="#modal-picker-{{ $id }}" data-hs-overlay-options='{"isClosePrev": false, "backdropClasses": "hs-overlay-backdrop transition duration fixed inset-0 bg-gray-900/50 dark:bg-neutral-900/80 !z-[70]"}'>
            <iconify-icon icon="solar:rounded-magnifer-linear" class="text-lg"></iconify-icon>
        </button>
        <button type="button" class="btn bg-red-100 text-red-600 hover:bg-red-200 py-2 px-4 rounded-md hidden" id="clear-{{ $id }}">
            <iconify-icon icon="solar:trash-bin-trash-linear" class="text-lg"></iconify-icon>
        </button>
    </div>
    <div id="{{ $name }}-error" class="text-red-500 text-sm mt-1 hidden"></div>

    <!-- The Modal -->
    <x-modal id="modal-picker-{{ $id }}" title="Select {{ $label }}" size="lg" zIndex="z-[80]">
        <div class="mb-4">
            <input type="text" id="search-{{ $id }}" class="form-control py-2 w-full" placeholder="Search...">
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Code / Ref</th>
                        <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Name / Title</th>
                        <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody id="tbody-{{ $id }}" class="divide-y divide-gray-200 dark:divide-gray-700">
                    <!-- Data rendered via JS -->
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Placeholder -->
        <div id="pagination-{{ $id }}" class="mt-4 flex justify-between items-center">
        </div>
    </x-modal>
</div>
