<?php

namespace App\Filament\Resources\UGDResource\Pages;

use App\Filament\Resources\UGDResource;
use App\Models\COA;
use App\Models\JurnalUmum;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListUGDS extends ListRecords
{
    protected static string $resource = UGDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Action::make('buat_coa')
                ->label('Buat COA')
                ->color('success')
                ->icon('heroicon-o-plus-circle')
                ->form([
                    Select::make('id_coa')
                        ->label('NAMA AKUN')
                        ->options(COA::query()->pluck('DESKRIPSI', 'ID_COA'))
                        ->searchable()
                        ->required(),
                    TextInput::make('debit')
                        ->label('DEBIT')
                        ->numeric()
                        ->placeholder('Debit')
                        ->default(0)
                        ->required(),
                    TextInput::make('kredit')
                        ->label('KREDIT')
                        ->numeric()
                        ->default(0)
                        ->placeholder('Kredit')
                        ->required(),
                    DatePicker::make('periode_awal')
                        ->label('PERIODE AWAL')
                        ->required(),
                    DatePicker::make('periode_akhir')
                        ->label('PERIODE AKHIR')
                        ->required(),
                    TextInput::make('keterangan')
                        ->label('KETERANGAN')
                        ->placeholder('Keterangan'),
                ])
                ->action(
                    function (array $data) {
                        $data_jurnal = JurnalUmum::where('periode_awal', '>=', $data['periode_awal'])
                            ->where('periode_awal', '<=', $data['periode_akhir'])
                            ->where('kode_coa', $data['id_coa'])
                            ->get();

                        if ($data_jurnal->count() > 0) {
                            Notification::make()
                                ->title('Gagal!!')
                                ->body('Data pada tanggal tersebut sudah ada')
                                ->danger()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Berhasil')
                                ->body('Data berhasil ditambahkan ke jurnal umum')
                                ->success()
                                ->send();

                            JurnalUmum::create([
                                'kode_coa' => $data['id_coa'],
                                'debit' => $data['debit'],
                                'kredit' => $data['kredit'],
                                'periode_awal' => $data['periode_awal'],
                                'periode_akhir' => $data['periode_akhir'],
                                'keterangan' => $data['keterangan'],
                            ]);
                        }


                    }
                )
        ];
    }
}
