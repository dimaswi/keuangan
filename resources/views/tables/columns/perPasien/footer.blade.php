@props(['columns', 'records'])
@php
    $administrasi = [];
    // $list_ruangan = [];
    // $list_biaya_administrasi = [];
    // $sarana_nominal = [];
    // $bhp_nominal = [];
    // $dokter_nominal = [];
    // $perawat_nominal = [];
    $sarana = [];
    $bhp = [];
    $dokter = [];
    $perawat = [];
    $pendapatan_per_unit = [];

    foreach ($records as $key => $value) {
        array_push($administrasi, $value->tarif_administrasi);
        array_push(
            $sarana,
            $value->tarif_ruang_rawat +
                $value->tarif_radiologi_sarana +
                $value->tarif_laboratorium_sarana +
                $value->tarif_tindakan_sarana,
        );
        array_push(
            $bhp,
            $value->tarif_obat +
                $value->tarif_radiologi_bhp +
                $value->tarif_laboratorium_bhp +
                $value->tarif_tindakan_bhp,
        );
        array_push(
            $dokter,
            $value->tarif_radiologi_dokter_operator +
                $value->tarif_radiologi_dokter_anastesi +
                $value->tarif_radiologi_dokter_lainnya +
                $value->tarif_laboratorium_dokter_operator +
                $value->tarif_laboratorium_dokter_operator +
                $value->tarif_laboratorium_dokter_lainnya +
                $value->tarif_tindakan_dokter_operator +
                $value->tarif_tindakan_dokter_anastesi +
                $value->tarif_tindakan_dokter_lainnya,
        );
        array_push(
            $perawat,
            $value->tarif_radiologi_penata_anastesi +
                $value->tarif_radiologi_paramedis +
                $value->tarif_radiologi_non_medis +
                $value->tarif_laboratorium_penata_anastesi +
                $value->tarif_laboratorium_paramedis +
                $value->tarif_laboratorium_non_medis +
                $value->tarif_tindakan_penata_anastesi +
                $value->tarif_tindakan_paramedis +
                $value->tarif_tindakan_non_medis,
        );

        //PENDAPATAN PER UNIT
        if (stripos($value->ruangan, '11101') !== false) {
            // RAWAT JALAN SPESIALIS
            array_push($pendapatan_per_unit, [
                'Rawat Jalan' =>
                    $value->tarif_tindakan_sarana +
                    $value->tarif_tindakan_bhp +
                    $value->tarif_tindakan_dokter_operator +
                    $value->tarif_tindakan_dokter_anastesi +
                    $value->tarif_tindakan_dokter_lainnya +
                    $value->tarif_tindakan_penata_anastesi +
                    $value->tarif_tindakan_paramedis +
                    $value->tarif_tindakan_non_medis +
                    $value->tarif_administrasi,
                'Farmasi' => $value->tarif_obat,
                'Radiologi' =>
                    $value->tarif_radiologi_sarana +
                    $value->tarif_radiologi_bhp +
                    $value->tarif_radiologi_dokter_operator +
                    $value->tarif_radiologi_dokter_anastesi +
                    $value->tarif_radiologi_dokter_lainnya +
                    $value->tarif_radiologi_penata_anastesi +
                    $value->tarif_radiologi_paramedis +
                    $value->tarif_radiologi_non_medis,
                'Laboratorium' =>
                    $value->tarif_laboratorium_sarana +
                    $value->tarif_laboratorium_bhp +
                    $value->tarif_laboratorium_dokter_operator +
                    $value->tarif_laboratorium_dokter_operator +
                    $value->tarif_laboratorium_dokter_lainnya +
                    $value->tarif_laboratorium_penata_anastesi +
                    $value->tarif_laboratorium_paramedis +
                    $value->tarif_laboratorium_non_medis,
            ]);
        }

        if (stripos($value->ruangan, '11301') !== false) {
            // RAWAT JALAN UMUM
            array_push($pendapatan_per_unit, [
                'Rawat Jalan' =>
                    $value->tarif_tindakan_sarana +
                    $value->tarif_tindakan_bhp +
                    $value->tarif_tindakan_dokter_operator +
                    $value->tarif_tindakan_dokter_anastesi +
                    $value->tarif_tindakan_dokter_lainnya +
                    $value->tarif_tindakan_penata_anastesi +
                    $value->tarif_tindakan_paramedis +
                    $value->tarif_tindakan_non_medis +
                    $value->tarif_administrasi,
                'Farmasi' => $value->tarif_obat,
                'Radiologi' =>
                    $value->tarif_radiologi_sarana +
                    $value->tarif_radiologi_bhp +
                    $value->tarif_radiologi_dokter_operator +
                    $value->tarif_radiologi_dokter_anastesi +
                    $value->tarif_radiologi_dokter_lainnya +
                    $value->tarif_radiologi_penata_anastesi +
                    $value->tarif_radiologi_paramedis +
                    $value->tarif_radiologi_non_medis,
                'Laboratorium' =>
                    $value->tarif_laboratorium_sarana +
                    $value->tarif_laboratorium_bhp +
                    $value->tarif_laboratorium_dokter_operator +
                    $value->tarif_laboratorium_dokter_operator +
                    $value->tarif_laboratorium_dokter_lainnya +
                    $value->tarif_laboratorium_penata_anastesi +
                    $value->tarif_laboratorium_paramedis +
                    $value->tarif_laboratorium_non_medis,
            ]);
        }

        if (stripos($value->ruangan, '11102') !== false) {
            //RAWAT INAP
            array_push($pendapatan_per_unit, [
                'Rawat Inap' =>
                    $value->tarif_ruang_rawat +
                    $value->tarif_tindakan_sarana +
                    $value->tarif_tindakan_bhp +
                    $value->tarif_tindakan_dokter_operator +
                    $value->tarif_tindakan_dokter_anastesi +
                    $value->tarif_tindakan_dokter_lainnya +
                    $value->tarif_tindakan_penata_anastesi +
                    $value->tarif_tindakan_paramedis +
                    $value->tarif_tindakan_non_medis +
                    $value->tarif_administrasi -
                    ($value->administrasi_ugd_ranap + $value->tindakan_ugd_ranap),
                'IGD' => $value->administrasi_ugd_ranap + $value->tindakan_ugd_ranap,
                'Farmasi' => $value->tarif_obat,
                'Radiologi' =>
                    $value->tarif_radiologi_sarana +
                    $value->tarif_radiologi_bhp +
                    $value->tarif_radiologi_dokter_operator +
                    $value->tarif_radiologi_dokter_anastesi +
                    $value->tarif_radiologi_dokter_lainnya +
                    $value->tarif_radiologi_penata_anastesi +
                    $value->tarif_radiologi_paramedis +
                    $value->tarif_radiologi_non_medis,
                'Laboratorium' =>
                    $value->tarif_laboratorium_sarana +
                    $value->tarif_laboratorium_bhp +
                    $value->tarif_laboratorium_dokter_operator +
                    $value->tarif_laboratorium_dokter_operator +
                    $value->tarif_laboratorium_dokter_lainnya +
                    $value->tarif_laboratorium_penata_anastesi +
                    $value->tarif_laboratorium_paramedis +
                    $value->tarif_laboratorium_non_medis,
            ]);
        }

        if (stripos($value->ruangan, '11103') !== false) {
            array_push($pendapatan_per_unit, [
                'Rawat Inap' =>
                    $value->tarif_ruang_rawat +
                    $value->tarif_tindakan_sarana +
                    $value->tarif_tindakan_bhp +
                    $value->tarif_tindakan_dokter_operator +
                    $value->tarif_tindakan_dokter_anastesi +
                    $value->tarif_tindakan_dokter_lainnya +
                    $value->tarif_tindakan_penata_anastesi +
                    $value->tarif_tindakan_paramedis +
                    $value->tarif_tindakan_non_medis +
                    $value->tarif_administrasi -
                    ($value->administrasi_ugd_ranap + $value->tindakan_ugd_ranap),
                'IGD' => $value->administrasi_ugd_ranap + $value->tindakan_ugd_ranap,
                'Farmasi' => $value->tarif_obat,
                'Radiologi' =>
                    $value->tarif_radiologi_sarana +
                    $value->tarif_radiologi_bhp +
                    $value->tarif_radiologi_dokter_operator +
                    $value->tarif_radiologi_dokter_anastesi +
                    $value->tarif_radiologi_dokter_lainnya +
                    $value->tarif_radiologi_penata_anastesi +
                    $value->tarif_radiologi_paramedis +
                    $value->tarif_radiologi_non_medis,
                'Laboratorium' =>
                    $value->tarif_laboratorium_sarana +
                    $value->tarif_laboratorium_bhp +
                    $value->tarif_laboratorium_dokter_operator +
                    $value->tarif_laboratorium_dokter_operator +
                    $value->tarif_laboratorium_dokter_lainnya +
                    $value->tarif_laboratorium_penata_anastesi +
                    $value->tarif_laboratorium_paramedis +
                    $value->tarif_laboratorium_non_medis,
            ]);
        }
    }

    // PENDAPATAN PER PASIEN
    $list_total = [
        'Total Karcis' => array_sum($administrasi),
        'Total Sarana' => array_sum($sarana),
        'Total BHP' => array_sum($bhp),
        'Total Dokter' => array_sum($dokter),
        'Total Paramedis' => array_sum($perawat),
    ];

    // PENDAPATAN PER UNIT\
    $data_per_unit = collect($pendapatan_per_unit);
    $list_total_unit = $data_per_unit->pipe(static function ($item) {
        return collect([
            'Rawat Jalan' => $item->sum('Rawat Jalan'),
            'Rawat Inap' => $item->sum('Rawat Inap'),
            'IGD' => $item->sum('IGD'),
            'Farmasi' => $item->sum('Farmasi'),
            'Radiologi' => $item->sum('Radiologi'),
            'Laboratorium' => $item->sum('Laboratorium'),
        ]);
    });

    //PENDAPATAN PER KASIR
    // $data_per_kasir = $records->groupBy('nama_kasir');
    // dd($data_per_kasir);

@endphp

<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        color: black;
    }
</style>
<div style="padding-top: 5px; padding-bottom: 5px; width:100%">
    <td style="padding-top: 10px; padding-bottom: 10px; width: 70%">
        <center>
            <b>Total</b>
        </center>
    </td>

    <td style="width: 20%;">
        <x-filament::modal width="5xl" sticky-header slide-over>
            <x-slot name="trigger" style="font-size: 18px">
                <x-filament::button size="sm">
                    Rp. {{ number_format(array_sum($list_total)) }}
                </x-filament::button>
            </x-slot>
            <x-slot name="heading">
                Pendapatan Total
            </x-slot>

            {{-- Tabel Pertama List Rincian Pendapatan Per Pasien --}}
            <div>
                <x-filament::section collapsible collapsed>
                    <x-slot name="heading">
                        Rincian Per Pasien
                    </x-slot>

                    <table id="customers">
                        <thead>
                            <th>
                                Ruangan
                            </th>
                            <th>
                                Nominal
                            </th>
                            {{-- <th>
                                <center>Coa</center>
                            </th> --}}
                        </thead>
                        <tbody>
                            @foreach ($list_total as $key => $value)
                                <tr>
                                    <td>
                                        Pendapatan {{ $key }}
                                    </td>
                                    <td>
                                        RP. {{ number_format($value) }}
                                    </td>
                                    {{-- <td>
                                        <center>
                                            <x-filament::modal width="5xl">
                                                <x-slot name="trigger">
                                                    <x-filament::button>
                                                        <center> + </center>
                                                    </x-filament::button>
                                                </x-slot>

                                                <x-slot name="heading">
                                                    Pendapatan Total {{ $key }}
                                                </x-slot>

                                                <livewire:bukti-kas-masuk.add-to-jurnal-umum :key="Str::random()"
                                                    :nama="$key" :total="$value" />

                                            </x-filament::modal>
                                        </center>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-filament::section>
            </div>

            {{-- Tabel Pertama List Rincian Pendapatan Per Unit --}}
            <div>
                <x-filament::section collapsible collapsed>
                    <x-slot name="heading">
                        Rincian Per Unit
                    </x-slot>

                    <table id="customers">
                        <thead>
                            <th>
                                Ruangan
                            </th>
                            <th>
                                Nominal
                            </th>
                            {{-- <th>
                                <center>Coa</center>
                            </th> --}}
                        </thead>
                        <tbody>
                            @foreach ($list_total_unit as $key => $value)
                                <tr>
                                    <td>
                                        Pendapatan {{ $key }}
                                    </td>
                                    <td>
                                        Rp. {{ number_format($value) }}
                                    </td>
                                    {{-- <td>
                                        <center>
                                            <x-filament::modal width="5xl" id="modal-coa">
                                                <x-slot name="trigger">
                                                    <x-filament::button>
                                                        <center> + </center>
                                                    </x-filament::button>
                                                </x-slot>

                                                <x-slot name="heading">
                                                    Pendapatan Total {{ $key }}
                                                </x-slot>

                                                <livewire:bukti-kas-masuk.add-to-jurnal-umum :key="Str::random()"
                                                    :nama="$key" :total="$value" />

                                            </x-filament::modal>
                                        </center>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-filament::section>
            </div>

            {{-- Tabel Pertama List Rincian Pendapatan Per Kasir --}}
            <div>
                <x-filament::section collapsible collapsed>
                    <x-slot name="heading">
                        Rincian Per Kasir
                    </x-slot>

                    <table id="customers">
                        <thead>
                            <th>
                                Nama kasir
                            </th>
                            <th>
                                Nominal
                            </th>
                            {{-- <th>
                                <center>Coa</center>
                            </th> --}}
                        </thead>
                        <tbody>
                            @foreach ($records->groupBy('nama_kasir') as $key => $value)
                                @php
                                    $total_tagihan_kasir = [];
                                    foreach ($value as $index => $val) {
                                        array_push($total_tagihan_kasir, $val->total_tagihan);
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        {{ $key }}
                                    </td>
                                    <td>
                                        Rp. {{ number_format(array_sum($total_tagihan_kasir)) }}
                                    </td>
                                    {{-- <td>
                                        <center>
                                            <x-filament::modal width="5xl" id="modal-coa">
                                                <x-slot name="trigger">
                                                    <x-filament::button>
                                                        <center> + </center>
                                                    </x-filament::button>
                                                </x-slot>

                                                <x-slot name="heading">
                                                    Pendapatan Total {{ $key }}
                                                </x-slot>

                                                <livewire:bukti-kas-masuk.add-to-jurnal-umum :key="Str::random()"
                                                    :nama="$key" :total="$value" />

                                            </x-filament::modal>
                                        </center>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-filament::section>
            </div>

            <div>
                <x-filament::modal width="5xl">
                    <x-slot name="trigger">
                        <x-filament::button color="success" icon="heroicon-o-banknotes">
                            Jurnalkan
                        </x-filament::button>
                    </x-slot>

                    <x-slot name="heading">
                        Tambahkan Total Pendapatan
                    </x-slot>

                    <livewire:bukti-kas-masuk.add-to-jurnal-umum :key="Str::random()" :nama="$key"
                        :total="array_sum($list_total)" />
                </x-filament::modal>
            </div>


        </x-filament::modal>
    </td>


</div>
