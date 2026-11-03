@props([
    'name', 
    'label', 
    'id' => null,
    'options' => [], 
    'selected' => '', 
    'required' => false,
    'placeholder' => 'Select an option'
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
    <select 
        id="{{ $inputId }}" 
        name="{{ $name }}" 
        {{ $required ? 'required' : '' }} 
        {{ $attributes->merge(['class' => 'form-control py-2 w-full']) }}
    >
        <option value="" disabled {{ empty($selected) ? 'selected' : '' }}>{{ $placeholder }}</option>
        @foreach($options as $value => $text)
            <option value="{{ $value }}" {{ old($name, $selected) == $value ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
    <div id="{{ $name }}-error" class="text-red-500 text-sm mt-1 hidden"></div>
</div>

