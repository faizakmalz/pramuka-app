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
        Schema::table('kenaikan_golongan', function (Blueprint $table) {
            $table->string('nomor_sertifikat')->unique()->nullable()->after('tanggal_kenaikan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kenaikan_golongan', function (Blueprint $table) {
            //
        });
    }
};
