<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.keluhanPasien" :value="__('Keluhan Pasien')" :required="__(false)" />


    <x-text-input-area id="dataDaftarPoliRJ.pemeriksaan.emg.keluhanPasien" placeholder="Keluhan Pasien" class="mt-1 ml-2"
        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.keluhanPasien'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.keluhanPasien" :rows="__('6')" />
</div>

<div>
    <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.pengobatan" :value="__('Pengobatan')" :required="__(false)" />


    <x-text-input-area id="dataDaftarPoliRJ.pemeriksaan.emg.pengobatan" placeholder="Pengobatan" class="mt-1 ml-2"
        :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.pengobatan'))" :disabled=$disabledPropertyRjStatus
        wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.pengobatan" :rows="__('6')" />
</div>

<div>
    <div class="grid grid-cols-4 gap-2 mt-2">
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.td" :value="__('TD')" :required="__(false)" />
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.rr" :value="__('RR')" :required="__(false)" />
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.hr" :value="__('HR')" :required="__(false)" />
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.s" :value="__('S')" :required="__(false)" />
    </div>

    <div class="grid grid-cols-4 gap-2">
        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.td" placeholder="TD" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.td'))"
            :disabled=$disabledPropertyRjStatus wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.td" />

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.rr" placeholder="RR" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.rr'))"
            :disabled=$disabledPropertyRjStatus wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.rr" />

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.hr" placeholder="HR" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.hr'))"
            :disabled=$disabledPropertyRjStatus wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.hr" />

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.s" placeholder="S" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.s'))"
            :disabled=$disabledPropertyRjStatus wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.s" />
    </div>
</div>

<div>
    <div class="grid grid-cols-4 gap-2 mt-2">
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.gcs" :value="__('GCS')" :required="__(false)" />
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.fkl" :value="__('FKL')" :required="__(false)" />
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.nprs" :value="__('NPRS')" :required="__(false)" />
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.rclRctl" :value="__('RCL/RCTL')" :required="__(false)" />
    </div>

    <div class="grid grid-cols-4 gap-2">
        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.gcs" placeholder="GCS" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.gcs'))"
            :disabled=$disabledPropertyRjStatus wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.gcs" />

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.fkl" placeholder="FKL" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.fkl'))"
            :disabled=$disabledPropertyRjStatus wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.fkl" />

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.nprs" placeholder="NPRS" class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.nprs'))"
            :disabled=$disabledPropertyRjStatus wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.nprs" />

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.rclRctl" placeholder="RCL/RCTL" class="mt-1 ml-2"
            :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.rclRctl'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.rclRctl" />
    </div>
</div>

<div>
    <div class="grid grid-cols-3 gap-2 mt-2">
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.nnCr" :value="__('nn Cranialis')" :required="__(false)" />
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.nnCrLain" :value="__('nn Cranialis Lain')" :required="__(false)" />
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.motorik" :value="__('Motorik')" :required="__(false)" />
    </div>

    <div class="grid grid-cols-3 gap-2">
        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.nnCr" placeholder="nn Cranialis" class="mt-1 ml-2"
            :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.nnCr'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.nnCr" />

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.nnCrLain" placeholder="nn Cranialis Lain" class="mt-1 ml-2"
            :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.nnCrLain'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.nnCrLain" />

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.motorik" placeholder="Motorik" class="mt-1 ml-2"
            :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.motorik'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.motorik" />
    </div>
</div>

<div>
    <div class="grid grid-cols-2 gap-2 mt-2">
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.pergerakan" :value="__('Pergerakan')" :required="__(false)" />
        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.kekuatan" :value="__('Kekuatan')" :required="__(false)" />

    </div>

    <div class="grid grid-cols-2 gap-2">
        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.pergerakan" placeholder="Pergerakan" class="mt-1 ml-2"
            :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.pergerakan'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.pergerakan" />

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.kekuatan" placeholder="Kekuatan" class="mt-1 ml-2"
            :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.kekuatan'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.kekuatan" />

    </div>
</div>

<div>
    <div class="grid grid-cols-1 gap-2 mt-2">

        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.extremitasSuperior" :value="__('Extremitas Superior')"
            :required="__(false)" />

    </div>

    <div class="grid grid-cols-1 gap-2">

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.extremitasSuperior" placeholder="Extremitas Superior"
            class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.extremitasSuperior'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.extremitasSuperior" />

    </div>
</div>

<div>
    <div class="grid grid-cols-1 gap-2 mt-2">

        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.extremitasInferior" :value="__('Extremitas Inferior')"
            :required="__(false)" />

    </div>

    <div class="grid grid-cols-1 gap-2">

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.extremitasInferior" placeholder="Extremitas Inferior"
            class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.extremitasInferior'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.extremitasInferior" />

    </div>
</div>

<div>
    <div class="grid grid-cols-1 gap-2 mt-2">

        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.tonus" :value="__('Tonus')" :required="__(false)" />

    </div>

    <div class="grid grid-cols-1 gap-2">

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.tonus" placeholder="Tonus" class="mt-1 ml-2"
            :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.tonus'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.tonus" />

    </div>
</div>

<div>
    <div class="grid grid-cols-1 gap-2 mt-2">

        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.refleksFisiologi" :value="__('Refleks Fisiologi')" :required="__(false)" />

    </div>

    <div class="grid grid-cols-1 gap-2">

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.refleksFisiologi" placeholder="Refleks Fisiologi"
            class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.refleksFisiologi'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.refleksFisiologi" />

    </div>
</div>

<div>
    <div class="grid grid-cols-1 gap-2 mt-2">

        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.refleksPatologis" :value="__('Refleks Patologis')" :required="__(false)" />

    </div>

    <div class="grid grid-cols-1 gap-2">

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.refleksPatologis" placeholder="Refleks Patologis"
            class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.refleksPatologis'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.refleksPatologis" />

    </div>
</div>

<div>
    <div class="grid grid-cols-1 gap-2 mt-2">

        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.sensorik" :value="__('Sensorik')" :required="__(false)" />

    </div>

    <div class="grid grid-cols-1 gap-2">

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.sensorik" placeholder="Sensorik" class="mt-1 ml-2"
            :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.sensorik'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.sensorik" />

    </div>
</div>

<div>
    <div class="grid grid-cols-1 gap-2 mt-2">

        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.otonom" :value="__('Otonom')" :required="__(false)" />

    </div>

    <div class="grid grid-cols-1 gap-2">

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.otonom" placeholder="Otonom" class="mt-1 ml-2"
            :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.otonom'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.otonom" />

    </div>
</div>

<div>
    <div class="grid grid-cols-1 gap-2 mt-2">

        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.emcEmgFindings" :value="__('NCV & EMG Finding')" :required="__(false)" />

    </div>

    <div class="grid grid-cols-1 gap-2">

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.emcEmgFindings" placeholder="NCV & EMG Finding"
            class="mt-1 ml-2" :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.emcEmgFindings'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.emcEmgFindings" />

    </div>
</div>

<div>
    <div class="grid grid-cols-1 gap-2 mt-2">

        <x-input-label for="dataDaftarPoliRJ.pemeriksaan.emg.impresion" :value="__('Impresion')" :required="__(false)" />

    </div>

    <div class="grid grid-cols-1 gap-2">

        <x-text-input id="dataDaftarPoliRJ.pemeriksaan.emg.impresion" placeholder="Impresion" class="mt-1 ml-2"
            :errorshas="__($errors->has('dataDaftarPoliRJ.pemeriksaan.emg.impresion'))" :disabled=$disabledPropertyRjStatus
            wire:model.debounce.500ms="dataDaftarPoliRJ.pemeriksaan.emg.impresion" />

    </div>
</div>
