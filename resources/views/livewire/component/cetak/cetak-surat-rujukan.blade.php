<div>
    <x-green-button wire:click.prevent="cetak()" type="button" wire:loading.remove>
        Cetak Surat Rujukan
    </x-green-button>
    <div wire:loading wire:target="cetak">
        <x-loading />
    </div>
</div>
