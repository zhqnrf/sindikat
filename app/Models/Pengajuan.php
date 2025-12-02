<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuan';

    protected $fillable = [
        'user_id',
        'jenis',
        'status',
        'surat_balasan',
        'invoice',
        'bukti_pembayaran',
        'ci_nama',
        'ci_no_hp',
        'ci_bidang',
        'ruangan',
        'status_galasan',
        'status_pembayaran',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function presentasi()
    {
        return $this->hasOne(Presentasi::class);
    }
}