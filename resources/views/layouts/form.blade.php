@extends('main')


@if (Request::is('admin/dashboard/form_area'))
    @section('title', 'area')
    @section('content')
        <div class="content {{ Request::is('admin/dashboard/form_area') ? 'active' : '' }}">

            <h2><a href="{{ url()->previous() }}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a> Form Tambah Area
                Parkir</h2>

            <div class="banner-2 mt-20" id="banner-2">
                <h2 id="label_area"></h2>
            </div>

            <form action="{{ route('tambah.area') }}" method="post" class="mt-20">
                @csrf

                <div class="flex flex-wrap align-top gap-10">
                    <div class="input">
                        <label for="nama_area">Nama Area</label>
                        <input type="text" name="nama_area" id="nama_area" class="input-text" placeholder="Nama Area">
                    </div>
                    <div class="input">
                        <label for="warna_label">Warna Label</label>
                        <input type="color" name="warna_label" id="warna_label" class="w-100" placeholder="Warna Label"
                            required>
                    </div>
                </div>

                <div class="flex align-center gap-10">
                    <div class="input">
                        <label for="kapasitas">Kapasitas Area</label>
                        <input type="number" name="kapasitas" id="kapasitas" class="input-text w-100"
                            placeholder="Kapasitas Area">
                    </div>
                </div>

                <input type="submit" name="" id="" class="input-submit" value="Tambah Area">
            </form>

        </div>
    @endsection
@elseif (Request::is('admin/dashboard/form_kendaraan'))
    @section('title', 'kendaraan')
    @section('content')
        <div class="content {{ Request::is('admin/dashboard/form_kendaraan') ? 'active' : '' }}">

            <h2><a href="{{ url()->previous() }}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a> Jenis Kendaraan
            </h2>

            {{-- <form action="" method="post" class="mt-20">
                @csrf

                <div class="input">
                    <label for="jenis_kendaraan">Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" id="jenis_kendaraan" class="input-text"
                        placeholder="Jenis Kendaraan">
                </div>
                <input type="submit" name="" id="" class="input-submit" value="Tambah Kendaraan">

            </form> --}}

            <div class="table-container mt-20">
                <h4 class="mt-20">Tabel Jenis Kendaraan</h4>
                <table class="text-center mt-14">
                    <tr>
                        <th>No</th>
                        <th>Jenis Kendaraan</th>
                    </tr>

                    <tr>
                        <td>1</td>
                        <td>Motor</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Mobil</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Lainnya</td>
                    </tr>
                </table>
            </div>

        </div>
    @endsection
@elseif (Request::is('admin/dashboard/tarif'))
    @section('title', 'tarif')
    @section('content')
        <div class="content {{ Request::is('admin/dashboard/tarif') ? 'active' : '' }}">
            <h2><a href="{{ route('admin.dashboard') }}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a> Data
                Tarif Area
                Parkir</h2>

            {{-- <form action="" method="POST" class="mt-20">
                @csrf
                <h4>Form Tambah Tarif</h4>
                <div class="flex align-top gap-10">
                    <div class="input">
                        <label for="tarif_per_jam">Tarif</label>
                        <input type="number" name="tarif_per_jam" id="tarif_per_jam" class="input-text"
                            placeholder="Tarif">
                    </div>
                    <div class="input">
                        <label for="jenis">Jenis Kendaraan</label>
                        <select name="jenis_kendaraan" id="jenis" class="input-text w-100">
                            <option value="motor">Motor</option>
                            <option value="mobil">Mobil</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <input type="submit" name="" id="" value="Tambah Tarif" class="input-submit">
            </form> --}}

            <div class="table-container mt-20">
                <h4 class="">Tabel Tarif Kendaraan</h4>
                <table class="text-center mt-12 text-nowrap">
                    <tr>
                        <th>No</th>
                        <th>Tarif</th>
                        <th>Jenis Kendaraan</th>
                        <th>Aksi</th>
                    </tr>

                    @php
                        $no = 1;
                    @endphp
                    @foreach ($tarifs as $tarif)
                        <tr>
                            <form action="{{ route('admin.editTarif') }}" method="post">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="id_tarif" id="" value="{{ $tarif->id_tarif }}">
                                <td>{{ $no++ }}</td>
                                <td>Rp. <input type="number" name="tarif_per_jam" id=""
                                        value="{{ $tarif->tarif_per_jam }}" class="input-text w-100" disabled></td>
                                <td>{{ $tarif->jenis_kendaraan }}</td>
                                <td>
                                    <input type="submit" name="input-submit" id=""
                                        class="inputSubmit btn-primary pl-8 pr-8 pt-4 pb-4 cursor-pointer" value="Update">
                                    <span class="btn-primary pl-8 pr-8 pt-4 pb-4 cursor-pointer btnEdit">Edit</span>
                                    <span class="btn-error pl-8 pr-8 pt-4 pb-4 cursor-pointer btnCancel">Batal</span>
                                </td>
                            </form>
                        </tr>
                    @endforeach
                </table>
            </div>

        </div>
    @endsection
@elseif (Request::is('admin/users/formEditUser*'))
    @section('title', 'formUser')
    @section('content')
        <div class="content {{ Request::is('admin/users/formEditUser*') ? 'active' : '' }}">

            <h2><a href="{{ route('admin.users') }}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a>
                Form Tambah User
            </h2>

            <form action="{{route('admin.editUserPost')}}" method="post" class="mt-20">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_user" id="" value="{{$user->id_user}}">
                <div class="flex flex-wrap align-top gap-10">
                    <div class="input">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" class="input-text"
                            placeholder="Nama Lengkap" required value="{{ $user->nama_lengkap }}">
                    </div>
                    <div class="input">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="input-text w-100" placeholder="Username" required
                            value="{{ $user->username }}">
                    </div>
                    <div class="input">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="input-text w-100">
                            <option value="{{$user->role}}">Petugas</option>
                            <option value="admin">Admin</option>
                            <option value="petugas">Petugas</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>
                </div>

                <input type="submit" name="" id="" class="input-submit" value="Edit User">
            </form>

        </div>
    @endsection
@endif
