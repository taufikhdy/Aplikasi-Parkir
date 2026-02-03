@extends('main')

@section('title', 'Aktivitas User')

@section('content')
    <div class="content active">
        <div class="flex flex-between align-center pb-10">
            <h2>Aktivitas Terbaru</h2>

            <div class="flex flex-end align-center gap-10 mt-10 flex-wrap">
                <form action="{{ route('admin.exportLog') }}" method="post">
                    @csrf
                    <div class="flex flex-end align-center gap-4 flex-wrap">
                        <input type="date" name="from" id="" class="input-text">
                        <input type="date" name="to" id="" class="input-text">

                        <button type="submit" class="btn-primary pl-8 pr-8 pt-6 pb-6"><i class="ri-file-pdf-2-line"></i>
                            Ekspor PDF</button>
                    </div>
                </form>
                <form action="{{ route('admin.hapusLog') }}" method="post">
                    @csrf
                    <button type="submit" class="btn-error p-6">Hapus Semua Log</button>
                </form>
            </div>
        </div>
        <div class="table-container">
            <table class="text-center text-nowrap">
                <tr>
                    <th>No</th>
                    {{-- <th>ID User</th> --}}
                    <th>User</th>
                    <th>Aktivitas</th>
                    <th>Waktu Aktivitas</th>
                </tr>

                @php
                    $no = 1;
                @endphp

                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $no++ }}</td>
                        {{-- <td>{{ $log->id_user }}</td> --}}
                        <td class="text-left"><a href="{{ route('admin.detail_log', $log->id_user) }}"
                                class="underline">{{ $log->user->nama_lengkap . ' ( ' . $log->user->role . ' )' }}</a>
                        </td>
                        <td class="text-left">{{ $log->aktifitas }}</td>
                        <td>{{ $log->waktu_aktifitas }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
