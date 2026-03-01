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
        Schema::create('detail_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 12)->foreign('nim')->references('nim')->on('mahasiswas')->onDelete('cascade');
            $table->string('nama', 100);
            $table->string('no_hp', 15);
            $table->string('email_um', 100);
            $table->string('email_lain', 100);
            $table->string('alamat_malang', 255);
            $table->string('alamat_asal', 255);
            $table->string('asal_instansi', 100);
            $table->float('PT_S1')->default(0);
            $table->float('PT_S2')->default(0);
            $table->integer('skor_toefl')->default(0);
            $table->integer('skor_TPA')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_mahasiswas');
    }
};
