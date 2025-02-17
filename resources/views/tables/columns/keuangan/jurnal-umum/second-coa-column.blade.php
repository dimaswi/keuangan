<div>
    @if ($getRecord()->secondary_coa == $getRecord()->primary_coa)
    @else
        @if ($getRecord()->kredit == 0)
        <p style="font-size: 18px; margin-left:-120%">
            <span style="color: green; font-size: 20px">&UpArrow;</span> {{ $getState() }}
        </p>
        @else
            <p style="font-size: 18px; margin-left:-120%">
                <span style="color: red; font-size: 20px">&DownArrow;</span> {{ $getState() }}
            </p>
        @endif
    @endif
</div>
