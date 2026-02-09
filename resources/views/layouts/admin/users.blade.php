@extends('main')

@section('title', 'pengguna')

@section('content')

    <div class="content active">

        <div class="flex align-center flex-between w-100">
            <h2>Data Users</h2>
            <a href="{{route('admin.formUser')}}" class="btn-primary p-6">Tambah User</a>
        </div>

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
                                    class="btn-warning p-6">Edit</a>
                                <form action="{{ route('admin.hapusUser') }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_user" id="" value="{{ $user->id_user }}">
                                    <input type="submit" name="" id=""
                                        class="btn-error p-6" value="Hapus">
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
