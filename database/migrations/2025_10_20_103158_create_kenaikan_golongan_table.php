<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kenaikan_golongan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nomor_anggota')->constrained('anggotas', 'nomor_anggota')->onDelete('cascade');  
            $table->string('golongan_awal');
            $table->string('golongan_tujuan');
            $table->date('tanggal_kenaikan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kenaikan_golongan');
    }
};
