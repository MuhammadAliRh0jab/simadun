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
        Schema::create('laporan_bulanans', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 15)->foreign('nim')->references('nim')->on('mahasiswas')->onDelete('cascade');
            $table->string('judul', 255);
            $table->text('isi_progress');
            $table->enum('status', [0, 1, 2])->default(0)->comment('0: Belum Mengajukan, 1: Dalam Proses, 2: Dibalas');
            $table->text('komentar_promotor')->nullable();
            $table->text('komentar_co_promotor1')->nullable();
            $table->text('komentar_co_promotor2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_bulanans');
    }
};
