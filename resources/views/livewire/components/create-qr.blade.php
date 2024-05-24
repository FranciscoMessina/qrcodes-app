<?php


use Illuminate\Support\Str;

\Livewire\Volt\rules([
    'name' => 'required|string',
    'type' => 'required|string',
    'data' => 'required|string',
]);

\Livewire\Volt\state([
    'name' => '',
    'type' => 'link',
    'data' => '',
]);

$add = function () {
    $validated = $this->validate();

    $validated['url_id'] = Str::random(10);

    auth()->user()->qr_codes()->create($validated);


//    $this->redirect('/dashboard');
};
?>


<form wire:submit="add" class="flex items-center gap-2">

    <div class="flex flex-col">

        <x-text-input type="text" name="name" wire:model="name"/>
        @error('name')
        <span class="text-red-600">{{ $message }}</span>
        @enderror
    </div>
    <div class="flex flex-col">
        <select name="type" class="rounded" wire:model="type">
            <option value="link">Link</option>
            <option value="v_card">vCard</option>
            <option value="whatsapp">WhatsApp</option>
        </select>

        @error('type')
        <span class="text-red-600">{{ $message }}</span>
        @enderror
    </div>

    <div class="flex flex-col">
        <x-text-input type="text" name="data" wire:model="data"/>

        @error('data')
        <span class="text-red-600">{{ $message }}</span>
        @enderror

    </div>

    <x-primary-button type="submit">Create QR</x-primary-button>
</form>
