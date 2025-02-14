<div>
    <div style="text-align: center">
        Rp. {{ number_format(
            $getRecord()->tarif_ruang_rawat +
                $getRecord()->tarif_radiologi_sarana +
                $getRecord()->tarif_laboratorium_sarana +
                $getRecord()->tarif_tindakan_sarana +
                $getRecord()->tarif_administrasi +
                $getRecord()->tarif_radiologi_penata_anastesi +
                $getRecord()->tarif_radiologi_paramedis +
                $getRecord()->tarif_radiologi_non_medis +
                $getRecord()->tarif_laboratorium_penata_anastesi +
                $getRecord()->tarif_laboratorium_paramedis +
                $getRecord()->tarif_laboratorium_dokter_non_medis +
                $getRecord()->tarif_tindakan_penata_anastesi +
                $getRecord()->tarif_tindakan_paramedis +
                $getRecord()->tarif_tindakan_dokter_non_medis +
                $getRecord()->tarif_radiologi_dokter_operator +
                $getRecord()->tarif_radiologi_dokter_anastesi +
                $getRecord()->tarif_radiologi_lainnya +
                $getRecord()->tarif_laboratorium_dokter_operator +
                $getRecord()->tarif_laboratorium_dokter_anastesi +
                $getRecord()->tarif_laboratorium_dokter_lainnya +
                $getRecord()->tarif_tindakan_dokter_operator +
                $getRecord()->tarif_tindakan_dokter_anastesi +
                $getRecord()->tarif_tindakan_dokter_lainnya +
                $getRecord()->tarif_obat +
                $getRecord()->tarif_radiologi_bhp +
                $getRecord()->tarif_laboratorium_bhp +
                $getRecord()->tarif_tindakan_bhp,
        ) }}
    </div>
</div>
