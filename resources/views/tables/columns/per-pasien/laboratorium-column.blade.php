@if ($getRecord()->tarif_laboratorium != null)
    <div style="text-align: center">
        {{ number_format($getRecord()->tarif_laboratorium) }}
    </div>
@else
    <div style="text-align: center">
        0
    </div>
@endif
