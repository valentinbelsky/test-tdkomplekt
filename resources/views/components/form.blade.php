<form wire:submit.prevent="saveForm" onkeydown="return event.key !== 'Enter';" class="w-full">
    {{$slot}}
</form>

