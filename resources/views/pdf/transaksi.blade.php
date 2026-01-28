<!DOCTYPE html>
<html>

<head>
    <title>PDF Export</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12pt;
        }

        h2,
        p {
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 20px;
            text-align: center;
            border-collapse: collapse;
        }

        table th {
            background-color: blue;
            color: white;
        }

        table th,
        table td {
            padding: 6px;
            border: 1px solid black
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h2>Laporan Transaksi Masuk Parkeasy App</h2>
    <p>Tanggal : {{ $from . ' - ' . $to }}</p>

    <table>
        <tr>
            <th>No</th>
            <th>ID Parkir</th>
            <th>Area Parkir</th>
            <th>Waktu Masuk</th>
            <th>Waktu Keluar</th>
            <th>Durasi Parkir</th>
            <th>Petugas</th>
            <th>Total Bayar</th>
        </tr>

        @php
            $no = 1;
        @endphp

        @foreach ($transaksis as $i)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $i->id_parkir }}</td>
                <td>{{ $i->area->nama_area }}</td>
                {{-- <td>{{\Carbon\Carbon::parse($i->waktu_masuk)->format('d-m-Y H:i:s')}}</td> --}}
                {{-- <td>{{\Carbon\Carbon::parse($i->waktu_keluar)->format('d-m-Y H:i:s')}}</td> --}}
                <td>{{ $i->waktu_masuk }}</td>
                <td>{{ $i->waktu_keluar }}</td>
                <td>{{ $i->durasi_jam . ' jam' }}</td>
                <td>{{ $i->user->nama_lengkap }}</td>
                <td class="text-right">{{ 'Rp. ' . number_format($i->biaya_total, 0, ',', '.') }}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="7">Total</td>
            <td>{{ 'Rp. ' . number_format($total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p style="font-size: 10pt; text-align: right;">diunduh pada {{ date('d-m-Y') }}</p>
</body>

</html>
