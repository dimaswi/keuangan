<?php

namespace App\Filament\Resources\FarmasiResource\Pages;

use App\Filament\Resources\FarmasiResource;
use App\Filament\Resources\FarmasiResource\Widgets\PendapatanFarmasi;
use App\Models\COA;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListFarmasis extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = FarmasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Action::make('tambah_coa')
            //     ->label('Tambah COA')
            //     ->icon('heroicon-o-plus-circle')
            //     ->color('success')
            //     ->form([
            //                 Select::make('coa')
            //                     ->label('NAMA AKUN')
            //                     ->options(COA::query()->pluck('DESKRIPSI', 'ID_COA'))
            //                     ->searchable()
            //                     ->required(),
            //                 TextInput::make('debit')
            //                     ->label('DEBIT')
            //                     ->numeric()
            //                     ->default(0),
            //                 TextInput::make('kredit')
            //                     ->label('KREDIT')
            //                     ->numeric()
            //                     ->default(0)
            //             ])
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // PendapatanFarmasi::class
        ];
    }
}
