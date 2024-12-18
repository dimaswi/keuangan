<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendapatanResource\Pages;
use App\Filament\Resources\PendapatanResource\RelationManagers;
use App\Models\Pendapatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class PendapatanResource extends Resource
{
    protected static ?string $model = Pendapatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Pendapatan';

    protected static ?string $modelLabel = 'Data Pendapatan ';

    protected static ?string $navigationGroup = 'Keuangan';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(
                function (Builder $query): Builder {
                    return $query->join('pembayaran.tagihan', 'pembayaran.tagihan.ID', '=', 'pembayaran.pembayaran_tagihan.TAGIHAN')
                        ->join('master.pasien', 'master.pasien.NORM', '=', 'pembayaran.tagihan.REF')
                        ->select(
                            'pembayaran.pembayaran_tagihan.NOMOR as NOMOR',
                            'master.pasien.NAMA as nama',
                            'master.pasien.NORM as rekam_medis',
                            'pembayaran.pembayaran_tagihan.TOTAL as total',
                        )
                        ->where('pembayaran.pembayaran_tagihan.COA', 0)
                        ->orderBy('pembayaran.tagihan.TANGGAL', 'DESC');
                }
            )
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Pasien'),
                TextColumn::make('rekam_medis')
                    ->label('Nomor Rekam Medis'),
                TextColumn::make('total')
                    ->label('Tagihan')
                    ->money('IDR'),

            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPendapatans::route('/'),
        ];
    }
}
