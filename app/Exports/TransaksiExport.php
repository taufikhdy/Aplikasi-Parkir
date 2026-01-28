<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

use App\Models\Transaksi;
use Carbon\Carbon;

class TransaksiExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */


    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function query(){
        return Transaksi::query()
            ->select([
                'id_parkir',
                'waktu_masuk',
                'waktu_keluar',
                'durasi_jam',
                'biaya_total'
            ])
            ->whereDate('waktu_keluar', '>=', $this->from)
            ->whereDate('waktu_keluar', '<=', $this->to)
            ->orderBy('waktu_keluar', 'desc');
    }

    public function map($row) : array{
        return [
            $row->waktu_masuk ? Carbon::parse($row->waktu_masuk)->timezone('Asia/Jakarta')->format('d-m-Y H:i') : '-',
            $row->waktu_keluar ? Carbon::parse($row->waktu_keluar)->timezone('Asia/Jakarta')->format('d-m-Y H:i') : '-',
            $row->durasi_jam . 'jam',
            'Rp ' . number_format($row->biaya_total, 0, ',', '.')
        ];
    }

    public function headings():array
    {
        return [
            'ID Parkir',
            'Waktu Masuk',
            'Waktu Keluar',
            'Durasi Parkir',
            'Total Biaya',
        ];
    }
}
