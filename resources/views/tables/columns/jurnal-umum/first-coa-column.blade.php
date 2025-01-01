@php
    $coa = App\Models\JurnalUmum::whereDate('tanggal', $getRecord()->tanggal)
        ->where('primary_coa', $getRecord()->primary_coa)
        // ->where('secondary_coa', $getRecord()->secondary_coa)
        ->first();
@endphp

@if ($coa->id < $getRecord()->id)
    <div>

    </div>
@else
    <div style="margin-left: 10px">
        <p>
            {{ $getState() }}
        </p>
    </div>
@endif
