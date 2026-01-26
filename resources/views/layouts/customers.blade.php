@extends('main')

@section('title', 'customer-table')

@section('content')

    <div class="content active">
        <h2><a href="{{ url()->previous() }}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a> Data Customer</h2>

        <div class="table-container mt-20">
            <table class="text-center text-nowrap">
                <tr>
                    <th>No</th>
                    <th>Plat Nomor</th>
                    <th>Area Parkir</th>
                    <th>Jenis Kendaraan</th>
                    <th>Pemilik</th>
                    {{-- <th>Waktu Masuk</th> --}}
                    {{-- <th>Status</th> --}}
                    <th>Aksi</th>
                </tr>

                @php
                    $no = 1;
                @endphp

                @foreach ($customers as $customer)
                    <tr>
                        <td>{{$no++}}</td>
                        <td>{{$customer->kendaraan->plat_nomor}}</td>
                        <td style="background: {{$customer->area->warna_label}}; color: var(--neutral-900)">{{$customer->area->nama_area}}</td>
                        <td>{{$customer->kendaraan->jenis_kendaraan}}</td>
                        {{-- <td>{{$customer->kendaraan->pemilik}}</td> --}}
                        {{-- <td>{{$customer->waktu_masuk}}</td> --}}
                        <td>{{$customer->status}}</td>
                        <td>
                            <a href="{{route('petugas.customerSelesai', $customer->id_parkir)}}" class="btn-primary pl-8 pr-8 pt-6 pb-6">Selesai</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
