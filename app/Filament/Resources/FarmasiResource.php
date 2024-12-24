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
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            ->paginated(false)
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
                        ->leftJoin('pembayaran.tagihan_pendaftaran', 'pembayaran.tagihan_pendaftaran.TAGIHAN', '=', 'pembayaran.rincian_tagihan.TAGIHAN')
                        ->leftJoin('pendaftaran.tujuan_pasien', 'pendaftaran.tujuan_pasien.NOPEN', '=', 'pembayaran.tagihan_pendaftaran.PENDAFTARAN')
                        ->leftJoin('master.ruangan', 'master.ruangan.ID', '=', 'pendaftaran.tujuan_pasien.RUANGAN')
                        // ->leftJoin('master.ruangan', 'master.ruangan.ID', 'LIKE', DB::raw())
                        ->leftJoin('pendaftaran.penjamin', 'pendaftaran.penjamin.NOPEN', '=', 'pembayaran.tagihan_pendaftaran.PENDAFTARAN')
                        ->select(
                            'pembayaran.rincian_tagihan.REF_ID as TAGIHAN',
                            'inventory.barang.NAMA as nama_tarif',
                            'pembayaran.rincian_tagihan.REF_ID as ref',
                            'pembayaran.rincian_tagihan.JUMLAH as jumlah',
                            'pembayaran.rincian_tagihan.TARIF as tarif',
                            'pembayaran.tagihan.TANGGAL as tanggal',
                            'master.ruangan.DESKRIPSI as ruangan',
                            'master.ruangan.ID as id_ruangan',
                            DB::raw("SUM(pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF) as pendapatan"),
                            DB::raw("SUM(case when pendaftaran.penjamin.JENIS = 1 then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as umum"),
                            DB::raw("SUM(case when pendaftaran.penjamin.JENIS = 2 then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as bpjs"),
                            DB::raw("SUM(case when pendaftaran.penjamin.JENIS = 7 then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as asuransi_karyawan"),
                            DB::raw("SUM(case when pendaftaran.penjamin.JENIS = 8 then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as jasa_raharja"),
                            // DB::raw("SUM(case when master.ruangan.ID LIKE '%11102%' then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as irna"),
                            // DB::raw("SUM(case when master.ruangan.ID LIKE '%11103%' then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as igd"),
                            // DB::raw("SUM(case when master.ruangan.ID LIKE '%11101%' then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as irjas"),
                            // DB::raw("SUM(case when master.ruangan.ID LIKE '%11301%' then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as irjau"),
                        )
                        // ->where('pembayaran.rincian_tagihan.COA', 0)
                        ->where('pembayaran.rincian_tagihan.JENIS', 4)
                        ->where('pembayaran.tagihan.STATUS',2)
                        ->groupBy('master.ruangan.DESKRIPSI')
                        ->orderBy('master.ruangan.ID', 'DESC');
                }
            )
            ->columns([
                TextColumn::make('ruangan')
                    ->label('Ruangan'),
                TextColumn::make('pendapatan')
                    ->label('Pendapatan')
                    ->money('IDR')
                    ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                TextColumn::make('umum')
                    ->label('Umum')
                    ->money('IDR')
                    ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                TextColumn::make('bpjs')
                    ->label('BPJS')
                    ->money('IDR')
                    ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                TextColumn::make('asuransi_karyawan')
                    ->label('Karyawan')
                    ->money('IDR')
                    ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                TextColumn::make('jasa_raharja')
                    ->label('Jasa Raharja')
                    ->money('IDR')
                    ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                // TextColumn::make('igd')
                //     ->label('IGD')
                //     ->money('IDR'),
                // TextColumn::make('irjau')
                //     ->label('Rawat Jalan')
                //     ->getStateUsing(fn($record) => $record->irjau + $record->irjas)
                //     ->money('IDR'),
                // TextColumn::make('nama_tarif'),
                // TextColumn::make('jumlah'),
                // TextColumn::make('tarif'),
                // TextColumn::make('ruangan'),

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
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                        if ($data['tanggal_awal'] ?? null) {
                            $indicators['tanggal_awal'] = 'Order from ' . Carbon::parse($data['tanggal_awal'])->toFormattedDateString();
                        }
                        if ($data['tanggal_akhir'] ?? null) {
                            $indicators['tanggal_akhir'] = 'Order until ' . Carbon::parse($data['tanggal_akhir'])->toFormattedDateString();
                        }

                        return $indicators;
                    }),
            ])
            ->actions([
                // Action::make('add_coa')
                //     ->label('Tambah COA')
                //     ->color('success')
                //     ->icon('heroicon-o-plus-circle')
                //     ->action(function ($record) {
                //         // Add logging to see if this part is reached
                //         Log::info('Action triggered for record: ', ['record' => $record]);
                //         dd($record);
                //     })
            ])
            ->bulkActions([
                // BulkAction::make('coa')
                //     ->label('Buat COA')
                //     ->color('success')
                //     ->icon('heroicon-o-paper-airplane')
                //     ->form([
                //         Select::make('coa')
                //             ->label('NAMA AKUN')
                //             ->options(COA::query()->pluck('DESKRIPSI', 'ID_COA'))
                //             ->searchable()
                //             ->required(),
                //         TextInput::make('debit')
                //             ->label('DEBIT')
                //             ->numeric()
                //             ->default(0),
                //         TextInput::make('kredit')
                //             ->label('KREDIT')
                //             ->numeric()
                //             ->default(
                //                 fn($livewire) => self::totalKredit($livewire->selectedTableRecords)
                //             )
                //     ])
                //     ->action(function ($livewire, Array $data) { {
                //             dd($livewire->selectedTableRecords);
                //             try {
                //                 // foreach ($livewire->selectedTableRecords as $record) {
                //                     // // dd($record);
                //                     // DB::connection('simgos')
                //                     //     ->table('rincian_tagihan')
                //                     //     ->where('JENIS', 4)
                //                     //     ->where('REF_ID', $record)
                //                     //     ->update([
                //                     //         'COA' => 1
                //                     //     ]);
                //                 // }

                //                 JurnalUmum::create([
                //                     'kode_coa' => $data['coa'],
                //                     'kredit' => $data['kredit'],
                //                     'debit' => $data['debit'],
                //                     'tanggal' => Carbon::now('Asia/Jakarta'),
                //                 ]);

                //                 Notification::make()
                //                     ->title('Berhasil Disimpan!')
                //                     ->success()
                //                     ->send();

                //                 return redirect('/keuangan/farmasis');
                //             } catch (\Throwable $th) {
                //                 Notification::make()
                //                     ->title('Gagal Simpan!')
                //                     ->body($th->getMessage())
                //                     ->danger()
                //                     ->send();
                //             }
                //         }
                //     })
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

    public static function totalKredit(array $data)
    {

        return array_sum($data);
    }
}
