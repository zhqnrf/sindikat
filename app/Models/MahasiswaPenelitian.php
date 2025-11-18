<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MahasiswaPenelitian extends Model
{

    protected $fillable = [
        'pra_penelitian_id',
        'nama',
        'no_telpon',
        'jenjang',
    ];

    public function praPenelitian()
    {
        return $this->belongsTo(PraPenelitian::class);
    }
}