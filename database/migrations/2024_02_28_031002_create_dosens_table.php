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
        Schema::create('dosens', function (Blueprint $table) {
            $table->id('id');
            $table->string('no_induk', 25)->unique();
            $table->string('nama', 100);
            $table->enum('role', ['kaprodi', 'dosen', 'eksternal'])->default('dosen');
            $table->string('pangkat_gol', 50)->nullable();
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
