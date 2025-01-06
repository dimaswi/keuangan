<?php

namespace App\Filament\Keuangan\Resources\PendapatanPerPasienResource\Pages;

use App\Filament\Keuangan\Resources\PendapatanPerPasienResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPendapatanPerPasiens extends ListRecords
{
    protected static string $resource = PendapatanPerPasienResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
