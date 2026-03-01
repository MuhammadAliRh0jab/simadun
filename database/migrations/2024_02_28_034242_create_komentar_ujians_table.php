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
        Schema::create('komentar_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftaran_ujian_id')->constrained('pendaftaran_ujians')->onDelete('cascade');
            $table->foreignId('dosen_id')->constrained('dosens');
            $table->enum('role', ['dosen', 'kaprodi']);
            $table->text('komentar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_ujians');
    }
};
