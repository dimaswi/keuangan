@if ($getRecord()->tarif_tindakan != null)
    <div style="text-align: center">
        {{ $getRecord()->tarif_tindakan }}
    </div>
@else
    <div style="text-align: center">
        0
    </div>
@endif
