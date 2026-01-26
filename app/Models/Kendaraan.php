<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    //
    protected $table = 'kendaraan';
    protected $primaryKey = 'id_kendaraan';
    protected $fillable = [
        'plat_nomor',
        'jenis_kendaraan',
        'warna',
        'pemilik',
        'id_user'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_kendaraan');
    }
}
