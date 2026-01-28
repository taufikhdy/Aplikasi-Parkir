@extends('main')

@section('title', 'transaksi-table')

@section('content')

    <div class="content active">

        <div class="flex flex-between align-center">
            <h2><a href="{{ url()->previous() }}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a> Data Transaksi
            </h2>
        </div>

        <div class="flex flex-end align-center gap-10 mt-10 flex-wrap">

            <form action="{{ route('owner.excelExport') }}" method="post">
                @csrf
                <div class="flex align-center gap-4">

                    <input type="date" name="from" id="" placeholder="From" class="input-text">
                    <input type="date" name="to" placeholder="To" class="input-text">

                    <button type="submit" class="btn-success pl-8 pr-8 pt-6 pb-6"><i class="ri-file-excel-line"></i> Ekspor Excel</button>
                </div>
            </form>
            <form action="{{ route('owner.pdfExport') }}" method="post">
                @csrf
                <div class="flex align-center gap-4">

                    <input type="date" name="from" id="" placeholder="From" class="input-text">
                    <input type="date" name="to" placeholder="To" class="input-text">

                    <button type="submit" class="btn-primary pl-8 pr-8 pt-6 pb-6"><i class="ri-file-pdf-2-line"></i> Ekspor PDF</button>
                </div>
            </form>
        </div>

        <div class="table-container mt-10">
            <table class="text-center text-nowrap">
                <tr>
                    <th>No</th>
                    <th>ID Parkir</th>
                    <th>Pelanggan</th>
                    <th>Waktu Masuk</th>
                    <th>Waktu Keluar</th>
                    <th>Durasi</th>
                    <th>Total Biaya</th>
                    <th>Area</th>
                    <th>Petugas</th>
                </tr>

                @php
                    $no = 1;
                @endphp

                @foreach ($transaksis as $i)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $i->id_parkir }}</td>
                        <td>{{ $i->kendaraan->pemilik }}</td>
                        <td>{{ $i->waktu_masuk }}</td>
                        <td>{{ $i->waktu_keluar }}</td>
                        <td>{{ $i->durasi_jam }} jam</td>
                        <td>Rp. {{ number_format($i->biaya_total, 0, ',', '.') }}</td>
                        <td>{{ $i->area->nama_area }}</td>
                        <td>{{ $i->user->nama_lengkap }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
