@if ($getRecord()->tarif_radiologi != null)
    <div style="text-align: center">
        {{ number_format($getRecord()->tarif_radiologi) }}
    </div>
@else
    <div style="text-align: center">
        0
    </div>
@endif
