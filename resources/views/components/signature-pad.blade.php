<div x-data="signaturePad(@entangle($attributes->wire('model')))">
    <div>
        <h1 class="text-lg font-bold text-gray-900">Tanda Tangan</h1>
        <p class="mb-2 text-sm text-gray-700"> Dengan tanda tangan dibawah ini, saya menyatakan bahwa saya telah membaca
            dan
            memahami item
            yang ada di halaman ini.</p>
    </div>
    <div>
        <canvas x-ref="signature_canvas" class="border rounded-lg shadow">
        </canvas>
    </div>

    <div class="flex justify-end mt-2">

        <x-red-button @click="signaturePadInstance.clear()">
            {{ __('Clear Signature') }}
        </x-red-button>
    </div>

    {{-- @push('scripts')
        <script src="assets/js/signature_pad.umd.min.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('signaturePad', (value) => ({
                    signaturePadInstance: null,
                    value: value,
                    init() {

                        this.signaturePadInstance = new SignaturePad(this.$refs.signature_canvas, {
                                minWidth: 2,
                                maxWidth: 2,
                                penColor: "rgb(11, 73, 182)"
                            }

                        );
                        this.signaturePadInstance.addEventListener("endStroke", () => {
                            // this.value = this.signaturePadInstance.toDataURL('image/png');signaturePad.toSVG()
                            // https://github.com/aturapi-data-tech/signature_pad
                            // https://gist.github.com/jonneroelofs/a4a372fe4b55c5f9c0679d432f2c0231
                            this.value = this.signaturePadInstance.toSVG();

                            // console.log(this.signaturePadInstance)
                        });
                    },
                }))
            })
        </script>
    @endpush --}}


</div>
