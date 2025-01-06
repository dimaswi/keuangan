<?php

namespace App\Filament\Keuangan\Resources\FarmasiResource\Pages;

use App\Filament\Keuangan\Resources\FarmasiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFarmasi extends EditRecord
{
    protected static string $resource = FarmasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
