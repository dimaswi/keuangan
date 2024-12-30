@if ($getRecord()->ruangan != '')
    <div style="font-size: 16px; padding-top: 5px; padding-bottom: 5px;">
        <div style="font-size: 16px; font-weight: bold">
            {{-- Rp. {{ number_format($getRecord()->pendapatan) }} --}}&nbsp;
        </div>

        <div style="font-size: 14px">
            <div style="margin-left: 20px;">
                @if ($getRecord()->ruangan == "Laboratorium")
                Rp. {{ number_format($getRecord()->karcis) }}.00
                @elseif ($getRecord()->ruangan == "Radiologi")

                @else
                Rp. 0.00
                @endif
            </div>
            <div style="margin-left: 20px;">
                Rp. {{ number_format($getRecord()->umum) }}.00
            </div>
            <div style="margin-left: 20px;">
                Rp. {{ number_format($getRecord()->bpjs) }}.00
            </div>

            <div style="margin-left: 20px;">
                Rp. {{ number_format($getRecord()->asuransi_karyawan) }}.00
            </div>

            <div style="margin-left: 20px;">
                Rp. {{ number_format($getRecord()->jasa_raharja) }}.00
            </div>
        </div>

    </div>
@else
    <div style="display: block">

    </div>
@endif
