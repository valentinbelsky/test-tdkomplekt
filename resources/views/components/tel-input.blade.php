@props(['disabled' => false, 'name', 'wireName'])

@php
    $errorClass = $errors->has($wireName) ? 'border-red-500' : ''
@endphp
<div class="relative mt-2">
    <div class="absolute inset-y-0 left-0 flex items-center">
        <label for="country" class="sr-only">Phone</label>
        <select wire:model.lazy="country" id="country" name="country"
                class="h-full rounded-md border-0 bg-transparent bg-none py-0 pl-2 pr-3 text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
            <option selected>+375</option>
            <option>+7</option>
        </select>
    </div>

    <input {{ $disabled ? 'disabled' : '' }}
           wire:model.lazy="{{ $wireName }}"
           type="tel"
           name="{{ $name }}"
           id="{{ $name }}"
        {{ $attributes->merge(['class' => 'block w-full rounded-md border-0 px-3.5 py-1.5 pl-20 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 ' . $errorClass]) }}>
</div>
@error($wireName)
<p class="text-red-500">{{ $message }}</p>
@enderror
