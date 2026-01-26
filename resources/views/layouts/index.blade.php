@extends('main')

@section('title', 'main')

@section('content')
    <div class="banner">
        <h1>Good Morning</h1>
        <br>
        <p><span class="text-bold">{{ Auth::User()->nama_lengkap }} </span><br>
            {{ Auth::User()->role }}
        </p>
    </div>

    <div class="phone-box">
        <div class="menu">
            <h2 class="pt-10 pb-10">Menu</h2>

            <div class="menu-item">
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('admin.tarif') }}" class="coin text-center"><i class="ri-lg ri-coins-line"></i> <br><br>
                        <span class="fs-12">Tarif
                            Parkir</span></a>
                    <a href="{{ route('admin.form_area') }}" class="park text-center"><i
                            class="ri-lg ri-parking-box-line"></i>
                        <br><br>
                        <span class="fs-12">Tambah<br>Area Parkir</span></a>
                    <a href="{{ route('admin.form_kendaraan') }}" class="vehilce text-center"><i
                            class="ri-lg ri-car-line"></i>
                        <br><br> <span class="fs-12">Jenis<br>Kendaraan</span></a>

                    <a href="{{ route('admin.form_kendaraan') }}" class="coin text-center"><i
                            class="ri-lg ri-group-line"></i>
                        <br><br> <span class="fs-12">Member</span></a>
                @elseif (Auth::user()->role === 'petugas')
                    <a href="{{ route('petugas.tambahCustomer') }}" class="coin text-center"><i class="ri-lg ri-user-add-line"></i>
                        <br><br>
                        <span class="fs-12">Tambah<br>Pelanggan</span></a>
                    <a href="{{ route('petugas.customerList') }}" class="park text-center"><i
                            class="ri-lg ri-list-check-3"></i>
                        <br><br>
                        <span class="fs-12">Konfirmasi<br>Pelanggan<br>Selesai</span></a>
                @elseif (Auth::user()->role === 'owner')
                    <a href="{{ route('admin.tarif') }}" class="coin text-center"><i class="ri-lg ri-coins-line"></i>
                        <br><br>
                        <span class="fs-12">Tarif
                            Parkir</span></a>
                @endif
            </div>
        </div>

        <div class="area">
            @if (Auth::user()->role === 'admin')

                <div class="flex flex-between align-center pt-10 pb-10 mt-20">
                    <h2>Area Parkir</h2>
                    {{-- <a href="" class="button-primary">Lihat Semua</a> --}}
                </div>

                <div class="grid grid-col-4 gap-10 row-gap-10 w-100">

                    @foreach ($areas as $area)
                        <a href="{{ route('admin.detail_area', $area->id_area) }}"
                            class="card flex flex-column flex-between gap-16" style="background: {{ $area->warna_label }}">
                            {{-- <div class=""> --}}
                                <h3>{{ $area->nama_area }}</h3>
                                <p class="fs-12">Kapasitas : {{ $area->kapasitas }}</p>
                            {{-- </div> --}}
                        </a>
                    @endforeach
                </div>
            @elseif (Auth::user()->role === 'petugas')
                <div class="flex flex-between align-center pt-10 pb-10 mt-20">
                    <h2>Area Parkir</h2>
                    {{-- <a href="" class="button-primary">Lihat Semua</a> --}}
                </div>

                <div class="grid grid-col-4 gap-10 row-gap-10 w-100">

                    @foreach ($areas as $area)
                        <a href="{{ route('petugas.detail_area', $area->id_area) }}"
                            class="card flex flex-column flex-between" style="background: {{ $area->warna_label }}">
                            <div class="">
                                <h3>{{ $area->nama_area }}</h3>
                                <p class="fs-12">Kapasitas : {{ $area->kapasitas }} <br> Terisi : {{ $area->terisi }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>


    @endsection
