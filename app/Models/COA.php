<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COA extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'COA';

    protected $primaryKey = 'id';

    protected $fillable = [
        'ID_COA',
        'DESKRIPSI',
    ];
}
