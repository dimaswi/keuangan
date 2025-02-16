<div>
    @if ($getRecord()->secondary_coa == $getRecord()->primary_coa)
    @else
        <p style="font-size: 18px; margin-left:-250px">
            {{ $getState() }}
        </p>
    @endif
</div>
