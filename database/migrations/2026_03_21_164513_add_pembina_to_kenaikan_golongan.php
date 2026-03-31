<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kenaikan_golongan', function (Blueprint $table) {
            $table->string('nama_pembina')->nullable()->after('tempat_penetapan');
            $table->string('nip_pembina')->nullable()->after('nama_pembina');
        });
    }

    public function down(): void
    {
        Schema::table('kenaikan_golongan', function (Blueprint $table) {
            $table->dropColumn(['nama_pembina', 'nip_pembina']);
        });
    }
};