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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nim', 15)->unique();
            $table->string('nama', 100);
            $table->string('judul', 255)->nullable();
            $table->enum('role', ['mahasiswa'])->default('mahasiswa');
            $table->foreignId('promotor_id')->nullable()->constrained('dosens');
            $table->foreignId('co_promotor1_id')->nullable()->constrained('dosens');
            $table->foreignId('co_promotor2_id')->nullable()->constrained('dosens')->default(null);
            $table->enum('progress', ['0', '1', '2', '3', '4', '5', '6'])->default('0')->comment('0 = Belum Mengajukan, 1 = Ujian Proposal, 2 = Ujian Semhas, 3 = Ujian Publikasi, 4 = Ujian Disertasi, 5 = Ujian Tertutup', '6 = Selesai');
            $table->string('password');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
