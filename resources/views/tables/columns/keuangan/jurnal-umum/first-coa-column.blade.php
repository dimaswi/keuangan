@php
    $coa = App\Models\JurnalUmum::whereDate('tanggal', $getRecord()->tanggal)
        ->where('primary_coa', $getRecord()->primary_coa)
        ->first();
@endphp

@if ($coa->id < $getRecord()->id)
    <div>

    </div>
@else
    <div style="margin-left: 10px; text-align: left">
        <p style="font-size: 18px">
            {{ $getState() }}
        </p>
    </div>
@endif
