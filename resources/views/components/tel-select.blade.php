@props(['name', 'wireName'])

<label for="country" class="sr-only"></label>
<select wire:model.lazy="{{ $wireName }}" id="{{ $name }}" name="{{ $name }}"
        class="h-full rounded-md border-0 bg-transparent bg-none py-0 pl-2 pr-3 text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
    {{$value ?? $slot}}
</select>
