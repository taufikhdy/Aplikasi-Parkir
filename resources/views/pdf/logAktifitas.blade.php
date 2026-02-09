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

        .text-left{
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Rekap Data Aktivitas Pengguna</h2>
    <p>Tanggal : {{ $from . ' - ' . $to }}</p>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>Aktivitas</th>
            <th>Waktu Aktivitas</th>
        </tr>

        @php
            $no = 1;
        @endphp

        @foreach ($logs as $i)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $i->user->nama_lengkap }}</td>
                <td class="text-left">{{ $i->aktifitas }}</td>
                <td>{{ $i->waktu_aktifitas }}</td>
            </tr>
        @endforeach

    </table>

    <p style="font-size: 10pt; text-align: right;">diunduh pada {{ date('d-m-Y H:i:s') }}</p>
</body>

</html>
