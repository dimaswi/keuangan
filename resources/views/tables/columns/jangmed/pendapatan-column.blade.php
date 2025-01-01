@if ($getRecord()->ruangan != '')
    <div style="font-size: 16px; padding-top: 5px; padding-bottom: 5px;">
        <div style="font-size: 16px; font-weight: bold">
            {{-- Rp. {{ number_format($getRecord()->pendapatan) }} --}}&nbsp;
        </div>

        <div style="font-size: 14px">
            <div style="margin-left: 20px;">
                @if ($getRecord()->ruangan == 'Laboratorium')
                    Rp. {{ number_format($getRecord()->karcis) }}.00

                    <x-filament::modal width="5xl" id="coa">
                        <x-slot name="trigger">
                            <p style="color: blue">
                                Tambahkan Coa
                            </p>
                        </x-slot>

                        <x-slot name="heading">
                            Pendapatan Karcis Laboratorium
                        </x-slot>

                        <livewire:coa.create-coa :kredit="$getRecord()->karcis" />
                    </x-filament::modal>
                @elseif ($getRecord()->ruangan == 'Radiologi')
                @else
                    Rp. 0.00

                    <x-filament::modal width="5xl" id="coa">
                        <x-slot name="trigger">
                            <p style="color: blue">
                                Tambahkan Coa
                            </p>
                        </x-slot>

                        <x-slot name="heading">
                            Pendapatan Karcis Laboratorium
                        </x-slot>

                        <livewire:coa.create-coa :kredit="0" />
                    </x-filament::modal>
                @endif


            </div>
            <div style="margin-left: 20px;">
                Rp. {{ number_format($getRecord()->umum) }}.00

                <x-filament::modal width="5xl" id="coa">
                    <x-slot name="trigger">
                        <p style="color: blue">
                            Tambahkan Coa
                        </p>
                    </x-slot>

                    <x-slot name="heading">
                        Pendapatan Umum
                    </x-slot>

                    <livewire:coa.create-coa :kredit="$getRecord()->umum" />
                </x-filament::modal>
            </div>
            <div style="margin-left: 20px;">
                Rp. {{ number_format($getRecord()->bpjs) }}.00

                <x-filament::modal width="5xl" id="coa">
                    <x-slot name="trigger">
                        <p style="color: blue">
                            Tambahkan Coa
                        </p>
                    </x-slot>

                    <x-slot name="heading">
                        Pendapatan BPJS
                    </x-slot>

                    <livewire:coa.create-coa :kredit="$getRecord()->bpjs" />
                </x-filament::modal>
            </div>

            <div style="margin-left: 20px;">
                Rp. {{ number_format($getRecord()->asuransi_karyawan) }}.00

                <x-filament::modal width="5xl" id="coa">
                    <x-slot name="trigger">
                        <p style="color: blue">
                            Tambahkan Coa
                        </p>
                    </x-slot>

                    <x-slot name="heading">
                        Pendapatan Asuransi Karyawan
                    </x-slot>

                    <livewire:coa.create-coa :kredit="$getRecord()->asuransi_karyawan" />
                </x-filament::modal>
            </div>

            <div style="margin-left: 20px;">
                Rp. {{ number_format($getRecord()->jasa_raharja) }}.00

                <x-filament::modal width="5xl" id="coa">
                    <x-slot name="trigger">
                        <p style="color: blue">
                            Tambahkan Coa
                        </p>
                    </x-slot>

                    <x-slot name="heading">
                        Pendapatan Jasa Raharja
                    </x-slot>

                    <livewire:coa.create-coa :kredit="$getRecord()->jasa_raharja" />
                </x-filament::modal>
            </div>
        </div>

    </div>
@else
    <div style="display: block">

    </div>
@endif
