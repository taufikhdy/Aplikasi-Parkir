@extends('main')

@section('title', 'Password GateWay')

@section('content')

    <div class="content active">

        <h2><a href="{{ url()->previous() }}" class="mr-10"><i class="ri-arrow-left-long-line"></i></a> Ubah Kata Sandi </h2>

        <form action="{{ route('newPassPost') }}" method="post" class="mt-20 mb-40">
            @csrf
            <div class="flex align-bottom gap-10 flex-wrap cursor-pointer">
                <div class="input">
                    <label for="old_password">Kata Sandi Lama</label>
                    <input type="text" name="old_password" id="old_password" class="input-text" required>
                </div>
                <div class="input">
                    <label for="new_password">Kata Sandi Baru</label>
                    <input type="password" name="new_password" id="new_password" class="input-text" required minlength="8">
                </div>
                <div class="input">
                    <label for="new_password_confirmed">Konfirmasi Kata Sandi</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required class="input-text" minlength="8">
                </div>
                <div class="input">
                    <input type="submit" name="" id="" class="input-submit"
                        value="Ubah Kata Sandi">
                </div>
            </div>
        </form>

    </div>

@endsection
