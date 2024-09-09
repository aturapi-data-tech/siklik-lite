<div>
    <x-light-button wire:click.prevent="PostSatuDataKesehatan()" type="button" wire:loading.remove>
        Kirim DINKESTA
    </x-light-button>
    <div wire:loading wire:target="PostSatuDataKesehatan">
        <x-loading />
    </div>
    <div class="text-xs text-gray-700">
        {{ $EncounterID }}
    </div>
</div>
