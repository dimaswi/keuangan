<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JurnalUmum extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'jurnal_umums';

    protected $fillable =
    [
        'kode_coa',
        'kredit',
        'debit',
        'periode_awal',
        'periode_akhir',
    ];

    public function coa()
    {
        return $this->belongsTo(COA::class, 'kode_coa', 'ID_COA');
    }
}
