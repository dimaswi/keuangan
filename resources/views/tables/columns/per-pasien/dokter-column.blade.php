<div>
    <div>
        <x-filament::modal width="5xl" sticky-header>
            <x-slot name="trigger">
                {{ number_format(
                    $getRecord()->tarif_radiologi_dokter_operator +
                        $getRecord()->tarif_radiologi_dokter_anastesi +
                        $getRecord()->tarif_radiologi_lainnya +
                        $getRecord()->tarif_laboratorium_dokter_operator +
                        $getRecord()->tarif_laboratorium_dokter_anastesi +
                        $getRecord()->tarif_laboratorium_dokter_lainnya +
                        $getRecord()->tarif_tindakan_dokter_operator +
                        $getRecord()->tarif_tindakan_dokter_anastesi +
                        $getRecord()->tarif_tindakan_dokter_lainnya,
                ) }}
            </x-slot>

            <x-slot name="heading">
                Detail Jasa Dokter {{ $getRecord()->pasien }}
            </x-slot>

            <x-filament::fieldset>
                <x-slot name="label">
                    Radiologi
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_radiologi_dokter_operator + $getRecord()->tarif_radiologi_dokter_anastesi + $getRecord()->tarif_radiologi_lainnya) }}
            </x-filament::fieldset>

            <x-filament::fieldset>
                <x-slot name="label">
                    Laboratorium
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_laboratorium_dokter_operator + $getRecord()->tarif_laboratorium_dokter_anastesi + $getRecord()->tarif_laboratorium_dokter_lainnya) }}
            </x-filament::fieldset>

            <x-filament::fieldset>
                <x-slot name="label">
                    Tindakan
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_tindakan_dokter_operator + $getRecord()->tarif_tindakan_dokter_anastesi + $getRecord()->tarif_tindakan_dokter_lainnya) }}
            </x-filament::fieldset>
        </x-filament::modal>
        {{-- <table>
            <tr>
                <td>&nbsp;</td>
                <td style="padding-left: 4px">&nbsp;</td>
            </tr>
            <tr>
                <td>Radiologi</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_radiologi_dokter_operator + $getRecord()->tarif_radiologi_dokter_anastesi + $getRecord()->tarif_radiologi_lainnya) }}</td>
            </tr>
            <tr>
                <td>Laboratorium</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_laboratorium_dokter_operator + $getRecord()->tarif_laboratorium_dokter_anastesi + $getRecord()->tarif_laboratorium_dokter_lainnya) }}</td>
            </tr>
            <tr>
                <td>Tindakan</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_tindakan_dokter_operator + $getRecord()->tarif_tindakan_dokter_anastesi + $getRecord()->tarif_tindakan_dokter_lainnya) }}</td>
            </tr>
        </table> --}}
    </div>
</div>
