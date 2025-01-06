<?php

namespace App\Filament\Keuangan\Resources\RawatInapResource\Pages;

use App\Filament\Keuangan\Resources\RawatInapResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRawatInap extends EditRecord
{
    protected static string $resource = RawatInapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
