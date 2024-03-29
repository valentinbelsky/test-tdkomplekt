@props(['disabled' => false, 'name', 'wireName'])

@php
    $errorClass = $errors->has($wireName) ? 'border-red-500' : ''
@endphp

    <input {{ $disabled ? 'disabled' : '' }}
           wire:model.lazy="{{ $wireName }}"
           type="tel"
           name="{{ $name }}"
           id="{{ $name }}"
        {{ $attributes->merge(['class' => 'block w-full rounded-md border-0 px-3.5 py-1.5 pl-20 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 ' . $errorClass]) }}>




