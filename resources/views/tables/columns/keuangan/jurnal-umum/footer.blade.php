@props(['columns', 'records'])

<div>
    <td style="padding-top: 5px; padding-bottom: 5px; font-size: 18px" colspan="3">
        <center><b>TOTAL</b></center>
    </td>
    <td style="padding-top: 5px; padding-bottom: 5px; font-size: 18px; text-align: center">Rp. {{ number_format($records->sum('debit')) }}</td>
    <td style="padding-top: 5px; padding-bottom: 5px; font-size: 18px; text-align: center">Rp. {{ number_format($records->sum('kredit')) }}</td>
    @if ($records->sum('kredit') != $records->sum('debit'))
        <td colspan="2" style="padding-top: 5px; padding-bottom: 5px; font-size: 18px"><small style="color: red">Nominal tidak
                sama!</small></td>
    @else
        <td colspan="2" style="padding-top: 5px; padding-bottom: 5px; font-size: 18px"><small style="color: green">Nominal sudah
                sama</small></td>
    @endif
</div>
