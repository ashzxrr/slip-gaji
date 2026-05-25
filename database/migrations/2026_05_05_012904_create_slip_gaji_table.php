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
       Schema::create('slip_gaji', function (Blueprint $table) {
        $table->id();
        $table->foreignId('karyawan_id')->constrained('karyawan')->cascadeOnDelete();
        $table->foreignId('periode_id')->constrained('gaji_periode')->cascadeOnDelete();

        // Penghasilan
        $table->bigInteger('gaji_pokok')->default(0);
        $table->bigInteger('tunj_jabatan')->default(0);
        $table->bigInteger('tunj_masa_kerja')->default(0);
        $table->bigInteger('tunj_komunikasi')->default(0);
        $table->bigInteger('tunj_transportasi')->default(0);
        $table->bigInteger('tunj_performance')->default(0);
        $table->bigInteger('tunj_tambahan')->default(0);
        $table->bigInteger('overtime')->default(0);

        // Potongan
        $table->bigInteger('pph21')->default(0);
        $table->bigInteger('bpjs_kesehatan')->default(0);
        $table->bigInteger('bpjs_ketenagakerjaan')->default(0);
        $table->bigInteger('potongan_lain')->default(0);
        $table->bigInteger('pinjaman')->default(0);

        // Status WA
        $table->enum('status_kirim', ['pending', 'terkirim', 'gagal'])->default('pending');
        $table->timestamp('waktu_kirim')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slip_gaji');
    }
};
