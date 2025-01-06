<div style="font-size: 16px; padding-top: 5px; padding-bottom: 5px;">
    <div style="font-size: 16px; font-weight: bold">
        {{-- Rp. {{ number_format($getRecord()->pendapatan) }} --}}&nbsp;
    </div>

    <div style="font-size: 14px">
        <div style="margin-left: 20px;">
            {{-- Rp. {{ number_format($getRecord()->karcis) }}.00 --}}&nbsp;
        </div>
        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->karcis_umum) }}.00

            <x-filament::modal width="5xl" id="coa">
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Pendapatan Karcis Umum
                </x-slot>

                <livewire:keuangan.coa.create-coa :kredit="$getRecord()->karcis_umum" />
            </x-filament::modal>
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_pelayanan_umum) }}.00
            <x-filament::modal width="5xl" id="coa">
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Pendapatan Jasa Pelayanan Umum
                </x-slot>

                <livewire:keuangan.coa.create-coa :kredit="$getRecord()->jasa_pelayanan_umum" />
            </x-filament::modal>
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_periksa_umum) }}.00
            <x-filament::modal width="5xl" id="coa">
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Pendapatan Jasa Periksa Umum
                </x-slot>

                <livewire:keuangan.coa.create-coa :kredit="$getRecord()->jasa_periksa_umum" />
            </x-filament::modal>
        </div>
    </div>

    <div style="font-size: 14px">
        <div style="margin-left: 20px;">
            {{-- Rp. {{ number_format($getRecord()->karcis) }}.00 --}}&nbsp;
        </div>
        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->karcis_bpjs) }}.00

            <x-filament::modal width="5xl" id="coa">
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Pendapatan Karcis BPJS
                </x-slot>

                <livewire:keuangan.coa.create-coa :kredit="$getRecord()->karcis_bpjs" />
            </x-filament::modal>
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_pelayanan_bpjs) }}.00

            <x-filament::modal width="5xl" id="coa">
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Pendapatan Jasa Pelayanan BPJS
                </x-slot>

                <livewire:keuangan.coa.create-coa :kredit="$getRecord()->jasa_pelayanan_bpjs" />
            </x-filament::modal>
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_periksa_bpjs) }}.00

            <x-filament::modal width="5xl" id="coa">
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Pendapatan Jasa Periksa BPJS
                </x-slot>

                <livewire:keuangan.coa.create-coa :kredit="$getRecord()->jasa_periksa_bpjs" />
            </x-filament::modal>
        </div>
    </div>
</div>
