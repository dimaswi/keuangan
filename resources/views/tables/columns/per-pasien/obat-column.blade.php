<div>
    <div>
        <x-filament::modal width="5xl" sticky-header>
            <x-slot name="trigger">
                {{ number_format($getRecord()->tarif_obat + $getRecord()->tarif_radiologi_bhp + $getRecord()->tarif_laboratorium_bhp + $getRecord()->tarif_tindakan_bhp) }}
            </x-slot>

            <x-slot name="heading">
                Detail BHP {{ $getRecord()->pasien }}
            </x-slot>

            <x-filament::fieldset>
                <x-slot name="label">
                    Farmasi
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_obat) }}
            </x-filament::fieldset>

            <x-filament::fieldset>
                <x-slot name="label">
                    Radiologi
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_radiologi_bhp) }}
            </x-filament::fieldset>

            <x-filament::fieldset>
                <x-slot name="label">
                    Laboratorium
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_laboratorium_bhp) }}
            </x-filament::fieldset>

            <x-filament::fieldset>
                <x-slot name="label">
                    Tindakan
                </x-slot>

                {{-- Form fields --}}
                {{ number_format($getRecord()->tarif_tindakan_bhp) }}
            </x-filament::fieldset>
        </x-filament::modal>
        {{-- <table>
            <tr>
                <td>Farmasi</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_obat) }}</td>
            </tr>
            <tr>
                <td>Radiologi</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_radiologi_bhp) }}</td>
            </tr>
            <tr>
                <td>Laboratorium</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_laboratorium_bhp) }}</td>
            </tr>
            <tr>
                <td>Tindakan</td>
                <td style="padding-left: 4px"> : {{ number_format($getRecord()->tarif_tindakan_bhp) }}</td>
            </tr>
        </table> --}}
    </div>
</div>
