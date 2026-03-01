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
        Schema::create('jadwal_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_ujian_id')->constrained('pendaftaran_ujians')->onDelete('cascade');
            $table->dateTime('tanggal');
            $table->time('jam');
            $table->string('ruangan', 50);
            $table->foreignId('penguji1_id')->constrained('dosens');
            $table->foreignId('penguji2_id')->constrained('dosens');
            $table->foreignId('penguji_eks_id')->nullable()->constrained('dosens')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_ujians');
    }
};
