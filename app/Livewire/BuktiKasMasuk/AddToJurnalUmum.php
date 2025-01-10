<?php

namespace App\Livewire\BuktiKasMasuk;

use App\Models\JurnalUmum;
use Carbon\Carbon;
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

class AddToJurnalUmum extends Component implements HasForms
{
    use InteractsWithForms;

    public $nama;
    public $total;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TableRepeater::make('kredit_coa')
                    ->schema([
                        Select::make('primary_coa')
                            ->label('Kode Akun')
                            ->searchable()
                            ->required()
                            ->options(\App\Models\COA::all()->pluck('DESKRIPSI', 'ID_COA')),
                        // Select::make('secondary_coa')
                        //     ->label('Kode Akun')
                        //     ->searchable()
                        //     ->required()
                        //     ->options(\App\Models\COA::all()->pluck('DESKRIPSI', 'ID_COA')),
                        TextInput::make('kredit')
                            ->label('Kredit')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                            ->required()
                            ->default($this->total + 0),
                        TextInput::make('keterangan')
                            ->placeholder('Keterangan')
                    ])
                    ->colStyles([
                        'primary_coa' => 'width: 450px;',
                    ])
                    ->label(' ')
                    ->maxItems(1)
                    ->columnSpan('full'),

                TableRepeater::make('debit_coa')
                    ->schema([
                        Select::make('secondary_coa')
                            ->label('Kode Akun')
                            ->searchable()
                            ->required()
                            ->options(\App\Models\COA::all()->pluck('DESKRIPSI', 'ID_COA')),
                        // Select::make('secondary_coa')
                        //     ->label('Kode Akun')
                        //     ->searchable()
                        //     ->required()
                        //     ->options(\App\Models\COA::all()->pluck('DESKRIPSI', 'ID_COA')),
                        TextInput::make('debit')
                            ->label('Debit')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('keterangan')
                            ->placeholder('Keterangan')
                    ])
                    ->colStyles([
                        'secondary_coa' => 'width: 450px;',
                    ])
                    ->label(' ')
                    // ->maxItems(1)
                    ->columnSpan('full'),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        // dd($this->form->getState()['kredit_coa']);
        foreach ($this->form->getState()['kredit_coa'] as $value) {
            JurnalUmum::create([
                'primary_coa' => $value['primary_coa'],
                'secondary_coa' => $value['primary_coa'],
                'kredit' => $value['kredit'],
                'debit' => 0,
                'tanggal' => Carbon::now('Asia/Jakarta'),
            ]);
        };

        foreach ($this->form->getState()['debit_coa'] as $value) {
            JurnalUmum::create([
                'primary_coa' => $value['primary_coa'],
                'secondary_coa' => $value['secondary_coa'],
                'kredit' => 0,
                'debit' => $value['debit'],
                'tanggal' => Carbon::now('Asia/Jakarta'),
            ]);
        };
    }

    public function render()
    {
        return view('livewire.bukti-kas-masuk.add-to-jurnal-umum');
    }
}
