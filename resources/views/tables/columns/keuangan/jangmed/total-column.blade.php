@if ($getRecord()->ruangan != '')
<div style="font-size: 16px; padding-top: 5px; padding-bottom: 5px;">
    <div style="font-size: 16px; font-weight: bold">
        {{-- Rp. {{ number_format($getRecord()->pendapatan) }} --}}&nbsp;
    </div>

    @if ($getRecord()->ruangan == 'Laboratorium' && url()->current() == url('/keuangan/laboratoria'))
    <div style="font-size: 20px; font-weight: bold">
        Rp. {{ number_format($getRecord()->pendapatan + $getRecord()->karcis) }}.00
    </div>
    @elseif ($getRecord()->ruangan == 'Radiologi' && url()->current() == url('/keuangan/radiologis'))
    <div style="font-size: 20px; font-weight: bold">
        Rp. {{ number_format($getRecord()->pendapatan + $getRecord()->karcis) }}.00
    </div>
    @else
    <div style="font-size: 20px; font-weight: bold">
        Rp. {{ number_format($getRecord()->pendapatan) }}.00
    </div>
    @endif

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
@else
<div style="display: block">

</div>
@endif
