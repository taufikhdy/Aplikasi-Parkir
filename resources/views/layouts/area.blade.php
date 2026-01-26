@extends('main')

@if (Auth::user()->role === 'admin')
    @section('title', 'detail_area')

    @section('content')
        <div class="content active">
            <h2><a href="{{ url()->previous() }}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a> Detail Area</h2>

            <div class="banner-2 mt-20" id="banner-2" style="background: {{ $area->warna_label }}">
                <h2 id="label_area">{{ $area->nama_area }}</h2>
            </div>

            <form action="{{ route('admin.editArea') }}" method="post" class="mt-20">
                @csrf
                @method('PUT')

                <input type="hidden" name="id_area" id="" value="{{ $area->id_area }}">
                <div class="flex flex-wrap align-top gap-10">
                    <div class="input">
                        <label for="nama_area">Nama Area</label>
                        <input type="text" name="nama_area" id="nama_area" class="input-text" placeholder="Nama Area"
                            value="{{ $area->nama_area }}" required>
                    </div>
                    <div class="input">
                        <label for="warna_label">Warna Label</label>
                        <input type="color" name="warna_label" id="warna_label" class="w-100" placeholder="Warna Label"
                            value="{{ $area->warna_label }}" required>
                    </div>
                </div>

                <div class="flex align-center gap-10">
                    <div class="input">
                        <label for="kapasitas">Kapasitas Area</label>
                        <input type="number" name="kapasitas" id="kapasitas" class="input-text w-100"
                            placeholder="Kapasitas Area" value="{{ $area->kapasitas }}" required>
                    </div>
                </div>

                <input type="submit" name="" id="" class="input-submit" value="Edit Area">
            </form>
        </div>
    @endsection
@elseif (Auth::user()->role === 'petugas')
    @section('title', 'detail_area')

    @section('content')

        <div class="content active">
            <h2><a href="{{ url()->previous() }}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a> Detail Area
            </h2>

            <div class="banner-2 mt-20" id="banner-2" style="background: {{ $area->warna_label }}"">
                <h2 id="label_area">{{ $area->nama_area }}</h2>
            </div>

            <p class="mt-20">
                Nama : {{ $area->nama_area }} <br>
                Kapasitas : {{ $area->kapasitas }} <br>
                Terisi : {{ $area->terisi }}
            </p>

            <div class="table-container mt-20">
                <table class="text-center text-nowrap">
                    <tr>
                        <th>No</th>
                        <th>Plat Nomor</th>
                        <th>Jenis Kendaraan</th>
                        <th>Pemilik</th>
                        {{-- <th>Waktu Masuk</th> --}}
                        {{-- <th>Status</th> --}}
                        <th>Aksi</th>
                    </tr>

                    @php
                        $no = 1;
                    @endphp

                    @foreach ($kendaraan as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->kendaraan->plat_nomor }}</td>
                            <td>{{ $item->kendaraan->jenis_kendaraan }}</td>
                            <td>{{ $item->kendaraan->pemilik }}</td>
                            {{-- <td>{{ $item->waktu_masuk }}</td> --}}
                            {{-- <td>{{ $item->status }}</td> --}}
                            <td>
                                <a href="{{ route('petugas.customerSelesai', $item->id_parkir) }}"
                                    class="btn-primary pl-8 pr-8 pt-6 pb-6">Selesai</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        </div>

    @endsection
@endif
