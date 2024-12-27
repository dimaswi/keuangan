@if ($getRecord()->ruangan != '')
    <div style="font-size: 16px; padding-left: 10px; padding-right: 10px; padding-bottom: 20px; padding-top: 20px">
        <div style="font-size: 16px; font-weight: bold">
            {{ $getRecord()->ruangan }}
        </div>

        <div style="font-size: 14px">
            <div style="margin-left: 30px;">
                &#8594; Pendapatan Pasien Umum
            </div>

            <div style="margin-left: 30px;">
                &#8594; Pendapatan Pasien BPJS
            </div>

            <div style="margin-left: 30px;">
                &#8594; Pendapatan Asuransi Karyawan
            </div>

            <div style="margin-left: 30px;">
                &#8594; Pendapatan Pasien Jasa Raharja
            </div>

        </div>
    </div>
@else
<div style="display: block">

</div>
@endif
