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
        Schema::create('pendaftaran_ujians', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 15)->foreign('nim')->references('nim')->on('mahasiswas')->onDelete('cascade');
            $table->enum('jenis_ujian', ['proposal', 'semhas', 'publikasi', 'disertasi', 'tertutup']);
            $table->foreignId('penguji1_id')->constrained('dosens');
            $table->foreignId('penguji2_id')->constrained('dosens');
            $table->string('penguji_eks')->nullable();
            $table->foreignId('kaprodi_id')->nullable()->constrained('dosens');
            $table->enum('status', ['0', '1', '2', '3', '4', '5', '6'])->default('0')->comment('0 = Belum Mengajukan, 1 = konfirmasi, 2 = Dalam Proses, 3 = terjadwal, 4 = revisi, 5 = revisi diajukan, 6 = selesai');
            $table->string('file', 255);
            $table->integer('nilai_kaprodi')->nullable();
            $table->integer('nilai_promotor')->nullable();
            $table->integer('nilai_co_promotor1')->nullable();
            $table->integer('nilai_co_promotor2')->nullable();
            $table->integer('nilai_penguji1')->nullable();
            $table->integer('nilai_penguji2')->nullable();
            $table->integer('nilai_penguji_eks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_ujians');
    }
};
