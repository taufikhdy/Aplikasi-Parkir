@extends('main')

@if (Request::is('petugas/dashboard/customer/tambah'))
    @section('title', 'area')
    @section('content')
        <div class="content {{ Request::is('petugas/dashboard/customer/tambah') ? 'active' : '' }}">

            <h2><a href="{{ route('petugas.dashboard') }}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a> Form
                Tambah
                Pelanggan Masuk</h2>

            <div class="banner-2 mt-20" id="banner-2">
                <h2 id="label_area"></h2>
            </div>

            <form action="{{ route('petugas.tambahCustomer.post') }}" method="post" class="mt-20">
                @csrf
                <input type="hidden" name="id_user" id="" value="{{ Auth::user()->id_user }}">
                <div class="flex align-center gap-10">
                    <div class="input">
                        <label for="nama_area">Plat Nomor</label>
                        <input type="text" name="plat_nomor" id="nama_area" class="input-text"
                            placeholder="Plat Nomor Kendaraan" required>
                    </div>
                    <div class="input">
                        <label for="pemilik">Pemilik Kendaraan</label>
                        <input type="text" name="pemilik" id="pemilik" class="input-text"
                            placeholder="Pemilik Kendaraan">
                    </div>
                </div>
                <div class="flex align-center gap-10">
                    <div class="input">
                        <label for="jenis_kendaraan">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" id="jenis_kendaraan" class="input-text" required>
                            <option value="motor">Motor</option>
                            <option value="mobil">Mobil</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="input">
                        <label for="warna_label">Warna Kendaraan</label>
                        <input type="color" name="warna_kendaraan" id="warna_label" class="w-100"
                            placeholder="Warna Label" required>
                    </div>
                </div>
                <div class="flex align-center gap-10">
                    <div class="input">
                        <label for="waktu">Waktu Masuk</label>
                        <input type="datetime-local" name="waktu_masuk" id="waktu" class="input-text w-100"
                            placeholder="Waktu Masuk">
                    </div>
                    <div class="input">
                        <label for="area">Area Parkir</label>
                        <select name="id_area" id="area" class="input-text" required>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id_area }}">{{ $area->nama_area }} ( sisa
                                    {{ $area->kapasitas - $area->terisi }} slot )</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="submit" name="" id="" class="input-submit" value="Tambah Pelanggan">
            </form>

        </div>
    @endsection
@elseif (Request::is('petugas/dashboard/customers/list/selesai*'))
    @section('title', 'area')
    @section('content')
        <div class="content {{ Request::is('petugas/dashboard/customers/list/selesai*') ? 'active' : '' }}">

            <h2><a href="{{ url()->previous() }}}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a> Konfirmasi
                Pelanggan Selesai</h2>

            <div class="banner-2 mt-20" id="banner-2" style="background: {{ $transaksi->kendaraan->warna }}">
                <h2 id="label_area">{{ $transaksi->kendaraan->plat_nomor }}</h2>
            </div>

            <form action="{{ route('petugas.pelangganSelesaiPost') }}" method="post" class="mt-20">
                @csrf

                <input type="hidden" name="id_parkir" id="" value="{{ $transaksi->id_parkir }}">
                <div class="flex align-center gap-10">
                    <div class="input">
                        <label for="pemilik">Pemilik Kendaraan</label>
                        <input type="text" name="pemilik" id="pemilik" class="input-text w-100"
                            placeholder="Pemilik Kendaraan" value="{{ $transaksi->kendaraan->pemilik }}" readonly>
                    </div>
                    <div class="input">
                        <label for="jenis_kendaraan">Jenis Kendaraan</label>
                        <input type="text" name="jenis_kendaraan" id="jenis_kendaraan" class="input-text w-100"
                            placeholder="Plat Nomor Kendaraan" required
                            value="{{ $transaksi->kendaraan->jenis_kendaraan }}" readonly>
                    </div>
                </div>

                <div class="input">
                    <label for="tarif_per_jam">Tarif Per Jam</label>
                    <input type="number" name="tarif_per_jam" id="tarif_per_jam" class="input-text w-100"
                        placeholder="Tarif Per Jam" required value="{{ $transaksi->tarif->tarif_per_jam }}" readonly>
                </div>
                <div class="input">
                    <label for="waktu_masuk">Waktu Masuk</label>
                    <input type="datetime-local" name="waktu_masuk" id="waktu_masuk" class="input-text w-100"
                        placeholder="Waktu Masuk" value="{{ $transaksi->waktu_masuk }}" readonly>
                </div>
                <div class="input">
                    <label for="waktu_keluar">Waktu Keluar</label>
                    <input type="datetime-local" name="waktu_keluar" id="waktu_keluar" class="input-text w-100"
                        placeholder="Waktu Keluar">
                </div>


                <input type="submit" name="" id="" class="input-submit" value="Konfirmasai Selesai">
            </form>

        </div>
    @endsection
@endif
