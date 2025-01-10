<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        color: black;
    }
</style>

<div>
    <table id="customers">
        <thead>
            <th>
                Ruangan
            </th>
            <th>
                Nominal
            </th>
            <th>
                <center>Coa</center>
            </th>
        </thead>
        <tbody>
            @foreach ($data as $key => $value)
                <tr>
                    <td>
                        Pendapatan Karcis {{ $key }}
                    </td>
                    <td>
                        {{ $value }}
                    </td>
                    <td>
                        <center>
                            <x-filament::modal width="5xl">
                                <x-slot name="trigger">
                                    <x-filament::button>
                                        <center> + </center>
                                    </x-filament::button>
                                </x-slot>

                                <x-slot name="heading">
                                    Pendapatan Karcis {{ $key }}
                                </x-slot>

                                <livewire:buktikasmasuk.addtojurnalumum :nama="$key" :total="$value" />
                            </x-filament::modal>
                        </center>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
