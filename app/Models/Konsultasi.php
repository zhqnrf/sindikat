<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';

    protected $fillable = [
        'pra_penelitian_id',
        'user_id',
        'tanggal_konsul',
        'hasil_konsul',
    ];

    protected $casts = [
        'tanggal_konsul' => 'date',
    ];

    public function praPenelitian()
    {
        return $this->belongsTo(PraPenelitian::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}