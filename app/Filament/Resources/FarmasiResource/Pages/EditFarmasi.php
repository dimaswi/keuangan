<?php

namespace App\Filament\Resources\FarmasiResource\Pages;

use App\Filament\Resources\FarmasiResource;
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
