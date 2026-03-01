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
        Schema::create('publikasi_jurnals', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nim')->foreign('nim')->references('nim')->on('mahasiswas')->onDelete('cascade');
            // $table->string('penulis');
            $table->string('jurnal');
            // $table->string('tahun');
            // $table->string('halaman');
            $table->string('volume');
            $table->string('nomor');
            $table->string('tanggal_terbit');
            $table->string('link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publikasi_jurnals');
    }
};
