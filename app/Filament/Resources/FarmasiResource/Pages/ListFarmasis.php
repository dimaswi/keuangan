<?php

namespace App\Filament\Resources\FarmasiResource\Pages;

use App\Filament\Resources\FarmasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFarmasis extends ListRecords
{
    protected static string $resource = FarmasiResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
