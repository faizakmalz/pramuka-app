<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kenaikan_golongan', function (Blueprint $table) {
            $table->string('tempat_penetapan')->nullable()->after('tanggal_kenaikan');
        });
    }

    public function down(): void
    {
        Schema::table('kenaikan_golongan', function (Blueprint $table) {
            $table->dropColumn('tempat_penetapan');
        });
    }
};