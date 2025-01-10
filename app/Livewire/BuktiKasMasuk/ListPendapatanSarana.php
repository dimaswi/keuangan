<?php

namespace App\Livewire\BuktiKasMasuk;

use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ListPendapatanSarana extends Component implements HasForms
{
    use InteractsWithForms;

    public $total;
    public $list = [];

    public function render()
    {
        $data = collect($this->list);

        $sum = $data->pipe(static function ($item) {
            return collect([
                'Rawat Inap' => $item->sum('Rawat Inap'),
                'Radiologi' => $item->sum('Radiologi'),
                'Laboratorium' => $item->sum('Laboratorium'),
                'Tindakan' => $item->sum('Tindakan'),
            ]);
        });

        return view('livewire.bukti-kas-masuk.list-pendapatan-sarana', [
            'data' => $sum,
        ]);
    }
}
