@extends('main')

@section('title', 'member')

@section('content')

    <div class="content active">

        @if (Auth::user()->role === 'admin')

            <div class="flex flex-between flex-wrap align-center">
                <h2><a href="{{ route('admin.dashboard') }}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a>Data
                    Member
                </h2>

                <div class="flex flex-end flex-wrap align-center gap-4">
                    <form action="{{ route('admin.importMember') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" id="" required class="input-file">
                        <input type="submit" name="" id="" class="btn-primary p-6" value="Import">
                    </form>
                    <a href="{{ route('admin.memberForm') }}" class="btn-primary p-6">Tambah Member</a>
                    <form action="{{ route('admin.memberHapusAll') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" name="" id="" class="btn-error p-6" value="Hapus Semua">
                    </form>
                </div>
            </div>

            <div class="table-container mt-10">
                <table class="text-center">
                    <tr>
                        <th>No</th>
                        <th class="text-nowrap">Plat Nomor</th>
                        <th>Pemilik</th>
                        <th>Jenis Kendaraan</th>
                        <th>Warna Kendaraan</th>
                        <th>Aksi</th>
                    </tr>

                    @php
                        $no = 1;
                    @endphp

                    @foreach ($kendaraan as $i)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $i->plat_nomor }}</td>
                            <td>{{ $i->pemilik }}</td>
                            <td>{{ $i->jenis_kendaraan }}</td>
                            <td style="background: {{ $i->warna }}; color: var(--warning-400);">{{ $i->warna }}</td>
                            <td>
                                <div class="flex flex-center align-center gap-4">
                                    <a href="{{ route('admin.memberEdit', $i->id_kendaraan) }}"
                                        class="btn-warning p-6">Edit</a>
                                    <form action="{{ route('admin.memberHapus') }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id_kendaraan" id=""
                                            value="{{ $i->id_kendaraan }}">
                                        <input type="submit" name="" id="" class="btn-error p-6"
                                            value="Hapus">
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @elseif (Auth::user()->role === 'petugas')
            <div class="flex flex-between flex-wrap align-center">
                <h2><a href="{{ route('petugas.dashboard') }}" class="mr-10"><i
                            class="ri-arrow-left-long-line"></i></a>Data
                    Member
                </h2>
            </div>

            <div class="table-container mt-10">
                <table class="text-center">
                    <tr>
                        <th>No</th>
                        <th class="text-nowrap">Plat Nomor</th>
                        <th>Pemilik</th>
                        <th>Jenis Kendaraan</th>
                        <th>Warna Kendaraan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>

                    @php
                        $no = 1;
                    @endphp

                    @foreach ($member as $i)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $i->plat_nomor }}</td>
                            <td>{{ $i->pemilik }}</td>
                            <td>{{ $i->jenis_kendaraan }}</td>
                            <td style="background: {{ $i->warna }}; color: var(--warning-400);">{{ $i->warna }}
                            </td>
                            @if ($i->transaksiTerakhir && $i->transaksiTerakhir->status === 'masuk')
                                <td>Masuk</td>
                                <td>
                                     <a href="{{route('petugas.customerSelesai', $i->transaksiTerakhir->id_parkir)}}" class="btn-success pl-8 pr-8 pt-6 pb-6">Selesai</a>
                                </td>
                            @else
                                <td>Keluar</td>
                                <td>
                                    <a href="{{route('petugas.tambahTransaksi', $i->id_kendaraan)}}" class="btn-primary p-6">Masuk</a>
                                </td>
                            @endif

                        </tr>
                    @endforeach
                </table>
            </div>

        @endif
    </div>

@endsection
