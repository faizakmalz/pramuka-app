<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('anggotas', function (Blueprint $table) {
        // Kolom yang sering dipakai Search & Filter
        $table->index('nama');
        $table->index('nik');
        $table->index('golongan_pramuka');
    });

    Schema::table('kenaikan_golongan', function (Blueprint $table) {
        // Kolom Foreign Key & Sortir
        $table->index('nomor_anggota');
        $table->index('tanggal_kenaikan');
    });
}

public function down()
{
    Schema::table('anggotas', function (Blueprint $table) {
        $table->dropIndex(['nama', 'nik', 'golongan_pramuka']);
    });

    Schema::table('kenaikan_golongan', function (Blueprint $table) {
        $table->dropIndex(['nomor_anggota', 'tanggal_kenaikan']);
    });
}
};
