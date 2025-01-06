<?php

namespace App\Filament\Keuangan\Resources\RadiologiResource\Pages;

use App\Filament\Keuangan\Resources\RadiologiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRadiologi extends EditRecord
{
    protected static string $resource = RadiologiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
