<?php

namespace App\Filament\Keuangan\Resources\LaboratoriumResource\Pages;

use App\Filament\Keuangan\Resources\LaboratoriumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaboratorium extends EditRecord
{
    protected static string $resource = LaboratoriumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
