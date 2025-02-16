<?php

namespace App\Filament\Keuangan\Resources;

use App\Filament\Keuangan\Resources\PendapatanPerPasienResource\Pages;
use App\Filament\Keuangan\Resources\PendapatanPerPasienResource\RelationManagers;
use App\Models\Pendapatan;
use App\Models\PendapatanPerPasien;
use App\Models\Rincian;
use App\Models\User;
use App\Tables\Columns\PerPasien\AdministrasiColumn;
use App\Tables\Columns\PerPasien\DokterColumn;
use App\Tables\Columns\PerPasien\LaboratoriumColumn;
use App\Tables\Columns\PerPasien\ObatColumn;
use App\Tables\Columns\PerPasien\ParamedisColumn;
use App\Tables\Columns\PerPasien\RadiologiColumn;
use App\Tables\Columns\PerPasien\SaranaColumn;
use App\Tables\Columns\PerPasien\SaranaTotalColumn;
use App\Tables\Columns\PerPasien\TindakanColumn;
use App\Tables\Columns\PerPasien\TotalColumn;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class PendapatanPerPasienResource extends Resource
{
    protected static ?string $model = Rincian::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Bukti Kas Masuk';

    protected static ?string $modelLabel = 'Bukti Kas Masuk ';

    // protected static ?string $navigationParentItem = 'Bukti Kas Masuk';

    protected static ?string $navigationGroup = 'Keuangan';

    protected static ?int $navigationSort = 2;

    public $karcis;

    public $form_coa = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $transaksi_kasir = DB::connection('simgos')
            ->table('transaksi_kasir')
            ->where('TUTUP', '!=', null)
            ->latest('BUKA')
            ->first();

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
                        ->leftJoin('master.ruangan', 'pendaftaran.tujuan_pasien.RUANGAN', '=', 'master.ruangan.ID')
                        ->join('pembayaran.pembayaran_tagihan', 'pembayaran.rincian_tagihan.TAGIHAN', '=', 'pembayaran.pembayaran_tagihan.TAGIHAN')
                        ->leftJoin('master.tarif_administrasi', function ($join) {
                            $join->on('pembayaran.rincian_tagihan.TARIF_ID', 'master.tarif_administrasi.ID')
                                ->where('pembayaran.rincian_tagihan.JENIS', 1);
                        })
                        ->leftJoin('layanan.tindakan_medis', function ($join) {
                            $join->on('pembayaran.rincian_tagihan.REF_ID', 'layanan.tindakan_medis.ID')
                                ->where('pembayaran.rincian_tagihan.JENIS', 3);
                        })
                        ->leftJoin('pendaftaran.kunjungan', function ($join) {
                            $join->on('layanan.tindakan_medis.KUNJUNGAN', 'pendaftaran.kunjungan.NOMOR')
                                ->where('pembayaran.rincian_tagihan.JENIS', 3);
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
                        ->leftJoin('transaksi_kasir', 'transaksi_kasir.NOMOR', '=', 'pembayaran.pembayaran_tagihan.TRANSAKSI_KASIR_NOMOR')
                        ->leftJoin('aplikasi.pengguna', 'pembayaran.transaksi_kasir.KASIR', '=', 'aplikasi.pengguna.ID')
                        ->leftJoin('master.tarif_o2', function ($join) {
                            $join->on('pembayaran.rincian_tagihan.TARIF_ID', 'master.tarif_o2.ID')
                                ->where('pembayaran.rincian_tagihan.JENIS', 6);
                        })
                        ->select(
                            'pembayaran.rincian_tagihan.TAGIHAN',
                            'master.pasien.NAMA as pasien',
                            'aplikasi.pengguna.NAMA as nama_kasir',
                            'pembayaran.transaksi_kasir.TOTAL as penerimaan_kasir',
                            // 'pembayaran.pembayaran_tagihan.TANGGAL as tanggal_penerimaan_kasir',
                            'pembayaran.tagihan.TOTAL as total_tagihan',
                            'master.ruangan.ID as ruangan',
                            DB::raw("SUM(case when ( pembayaran.rincian_tagihan.JENIS = 3 and pendaftaran.kunjungan.RUANGAN LIKE '%11103%' ) then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as tindakan_ugd_ranap"),
                            DB::raw("SUM(case when ( pembayaran.rincian_tagihan.JENIS = 1 and pembayaran.rincian_tagihan.TARIF_ID = 24 ) then pembayaran.rincian_tagihan.JUMLAH * pembayaran.rincian_tagihan.TARIF end) as administrasi_ugd_ranap"),
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
                        // ->where('pembayaran.rincian_tagihan.TAGIHAN', 2501160016)
                        // ->where('pembayaran.rincian_tagihan.TAGIHAN', 2501160029)
                        ->where('pembayaran.tagihan_pendaftaran.UTAMA', 1)
                        // ->where('pembayaran.tagihan.STATUS', 2)
                        // ->groupBy('pembayaran.rincian_tagihan.TAGIHAN')
                        ->groupBy('nama_kasir')
                    ;
                }
            )
            ->columns([
                // TextColumn::make('TAGIHAN'),
                TextColumn::make('nama_kasir'),
                // TextColumn::make('tanggal_penerimaan_kasir'),
                // // TextColumn::make('pasien'),
                // AdministrasiColumn::make('karcis'),
                // SaranaColumn::make('sarana'),
                // ObatColumn::make('obat')->label('BHP'),
                // DokterColumn::make('dokter'),
                // ParamedisColumn::make('paramedis'),
                TextColumn::make('total_tagihan')
                    ->formatStateUsing(
                        fn(Rincian $record) => 'Rp. ' . number_format(
                            $record->tarif_ruang_rawat +
                                $record->tarif_radiologi_sarana +
                                $record->tarif_laboratorium_sarana +
                                $record->tarif_tindakan_sarana +
                                $record->tarif_administrasi +
                                $record->tarif_radiologi_penata_anastesi +
                                $record->tarif_radiologi_paramedis +
                                $record->tarif_radiologi_non_medis +
                                $record->tarif_laboratorium_penata_anastesi +
                                $record->tarif_laboratorium_paramedis +
                                $record->tarif_laboratorium_dokter_non_medis +
                                $record->tarif_tindakan_penata_anastesi +
                                $record->tarif_tindakan_paramedis +
                                $record->tarif_tindakan_dokter_non_medis +
                                $record->tarif_radiologi_dokter_operator +
                                $record->tarif_radiologi_dokter_anastesi +
                                $record->tarif_radiologi_lainnya +
                                $record->tarif_laboratorium_dokter_operator +
                                $record->tarif_laboratorium_dokter_anastesi +
                                $record->tarif_laboratorium_dokter_lainnya +
                                $record->tarif_tindakan_dokter_operator +
                                $record->tarif_tindakan_dokter_anastesi +
                                $record->tarif_tindakan_dokter_lainnya +
                                $record->tarif_obat +
                                $record->tarif_radiologi_bhp +
                                $record->tarif_laboratorium_bhp +
                                $record->tarif_tindakan_bhp
                        )
                    ),
                TextColumn::make('penerimaan_kasir')
                    ->formatStateUsing(
                        fn(Rincian $record) => 'Rp. ' . number_format($record->penerimaan_kasir)
                    ),
            ])
            ->contentFooter(
                view('tables.columns.per-pasien.footer')
            )
            ->filters([
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('tanggal_awal')->default(Carbon::now('Asia/Jakarta')),
                        DatePicker::make('tanggal_akhir'),
                        // Select::make('shift')
                        //     ->default(
                        //         $transaksi_kasir->NOMOR
                        //     )
                        //     ->options(
                        //         DB::connection('simgos')
                        //             ->table('transaksi_kasir')
                        //             ->leftJoin('aplikasi.pengguna', 'pembayaran.transaksi_kasir.KASIR', '=', 'aplikasi.pengguna.ID')
                        //             // ->get()
                        //             ->where('pembayaran.transaksi_kasir.STATUS', 2)
                        //             ->orderBy('pembayaran.transaksi_kasir.BUKA', 'desc')
                        //             ->limit(10)
                        //             ->pluck('aplikasi.pengguna.NAMA', 'pembayaran.transaksi_kasir.NOMOR')
                        //     ),
                        // Select::make('ruangan')->options([
                        //     '11103' => 'Instalasi Gawat Darurat',
                        //     '11102' => 'Rawat Inap',
                        //     '113010101' => 'Poli Umum',
                        //     '111010401' => 'Poli Spesialis Penyakit Dalam',
                        //     '111010501' => 'Poli Spesialis Anak',
                        //     '111010601' => 'Poli Spesialis Bedah',
                        //     '111010701' => 'Poli Spesialis Kandungan',
                        //     '11201' => 'Laboratorium',
                        //     '11202' => 'Radiologi',
                        //     // Add your ruangan options here
                        // ])
                    ])->columns(3)
                    ->query(function (Builder $query, array $data): Builder {

                        // $data_shift = DB::connection('simgos')
                        //     ->table('transaksi_kasir')
                        //     ->where('pembayaran.transaksi_kasir.NOMOR', $data['shift'])
                        //     ->first();

                        // dd($data_shift);

                        return $query
                            ->when(
                                $data['tanggal_awal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('pembayaran.pembayaran_tagihan.TANGGAL', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_akhir'],
                                fn(Builder $query, $date): Builder => $query->whereDate('pembayaran.pembayaran_tagihan.TANGGAL', '<=', $date),
                            );
                            // ->when(
                            //     $data['shift'],
                            //     fn(Builder $query, $shift): Builder => $query->whereBetween('pembayaran.pembayaran_tagihan.TANGGAL', [$data_shift->BUKA, $data_shift->TUTUP])
                            // )
                            // ->when(
                            //     $data['ruangan'],
                            //     fn(Builder $query, $ruangan): Builder => $query->where('pendaftaran.tujuan_pasien.RUANGAN', 'LIKE', '%' . $ruangan . '%'),
                            // );
                    })
                // ->indicateUsing(function (array $data): array {
                //     $indicators = [];
                //     if ($data['tanggal_awal'] ?? null) {
                //         $indicators['tanggal_awal'] = 'Order from ' . Carbon::parse($data['tanggal_awal'])->toFormattedDateString();
                //     }
                //     if ($data['tanggal_akhir'] ?? null) {
                //         $indicators['tanggal_akhir'] = 'Order until ' . Carbon::parse($data['tanggal_akhir'])->toFormattedDateString();
                //     }

                //     return $indicators;
                // }),

            ], layout: FiltersLayout::AboveContent)
            ->filtersFormColumns(1)
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
