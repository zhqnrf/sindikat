<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    protected $table = 'pelatihans';

    protected $fillable = [
        'nama',
        'bidang',
        'jabatan',
        'unit',
        'status_pegawai',
        'nip',
        'golongan',
        'pangkat',
        'nirp',
        'pelatihan_dasar',
        'pelatihan_peningkatan_kompetensi',
    ];

    protected $casts = [
        'pelatihan_dasar' => 'array',
        'pelatihan_peningkatan_kompetensi' => 'array', 
    ];
}
