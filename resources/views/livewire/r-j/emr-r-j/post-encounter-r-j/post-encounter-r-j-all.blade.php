<div>
    <x-light-button wire:click.prevent="PostEncounterSatuSehatAll()" type="button" wire:loading.remove>
        Kirim Satu Sehat All
    </x-light-button>
    <div wire:loading wire:target="PostEncounterSatuSehatAll">
        <x-loading />
    </div>

</div>
