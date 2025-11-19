<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratBalasan extends Model
{
    protected $table = 'surat_balasan';

    protected $fillable = [
        'mou_id',
        'mahasiswa_penelitian_id',
        'nama_mahasiswa',
        'nim',
        'wa_mahasiswa',
        'keperluan',
        'prodi',
        'lama_berlaku',
        'data_dibutuhkan',
    ];

    public function mou()
    {
        return $this->belongsTo(Mou::class);
    }

    public function mahasiswaPenelitian()
    {
        return $this->belongsTo(MahasiswaPenelitian::class);
    }
}
