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
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_pelayanan_umum) }}.00
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_periksa_umum) }}.00
        </div>
    </div>

    <div style="font-size: 14px">
        <div style="margin-left: 20px;">
            {{-- Rp. {{ number_format($getRecord()->karcis) }}.00 --}}&nbsp;
        </div>
        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->karcis_bpjs) }}.00
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_pelayanan_bpjs) }}.00
        </div>

        <div style="margin-left: 20px;">
            Rp. {{ number_format($getRecord()->jasa_periksa_bpjs) }}.00
        </div>
    </div>
</div>
