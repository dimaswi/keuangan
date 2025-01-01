@php
    $coa = App\Models\JurnalUmum::whereDate('tanggal', $getRecord()->tanggal)
        // ->where('primary_coa', $getRecord()->primary_coa)
        // ->where('secondary_coa', $getRecord()->secondary_coa)
        ->first();

    $tanggal = date("d-m-Y", strtotime($getRecord()->tanggal));
@endphp

@if ($coa->id < $getRecord()->id)
    <div>

    </div>
@else
    <div style="margin-left: 10px">
        <p>
            {{ $tanggal }}
        </p>
    </div>
@endif
