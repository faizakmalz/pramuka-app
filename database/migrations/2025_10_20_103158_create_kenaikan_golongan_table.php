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
            $table->foreign('nomor_anggota')
                ->references('nomor_anggota')
                ->on('anggotas')
                ->onDelete('cascade');
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
