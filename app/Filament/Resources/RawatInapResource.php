<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RawatInapResource\Pages;
use App\Filament\Resources\RawatInapResource\RelationManagers;
use App\Models\Pendapatan;
use App\Models\RawatInap;
use App\Models\Rincian;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class RawatInapResource extends Resource
{
    protected static ?string $model = Rincian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pendapatan Rawat Inap';

    protected static ?string $modelLabel = 'Pendapatan Rawat Inap ';

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
                        ->leftJoin('master.tarif_tindakan', 'pembayaran.rincian_tagihan.TARIF_ID', '=', 'master.tarif_tindakan.ID')
                        ->leftJoin('master.tindakan', 'master.tarif_tindakan.TINDAKAN', '=', 'master.tindakan.ID')
                        ->leftJoin('pembayaran.tagihan_pendaftaran', 'pembayaran.tagihan_pendaftaran.TAGIHAN', '=', 'pembayaran.rincian_tagihan.TAGIHAN')
                        ->leftJoin('pembayaran.tagihan', 'pembayaran.tagihan.ID', '=', 'pembayaran.rincian_tagihan.TAGIHAN')
                        ->leftJoin('pendaftaran.tujuan_pasien', 'pendaftaran.tujuan_pasien.NOPEN', '=', 'pembayaran.tagihan_pendaftaran.PENDAFTARAN')
                        // ->leftJoin('pendaftaran.penjamin', 'pendaftaran.penjamin.NOPEN', '=', 'pembayaran.tagihan_pendaftaran.PENDAFTARAN')
                        ->leftJoin('master.ruangan', 'master.ruangan.ID', '=', 'pendaftaran.tujuan_pasien.RUANGAN')
                        ->select(
                            'pembayaran.rincian_tagihan.TAGIHAN as TAGIHAN',
                            'pembayaran.rincian_tagihan.TARIF as tarif',
                            // 'master.tindakan.NAMA as nama_tindakan',
                            'master.ruangan.DESKRIPSI as ruangan',
                            DB::raw("SUM(pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF) as pendapatan"),
                            DB::raw("SUM(case when master.tindakan.NAMA LIKE '%VISITE %' then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as visite"),
                            DB::raw("SUM(case when master.tindakan.JENIS != 4 then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as jasa_pelayanan"),
                            DB::raw("SUM(case when pembayaran.rincian_tagihan.JENIS = 1 then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as karcis"),
                            // DB::raw("SUM(case when pendaftaran.penjamin.JENIS = 8 then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as jasa_raharja"),
                        )
                        ->whereIn('master.tindakan.JENIS', [0, 1, 2, 3, 4, 5, 6, 9, 10, 11])
                        ->whereIn('pembayaran.rincian_tagihan.JENIS', [1, 3])
                        // ->where(function($query) {
                        //     $query->where("pendaftaran.tujuan_pasien.RUANGAN", "LIKE", "%".'11103'."%")
                        //         ->orWhere("pendaftaran.tujuan_pasien.RUANGAN", "LIKE", "%".'11301'."%");
                        // })
                        ->where('pendaftaran.tujuan_pasien.RUANGAN', 'LIKE', '%' . '11102' . '%')
                        // ->orWhere('pendaftaran.tujuan_pasien.RUANGAN', 'LIKE', '%'.'11301'.'%');
                        ->groupBy('master.ruangan.DESKRIPSI')
                    ;
                }
            )
            ->columns([
                // TextColumn::make('TAGIHAN'),
                // TextColumn::make('nama_tindakan'),
                TextColumn::make('ruangan'),
                // TextColumn::make('tarif'),
                TextColumn::make('karcis')
                    ->money('IDR')
                    ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                TextColumn::make('visite')
                    ->money('IDR')
                    ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                TextColumn::make('jasa_pelayanan')
                    ->formatStateUsing(function ($state, Rincian $rincian) {
                        return 'IDR ' . number_format($rincian->jasa_pelayanan - $rincian->karcis) . '.00';
                    })
                    // ->money('IDR')
                    ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                TextColumn::make('pendapatan')
                    ->label('Total Pendapatan')
                    ->money('IDR')
                    ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListRawatInaps::route('/'),
            'create' => Pages\CreateRawatInap::route('/create'),
            'edit' => Pages\EditRawatInap::route('/{record}/edit'),
        ];
    }
}
