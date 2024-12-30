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

            <x-filament::modal>
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Tambahakan COA
                </x-slot>

                <x-slot name="description">

                    {{-- Rp. {{ number_format($getRecord()->karcis_umum) }}.00 --}}
                    <livewire:coa.create-coa />
                </x-slot>

                {{-- Modal content --}}
            </x-filament::modal>
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_pelayanan_umum) }}.00
            <x-filament::modal>
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Modal heading
                </x-slot>

                <x-slot name="description">
                    Rp. {{ number_format($getRecord()->jasa_pelayanan_umum) }}.00
                </x-slot>

                {{-- Modal content --}}
            </x-filament::modal>
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_periksa_umum) }}.00
            <x-filament::modal>
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Modal heading
                </x-slot>

                <x-slot name="description">
                    Rp. {{ number_format($getRecord()->jasa_periksa_umum) }}.00
                </x-slot>

                {{-- Modal content --}}
            </x-filament::modal>
        </div>
    </div>

    <div style="font-size: 14px">
        <div style="margin-left: 20px;">
            {{-- Rp. {{ number_format($getRecord()->karcis) }}.00 --}}&nbsp;
        </div>
        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->karcis_bpjs) }}.00
            <x-filament::modal>
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Modal heading
                </x-slot>

                <x-slot name="description">
                    Rp. {{ number_format($getRecord()->karcis_bpjs) }}.00
                </x-slot>

                {{-- Modal content --}}
            </x-filament::modal>
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_pelayanan_bpjs) }}.00
            <x-filament::modal>
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Modal heading
                </x-slot>

                <x-slot name="description">
                    Rp. {{ number_format($getRecord()->jasa_pelayanan_bpjs) }}.00
                </x-slot>

                {{-- Modal content --}}
            </x-filament::modal>
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_periksa_bpjs) }}.00
            <x-filament::modal>
                <x-slot name="trigger">
                    <p style="color: blue">
                        Tambahkan Coa
                    </p>
                </x-slot>

                <x-slot name="heading">
                    Modal heading
                </x-slot>

                <x-slot name="description">
                    Rp. {{ number_format($getRecord()->jasa_periksa_bpjs) }}.00
                </x-slot>

                {{-- Modal content --}}
            </x-filament::modal>
        </div>
    </div>
</div>
