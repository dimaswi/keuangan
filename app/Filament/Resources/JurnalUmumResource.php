<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JurnalUmumResource\Pages;
use App\Filament\Resources\JurnalUmumResource\RelationManagers;
use App\Models\JurnalUmum;
use App\Tables\Columns\JurnalUmum\FirstCoaColumn;
use App\Tables\Columns\JurnalUmum\TanggalColumn;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class JurnalUmumResource extends Resource
{
    protected static ?string $model = JurnalUmum::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationLabel = 'Jurnal Umum';

    protected static ?string $modelLabel = 'Jurnal Umum ';

    protected static ?string $navigationGroup = 'Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->recordUrl(
                function () {
                    return false;
                }
            )
            ->modifyQueryUsing(
                function (Builder $query): Builder {
                    return $query->orderBy('tanggal', 'asc');

                }
            )
            ->columns([
                TanggalColumn::make('tanggal')
                    ->label('Tanggal'),
                FirstCoaColumn::make('first_coa.DESKRIPSI')
                    ->label('Nama Akun'),
                TextColumn::make('second_coa.DESKRIPSI')
                    ->label('Nama Akun'),
                TextColumn::make('debit')
                    ->money('IDR'),
                TextColumn::make('kredit')
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
            'index' => Pages\ListJurnalUmums::route('/'),
            'edit' => Pages\EditJurnalUmum::route('/{record}/edit'),
        ];
    }
}
