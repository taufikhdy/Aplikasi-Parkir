<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaParkir extends Model
{
    //
    protected $table = 'area_parkir';
    protected $primaryKey = 'id_area';
    protected $fillable =[
        'nama_area',
        'warna_label',
        'kapasitas',
        'terisi'
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_area');
    }
}
