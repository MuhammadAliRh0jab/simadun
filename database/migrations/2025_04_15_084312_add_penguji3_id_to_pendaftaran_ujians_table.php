<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNilaiPenguji3ToPendaftaranUjiansTable extends Migration
{
    public function up()
    {
        Schema::table('pendaftaran_ujians', function (Blueprint $table) {
            $table->unsignedBigInteger('penguji3_id')->nullable()->after('penguji2_id');
            $table->integer('nilai_penguji3')->nullable()->after('nilai_penguji2');
        });
    }

    public function down()
    {
        Schema::table('pendaftaran_ujians', function (Blueprint $table) {
            $table->dropColumn('penguji3_id');
            $table->dropColumn('nilai_penguji3');
        });
    }
}