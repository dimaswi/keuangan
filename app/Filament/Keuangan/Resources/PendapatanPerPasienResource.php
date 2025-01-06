<?php

namespace App\Filament\Keuangan\Resources;

use App\Filament\Keuangan\Resources\PendapatanPerPasienResource\Pages;
use App\Filament\Keuangan\Resources\PendapatanPerPasienResource\RelationManagers;
use App\Models\Pendapatan;
use App\Models\PendapatanPerPasien;
use App\Models\Rincian;
use App\Tables\Columns\PerPasien\AdministrasiColumn;
use App\Tables\Columns\PerPasien\DokterColumn;
use App\Tables\Columns\PerPasien\LaboratoriumColumn;
use App\Tables\Columns\PerPasien\ObatColumn;
use App\Tables\Columns\PerPasien\ParamedisColumn;
use App\Tables\Columns\PerPasien\RadiologiColumn;
use App\Tables\Columns\PerPasien\SaranaColumn;
use App\Tables\Columns\PerPasien\SaranaTotalColumn;
use App\Tables\Columns\PerPasien\TindakanColumn;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class PendapatanPerPasienResource extends Resource
{
    protected static ?string $model = Rincian::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pendapatan Per Pasien';

    protected static ?string $modelLabel = 'Pendapatan Per Pasien ';

    protected static ?string $navigationParentItem = 'Pendapatan';

    protected static ?string $navigationGroup = 'Keuangan';

    // protected static ?int $navigationSort = 1;

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
                        ->leftJoin('pembayaran.tagihan', 'pembayaran.tagihan.ID', '=', 'pembayaran.rincian_tagihan.TAGIHAN')
                        ->leftJoin('master.pasien', 'master.pasien.NORM', '=', 'pembayaran.tagihan.REF')
                        ->leftJoin('pembayaran.tagihan_pendaftaran', 'pembayaran.rincian_tagihan.TAGIHAN', '=', 'pembayaran.tagihan_pendaftaran.TAGIHAN')
                        ->leftJoin('pendaftaran.tujuan_pasien', 'pendaftaran.tujuan_pasien.NOPEN', '=', 'pembayaran.tagihan_pendaftaran.PENDAFTARAN')
                        ->leftJoin('master.tarif_administrasi', function ($join) {
                            $join->on('pembayaran.rincian_tagihan.TARIF_ID', 'master.tarif_administrasi.ID')
                                ->where('pembayaran.rincian_tagihan.JENIS', 1);
                        })
                        // ->leftJoin('master.administrasi', function ($join) {
                        //     $join->on('master.tarif_administrasi.ADMINISTRASI', 'master.administrasi.ID')
                        //         ->where('pembayaran.rincian_tagihan.JENIS', 1);
                        // })
                        ->leftJoin('master.tarif_ruang_rawat', function ($join) {
                            $join->on('pembayaran.rincian_tagihan.TARIF_ID', 'master.tarif_ruang_rawat.ID')
                                ->where('pembayaran.rincian_tagihan.JENIS', 2);
                        })
                        ->leftJoin('master.tarif_tindakan', function ($join) {
                            $join->on('pembayaran.rincian_tagihan.TARIF_ID', 'master.tarif_tindakan.ID')
                                ->where('pembayaran.rincian_tagihan.JENIS', 3);
                        })
                        ->leftJoin('master.tindakan', function ($join) {
                            $join->on('master.tarif_tindakan.TINDAKAN', 'master.tindakan.ID')
                                ->where('pembayaran.rincian_tagihan.JENIS', 3);
                        })
                        ->leftJoin('inventory.harga_barang', function ($join) {
                            $join->on('pembayaran.rincian_tagihan.TARIF_ID', 'inventory.harga_barang.ID')
                                ->where('pembayaran.rincian_tagihan.JENIS', 4);
                        })
                        // ->leftJoin('inventory.barang', function ($join) {
                        //     $join->on('inventory.harga_barang.BARANG', 'inventory.barang.ID')
                        //         ->where('pembayaran.rincian_tagihan.JENIS', 4);
                        // })
                        ->leftJoin('master.tarif_o2', function ($join) {
                            $join->on('pembayaran.rincian_tagihan.TARIF_ID', 'master.tarif_o2.ID')
                                ->where('pembayaran.rincian_tagihan.JENIS', 6);
                        })
                        ->select(
                            'pembayaran.rincian_tagihan.TAGIHAN',
                            'master.pasien.NAMA as pasien',
                            DB::raw("SUM(case when pembayaran.rincian_tagihan.JENIS = 1  then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as tarif_administrasi"),
                            DB::raw("SUM(case when pembayaran.rincian_tagihan.JENIS = 2  then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as tarif_ruang_rawat"),
                            DB::raw("SUM(case when pembayaran.rincian_tagihan.JENIS = 4  then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as tarif_obat"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 7  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.SARANA end) as tarif_radiologi_sarana"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 7  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.BHP end) as tarif_radiologi_bhp"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 7  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.DOKTER_OPERATOR end) as tarif_radiologi_dokter_operator"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 7  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.DOKTER_ANASTESI end) as tarif_radiologi_dokter_anastesi"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 7  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.DOKTER_LAINNYA end) as tarif_radiologi_dokter_lainnya"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 7  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.PENATA_ANASTESI end) as tarif_radiologi_penata_anastesi"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 7  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.PARAMEDIS end) as tarif_radiologi_paramedis"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 7  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.NON_MEDIS end) as tarif_radiologi_non_medis"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 8  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.SARANA end) as tarif_laboratorium_sarana"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 8  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.BHP end) as tarif_laboratorium_bhp"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 8  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.DOKTER_OPERATOR end) as tarif_laboratorium_dokter_operator"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 8  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.DOKTER_ANASTESI end) as tarif_laboratorium_dokter_anastesi"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 8  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.DOKTER_LAINNYA end) as tarif_laboratorium_dokter_lainnya"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 8  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.PENATA_ANASTESI end) as tarif_laboratorium_penata_anastesi"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 8  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.PARAMEDIS end) as tarif_laboratorium_paramedis"),
                            DB::raw("SUM(case when master.tindakan.JENIS = 8  then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.NON_MEDIS end) as tarif_laboratorium_non_medis"),
                            DB::raw("SUM(case when ( master.tindakan.JENIS != 7 and master.tindakan.JENIS != 8 ) then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.SARANA end) as tarif_tindakan_sarana"),
                            DB::raw("SUM(case when ( master.tindakan.JENIS != 7 and master.tindakan.JENIS != 8 ) then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.BHP end) as tarif_tindakan_bhp"),
                            DB::raw("SUM(case when ( master.tindakan.JENIS != 7 and master.tindakan.JENIS != 8 ) then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.DOKTER_OPERATOR end) as tarif_tindakan_dokter_operator"),
                            DB::raw("SUM(case when ( master.tindakan.JENIS != 7 and master.tindakan.JENIS != 8 ) then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.DOKTER_ANASTESI end) as tarif_tindakan_dokter_anastesi"),
                            DB::raw("SUM(case when ( master.tindakan.JENIS != 7 and master.tindakan.JENIS != 8 ) then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.DOKTER_LAINNYA end) as tarif_tindakan_dokter_lainnya"),
                            DB::raw("SUM(case when ( master.tindakan.JENIS != 7 and master.tindakan.JENIS != 8 ) then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.PENATA_ANASTESI end) as tarif_tindakan_penata_anastesi"),
                            DB::raw("SUM(case when ( master.tindakan.JENIS != 7 and master.tindakan.JENIS != 8 ) then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.PARAMEDIS end) as tarif_tindakan_paramedis"),
                            DB::raw("SUM(case when ( master.tindakan.JENIS != 7 and master.tindakan.JENIS != 8 ) then pembayaran.rincian_tagihan.JUMLAH * master.tarif_tindakan.NON_MEDIS end) as tarif_tindakan_non_medis"),
                        )
                        ->groupBy('pembayaran.rincian_tagihan.TAGIHAN')
                    ;
                }
            )
            ->columns([
                TextColumn::make('pasien'),
                AdministrasiColumn::make('karcis'),
                SaranaColumn::make('sarana'),
                ObatColumn::make('obat')->label('BHP'),
                DokterColumn::make('dokter'),
                ParamedisColumn::make('paramedis'),
            ])
            ->contentFooter(
                view('tables.columns.per-pasien.footer')
            )
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('tanggal_awal')->default(Carbon::now('Asia/Jakarta')),
                        DatePicker::make('tanggal_akhir'),
                        Select::make('ruangan')->options([
                            '11103' => 'Instalasi Gawat Darurat',
                            '11102' => 'Rawat Inap',
                            '113010101' => 'Poli Umum',
                            '111010401' => 'Poli Spesialis Penyakit Dalam',
                            '111010501' => 'Poli Spesialis Anak',
                            '111010601' => 'Poli Spesialis Bedah',
                            '111010701' => 'Poli Spesialis Kandungan',
                            '11201' => 'Laboratorium',
                            '11202' => 'Radiologi',
                            // Add your ruangan options here
                        ])
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
                            )
                            ->when(
                                $data['ruangan'],
                                fn(Builder $query, $ruangan): Builder => $query->where('pendaftaran.tujuan_pasien.RUANGAN' ,'LIKE', '%'.$ruangan.'%'),
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
            'index' => Pages\ListPendapatanPerPasiens::route('/'),
        ];
    }
}
