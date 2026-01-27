@extends('main')

@section('title', 'pengguna')

@section('content')

    <div class="content active">

        <form action="{{ route('admin.tambahUser') }}" method="post" class="mt-20 mb-40">
            @csrf
            <h2>Form Tambah Pengguna</h2>
            <div class="flex align-bottom gap-10 flex-wrap cursor-pointer">
                <div class="input">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="input-text" required>
                </div>
                <div class="input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="input-text" required>
                </div>
                <div class="input">
                    <label for="password">Password</label>
                    <input type="text" name="password" id="password" required value="password123" class="input-text">
                </div>
                <div class="input">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="input-text">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="owner">Owner</option>
                    </select>
                </div>
                <div class="input">
                    <input type="submit" name="" id="" class="btn-primary pl-8 pr-8 pt-6 pb-6"
                        value="Tambah">
                </div>
            </div>
        </form>

        <h2>Data Pengguna</h2>

        <div class="table-container mt-20">
            <table class="text-center">
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Log Aktivitas</th>
                    <th>Aksi</th>
                </tr>

                @php
                    $no = 1;
                @endphp

                @foreach ($users as $user)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->role }}</td>
                        {{-- <td>{{$user->status_aktif}}</td> --}}
                        @if ($user->status_aktif === 1)
                            <td>Online</td>
                        @elseif($user->status_aktif === 0)
                            <td>Offline</td>
                        @endif

                        <td><a href="{{ route('admin.detail_log', $user->id_user) }}">lihat log aktivitas</a></td>
                        <td>
                            <div class="flex flex-center align-center gap-4">
                                <a href="{{ route('admin.editUser', $user->id_user) }}"
                                    class="btn-warning pl-8 pr-8 pt-6 pb-6">Edit</a>
                                <form action="{{ route('admin.hapusUser') }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_user" id="" value="{{ $user->id_user }}">
                                    <input type="submit" name="" id=""
                                        class="btn-error pl-8 pr-8 pt-6 pb-6" value="Hapus">
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
