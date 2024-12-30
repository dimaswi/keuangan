<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaboratoriumResource\Pages;
use App\Filament\Resources\LaboratoriumResource\RelationManagers;
use App\Models\Laboratorium;
use App\Models\Pendapatan;
use App\Models\Rincian;
use App\Tables\Columns\Jangmed\PendapatanColumn;
use App\Tables\Columns\Jangmed\RuanganColumn;
use App\Tables\Columns\Jangmed\TotalColumn;
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

class LaboratoriumResource extends Resource
{
    protected static ?string $model = Rincian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pendapatan Laboratorium';

    protected static ?string $modelLabel = 'Pendapatan Laboratorium ';

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
                    $query
                    ->leftJoin('master.tarif_tindakan', 'pembayaran.rincian_tagihan.TARIF_ID', '=', 'master.tarif_tindakan.ID')
                    ->leftJoin('master.tindakan', 'master.tarif_tindakan.TINDAKAN', '=', 'master.tindakan.ID')
                    ->leftJoin('pembayaran.tagihan_pendaftaran', 'pembayaran.tagihan_pendaftaran.TAGIHAN', '=', 'pembayaran.rincian_tagihan.TAGIHAN')
                    ->leftJoin('pembayaran.tagihan', 'pembayaran.tagihan.ID', '=', 'pembayaran.rincian_tagihan.TAGIHAN')
                    ->leftJoin('pendaftaran.tujuan_pasien', 'pendaftaran.tujuan_pasien.NOPEN', '=', 'pembayaran.tagihan_pendaftaran.PENDAFTARAN')
                    // ->leftJoin('master.ruangan', 'master.ruangan.ID', '=', 'pendaftaran.tujuan_pasien.RUANGAN')
                    ->leftJoin('master.ruangan', 'master.ruangan.ID', '=', DB::raw("SUBSTR(pendaftaran.tujuan_pasien.RUANGAN,1,5)"))
                    ->leftJoin('pendaftaran.penjamin', 'pendaftaran.penjamin.NOPEN', '=', 'pembayaran.tagihan_pendaftaran.PENDAFTARAN')
                    ->select(
                        'pembayaran.rincian_tagihan.TAGIHAN as TAGIHAN',
                        'master.tindakan.NAMA as nama_tindakan',
                        'master.ruangan.DESKRIPSI as ruangan',
                        DB::raw("SUM(case when master.tindakan.JENIS = 8 then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as pendapatan"),
                        DB::raw("SUM(case when (pembayaran.rincian_tagihan.JENIS = 1 )  then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as karcis"),
                        DB::raw("SUM(case when (pendaftaran.penjamin.JENIS = 1 and master.tindakan.JENIS = 8 )  then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as umum"),
                        DB::raw("SUM(case when (pendaftaran.penjamin.JENIS = 2 and master.tindakan.JENIS = 8 )  then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as bpjs"),
                        DB::raw("SUM(case when (pendaftaran.penjamin.JENIS = 7 and master.tindakan.JENIS = 8 )  then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as asuransi_karyawan"),
                        DB::raw("SUM(case when (pendaftaran.penjamin.JENIS = 8 and master.tindakan.JENIS = 8 ) then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as jasa_raharja"),
                    )
                    ->whereIn('pembayaran.rincian_tagihan.JENIS', [1,3])
                    // ->where('master.tindakan.JENIS', 8)
                    ->where('pembayaran.tagihan.STATUS',2)
                    ->groupBy('master.ruangan.DESKRIPSI');
                    return $query;

                }
            )
            ->columns([
                RuanganColumn::make('rincian'),
                PendapatanColumn::make('pendapatan')->label(' '),
                TotalColumn::make('total')->label('Pendapatan'),
                // TextColumn::make('ruangan')
                //     ->label('Nama Ruangan'),
                // TextColumn::make('umum')
                //     ->money('IDR')
                //     ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                // TextColumn::make('bpjs')
                //     ->money('IDR')
                //     ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                // TextColumn::make('asuransi_karyawan')
                //     ->money('IDR')
                //     ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                // TextColumn::make('jasa_raharja')
                //     ->money('IDR')
                //     ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
                // TextColumn::make('pendapatan')
                //     ->label('Total Pendapatan')
                //     ->money('IDR')
                //     ->summarize(Sum::make()->label('Total Pendapatan')->money('IDR')),
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
            'index' => Pages\ListLaboratoria::route('/'),
            // 'create' => Pages\CreateLaboratorium::route('/create'),
            // 'edit' => Pages\EditLaboratorium::route('/{record}/edit'),
        ];
    }
}
