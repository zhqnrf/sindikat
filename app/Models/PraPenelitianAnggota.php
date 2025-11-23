<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PraPenelitianAnggota extends Model
{
    protected $table = 'pra_penelitian_anggotas';

    protected $fillable = [
        'pra_penelitian_id',
        'nama',
        'no_telpon',
        'jenjang',
    ];

    // Relasi balik ke tabel utama
    public function praPenelitian()
    {
        return $this->belongsTo(PraPenelitian::class, 'pra_penelitian_id');
    }
}
