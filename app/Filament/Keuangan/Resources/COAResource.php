<?php

namespace App\Filament\Keuangan\Resources;

use App\Filament\Keuangan\Resources\COAResource\Pages;
use App\Filament\Keuangan\Resources\COAResource\RelationManagers;
use App\Models\COA;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class COAResource extends Resource
{
    protected static ?string $model = COA::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Master COA';

    protected static ?string $modelLabel = 'COA ';

    protected static ?string $navigationGroup = 'Master';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('ID_COA')
                        ->label('Kode COA')
                        ->numeric()
                        ->required(),
                    TextInput::make('DESKRIPSI')
                        ->label('Nama COA')
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ID_COA')
                    ->label('KODE')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('DESKRIPSI')
                    ->label('NAMA')
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([

            ]);
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
            'index' => Pages\ListCOAS::route('/'),
            'create' => Pages\CreateCOA::route('/create'),
            'edit' => Pages\EditCOA::route('/{record}/edit'),
        ];
    }
}
