<?php

namespace App\Filament\Keuangan\Resources\COAResource\Pages;

use App\Filament\Keuangan\Resources\COAResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCOA extends EditRecord
{
    protected static string $resource = COAResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
