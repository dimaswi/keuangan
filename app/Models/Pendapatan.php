<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    use HasFactory;

    protected $connection = 'simgos';

    protected $table = 'pembayaran_tagihan';

    protected $primaryKey = 'NOMOR';
}
