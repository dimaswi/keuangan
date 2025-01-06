<?php

namespace App\Filament\Keuangan\Resources\RawatInapResource\Pages;

use App\Filament\Keuangan\Resources\RawatInapResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRawatInaps extends ListRecords
{
    protected static string $resource = RawatInapResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
