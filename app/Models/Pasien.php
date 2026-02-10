<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Pasien extends Model
{
    protected $table = 'pasien'; // nama tabel sesuai DB Khanza

    protected $primaryKey = 'no_rkm_medis'; // primary key di Khanza
    public $incrementing = false; // karena bukan auto-increment
    protected $keyType = 'string';
    public $timestamps = false;

   protected $fillable = [
        'no_rkm_medis',
        'nm_pasien',
        'no_ktp',
        'jk',
        'tmp_lahir',
        'tgl_lahir',
        'nm_ibu',
        'alamat',
        'gol_darah',
        'pekerjaan',
        'stts_nikah',
        'agama',
        'tgl_daftar',
        'no_tlp',
        'umur',
        'pnd',
        'keluarga',
        'namakeluarga',
        'kd_pj',
        'no_peserta',
        'kd_kel',
        'kd_kec',
        'kd_kab',
        'pekerjaanpj',
        'alamatpj',
        'kelurahanpj',
        'kecamatanpj',
        'kabupatenpj',
        'perusahaan_pasien',
        'suku_bangsa',
        'bahasa_pasien',
        'cacat_fisik',
        'email',
        'nip',
        'kd_prop',
        'propinsipj',
    ];
     protected function tglLahir(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value 
                ? \Carbon\Carbon::parse($value)->format('Y-m-d') 
                : null
        );
    }

    protected function tglDaftar(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value 
                ? \Carbon\Carbon::parse($value)->format('Y-m-d') 
                : null
        );
    }
}
