@if ($getRecord()->jenis_tagihan > 1 )
@else
    <div style="padding-left: 12px; padding-top: 12px; padding-bottom: 12px">
        <center>{{ $getRecord()->pasien }} -  {{ $getRecord()->ruangan }}</center>
    </div>
@endif
