<?php

namespace App\Filament\Keuangan\Resources;

use App\Filament\Keuangan\Resources\JurnalUmumResource\Pages;
use App\Filament\Keuangan\Resources\JurnalUmumResource\RelationManagers;
use App\Models\COA;
use App\Models\JurnalUmum;
use App\Tables\Columns\Keuangan\JurnalUmum\FirstCoaColumn;
use App\Tables\Columns\Keuangan\JurnalUmum\SecondCoaColumn;
use App\Tables\Columns\Keuangan\JurnalUmum\TanggalColumn;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
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

    protected static ?int $navigationSort = 3;

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
                SecondCoaColumn::make('second_coa.DESKRIPSI')
                    ->label('Nama Akun'),
                TextColumn::make('debit')
                    ->money('IDR'),
                TextColumn::make('kredit')
                    ->money('IDR'),
            ])
            ->contentFooter(
                view('tables.columns.keuangan.jurnal-umum.footer')
            )
            ->filters([
                //
            ])
            ->actions([
                DeleteAction::make(),
                Action::make('tambah')
                    ->label('Tambah')
                    ->color('success')
                    ->icon('heroicon-o-plus-circle')
                    ->form([
                        Select::make('secondary_coa')
                            ->label('Jurnal Umum')
                            ->live()
                            ->searchable()
                            ->options(
                                COA::all()->pluck('DESKRIPSI', 'ID_COA')
                            )
                            ->required(),
                        TextInput::make('debit')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->placeholder('Masukan Nominal Debit')
                            ->numeric(),
                        DatePicker::make('tanggal')
                            ->required()
                    ])
                    ->hidden(
                        function (JurnalUmum $record) {
                            return $record->primary_coa != $record->secondary_coa;
                        }
                    )
                    ->action(
                        function (array $data, JurnalUmum $record) {
                            try {
                                JurnalUmum::create([
                                    'primary_coa' => $record->primary_coa,
                                    'secondary_coa' => $data['secondary_coa'],
                                    'kredit' => 0,
                                    'debit' => $data['debit'],
                                    'tanggal' => $data['tanggal'],
                                ]);

                                Notification::make()
                                    ->title('Berhasil Ditambahkan!')
                                    ->body('Data jurnal umum berhasil ditambahkan!')
                                    ->success()
                                    ->send();
                            } catch (\Throwable $th) {
                                Notification::make()
                                    ->title('Gagal!')
                                    ->body($th->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }
                    )
            ])
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
