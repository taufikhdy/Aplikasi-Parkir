<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_parkir');
            // $table->foreignId('id_kendaraan')->constrained('kendaraan', 'id_kendaraan')->cascadeOnDelete(); ga di pake biar transaksi akhir ga dihapus terus masuk data transaksi buat owner
            $table->foreignId('id_kendaraan')->constrained('kendaraan', 'id_kendaraan');
            $table->foreignId('id_tarif')->constrained('tarif', 'id_tarif');
            $table->foreignId('id_user')->constrained('users', 'id_user');
            $table->foreignId('id_area')->constrained('area_parkir', 'id_area');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar')->nullable();
            $table->integer('durasi_jam')->nullable();
            $table->decimal('biaya_total')->nullable();
            $table->enum('status', ['masuk', 'keluar'])->default('masuk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
