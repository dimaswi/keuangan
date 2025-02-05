@props(['columns', 'records'])

<div>
    <td style="padding-top: 10px; padding-bottom: 10px" colspan="3">
        <center>Total</center>
    </td>
    <td style="padding-top: 10px; padding-bottom: 10px">Rp. {{ number_format($records->sum('debit')) }}</td>
    <td style="padding-top: 10px; padding-bottom: 10px">Rp. {{ number_format($records->sum('kredit')) }}</td>
    @if ($records->sum('kredit') != $records->sum('debit'))
        <td colspan="2" style="padding-top: 10px; padding-bottom: 10px"><small style="color: red">Nominal tidak
                sama!</small></td>
    @else
        <td colspan="2" style="padding-top: 10px; padding-bottom: 10px"><small style="color: green">Nominal sudah
                sama</small></td>
    @endif
</div>
