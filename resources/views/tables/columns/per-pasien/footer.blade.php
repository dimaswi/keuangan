@props(['columns', 'records'])
@php
    $administrasi = [];
    $sarana = [];
    $bhp = [];
    $dokter = [];
    $perawat = [];

    foreach ($records as $key => $value) {
        array_push($administrasi, $value->tarif_administrasi);
        array_push(
            $sarana,
            $value->tarif_ruang_rawat +
                $value->tarif_ruang_rawat +
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

@endphp
<div style="padding-top: 5px; padding-bottom: 5px">
    <td style="padding-top: 10px; padding-bottom: 10px">
        <center>
            <b>Total</b>
        </center>
    </td>
    <td>
        {{ number_format(array_sum($administrasi)) }}
    </td>
    <td>
        {{ number_format(array_sum($sarana)) }}
    </td>
    <td>
        {{ number_format(array_sum($bhp)) }}
    </td>
    <td>
        {{ number_format(array_sum($dokter)) }}
    </td>
    <td>
        {{ number_format(array_sum($perawat)) }}
    </td>
</div>
