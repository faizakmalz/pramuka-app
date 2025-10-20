<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id('nomor_anggota');
            $table->string('nik');
            $table->string('nama');
            $table->string('jenis_kelamin');
            $table->string('agama');
            $table->string('golongan_pramuka');
            $table->string('golongan_darah');
            $table->string('tempat_lahir');
            $table->string('tanggal_lahir');
            $table->string('alamat');
            $table->string('email');
            $table->string('no_telp');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('anggota');
    }
};
