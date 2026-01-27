<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('styles/receipt.css') }}">
    {{-- <link rel="stylesheet" href="{{asset('styles/main.css')}}.css"> --}}
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: monospace;
        }

        body {
            display: flex;
            justify-content: center;

            width: 100%;
            height: 100vh;
            background: whitesmoke;
        }

        a {
            text-decoration: none
        }

        .box {
            background: white;
            padding: 20px;
            text-align: center;
            width: 30%
        }

        .address {
            display: block;
            width: 100%;
            font-size: 10pt;
            font-weight: 600;
        }

        .date {
            margin-top: 16px;
            display: block;
            width: 100%;
            font-size: 26pt
        }

        .price {
            margin-top: 16px;
            display: block;
            width: 100%;
            font-size: 12pt
        }

        .park {
            margin-top: 16px;
            display: block;
            width: 100%;
            font-size: 28pt;
            font-weight: 700;
        }

        .table-container {
            margin-top: 16px;
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 0px 14%;
        }

        table {
            width: 100%;
            text-align: left;
            text-wrap: nowrap;
        }

        tr:nth-child(4) {
            font-size: 14pt;
            font-weight: 500;
        }

        .word {
            margin-top: 16px;
        }

        .btn {
            display: inline-block;
            width: max-content;
            padding: 10px;
            border-radius: 6px;
            color: white;
            background-color: blue;
        }

        .menu {
            margin-top: 16px;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        @media print {
            @page {
                size: 80mm auto;
                margin: 0;
            }

            body {
                /* display: block; */
                width: 100%;
                margin: 0;
                font-size: 10pt
            }

            .box{
                width: 100%
            }

            .not-print{
                display: none;
            }
        }
    </style>
    <title>Customer Receipt</title>
</head>

<body>

    <div class="box">
        <div class="address">
            PK2, Jakarta, Indonesia
        </div>

        <div class="date">{{ \Carbon\Carbon::parse($transaksi->waktu_keluar)->format('d/m/Y') }}</div>

        <div class="price">Base Price {{': Rp ' . number_format($transaksi->tarif->tarif_per_jam, 0, ',', '.') }}</div>

        <div class="park">Parkeasy</div>

        <div class="table-container">
            <table>
                <tr>
                    <td>From</td>
                    <td>{{' : ' . \Carbon\Carbon::parse($transaksi->waktu_masuk)->format('H:i:s') }}</td>
                </tr>

                <tr>
                    <td>To</td>
                    <td>{{' : ' . \Carbon\Carbon::parse($transaksi->waktu_keluar)->format('H:i:s') }}</td>
                </tr>

                <tr>
                    <td>Time Total</td>
                    <td>{{' : ' . $transaksi->durasi_jam }} jam</td>
                </tr>

                <tr>
                    <td>Total</td>
                    <td>{{' : Rp ' . number_format($transaksi->biaya_total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="word">
            THANK YOU AND DRIVE SAFELY
        </div>

        <div class="menu not-print">
            <a href="{{ route('petugas.dashboard') }}" class="btn">Kembali</a>
            <div class="btn" onclick="print()" style="cursor: pointer">cetak struk</div>
        </div>
    </div>

    <script>
        print();
    </script>

</body>

</html>
