<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rincian extends Model
{
    use HasFactory;

    protected $connection = 'simgos';

    protected $table = 'rincian_tagihan';

    protected $primaryKey = 'TAGIHAN';
}
