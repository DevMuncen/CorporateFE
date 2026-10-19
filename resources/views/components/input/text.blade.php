@props([
    'name', 
    'label', 
    'type' => 'text', 
    'value' => '', 
    'placeholder' => '', 
    'required' => false,
    'readonly' => false,
])

<div class="mb-4">
    <label for="{{ $name }}" class="text-dark dark:text-darklink font-semibold mb-2 block">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        placeholder="{{ $placeholder }}" 
        {{ $required ? 'required' : '' }} 
        {{ $readonly ? 'readonly' : '' }}
        {{ $attributes->merge(['class' => 'form-control py-2 w-full ' . ($readonly ? 'bg-gray-100 cursor-not-allowed dark:bg-gray-700' : '')]) }}
    />
    <div id="{{ $name }}-error" class="text-red-500 text-sm mt-1 hidden"></div>
</div>
