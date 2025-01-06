<?php

namespace App\Filament\Keuangan\Resources\JurnalUmumResource\Pages;

use App\Filament\Keuangan\Resources\JurnalUmumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJurnalUmums extends ListRecords
{
    protected static string $resource = JurnalUmumResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
