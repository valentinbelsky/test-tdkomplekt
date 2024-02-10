<form wire:submit.prevent="saveForm" onkeydown="return event.key !== 'Enter';"  method="post" enctype="multipart/form-data" class="w-full">
    @csrf
    {{$slot}}
</form>

