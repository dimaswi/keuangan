<?php

namespace App\Livewire\Keuangan\Coa;

use App\Models\JurnalUmum;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\RawJs;
use Livewire\Component;

class CreateCoa extends Component implements HasForms
{
    use InteractsWithForms;

    public $kredit;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {

        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('primary_coa')
                        ->label('Kode Akun')
                        ->searchable()
                        ->required()
                        ->options(\App\Models\COA::all()->pluck('DESKRIPSI', 'ID_COA')),
                    Select::make('secondary_coa')
                        ->label('Kode Akun')
                        ->searchable()
                        ->required()
                        ->options(\App\Models\COA::all()->pluck('DESKRIPSI', 'ID_COA')),
                    TextInput::make('kredit')
                        ->label('Kredit')
                        ->mask(RawJs::make('$money($input)'))
                        ->stripCharacters(',')
                        ->numeric()
                        ->required()
                        ->default($this->kredit + 0),
                    TextInput::make('debit')
                        ->label('Debit')
                        ->required()
                        ->default(0),
                    DatePicker::make('tanggal')
                        ->label('Tanggal')
                        ->required(),
                    Textarea::make('keterangan')
                        ->label('Keterangan')
                        ->placeholder('Masukan Keterangan')
                ])
            ])
            ->statePath('data');
    }

    public function create(): void
    {

        $available_coa_date = JurnalUmum::where('primary_coa', $this->form->getState()['primary_coa'])
            ->where('secondary_coa', $this->form->getState()['secondary_coa'])
            ->whereDate('tanggal', $this->form->getState()['tanggal'])
            ->get();

        if ($available_coa_date->count() > 0) {
            Notification::make()
                ->title('Gagal!')
                ->danger()
                ->body('Jurnal pada hari ' . $this->form->getState()['tanggal'] . ' sudah ada!')
                ->send();
        } else {
            JurnalUmum::create([
                'primary_coa' => $this->form->getState()['primary_coa'],
                'secondary_coa' => $this->form->getState()['secondary_coa'],
                'kredit' => $this->form->getState()['kredit'],
                'debit' => $this->form->getState()['debit'],
                'tanggal' => $this->form->getState()['tanggal'],
                'keterangan' => $this->form->getState()['keterangan'],
            ]);

            Notification::make()
                ->title('Berhasil!')
                ->success()
                ->body('Data berhasil ditambahkan!')
                ->send();
        }

        $this->dispatch('close-modal', id: 'coa');
    }

    public function render()
    {
        return view('livewire.keuangan.coa.create-coa');
    }
}
