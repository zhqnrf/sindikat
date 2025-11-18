<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PraPenelitian extends Model
{

    protected $fillable = [
        'judul',
        'mou_id',
        'jenis_penelitian',
        'tanggal_mulai',
        'status',
    ];

    protected $dates = [
        'tanggal_mulai',
        'created_at', // Sebaiknya tambahkan ini juga
        'updated_at', // Sebaiknya tambahkan ini juga
    ];

    public function mou()
    {
        return $this->belongsTo(Mou::class); 
    }

    public function mahasiswas()
    {
        return $this->hasMany(MahasiswaPenelitian::class);
    }
}