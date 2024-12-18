<?php

namespace App\Filament\Resources\COAResource\Pages;

use App\Filament\Resources\COAResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCOAS extends ListRecords
{
    protected static string $resource = COAResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
