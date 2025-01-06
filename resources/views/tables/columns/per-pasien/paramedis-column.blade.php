<div>
    <div>
        <x-filament::modal width="5xl" sticky-header>
            <x-slot name="trigger">
                {{ number_format(
                    $getRecord()->tarif_radiologi_penata_anastesi +
                        $getRecord()->tarif_radiologi_paramedis +
                        $getRecord()->tarif_radiologi_non_medis +
                        $getRecord()->tarif_laboratorium_penata_anastesi +
                        $getRecord()->tarif_laboratorium_paramedis +
                        $getRecord()->tarif_laboratorium_dokter_non_medis +
                        $getRecord()->tarif_tindakan_penata_anastesi +
                        $getRecord()->tarif_tindakan_paramedis +
                        $getRecord()->tarif_tindakan_dokter_non_medis,
                ) }}
            </x-slot>

            <x-slot name="heading">
                Detail Jasa Paramedis {{ $getRecord()->pasien }}
            </x-slot>

            <x-filament::fieldset>
                <x-slot name="label">
                    Radiologi
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_radiologi_penata_anastesi + $getRecord()->tarif_radiologi_paramedis + $getRecord()->tarif_radiologi_non_medis) }}
            </x-filament::fieldset>

            <x-filament::fieldset>
                <x-slot name="label">
                    Laboratorium
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_laboratorium_penata_anastesi + $getRecord()->tarif_laboratorium_paramedis + $getRecord()->tarif_laboratorium_dokter_non_medis) }}
            </x-filament::fieldset>

            <x-filament::fieldset>
                <x-slot name="label">
                    Tindakan
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_tindakan_penata_anastesi + $getRecord()->tarif_tindakan_paramedis + $getRecord()->tarif_tindakan_dokter_non_medis) }}
            </x-filament::fieldset>
        </x-filament::modal>
        {{-- <table>
            <tr>
                <td>&nbsp;</td>
                <td style="padding-left: 4px">&nbsp;</td>
            </tr>
            <tr>
                <td>Radiologi</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_radiologi_penata_anastesi + $getRecord()->tarif_radiologi_paramedis + $getRecord()->tarif_radiologi_non_medis) }}</td>
            </tr>
            <tr>
                <td>Laboratorium</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_laboratorium_penata_anastesi + $getRecord()->tarif_laboratorium_paramedis + $getRecord()->tarif_laboratorium_dokter_non_medis) }}</td>
            </tr>
            <tr>
                <td>Tindakan</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_tindakan_penata_anastesi + $getRecord()->tarif_tindakan_paramedis + $getRecord()->tarif_tindakan_dokter_non_medis) }}</td>
            </tr>
        </table> --}}
    </div>
</div>
