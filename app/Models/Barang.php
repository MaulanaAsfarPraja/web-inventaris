<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barangs';
    protected $guarded = [];

    protected $fillable = [
        'nama_barang',
        'kondisi_bagus',
        'kondisi_rusak',
        'keterangan'
    ];

    protected $appends = ['total'];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function getTotalAttribute()
    {
        return $this->kondisi_bagus + $this->kondisi_rusak;
    }
}
