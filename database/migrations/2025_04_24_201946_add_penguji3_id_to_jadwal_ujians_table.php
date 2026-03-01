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
        Schema::table('jadwal_ujians', function (Blueprint $table) {
            $table->unsignedBigInteger('penguji3_id')->nullable()->after('penguji2_id');

            // Tambahkan foreign key constraint
            $table->foreign('penguji3_id')
                  ->references('id')
                  ->on('dosens')
                  ->onDelete('set null'); // atau bisa diganti menjadi cascade / restrict sesuai kebutuhan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_ujians', function (Blueprint $table) {
            // Hapus foreign key terlebih dahulu sebelum menghapus kolom
            $table->dropForeign(['penguji3_id']);
            $table->dropColumn('penguji3_id');
        });
    }
};
