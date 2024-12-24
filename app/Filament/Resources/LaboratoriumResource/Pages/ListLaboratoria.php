<?php

namespace App\Filament\Resources\LaboratoriumResource\Pages;

use App\Filament\Resources\LaboratoriumResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListLaboratoria extends ListRecords
{
    protected static string $resource = LaboratoriumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
            Action::make('coa')
            ->label('Buat COA')
            ->color('success')
            ->icon('heroicon-o-plus-circle')
        ];
    }
}
