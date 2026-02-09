@extends('main')

@section('title', 'pengguna')

@section('content')

    <div class="content active">
        <h2>Detail Log Aktivitas {{$logs->first()->user->nama_lengkap}} ( {{$logs->first()->user->username}} )</h2>

        <div class="table-container mt-20">
            <table class="text-center text-nowrap">
                <tr>
                    <th>No</th>
                    {{-- <th>ID User</th>
                    <th>Role</th> --}}
                    <th>Aktivitas</th>
                    <th>Waktu Aktivitas</th>
                </tr>

                @php
                    $no = 1;
                @endphp

                @foreach ($logs as $log)
                    <tr>
                        <td>{{$no++}}</td>
                        {{-- <td>{{$log->id_user}}</td>
                        <td>{{$log->user->role}}</td> --}}
                        <td class="text-left">{{$log->aktifitas}}</td>
                        <td>{{$log->waktu_aktifitas}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection
