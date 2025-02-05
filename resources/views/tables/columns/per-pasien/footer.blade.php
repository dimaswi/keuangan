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
        // dump($value);
        // array_push($list_ruangan, ['ruangan' => $value->ruangan]);
        // array_push($list_biaya_administrasi, ['administrasi' => $value->tarif_administrasi]);
        // array_push($sarana_nominal, [
        //     'RawatInap' => $value->tarif_ruang_rawat,
        //     'Radiologi' => $value->tarif_radiologi_sarana,
        //     'Laboratorium' => $value->tarif_laboratorium_sarana,
        //     'Tindakan' => $value->tarif_tindakan_sarana,
        // ]);

        // array_push($bhp_nominal, [
        //     'Farmasi' => $value->tarif_obat,
        //     'Radiologi' => $value->tarif_radiologi_bhp,
        //     'Laboratorium' => $value->tarif_laboratorium_bhp,
        //     'Tindakan' => $value->tarif_tindakan_bhp,
        // ]);

        // array_push($dokter_nominal, [
        //     'Radiologi' =>
        //         $value->tarif_radiologi_dokter_operator +
        //         $value->tarif_radiologi_dokter_anastesi +
        //         $value->tarif_radiologi_dokter_lainnya,
        //     'Laboratorium' =>
        //         $value->tarif_laboratorium_dokter_operator +
        //         $value->tarif_laboratorium_dokter_operator +
        //         $value->tarif_laboratorium_dokter_lainnya,
        //     'Tindakan' =>
        //         $value->tarif_tindakan_dokter_operator +
        //         $value->tarif_tindakan_dokter_anastesi +
        //         $value->tarif_tindakan_dokter_lainnya,
        // ]);

        // array_push($perawat_nominal, [
        //     'Radiologi' =>
        //         $value->tarif_radiologi_penata_anastesi +
        //         $value->tarif_radiologi_paramedis +
        //         $value->tarif_radiologi_non_medis,
        //     'Laboratorium' =>
        //         $value->tarif_laboratorium_penata_anastesi +
        //         $value->tarif_laboratorium_paramedis +
        //         $value->tarif_laboratorium_non_medis,
        //     'Tindakan' =>
        //         $value->tarif_tindakan_penata_anastesi +
        //         $value->tarif_tindakan_paramedis +
        //         $value->tarif_tindakan_non_medis,
        // ]);
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

        if (stripos($value->ruangan, '11101') !== false) {
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
                'Rawat Inap' => null,
                'IGD' => null,
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
                'Rawat Inap' => null,
                'IGD' => null,
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
            array_push($pendapatan_per_unit, [
                'Rawat Jalan' => null,
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
                'Rawat Jalan' => null,
                'Rawat Inap' => null,
                'IGD' =>
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

        // array_push($pendapatan_per_unit, [
        //     'Rawat Jalan' => $value->tarif_administrasi + $value->tarif_tindakan_sarana + $value->tarif_tindakan_bhp + $value->tarif_tindakan_dokter_operator + $value->tarif_tindakan_dokter_anastesi + $value->tarif_tindakan_dokter_lainnya $value->tarif_tindakan_penata_anastesi + $value->tarif_tindakan_paramedis + $value->tarif_tindakan_non_medis,
        //     'Rawat Inap' => $value->tarif_administrasi + $value->tarif_ruang_rawat,
        // ]);
    }

    // //KARCIS
    // $ruangan_to_biaya = array_replace_recursive($list_biaya_administrasi, $list_ruangan);
    // $data_karcis = collect($ruangan_to_biaya);
    // $list_karcis = $data_karcis->groupBy('ruangan')->map(function ($row) {
    //     return $row->sum('administrasi');
    // });
    // $nama_total_karcis = 'Total';
    // $total_data_karcis = array_sum($administrasi);

    // // dump($total_data_karcis);

    // // SARANA
    // $data_sarana = collect($sarana_nominal);
    // $list_sarana = $data_sarana->pipe(static function ($item) {
    //     return collect([
    //         'Sarana Rawat Inap' => $item->sum('Rawat Inap'),
    //         'Sarana Radiologi' => $item->sum('Radiologi'),
    //         'Sarana Laboratorium' => $item->sum('Laboratorium'),
    //         'Sarana Tindakan' => $item->sum('Tindakan'),
    //     ]);
    // });

    // // BHP
    // $data_bhp = collect($bhp_nominal);
    // $list_bhp = $data_bhp->pipe(static function ($item) {
    //     return collect([
    //         'BHP Farmasi' => $item->sum('Farmasi'),
    //         'BHP Radiologi' => $item->sum('Radiologi'),
    //         'BHP Laboratorium' => $item->sum('Laboratorium'),
    //         'BHP Tindakan' => $item->sum('Tindakan'),
    //     ]);
    // });

    // // DOKTER
    // $data_dokter = collect($dokter_nominal);
    // $list_dokter = $data_dokter->pipe(static function ($item) {
    //     return collect([
    //         'Dokter Radiologi' => $item->sum('Radiologi'),
    //         'Dokter Laboratorium' => $item->sum('Laboratorium'),
    //         'Dokter Tindakan' => $item->sum('Tindakan'),
    //     ]);
    // });

    // // PERAWAT
    // $data_perawat = collect($perawat_nominal);
    // $list_perawat = $data_perawat->pipe(static function ($item) {
    //     return collect([
    //         'Paramedis Radiologi' => $item->sum('Radiologi'),
    //         'Paramedis Laboratorium' => $item->sum('Laboratorium'),
    //         'Paramedis Tindakan' => $item->sum('Tindakan'),
    //     ]);
    // });

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

    // dump($pendapatan_per_unit);

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
<div style="padding-top: 5px; padding-bottom: 5px">
    <td style="padding-top: 10px; padding-bottom: 10px">
        <center>
            <b>Total</b>
        </center>
    </td>
    {{-- <td>
        <x-filament::modal width="5xl" sticky-header slide-over>
            <x-slot name="trigger">
                {{ number_format(array_sum($administrasi)) }}
            </x-slot>

            <x-slot name="heading">
                Pendapatan Karcis
            </x-slot>
            <div>
                <table id="customers">
                    <thead>
                        <th>
                            Ruangan
                        </th>
                        <th>
                            Nominal
                        </th>
                        <th>
                            <center>Coa</center>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($list_karcis as $key => $value)
                            <tr>
                                <td>
                                    Pendapatan Karcis {{ $key }}
                                </td>
                                <td>
                                    {{ number_format($value) }}
                                </td>
                                <td>
                                    <center>
                                        <x-filament::modal width="5xl">
                                            <x-slot name="trigger">
                                                <x-filament::button>
                                                    <center> + </center>
                                                </x-filament::button>
                                            </x-slot>

                                            <x-slot name="heading">
                                                Pendapatan {{ $key }}
                                            </x-slot>

                                            <livewire:buktikasmasuk.addtojurnalumum :key="Str::random()" :nama="$key" :total="$value" />
                                        </x-filament::modal>
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::modal>
    </td>
    <td>
        <x-filament::modal width="5xl" sticky-header slide-over>
            <x-slot name="trigger">
                {{ number_format(array_sum($sarana)) }}
            </x-slot>

            <x-slot name="heading">
                Pendapatan Sarana
            </x-slot>
            <div>
                <table id="customers">
                    <thead>
                        <th>
                            Ruangan
                        </th>
                        <th>
                            Nominal
                        </th>
                        <th>
                            <center>Coa</center>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($list_sarana as $key => $value)
                            <tr>
                                <td>
                                    Pendapatan {{ $key }}
                                </td>
                                <td>
                                    {{ number_format($value) }}
                                </td>
                                <td>
                                    <center>
                                        <x-filament::modal width="5xl">
                                            <x-slot name="trigger">
                                                <x-filament::button>
                                                    <center> + </center>
                                                </x-filament::button>
                                            </x-slot>

                                            <x-slot name="heading">
                                                Pendapatan Sarana {{ $key }}
                                            </x-slot>

                                            <livewire:buktikasmasuk.addtojurnalumum :key="Str::random()" :nama="$key" :total="$value" />
                                        </x-filament::modal>
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::modal>

    </td>
    <td>
        <x-filament::modal width="5xl" sticky-header slide-over>
            <x-slot name="trigger">
                {{ number_format(array_sum($bhp)) }}
            </x-slot>

            <x-slot name="heading">
                Pendapatan BHP
            </x-slot>
            <div>
                <table id="customers">
                    <thead>
                        <th>
                            Ruangan
                        </th>
                        <th>
                            Nominal
                        </th>
                        <th>
                            <center>Coa</center>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($list_bhp as $key => $value)
                            <tr>
                                <td>
                                    Pendapatan {{ $key }}
                                </td>
                                <td>
                                    {{ number_format($value) }}
                                </td>
                                <td>
                                    <center>
                                        <x-filament::modal width="5xl">
                                            <x-slot name="trigger">
                                                <x-filament::button>
                                                    <center> + </center>
                                                </x-filament::button>
                                            </x-slot>

                                            <x-slot name="heading">
                                                Pendapatan BHP {{ $key }}
                                            </x-slot>

                                            <livewire:buktikasmasuk.addtojurnalumum :key="Str::random()" :nama="$key" :total="$value" />
                                        </x-filament::modal>
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::modal>
    </td>
    <td>
        <x-filament::modal width="5xl" sticky-header slide-over>
            <x-slot name="trigger">
                {{ number_format(array_sum($dokter)) }}
            </x-slot>

            <x-slot name="heading">
                Pendapatan Dokter
            </x-slot>
            <div>
                <table id="customers">
                    <thead>
                        <th>
                            Ruangan
                        </th>
                        <th>
                            Nominal
                        </th>
                        <th>
                            <center>Coa</center>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($list_dokter as $key => $value)
                            <tr>
                                <td>
                                    Pendapatan {{ $key }}
                                </td>
                                <td>
                                    {{ number_format($value) }}
                                </td>
                                <td>
                                    <center>
                                        <x-filament::modal width="5xl">
                                            <x-slot name="trigger">
                                                <x-filament::button>
                                                    <center> + </center>
                                                </x-filament::button>
                                            </x-slot>

                                            <x-slot name="heading">
                                                Pendapatan Dokter {{ $key }}
                                            </x-slot>

                                            <livewire:buktikasmasuk.addtojurnalumum :key="Str::random()" :nama="$key" :total="$value" />
                                        </x-filament::modal>
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::modal>
    </td>
    <td>
        <x-filament::modal width="5xl" sticky-header slide-over>
            <x-slot name="trigger">
                {{ number_format(array_sum($perawat)) }}
            </x-slot>

            <x-slot name="heading">
                Pendapatan Perawat
            </x-slot>
            <div>
                <table id="customers">
                    <thead>
                        <th>
                            Ruangan
                        </th>
                        <th>
                            Nominal
                        </th>
                        <th>
                            <center>Coa</center>
                        </th>
                    </thead>
                    <tbody>
                        @foreach ($list_perawat as $key => $value)
                            <tr>
                                <td>
                                    Pendapatan {{ $key }}
                                </td>
                                <td>
                                    {{ number_format($value) }}
                                </td>
                                <td>
                                    <center>
                                        <x-filament::modal width="5xl">
                                            <x-slot name="trigger">
                                                <x-filament::button>
                                                    <center> + </center>
                                                </x-filament::button>
                                            </x-slot>

                                            <x-slot name="heading">
                                                Pendapatan Perawat {{ $key }}
                                            </x-slot>

                                            <livewire:buktikasmasuk.addtojurnalumum :key="Str::random()" :nama="$key" :total="$value" />
                                        </x-filament::modal>
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-filament::modal>
    </td> --}}
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>
        <x-filament::modal width="5xl" sticky-header slide-over>
            <x-slot name="trigger">
                {{ number_format(array_sum($list_total)) }}
            </x-slot>
            <x-slot name="heading">
                Pendapatan Total
            </x-slot>

            {{-- Tabel Pertama List Rincian Pendapatan --}}
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
                            <th>
                                <center>Coa</center>
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($list_total as $key => $value)
                                <tr>
                                    <td>
                                        Pendapatan {{ $key }}
                                    </td>
                                    <td>
                                        {{ number_format($value) }}
                                    </td>
                                    <td>
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

                                                @livewire('buktikasmasuk.add-to-jurnal-umum', ['key' => Str::random(), 'nama' => $key, 'total' => $value])
                                            </x-filament::modal>
                                        </center>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-filament::section>
            </div>

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
                            <th>
                                <center>Coa</center>
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($list_total_unit as $key => $value)
                                <tr>
                                    <td>
                                        Pendapatan {{ $key }}
                                    </td>
                                    <td>
                                        {{ number_format($value) }}
                                    </td>
                                    <td>
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

                                                    @livewire('buktikasmasuk.add-to-jurnal-umum', ['key' => Str::random(), 'nama' => $key, 'total' => $value])
                                            </x-filament::modal>
                                        </center>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </x-filament::section>
            </div>
        </x-filament::modal>
    </td>
</div>
