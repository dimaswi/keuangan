<?php

namespace App\Filament\Keuangan\Resources\RawatJalanResource\Pages;

use App\Filament\Keuangan\Resources\RawatJalanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRawatJalan extends EditRecord
{
    protected static string $resource = RawatJalanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
