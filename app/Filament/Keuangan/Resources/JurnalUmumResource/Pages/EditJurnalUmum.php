<?php

namespace App\Filament\Keuangan\Resources\JurnalUmumResource\Pages;

use App\Filament\Keuangan\Resources\JurnalUmumResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJurnalUmum extends EditRecord
{
    protected static string $resource = JurnalUmumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
