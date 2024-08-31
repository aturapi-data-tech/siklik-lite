<div>
    <x-yellow-button wire:click.prevent="cetak()" type="button" wire:loading.remove>
        Etiket
    </x-yellow-button>
    <div wire:loading wire:target="cetak">
        <x-loading />
    </div>
</div>
