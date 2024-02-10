@props(['disabled' => false, 'name', 'wireName', 'type'])

@php
    $errorClass = $errors->has($wireName) ? 'border-red-500' : '';
@endphp
<div class="mt-2">
<input {{ $disabled ? 'disabled' : '' }}
       wire:model.lazy="{{ $wireName }}"
       type="{{$type ?? 'text'}}"
       name="{{ $name }}"
       id="{{ $name }}"
    {{ $attributes->merge(['class' => 'block w-full rounded-md border-2 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 ' . $errorClass]) }}>
</div>
@error($wireName)
<p class="text-red-500">{{ $message }}</p>
@enderror
