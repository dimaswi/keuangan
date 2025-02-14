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
use Filament\Notifications\Notification;
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
                        DatePicker::make('tanggal')
                            ->label('Tanggal')
                            ->required(),
                        TextInput::make('keterangan')
                            ->placeholder('Keterangan')
                    ])
                    ->colStyles([
                        'primary_coa' => 'width: 450px;',
                    ])
                    ->label(' ')
                    ->maxItems(1)
                    ->columnSpan('full'),

                // TableRepeater::make('debit_coa')
                //     ->schema([
                //         Select::make('secondary_coa')
                //             ->label('Kode Akun')
                //             ->searchable()
                //             ->required()
                //             ->options(\App\Models\COA::all()->pluck('DESKRIPSI', 'ID_COA')),
                //         // Select::make('secondary_coa')
                //         //     ->label('Kode Akun')
                //         //     ->searchable()
                //         //     ->required()
                //         //     ->options(\App\Models\COA::all()->pluck('DESKRIPSI', 'ID_COA')),
                //         TextInput::make('debit')
                //             ->label('Debit')
                //             ->mask(RawJs::make('$money($input)'))
                //             ->stripCharacters(',')
                //             ->numeric()
                //             ->default(0)
                //             ->required(),
                //         TextInput::make('keterangan')
                //             ->placeholder('Keterangan')
                //     ])
                //     ->colStyles([
                //         'secondary_coa' => 'width: 450px;',
                //     ])
                //     ->label(' ')
                //     // ->maxItems(1)
                //     ->columnSpan('full'),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        try {
            $primary_coa = JurnalUmum::where('primary_coa', $this->form->getState()['kredit_coa'][0]['primary_coa'])
                ->whereDate('tanggal', $this->form->getState()['kredit_coa'][0]['tanggal'])
                ->first();

            if ($primary_coa) {
                Notification::make()
                    ->title('Data kredit sudah ada dalam jurnal!')
                    ->body('Silahkan cek menu jurnal umum untuk menambahkan data debit secara manual!')
                    ->danger()
                    ->send();
                $this->dispatch('close-modal', id: 'modal-coa');
            } else {
                JurnalUmum::create([
                    'primary_coa' => $this->form->getState()['kredit_coa'][0]['primary_coa'],
                    'secondary_coa' => $this->form->getState()['kredit_coa'][0]['primary_coa'],
                    'kredit' =>  $this->form->getState()['kredit_coa'][0]['kredit'],
                    'debit' => 0,
                    'tanggal' => $this->form->getState()['kredit_coa'][0]['tanggal'],
                ]);
                // foreach ($this->form->getState()['debit_coa'] as $key => $value) {
                //     $available_coa_date = JurnalUmum::with('second_coa')->where('primary_coa', $this->form->getState()['kredit_coa'][0]['primary_coa'])
                //         ->where('secondary_coa', $value['secondary_coa'])
                //         ->whereDate('tanggal', $this->form->getState()['kredit_coa'][0]['tanggal'])
                //         ->select('secondary_coa')
                //         ->first();

                //     if ($available_coa_date) {
                //         Notification::make()
                //             ->title('Data debit sudah ada dalam jurnal!')
                //             ->body('Data ke-' . $key + 1 . ' dengan nama debit ' . $available_coa_date->second_coa->DESKRIPSI . ' sudah ada dalam data, silahkan cek dan tambahkan secara manual pada menu jurnal umum!')
                //             ->danger()
                //             ->send();

                //         $this->dispatch('close-modal', id: 'modal-coa');
                //     } else {
                //         JurnalUmum::create([
                //             'primary_coa' => $this->form->getState()['kredit_coa'][0]['primary_coa'],
                //             'secondary_coa' => $value['secondary_coa'],
                //             'kredit' => 0,
                //             'debit' => $value['debit'],
                //             'tanggal' => $this->form->getState()['kredit_coa'][0]['tanggal'],
                //         ]);
                //     }
                // }
                Notification::make()
                    ->title('Berhasil ditambahkan!)')
                    ->body('Data kredit/denit berhasil ditambahkan ke dalam jurnal umum')
                    ->success()
                    ->send();

                $this->dispatch('close-modal', id: 'modal-coa');
            }
        } catch (\Throwable $th) {
            Notification::make()
                ->title('Gagal!)')
                ->body($th->getMessage())
                ->danger()
                ->send();
        }
    }

    public function render()
    {
        return view('livewire.bukti-kas-masuk.add-to-jurnal-umum');
    }
}
