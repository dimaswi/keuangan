<?php

namespace App\Filament\Keuangan\Resources\PendapatanResource\Pages;

use App\Filament\Keuangan\Resources\PendapatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPendapatan extends EditRecord
{
    protected static string $resource = PendapatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
