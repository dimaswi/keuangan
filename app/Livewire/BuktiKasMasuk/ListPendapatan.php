<?php

namespace App\Livewire\BuktiKasMasuk;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class ListPendapatan extends Component implements HasForms
{

    use InteractsWithForms;

    public $total;
    public $list_total = [];
    public $list_ruangan = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render()
    {
        $ruangan_to_biaya = array_replace_recursive($this->list_total, $this->list_ruangan);
        $data = collect($ruangan_to_biaya);

        $num = $data->groupBy('ruangan')->map(function ($row) {
            return $row->sum('administrasi');
        });

        return view('livewire.bukti-kas-masuk.list-pendapatan',[
            'data' => $num
        ]);
    }
}
