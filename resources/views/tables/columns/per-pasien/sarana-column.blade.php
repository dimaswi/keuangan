<div>
    <div>
        <x-filament::modal width="5xl" sticky-header>
            <x-slot name="trigger">
                {{ number_format($getRecord()->tarif_ruang_rawat + $getRecord()->tarif_radiologi_sarana + $getRecord()->tarif_laboratorium_sarana + $getRecord()->tarif_tindakan_sarana) }}
            </x-slot>

            <x-slot name="heading">
                Detail Sarana {{$getRecord()->pasien}}
            </x-slot>

            <x-filament::fieldset>
                <x-slot name="label">
                    Ruang Rawat
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_ruang_rawat) }}
            </x-filament::fieldset>

            <x-filament::fieldset>
                <x-slot name="label">
                    Radiologi
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_radiologi_sarana) }}
            </x-filament::fieldset>

            <x-filament::fieldset>
                <x-slot name="label">
                    Laboratorium
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_laboratorium_sarana) }}
            </x-filament::fieldset>

            <x-filament::fieldset>
                <x-slot name="label">
                    Tindakan
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_tindakan_sarana) }}
            </x-filament::fieldset>
        </x-filament::modal>
        {{-- <table>
            <tr>
                <td>Ruang Rawat</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_ruang_rawat) }}</td>
            </tr>
            <tr>
                <td>Radiologi</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_radiologi_sarana) }}</td>
            </tr>
            <tr>
                <td>Laboratorium</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_laboratorium_sarana) }}</td>
            </tr>
            <tr>
                <td>Tindakan</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_tindakan_sarana) }}</td>
            </tr>
        </table> --}}
    </div>
</div>
