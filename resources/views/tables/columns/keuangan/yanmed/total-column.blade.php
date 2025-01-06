<div style="font-size: 16px; padding-top: 5px; padding-bottom: 5px;">
    <div style="font-size: 16px; font-weight: bold">
        {{-- Rp. {{ number_format($getRecord()->pendapatan) }} --}}&nbsp;
    </div>

    <div style="font-size: 20px; font-weight: bold">
        Rp. {{ number_format($getRecord()->pendapatan) }}.00
    </div>

    <div style="font-size: 14px">
        <div style="margin-left: 20px;">
            {{-- IDR. {{ number_format($getRecord()->karcis) }}.00 --}}&nbsp;
        </div>

        <div style="margin-left: 20px;">
            {{-- IDR. {{ number_format($getRecord()->jasa_pelayanan) }}.00 --}}&nbsp;
        </div>

        <div style="margin-left: 20px;">
            {{-- IDR. {{ number_format($getRecord()->jasa_periksa) }}.00 --}}&nbsp;
        </div>
    </div>

    {{-- <div style="font-size: 16px; font-weight: bold">
        Rp. {{ number_format($getRecord()->pendapatan) }}
    </div> --}}
</div>
