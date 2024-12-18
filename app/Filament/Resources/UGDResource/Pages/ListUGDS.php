<?php

namespace App\Filament\Resources\UGDResource\Pages;

use App\Filament\Resources\UGDResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUGDS extends ListRecords
{
    protected static string $resource = UGDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
