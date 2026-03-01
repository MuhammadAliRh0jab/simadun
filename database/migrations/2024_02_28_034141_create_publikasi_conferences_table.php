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
        Schema::create('publikasi_conferences', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('nim')->foreign('nim')->references('nim')->on('mahasiswas')->onDelete('cascade');
            $table->string('namaConference');
            $table->string('penyelenggara');
            $table->string('tanggal_conference');
            $table->string('lokasi_Conference');
            $table->string('tanggalPublikasi');
            $table->string('link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publikasi_conferences');
    }
};
