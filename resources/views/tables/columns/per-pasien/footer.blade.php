@props(['columns', 'records'])
@php
    $administrasi = [];
    $list_ruangan = [];
    $list_biaya_administrasi = [];
    $sarana_nominal = [];
    $bhp_nominal = [];
    $dokter_nominal = [];
    $perawat_nominal = [];
    $sarana = [];
    $bhp = [];
    $dokter = [];
    $perawat = [];
    $total = [];

    foreach ($records as $key => $value) {
        array_push($list_ruangan, ['ruangan' => $value->ruangan]);
        array_push($list_biaya_administrasi, ['administrasi' => $value->tarif_administrasi]);
        array_push($sarana_nominal, [
            'Rawat Inap' => $value->tarif_ruang_rawat,
            'Radiologi' => $value->tarif_radiologi_sarana,
            'Laboratorium' => $value->tarif_laboratorium_sarana,
            'Tindakan' => $value->tarif_tindakan_sarana,
        ]);

        array_push($bhp_nominal, [
            'Farmasi' => $value->tarif_obat,
            'Radiologi' => $value->tarif_radiologi_bhp,
            'Laboratorium' => $value->tarif_laboratorium_bhp,
            'Tindakan' => $value->tarif_tindakan_bhp,
        ]);

        array_push($dokter_nominal, [
            'Radiologi' =>
                $value->tarif_radiologi_dokter_operator +
                $value->tarif_radiologi_dokter_anastesi +
                $value->tarif_radiologi_dokter_lainnya,
            'Laboratorium' =>
                $value->tarif_laboratorium_dokter_operator +
                $value->tarif_laboratorium_dokter_operator +
                $value->tarif_laboratorium_dokter_lainnya,
            'Tindakan' =>
                $value->tarif_tindakan_dokter_operator +
                $value->tarif_tindakan_dokter_anastesi +
                $value->tarif_tindakan_dokter_lainnya,
        ]);

        array_push($perawat_nominal, [
            'Radiologi' =>
                $value->tarif_radiologi_penata_anastesi +
                $value->tarif_radiologi_paramedis +
                $value->tarif_radiologi_non_medis,
            'Laboratorium' =>
                $value->tarif_laboratorium_penata_anastesi +
                $value->tarif_laboratorium_paramedis +
                $value->tarif_laboratorium_non_medis,
            'Tindakan' =>
                $value->tarif_tindakan_penata_anastesi +
                $value->tarif_tindakan_paramedis +
                $value->tarif_tindakan_non_medis,
        ]);
        array_push($total, $value->total_tagihan);
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
    }

    //KARCIS
    $ruangan_to_biaya = array_replace_recursive($list_biaya_administrasi, $list_ruangan);
    $data_karcis = collect($ruangan_to_biaya);
    $list_karcis = $data_karcis->groupBy('ruangan')->map(function ($row) {
        return $row->sum('administrasi');
    });
    $nama_total_karcis = "Total";
    $total_data_karcis = array_sum($administrasi);

    // dump($total_data_karcis);

    // SARANA
    $data_sarana = collect($sarana_nominal);
    $list_sarana = $data_sarana->pipe(static function ($item) {
        return collect([
            'Rawat Inap' => $item->sum('Rawat Inap'),
            'Radiologi' => $item->sum('Radiologi'),
            'Laboratorium' => $item->sum('Laboratorium'),
            'Tindakan' => $item->sum('Tindakan'),
        ]);
    });

    // BHP
    $data_bhp = collect($bhp_nominal);
    $list_bhp = $data_bhp->pipe(static function ($item) {
        return collect([
            'Farmasi' => $item->sum('Farmasi'),
            'Radiologi' => $item->sum('Radiologi'),
            'Laboratorium' => $item->sum('Laboratorium'),
            'Tindakan' => $item->sum('Tindakan'),
        ]);
    });

    // DOKTER
    $data_dokter = collect($dokter_nominal);
    $list_dokter = $data_dokter->pipe(static function ($item) {
        return collect([
            'Radiologi' => $item->sum('Radiologi'),
            'Laboratorium' => $item->sum('Laboratorium'),
            'Tindakan' => $item->sum('Tindakan'),
        ]);
    });

    // PERAWAT
    $data_perawat = collect($perawat_nominal);
    $list_perawat = $data_perawat->pipe(static function ($item) {
        return collect([
            'Radiologi' => $item->sum('Radiologi'),
            'Laboratorium' => $item->sum('Laboratorium'),
            'Tindakan' => $item->sum('Tindakan'),
        ]);
    });

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
    <td>


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
                                                Pendapatan Karcis {{ $key }}
                                            </x-slot>

                                            {{-- <livewire:buktikasmasuk.addtojurnalumum :nama="$key" :total="$value" /> --}}
                                        </x-filament::modal>
                                    </center>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>
                                Pendapatan Karcis Total
                            </td>
                            <td>
                                {{ number_format(array_sum($administrasi)) }}
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
                                            Pendapatan Karcis Total
                                        </x-slot>

                                        {{-- <livewire:buktikasmasuk.addtojurnalumum :nama="$nama_total_karcis" :total="$total_data_karcis" /> --}}
                                    </x-filament::modal>
                                </center>
                            </td>
                        </tr>
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
                                    Pendapatan Sarana {{ $key }}
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

                                            {{-- <livewire:buktikasmasuk.addtojurnalumum :nama="$key" :total="$value" /> --}}
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
                                    Pendapatan BHP {{ $key }}
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

                                            {{-- <livewire:buktikasmasuk.addtojurnalumum :nama="$key" :total="$value" /> --}}
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
                                    Pendapatan Dokter {{ $key }}
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

                                            {{-- <livewire:buktikasmasuk.addtojurnalumum :nama="$key" :total="$value" /> --}}
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
                                    Pendapatan Perawat {{ $key }}
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

                                            {{-- <livewire:buktikasmasuk.addtojurnalumum :nama="$key" :total="$value" /> --}}
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
        <x-filament::modal width="5xl" sticky-header>
            <x-slot name="trigger">
                {{ number_format(array_sum($total)) }}
            </x-slot>

            {{-- <livewire:buktikasmasuk.addtojurnalumum :total="array_sum($total)" /> --}}
        </x-filament::modal>
    </td>
</div>
