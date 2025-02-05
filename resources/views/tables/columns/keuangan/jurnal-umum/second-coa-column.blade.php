<div>
    @if ($getRecord()->secondary_coa == $getRecord()->primary_coa)
    @else
        {{ $getState() }}
    @endif
</div>
