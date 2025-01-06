<?php

namespace App\Filament\Keuangan\Resources\UGDResource\Pages;

use App\Filament\Keuangan\Resources\UGDResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUGD extends EditRecord
{
    protected static string $resource = UGDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
