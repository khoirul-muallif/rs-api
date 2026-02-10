<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar'; // pakai nama asli (tanpa "s")
    protected $primaryKey = 'kd_kamar';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // penting
    protected $fillable = [
        'kd_kamar',
        'kd_bangsal',
        'trf_kamar',
        'status',
        'kelas',
        'statusdata',
    ];
}
