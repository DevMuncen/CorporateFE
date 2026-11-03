@props([
    'name', 
    'label', 
    'id' => null,
    'value' => '', 
    'required' => false,
    'readonly' => false,
])

@php
    $inputId = $id ?? $name;
@endphp

<div class="mb-4">
    <label for="{{ $inputId }}" class="text-dark dark:text-darklink font-semibold mb-2 block">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <div class="relative">
        <input 
            type="date" 
            id="{{ $inputId }}" 
            name="{{ $name }}" 
            value="{{ old($name, $value) }}" 
            {{ $required ? 'required' : '' }} 
            {{ $readonly ? 'readonly' : '' }}
            {{ $attributes->merge(['class' => 'form-control py-2 w-full ' . ($readonly ? 'bg-gray-100 cursor-not-allowed dark:bg-gray-700' : '')]) }}
        />
        <!-- Optional Date icon overlay can go here if needed -->
    </div>
    <div id="{{ $name }}-error" class="text-red-500 text-sm mt-1 hidden"></div>
</div>

