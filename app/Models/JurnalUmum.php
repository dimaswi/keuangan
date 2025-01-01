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
        'primary_coa',
        'secondary_coa',
        'kredit',
        'debit',
        'tanggal',
        'keterangan'
    ];

    public function first_coa()
    {
        return $this->belongsTo(COA::class, 'primary_coa', 'ID_COA');
    }

    public function second_coa()
    {
        return $this->belongsTo(COA::class, 'secondary_coa', 'ID_COA');
    }
}
