<div>
    <div>
        <x-filament::modal width="5xl" sticky-header>
            <x-slot name="trigger">
                {{ number_format($getRecord()->tarif_administrasi) }}
            </x-slot>

            <x-slot name="heading">
                Detail Administrasi {{ $getRecord()->pasien }}
            </x-slot>

            <x-filament::fieldset>
                <x-slot name="label">
                    Administrasi
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_administrasi) }}
            </x-filament::fieldset>
        </x-filament::modal>

    </div>
</div>
