<div class="grid grid-cols-1">
    <x-yellow-button wire:click.prevent="cetak()" type="button" wire:loading.remove>
        Cetak E-resep
    </x-yellow-button>
    <div wire:loading wire:target="cetak">
        <x-loading />
    </div>
</div>
