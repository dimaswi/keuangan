<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FarmasiResource\Pages;
use App\Filament\Resources\FarmasiResource\RelationManagers;
use App\Models\COA;
use App\Models\Farmasi;
use App\Models\JurnalUmum;
use App\Models\Pendapatan;
use App\Models\Rincian;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class FarmasiResource extends Resource
{
    protected static ?string $model = Rincian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pendapatan Farmasi';

    protected static ?string $modelLabel = 'Pendapatan Farmasi ';

    protected static ?string $navigationParentItem = 'Pendapatan';

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
            ->recordUrl(
                function () {
                    return null;
                }
            )
            ->modifyQueryUsing(
                function (Builder $query): Builder {
                    return $query
                        ->leftJoin('inventory.harga_barang', 'inventory.harga_barang.ID', '=', 'pembayaran.rincian_tagihan.TARIF_ID')
                        ->leftJoin('inventory.barang', 'inventory.barang.ID', '=', 'inventory.harga_barang.BARANG')
                        ->leftJoin('pembayaran.tagihan', 'pembayaran.tagihan.ID', '=', 'pembayaran.rincian_tagihan.TAGIHAN')
                        ->select(
                            'pembayaran.rincian_tagihan.REF_ID as TAGIHAN',
                            'inventory.barang.NAMA as nama_tarif',
                            'pembayaran.rincian_tagihan.REF_ID as ref',
                            'pembayaran.rincian_tagihan.JUMLAH as jumlah',
                            'pembayaran.rincian_tagihan.TARIF as tarif',
                            'pembayaran.tagihan.TANGGAL as tanggal',
                        )
                        ->where('pembayaran.rincian_tagihan.COA', 0)
                        ->where('pembayaran.rincian_tagihan.JENIS', 4)
                        ->orderBy('pembayaran.rincian_tagihan.TAGIHAN', 'DESC');
                }
            )
            ->columns([
                TextColumn::make('nama_tarif')
                    ->label('Nama Tarif'),
                TextColumn::make('jumlah')
                    ->label('Jumlah'),
                TextColumn::make('tarif')
                    ->label('Tarif'),
                TextColumn::make('tanggal')
                    ->label('Tanggal'),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('tanggal_awal'),
                        DatePicker::make('tanggal_akhir'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_awal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('pembayaran.tagihan.TANGGAL', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_akhir'],
                                fn(Builder $query, $date): Builder => $query->whereDate('pembayaran.tagihan.TANGGAL', '<=', $date),
                            );
                    })
            ])
            ->actions([])
            ->bulkActions([
                BulkAction::make('coa')
                    ->label('Buat COA')
                    ->color('success')
                    ->icon('heroicon-o-paper-airplane')
                    ->form([
                        Select::make('coa')
                            ->label('NAMA AKUN')
                            ->options(COA::query()->pluck('DESKRIPSI', 'ID_COA'))
                            ->searchable()
                            ->required(),
                        TextInput::make('debit')
                            ->label('DEBIT')
                            ->numeric()
                            ->default(0),
                        TextInput::make('kredit')
                            ->label('KREDIT')
                            ->numeric()
                            ->default(
                                fn($livewire) => self::totalKredit($livewire->selectedTableRecords)
                            )
                    ])
                    ->action(function ($livewire, Array $data) { {
                            // dd($livewire->selectedTableRecords);
                            try {
                                foreach ($livewire->selectedTableRecords as $record) {
                                    // dd($record);
                                    DB::connection('simgos')
                                        ->table('rincian_tagihan')
                                        ->where('JENIS', 4)
                                        ->where('REF_ID', $record)
                                        ->update([
                                            'COA' => 1
                                        ]);
                                }

                                JurnalUmum::create([
                                    'kode_coa' => $data['coa'],
                                    'kredit' => $data['kredit'],
                                    'debit' => $data['debit'],
                                    'tanggal' => Carbon::now('Asia/Jakarta'),
                                ]);

                                Notification::make()
                                    ->title('Berhasil Disimpan!')
                                    ->success()
                                    ->send();

                                return redirect('/keuangan/farmasis');
                            } catch (\Throwable $th) {
                                Notification::make()
                                    ->title('Gagal Simpan!')
                                    ->body($th->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }
                    })
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
            'index' => Pages\ListFarmasis::route('/'),
        ];
    }

    public static function totalKredit(Array $data)
    {
        $total = array();
        foreach ($data as $record) {
            $data = DB::connection('simgos')
                ->table('rincian_tagihan')
                ->where('JENIS', 4)
                ->where('REF_ID', $record)
                ->first();

            $harga = $data->JUMLAH * $data->TARIF;

            array_push($total, $harga);
        }

        return array_sum($total);
    }
}
