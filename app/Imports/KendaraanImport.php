<?php

namespace App\Imports;

use App\Models\Kendaraan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KendaraanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function model(array $row)
    {
        return new Kendaraan([
            'plat_nomor' => $row['plat_nomor'],
            'jenis_kendaraan' => $row['jenis_kendaraan'],
            'warna' => $row['warna'],
            'pemilik' => $row['pemilik'],
            'id_user' => $this->userId
        ]);
    }
}
