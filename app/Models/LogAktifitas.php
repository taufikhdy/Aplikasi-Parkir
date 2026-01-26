<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktifitas extends Model
{
    //
    protected $table = 'log_aktifitas';
    protected $primaryKey = 'id_log';
    protected $fillable = [
        // 'id_user',
        'aktifitas',
        'waktu_aktifitas'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
