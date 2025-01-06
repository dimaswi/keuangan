<?php

namespace App\Filament\Keuangan\Resources\FarmasiResource\Widgets;

use App\Filament\Keuangan\Resources\FarmasiResource\Pages\ListFarmasis;
use App\Models\Rincian;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class PendapatanFarmasi extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ListFarmasis::class;
    }
    protected function getStats(): array
    {
        return [
            // Stat::make('Pendapatan', $this->getPageTableQuery()->groupBy('master.ruangan.DESKRIPSI')->count()),
        ];
    }
}
